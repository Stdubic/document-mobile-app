<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\MultiValues;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = User::orderBy('name')->get();

		return view('users.list', compact('users'));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$roles = Role::orderBy('name')->get();

        return view('users.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
		$status = User::create([
			'name' => $request->name,
			'email' => strtolower($request->email),
			'password' => Hash::make($request->password),
			'active' => isset($request->active),
			'role_id' => isset($request->role_id) ? $request->role_id : setting('registration_role_id')
		]);

		return redirect(route('users.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$user = User::findOrFail($id);
		$roles = Role::orderBy('name')->get();

		return view('users.add', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$request->validate([
			'name' => 'required|max:50',
			'email' => 'required|max:50|email|unique:users,email,'.$id,
			'password' => 'required|confirmed|min:'.setting('min_pass_len'),
			'active' => 'boolean',
			'role_id' => 'required|integer|min:1'
		]);

		User::findOrFail($id)->update([
			'name' => $request->name,
			'email' => strtolower($request->email),
			'password' => Hash::make($request->password),
			'active' => isset($request->active),
			'role_id' => $request->role_id
		]);

		return redirect(route('users.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		User::findOrFail($id)->delete();

		return redirect(route('users.list'));
	}

	public function multiActivate(MultiValues $request)
	{
		$values = $request->values;

		foreach($values as $id)
		{
			User::find($id)->update([
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
			User::find($id)->update([
				'active' => 0
			]);
		}

		return back();
	}

	public function multiRemove(MultiValues $request)
	{
		$values = $request->values;

		foreach($values as $id) User::find($id)->delete();

		return back();
	}
}
