<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreFilter;
use App\Http\Requests\MultiValues;
use App\Http\Requests\StoreTransaction;
use App\Transactions;
use App\Upgrade;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UpgradeBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Upgrade::with('user')->get();

        return view('upgrade.list', compact('users'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($jwt)
    {
        $user = JWTAuth::toUser(Crypt::decrypt($jwt));

        Upgrade::create([
            'user_id' => $user->id,
            'active' => 0
        ]);

        return view('paypal.succsess', compact('user'));
    }


    public function multiActivate(MultiValues $request)
    {

        $values = $request->values;

        foreach($values as $id)
        {
            Upgrade::find($id)->update([
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
            Upgrade::find($id)->update([
                'active' => 0
            ]);
        }

        return back();
    }


    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Upgrade::find($id)->delete();

        return back();
    }

}
