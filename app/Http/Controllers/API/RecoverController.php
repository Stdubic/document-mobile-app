<?php

namespace App\Http\Controllers\API;


use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class RecoverController extends Controller
{

    public function recover(Request $request)
    {
        try
        {
             $user = User::where('email', $request->email)->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            return response()->json(['error'=> true, 'message'=> 'User not found.']);
        }
        $id = $user->id;
        $name = $user->name;
        $email = $user->email;
        $pass_code = str_random(8); //Generate pass code

        Mail::send('email.verify', ['name' => $name, 'pass_code' => $pass_code],
            function($mail) use ($email, $name){
                $mail->from('stevan@gmail.com', "From User ");
                $mail->to($email, $name);
            });
        User::findOrFail($id)->update([
            'password' =>  bcrypt($pass_code),
        ]);

        return response()->json(['success'=> true, 'message'=> 'Mail sent.']);

    }

}

