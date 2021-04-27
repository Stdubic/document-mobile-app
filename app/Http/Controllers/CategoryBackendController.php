<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\MultiValues;

class CategoryBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('order')->get();

        return view('category.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        Category::create([
            'name' => $request->name,
            'order' => $request->order,
            'protected' => $request->protected,
        ]);

        return redirect(route('category.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('category.add', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request, $id)
    {
        Category::findOrFail($id)->update([
            'name' => $request->name,
            'order' => $request->order,
            'protected' => $request->protected,

        ]);

        return redirect(route('category.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return $this->index();
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Category::find($id)->delete();

        return back();
    }

}
