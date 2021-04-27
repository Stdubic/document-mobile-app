<?php

namespace App\Http\Resources;

use App\Comment;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Category;

class SentenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $categories = Category::all();
        $data = array(
            "results" => array()
        );

        foreach ($categories as $category){
            $comment_number = Comment::where('sentence_id',$this->id)->where('category_id',$category['id'])->count();
            $comment_category = array(
                'id'=> $category['id'],
                'category_name'=> $category['name'],
                'order'=> $category['order'],
            );
            $data['results'][] = array(
                'commentCategory'=> $comment_category,
                'comments_count' => $comment_number,
            );
        }
        return [
            'id' => $this->id,
            'sentece_text' => $this->sentence_text,
            'comment_category' => $data['results'],

        ];
    }
}
