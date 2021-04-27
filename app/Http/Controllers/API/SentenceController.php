<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SectionResource;
use App\Http\Resources\SentanceCommentsResource;
use App\Http\Resources\SentenceResource;
use App\Section;
use App\Sentence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SentenceController extends Controller
{
    public function index()
    {
        return SentenceResource::collection(Sentence::all());
    }

    public function store(Request $request)
    {
        $sentence = Sentence::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return new SentenceResource($sentence);
    }

    public function show(Sentence $sentence)
    {
            return new SentenceResource($sentence);


    }
    public function sentence_comments(Sentence $sentence, $comment_category_id)
    {

        return new SentanceCommentsResource($sentence,$comment_category_id);

    }

}
