<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['name','protected','description','user_id','active'];
    public function filter_options()
    {
        return $this->belongsToMany('App\FilterOption','video_filter_options','video_id','filter_options_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
