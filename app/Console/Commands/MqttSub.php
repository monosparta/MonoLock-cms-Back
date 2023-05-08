<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;
use App\Http\Controllers\LockerController;
use App\Models\OfflineSyncLog;

class mqttSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqttSub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update locker's status or error";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $mqtt = MQTT::connection();
            ini_set('memory_limit', '256M');
            echo sprintf("MQTT is connected\r\n");
            $mqtt->subscribe('locker/status', function (string $topic, string $message) {
                echo sprintf("Received QoS level 0 message on topic [%s]: \r\n%s\r\n", $topic, $message);
                DB::table("lockers")->where('lockUp', 0)->update(['lockUp' => 1]);
                $lockerEncodings = explode(",", $message);
                foreach ($lockerEncodings as $lockerEncoding) {
                    DB::table("lockers")->where('lockerEncoding', $lockerEncoding)->update(['lockUp' => 0]);
                }
            }, 0);
            $mqtt->subscribe('locker/error', function (string $topic, string $message) {
                echo sprintf("Received QoS level 0 message on topic [%s]: \r\n%s\r\n", $topic, $message);
                list($lockerEncoding, $error) = explode(",", $message, 2);
                DB::table("lockers")->where('lockerEncoding', $lockerEncoding)->update(['error' => (int)$error]);
            }, 0);
            $mqtt->subscribe('locker/offline', function (string $topic, string $message) {
                echo sprintf("Received QoS level 0 message on topic [%s]: \r\n%s\r\n", $topic, $message);
                list($mode, $error) = explode(",", $message, 2);
                switch ($mode) {
                    case 'auto':
                        OfflineSyncLog::create([
                            'mode' => $mode,
                            'error' => (int)$error,
                        ]);
                        break;
                    case 'manual':
                        $log = OfflineSyncLog::where(['mode' => $mode, 'error' => null])
                            ->orderBy('created_at', 'desc')
                            ->first();
                        if ($log) {
                            $log->update(['error' => (int)$error]);
                            OfflineSyncLog::where(['mode' => $mode, 'error' => null])->update(['error' => 1]);
                        } else {
                            OfflineSyncLog::create([
                                'mode' => $mode,
                                'error' => (int)$error,
                            ]);
                        }
                        break;
                    default:
                        break;
                }
            }, 0);
            $mqtt->loop(true);
        } catch (\Exception $e) {
            echo sprintf($e->getMessage());
        }
        return 1;
    }
}
