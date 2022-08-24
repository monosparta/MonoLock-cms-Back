<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Http\Request;


class RecordController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     tags={"record"},
     *     path="/api/record/{lockerNo}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="lockerNo",
     *         description="locker number",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=400, description="Bad Request", @OA\JsonContent()),
     * )
     *
     * @return AnonymousResourceCollection
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show($lockerNo)
    {
        $response = "";
        $httpstatus = 204;
        if ($lockerNo == null) {
            $response = "lockerNo is null";
            $httpstatus = 400;
        } else {
            $locker = Locker::where("lockerNo", "=", $lockerNo)->first();
            if ($locker == null) {
                $response = "lockerNo error " . $lockerNo;
                $httpstatus = 400;
            } else {
                $records = Record::select([
                    'created_at AS time',
                    'description',
                    'userId'
                ])->with('user:id,name,permission')->where("lockerId", "=", $locker->id)->orderByDesc('created_at')->get();
                $user = User::where("id", "=", $locker->userId)->first(['id', 'name', 'mail', 'phone', 'cardId']);
                if ($user == null) {
                    $response = "didn't have user";
                    $httpstatus = 400;
                } else {
                    return response()->json(["user" => $user, "records" => $records], 200);
                }
            }
        }
        return response($response, $httpstatus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}
