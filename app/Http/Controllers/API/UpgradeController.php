<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Setting;
use App\Transactions;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\PayPalValidator;



class UpgradeController extends Controller
{
    public function upgrade(Request $request)
    {
        $settings = Setting::firstOrFail();
        $client_id = $settings->client_id;
        $client_secret = $settings->client_secret;
        $duration = $settings->duration;
        $user = JWTAuth::parseToken()->authenticate();


        $payment_id = ($request->payment_id ? $request->payment_id : false );
        $valid =  ( $payment_id ? true : false );


        if($valid && Transactions::where('payment_id', '=', $payment_id)->first()){
            $valid = false;
        }else{
            $valid = true;
        }

        $paypal_validator = new PayPalValidator($client_id, $client_secret);

        if($valid){
            $valid = $paypal_validator->validatePayment($payment_id);
        }

        if($valid ){

           Transactions::create([
                'user_id' => $user->id,
                'time' => Carbon::now(),
                'expiry_time' => Carbon::now()->addMonths($duration) ,
                'payment_id' => $request->payment_id,
            ]);
        }

        echo json_encode(["success" => $valid]);
    }

}


