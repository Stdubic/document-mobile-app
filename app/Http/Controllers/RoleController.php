<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use App\Http\Requests\MultiValues;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('name')->get();

		return view('roles.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        $status = Role::create([
			'name' => $request->name,
			'view_all' => isset($request->view_all),
			'mode' => $request->mode,
			'routes' => $request->routes
		]);

		return redirect(route('roles.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $Role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

		return view('roles.add', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRole $request, $id)
    {
        Role::findOrFail($id)->update([
			'name' => $request->name,
			'view_all' => isset($request->view_all),
			'mode' => $request->mode,
			'routes' => $request->routes
		]);

		return redirect(route('roles.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $Role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

		return $this->index();
	}

	public function multiRemove(MultiValues $request)
	{
		$values = $request->values;

		foreach($values as $id) Role::find($id)->delete();

		return back();
	}
}
