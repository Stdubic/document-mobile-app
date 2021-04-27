<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['title','structure','protected','active'];
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
