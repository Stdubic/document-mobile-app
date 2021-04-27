<?php

namespace App\Http\Resources;

use App\Comment;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Category;
use App\User;

class SentanceCommentsResource extends JsonResource
{
    public function __construct($resource, $comment_category_id)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->comment_category_id = $comment_category_id;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = array(
            "results" => array()
        );

        $comments = Comment::where('sentence_id',$this->id)->where('category_id',$this->comment_category_id)->orderBy('created_at', 'desc')->get();

        foreach ($comments as $comment){
            $user = User::select('id','name','surname','company')->where('id',$comment['user_id'])->get();
            $category = Category::select('id','name')->where('id',$comment->category_id)->get();
            $time = $comment->created_at;
            $data['results'][] = array(
                'category'=> $category[0],
                'user' => $user[0],
                'time'=> $time->toDateTimeString(),
                'comment'=> $comment->text,
                'id'=> $comment->id,
            );
        }
        $protected = Category::select('protected')->where('id',$this->comment_category_id)->first();


        return [
            'id' => $this->id,
            'sentece_text' => $this->sentence_text,
            'protected' => boolval($protected->protected),
            'comments' => $data['results'],
        ];
    }
}
