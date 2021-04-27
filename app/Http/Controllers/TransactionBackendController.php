<?php

namespace App\Http\Controllers;

use App\Filter;
use App\Http\Requests\StoreFilter;
use App\Http\Requests\MultiValues;
use App\Http\Requests\StoreTransaction;
use App\Transactions;
use Carbon\Carbon;
use App\User;

class TransactionBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transactions::with('user')->orderBy('created_at','dec')->get()->toArray();

        return view('transactions.list', compact('transactions','test'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('surname','dec')->get();

        return view('transactions.add', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaction $request)
    {
        Transactions::create([
            'user_id' => $request->user_id,
            'time' => Carbon::now(),
            'expiry_time' => Carbon::now()->addMonths(setting('duration')) ,
        ]);

        return redirect(route('transactions.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transactions
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transactions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transactions = Transactions::findOrFail($id);
        $users = User::orderBy('surname','dec')->get();

        return view('transactions.add', compact('transactions','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transactions
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFilter $request, $id)
    {
        Transactions::findOrFail($id)->update([
            'user_id' => $request->user_id,
            'time' => Carbon::now(),
            'expiry_time' => Carbon::now()->addMonths(setting('duration')) ,
        ]);

        return redirect(route('transactions.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transactions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transactions::findOrFail($id)->delete();

        return $this->index();
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id) Transactions::find($id)->delete();

        return back();
    }

}
