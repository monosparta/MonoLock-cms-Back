<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Locker;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where("permission", 0)->get(["id", "name", "mail", "permission"]);
        return response()->json($admins, 200);
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
        $response = "";
        $httpstatus = 204;
        $request["password_confirmation"] = $request["confirm"];
        $validator = Validator::make(
            $request->all(),
            [
                'mail' => 'required|unique:users|email:rfc|max:80',
                'name' => 'required|max:40',
                'password' => 'required|confirmed',
            ],
        );
        if ($validator->fails()) {
            $response = $validator->errors();
            $httpstatus = 400;
        }
        try {
            $newUser = new User();
            $newUser->mail = $request["mail"];
            $newUser->name = $request["name"];
            $newUser->password = Hash::make($request["password"]);
            $newUser->permission = 0;
            $newUser->save();
            $response = "success";
            $httpstatus = 200;
        } catch (\Exception $e) {
            $response = $e->getMessage();
            $httpstatus = 422;
        }
        return response()->json($response, $httpstatus);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $response = "";
        $httpstatus = 204;
        $json = $request->all();
        $json["id"] = $id;
        $json["password_confirmation"] = $request["confirm"];
        $validator = Validator::make(
            $json,
            [
                'id' => [
                    'required',
                    Rule::exists('users')->where(function ($query) {
                        return $query->where('permission', 0);
                    }),
                ],
                'name' => [
                    'min:1',
                    'max:40'
                ],
                'password' => 'confirmed',
                'cardId' => [
                    'min:1',
                    'max:20',
                ],
                'phone' => [
                    'regex:/(0)[0-9]{9}/',
                    'max:10',
                ],
                'mail' => [
                    Rule::unique('users')->ignore($id)
                ],
            ],
        );
        if ($validator->fails()) {
            $response = $validator->errors();
            $httpstatus = 400;
            return response()->json($response, $httpstatus);
        }
        try {
            $user = User::where('id', $id);
            if (!empty($json["name"] ?? [])) {
                $user->update([
                    "name" => $json["name"]
                ]);
            }
            if (!empty($json["password"] ?? [])) {
                $user->update([
                    "password" => Hash::make($json["password"])
                ]);
            }
            // if(!empty($json["cardId"] ?? [])) {
            //     $user->update([
            //         "cardId" => $json["cardId"]
            //     ]);
            // }
            // if(!empty($json["phone"] ?? [])) {
            //     $user->update([
            //         "phone" => $json["phone"]
            //     ]);
            // }
            if (!empty($json["mail"] ?? [])) {
                $user->update([
                    "mail" => $json["mail"]
                ]);
            }
            $response = $user->first(['id', 'name', 'mail']);
            $httpstatus = 200;
        } catch (\Exception $e) {
            $response = $e->getMessage();
            $httpstatus = 422;
        }
        return response()->json($response, $httpstatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = "";
        $httpstatus = 204;
        $validator = Validator::make(
            ['id' => $id],
            [
                'id' => 'required|exists:users'
            ],
        );
        if ($validator->fails()) {
            $response = $validator->errors();
            $httpstatus = 400;
        }
        try {
            $user = User::where('id', $id);
            Locker::where('userId', $id)->update(['userId' => NULL]);
            Record::where('userId', $id)->delete();
            $user->delete();
            $response = "success";
            $httpstatus = 200;
        } catch (\Exception $e) {
            $response = $e->getMessage();
            $httpstatus = 400;
        }
        return response()->json($response, $httpstatus);
    }
}
