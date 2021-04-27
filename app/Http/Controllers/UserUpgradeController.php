<?php

namespace App\Http\Controllers;

use App\User;
use App\Setting;
use JWTAuth;

class UserUpgradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upgrade()
    {
        $jwt = JWTAuth::getToken();
        $settings = Setting::firstOrFail();
        $payment_currency = 'USD';
        return view('paypal.web',compact('payment_currency','settings','jwt') );
    }


}
