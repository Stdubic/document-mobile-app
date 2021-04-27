<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Upgrade extends Model
{

    protected $fillable = ['user_id','active'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
