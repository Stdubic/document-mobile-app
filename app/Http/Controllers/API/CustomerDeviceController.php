<?php

namespace App\Http\Controllers\API;

use App\UserDevice;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserDevice;
use App\Http\Resources\UserDevicesResource;
use JWTAuth;

class CustomerDeviceController extends Controller
{
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return UserDevicesResource::collection(
            UserDevice::where( 'user_id', $user->id)->paginate(50)
        );
    }

    public function toggle(StoreUserDevice $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $status = UserDevice::where([
            'device_id' => $request->device_id,
            'user_id' => $user->id
        ])->delete();

        if(!$status)
        {
            $status = UserDevice::create([
                'device_id' => $request->device_id,
                'user_id' => $user->id
            ]);
        }

        return ['status' => $status ? true : false];
    }

    public function createOrNothing( StoreUserDevice $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $status = UserDevice::where([
            'device_id' => $request->device_id,
            'user_id' => $user->id
        ])->exists();

        if(!$status)
        {
            $status = UserDevice::create([
                'device_id' => $request->device_id,
                'user_id' => $user->id
            ]);
        }

        return ['status' => $status ? true : false];
    }
}
