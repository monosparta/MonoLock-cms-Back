<?php

use App\Models\Locker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_lockers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lockerNo', 20)->unique()->nullable();
            $table->string('lockerEncoding', 4)->unique()->nullable();
            $table->boolean('lockUp')->default(true);
            $table->uuid('userId')->nullable();
            $table->boolean('error')->default(false);
            $table->timestamps();
        });

        $lockers = Locker::orderBy('id', 'ASC')->get();
        foreach ($lockers as $locker) {
            if ($locker->userId != null) {
                $result = DB::select(
                    'SELECT temp_users.id as newUuid FROM `lockers` 
                    INNER JOIN users on users.id = lockers.userId
                    INNER JOIN temp_users on temp_users.mail = users.mail
                    WHERE users.id = ?;',
                    [$locker->userId]
                );
                DB::statement(
                    'INSERT INTO temp_lockers (lockerNo, lockerEncoding, lockUp, userId, error)
                        VALUES (:lockerNo, :lockerEncoding, :lockUp, :userId, :error);',
                    [
                        $locker->lockerNo,
                        $locker->lockerEncoding,
                        $locker->lockUp,
                        $result[0]->newUuid,
                        $locker->error,
                    ]
                );
            } else {
                DB::statement(
                    'INSERT INTO temp_lockers (lockerNo, lockerEncoding, lockUp, error)
                        VALUES (:lockerNo, :lockerEncoding, :lockUp, :error);',
                    [
                        $locker->lockerNo,
                        $locker->lockerEncoding,
                        $locker->lockUp,
                        $locker->error,
                    ]
                );
            }
        }

        Schema::table('temp_lockers', function (Blueprint $table) {
            $table->foreign('userId')->references('id')->on('temp_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('temp_lockers', function (Blueprint $table) {
        //     $table->dropForeign(['userId']);
        // });
        // Schema::table('temp_records', function (Blueprint $table) {
        //     $table->dropForeign(['userId']);
        // });
        // Schema::dropIfExists('temp_records');
        Schema::dropIfExists('temp_lockers');
    }
};
