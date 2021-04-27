<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Category;
use App\Http\Resources\CommentResource;
use App\Sentence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentBackendController extends Controller
{
    public function index()
    {
        return CommentResource::collection(Comment::all());
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function store(Request $request, Sentence $sentence)
    {
        $user_id = Auth::id();
        $comment = Comment::create(
            [
                'sentence_id' => $sentence->id,
                'user_id' => $user_id,
                'category_id' => $request->category_id,
                'text' => $request->text
            ]
        );
        return new CommentResource($comment);
    }
    public function categories(){

        return Category::all();

    }

}
