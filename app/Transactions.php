<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transactions extends Model
{

    protected $fillable = ['user_id','time','expiry_time','payment_id'];
    protected $appends = ['expired','paypal'];

    public function user(){

       return $this->belongsTo(User::class);

    }

    function getExpiredAttribute() {

        $expiry_time = Carbon::parse($this->expiry_time);

        if (Carbon::now()->gt($expiry_time) ){
            return 0;
        }else{
            return 1;
        }
    }

    function getPaypalAttribute() {

        if ($this->payment_id == null){
            return 0;
        }else{
            return 1;
        }
    }

}
