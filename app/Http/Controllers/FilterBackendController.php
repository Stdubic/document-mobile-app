<?php

namespace App\Http\Controllers;

use App\Filter;
use App\Http\Requests\StoreFilter;
use App\Http\Requests\MultiValues;

class FilterBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = Filter::orderBy('order')->get();

        return view('filters.list', compact('filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('filters.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFilter $request)
    {
        Filter::create([
            'title' => $request->title,
            'type' => $request->type,
            'protected' => $request->protected,
            'order' => $request->order,
        ]);

        return redirect(route('filters.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Filter
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Filter
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $filter = Filter::findOrFail($id);

        return view('filters.add', compact('filter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Filter
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFilter $request, $id)
    {
        Filter::findOrFail($id)->update([
            'title' => $request->title,
            'type' => $request->type,
            'protected' => $request->protected,
            'order' => $request->order,
        ]);

        return redirect(route('filters.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Filter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Filter::findOrFail($id)->delete();

        return $this->index();
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Filter::find($id)->delete();

        return back();
    }

}
