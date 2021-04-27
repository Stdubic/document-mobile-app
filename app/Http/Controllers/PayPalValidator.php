<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Payment as PayPayPayment;
class PayPalValidator extends Controller
{
    public function __construct($client_id = "", $client_secret = ""){

        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($client_id, $client_secret)
        );
    }

    public function login($client_id = "", $client_secret = ""){
        try {
            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential($client_id, $client_secret)
            );
        } catch (Exception $ex) {
            return false;
        }
        $this->apiContext = $apiContext;
        return true;
    }

    private function getApiContext(){
        if($this->apiContext) return $this->apiContext;
        return false;
    }

    public function getPaymentInfo($payment_id) {
        try {
            $payment = PayPayPayment::get($payment_id, $this->apiContext);
        } catch (Exception $ex) {
            return false;
        }
        return $payment;
    }

    public function validatePayment($payment_id){

        $payment_info = $this->getPaymentInfo($payment_id, $this->apiContext);
        if(!$payment_info) return false;

        $state = $payment_info->getState();
        // $tranactions = $payment_info->getTransactions();

        // foreach ($tranactions as $tranaction) {
        // 	if($currency != $tranaction->getAmount()->currency) return false;
        // }

        $success = $state == "approved"  ;

        return $success;
    }
}
