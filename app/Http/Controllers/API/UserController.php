<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index()
    {
        return UserResource::collection(User::all());
    }


    public function me(Request $request){
        return new UserResource($request->user());
    }


    public function update(Request $request)
    {

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json('user_not_found');
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json('token_expired');

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json('token_invalid');

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json('token_absent');
        }
        $id = $user->id;
        try
        {
            User::findOrFail($id)->update([
                'name'     => $request->get( 'name' ),
                'surname'     => $request->get( 'surname' ),
                'country'     => $request->get( 'country' ),
                'company'     => $request->get( 'company' ),
                'mobile_number'     => $request->get( 'mobile_number' ),
                'date_of_birth'     => $request->get( 'date_of_birth' ),
                'email'    => $request->get( 'email' ),
                'role_id'  => 2,
            ]);
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['error'=> true, 'message'=> 'User not found.']);
        }

        return response()->json(['success'=> true, 'message'=> 'User updated.']);
    }


    public function updatePass(Request $request)
    {

        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json('user_not_found');
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json('token_expired');

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json('token_invalid');

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json('token_absent');
        }
        $id = $user->id;
        $user = User::findOrFail($id);

        if(Hash::check($request->get('current_password'), $user->password)){
            try
            {
                User::findOrFail($id)->update([
                    'password' => bcrypt( $request->get( 'new_password' ) ),
                ]);
            }
            catch(ModelNotFoundException $e)
            {
                return response()->json(['error'=> true, 'message'=> 'User not found.']);
            }

            return response()->json(['success'=> true, 'message'=> 'Password updated.']);
        }
        else{
            return response()->json(['error'=> true, 'message'=> 'Password not mach.']);
        }
    }

}