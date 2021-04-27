<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SectionResource;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SectionController extends Controller
{
    public function index()
    {
        return SectionResource::collection(Section::all());
    }

    public function show(Section $rating)
    {
        return new SectionResource($rating);
    }
}
