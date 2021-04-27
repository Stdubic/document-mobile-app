<?php

namespace App\Http\Controllers\API;

use App\Section;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Document;
use App\Http\Resources\DocumentResource;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index()
    {
        return DocumentResource::collection(Document::with('sections')->where('active',1)->orderBy('protected','asc')->get());

    }

    public function store(Request $request)
    {
        $document = Document::create([
            'title' => $request->title
        ]);

        return new DocumentResource($document);
    }

    public function show(Document $document)
    {
        $response_data['text'] = $document->title;
        $response_data['children'] = ($document->structure != null ? json_decode($document->structure) : []);
        $response_data['id'] = $document->id;
        $response_data['data']['database']['id'] = $document->id;
        $response_data['data']['database']['type'] = 'DOCUMENT';
        $response_data['data']['database']['document_title'] = $document->title;
        $response_data['data']['database']['protected'] = $document->protected;

        return $response_data;
    }



}
