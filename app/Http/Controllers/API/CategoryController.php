<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(Request $request, Sentence $sentence)
    {
        $comment = Comment::create(
            [
                'user_id' => 1,
                'comment_category_id' => 1,
                'sentence_id' => $sentence->id,
                'text' => $request->text,
            ]
        );

        return new CommentResource($comment);
    }
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
}
