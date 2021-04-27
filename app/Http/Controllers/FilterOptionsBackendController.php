<?php

namespace App\Http\Controllers;

use App\Filter;
use App\FilterOption;
use App\Http\Requests\StoreFilter;
use App\Http\Requests\MultiValues;
use App\Http\Requests\StoreFilterOptions;

class FilterOptionsBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = Filter::all()->keyBy('id');
        $filter_options = FilterOption::orderBy('filter_id')->get();

        return view('filteroptions.list', compact('filter_options','filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filters = Filter::all();
        return view('filteroptions.add',compact('filters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFilterOptions $request)
    {
        FilterOption::create([
            'title' => $request->title,
            'filter_id'=> $request->filter_id,
            'protected'=> $request->protected,
            'order'=> $request->order,
        ]);

        return redirect(route('filteroptions.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FilterOption
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FilterOption
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $filters = Filter::all();
        $filter = FilterOption::findOrFail($id);


        return view('filteroptions.add', compact('filter','filters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FilterOption
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFilterOptions $request, $id)
    {
        FilterOption::findOrFail($id)->update([
            'title' => $request->title,
            'protected'=> $request->protected,
            'order'=> $request->order,
        ]);

        return redirect(route('filteroptions.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FilterOption
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FilterOption::findOrFail($id)->delete();

        return $this->index();
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) FilterOption::find($id)->delete();

        return back();
    }

}
