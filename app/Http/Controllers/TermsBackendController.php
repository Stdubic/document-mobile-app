<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTerms;
use App\Term;
use App\Http\Requests\MultiValues;

class TermsBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::orderBy('created_at')->get();

        return view('terms.list', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('terms.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTerms $request)
    {
        Term::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect(route('terms.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Term
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = Term::findOrFail($id);

        return view('terms.add', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Term
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTerms $request, $id)
    {
        Term::findOrFail($id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect(route('terms.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Term
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Term::findOrFail($id)->delete();

        return $this->index();
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Term::find($id)->delete();

        return back();
    }

}
