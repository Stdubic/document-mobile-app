<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['document_id','section_title','description','section_number'];
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
