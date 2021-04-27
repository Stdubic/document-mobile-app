<?php

namespace App\Http\Controllers;

use App\Document;
use App\Role;
use App\Section;
use App\Sentence;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDocument;
use App\Http\Requests\MultiValues;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class DocumentBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::orderBy('created_at','dec')->get();

        return view('documents.list', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authUser = Auth::user();
        $user = JWTAuth::fromUser($authUser);
        return view('documents.add',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocument $request)
    {
        Document::create([
            'title' => $request->title,
        ]);

        return redirect(route('documents.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $Document
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $authUser = Auth::user();
        $user = JWTAuth::fromUser($authUser);
        return view('documents.edit', compact('document','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $Document
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDocument $request, $id)
    {
        Document::findOrFail($id)->update([
            'title' => $request->title,
        ]);

        return redirect(route('documents.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document $Document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Document::findOrFail($id)->delete();

        return $this->index();
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Document::find($id)->delete();

        return back();
    }
    public function sectionsEdit($id)
    {

        $document = Document::find($id);

        return view('documents.edit', compact('section','document', 'sentences','sectionid'));
    }
    public function multiActivate(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id)
        {
            Document::find($id)->update([
                'active' => 1
            ]);
        }

        return back();
    }

    public function multiDeactivate(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id)
        {
            Document::find($id)->update([
                'active' => 0
            ]);
        }

        return back();
    }

}
