<?php

namespace App\Http\Controllers;

use App\NotificationGroup;
use App\Http\Requests\MultiValues;
use App\Http\Requests\StoreNotificationGroup;

class NotificationGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = NotificationGroup::orderBy('name')->get();

        return view('notification-groups.list', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('notification-groups.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationGroup $request)
    {
        $group = NotificationGroup::create([
            'name' => $request->name
        ]);


        return redirect(route('notification-groups.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NotificationGroup  $notificationGroup
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationGroup $notificationGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NotificationGroup  $notificationGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = NotificationGroup::findOrFail($id);

        return view('notification-groups.add', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NotificationGroup  $notificationGroup
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNotificationGroup $request, NotificationGroup $id)
    {
        $id->update([
            'name' => $request->name,
        ]);


        return redirect(route('notification-groups.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NotificationGroup  $notificationGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationGroup $id)
    {
        $id->delete();

        return redirect(route('notification-groups.list'));
    }

    public function multiRemove(MultiValues $request)
    {
        foreach($request->values as $id) NotificationGroup::find($id)->delete();

        return back();
    }
}
