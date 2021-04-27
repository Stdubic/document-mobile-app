<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['sentence_id','category_id', 'user_id', 'text'];
    public function sentence()
    {
        return $this->belongsTo(Sentence::class);
    }
    public function categories()
    {
        return $this->hasOne(Comment::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

