<?php

namespace App\Http\Controllers\API;


use App\Http\Resources\FilterResource;
use App\Filter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FilterController extends Controller
{
    public function index()
    {
        return FilterResource::collection(Filter::with('filter_options')->orderBy('order')->get());
    }


}
