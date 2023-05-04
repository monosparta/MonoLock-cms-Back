<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfflineSyncLogResource;
use App\Models\OfflineSyncLog;
use App\Models\User;
use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;

class OfflineDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offlineSyncLogs = OfflineSyncLog::orderBy('created_at', 'desc')->get();
        return  response()->json(OfflineSyncLogResource::collection($offlineSyncLogs), 200);
    }
    /**
     * Request Sync
     *
     * @return \Illuminate\Http\Response
     */
    public function requestSync(Request $request)
    {
        $token = $request->header('token');
        $user = User::where('remember_token', '=', $token)->first();
        $user->OfflineSyncLog()->create(['mode' => 'manual']);

        $mqtt = MQTT::connection();
        $mqtt->publish('locker/offline', 'sync', 0);
        $mqtt->loop(true, true);

        return response()->json(['message' => 'Sync request sent'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
