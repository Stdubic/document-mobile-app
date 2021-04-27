<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterOption extends Model
{
    protected $fillable = ['filter_id','title','protected','order'];
    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }
}
