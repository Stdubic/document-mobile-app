<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\TermResource;
use App\Term;
use App\Http\Controllers\Controller;


class TermsController extends Controller
{
    public function index()
    {
        return TermResource::collection(Term::orderBy('created_at')->get());
    }

    public function show(Term $term)
    {
        return new TermResource($term);
    }

}
