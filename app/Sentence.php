<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    protected $fillable = ['sentence_text','sentence_number'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
