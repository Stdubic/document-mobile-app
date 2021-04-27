<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Http\Resources\CommentResource;
use App\Sentence;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CommentController extends Controller
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
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json('user_not_found');
            }
        } catch (TokenExpiredException $e) {
            return response()->json('token_expired');

        } catch (TokenInvalidException $e) {
            return response()->json('token_invalid');

        } catch (JWTException $e) {
            return response()->json('token_absent');
        }

        $user_id = $user->id;
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

    public function delete(Request $request,$id){
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json('user_not_found');
            }
        } catch (TokenExpiredException $e) {
            return response()->json('token_expired');

        } catch (TokenInvalidException $e) {
            return response()->json('token_invalid');

        } catch (JWTException $e) {
            return response()->json('token_absent');
        }


        Comment::findOrFail($id)->delete();

        return response()->json(['status'=>'deleted']);

    }
}
