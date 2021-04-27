<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Filter extends Model
{
    protected $fillable = ['title','type','protected','order'];
    public function filter_options()
    {
        return $this->hasMany(FilterOption::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($value)
        {
            $value->filter_options()->delete();

        });
    }

}
