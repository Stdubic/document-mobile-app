<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $token = null;
        DB::transaction(function () use ($request, &$token) {

            $new_user = User::create( [
                'name'     => $request->get( 'name' ),
                'surname'     => $request->get( 'surname' ),
                'email'    => $request->get( 'email' ),
                'role_id'  => 2,
                'password' => bcrypt( $request->get( 'password' ) ),
            ] );

            $new_user->user_number = $new_user->id + 100000000;
            $new_user->save();
            $token = JWTAuth::fromUser($new_user);
        });


        return response()->json(compact('token'));
    }
}