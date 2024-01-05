<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\User;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::all();
        return view('stores.index', compact('stores'));
    }

    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $store = new Store($request->all());
        $store->save();
        return redirect()->route('stores.index');
    }

    public function show($id)
    {
        $store = Store::findOrFail($id);
        return view('stores.show', compact('store'));
    }

    public function edit($id)
    {
        $store = Store::findOrFail($id);
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->update($request->all());
        return redirect()->route('stores.index');
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
        return redirect()->route('stores.index');
    }
}
