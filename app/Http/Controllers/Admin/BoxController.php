<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BoxStoreRequest;
use App\Models\Box;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoxController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.box.index');
    }

    public function create()
    {
        $warehouses =  Warehouse::orderBy('name')->get();
        $number = now()->format('YmdHi').'1'.rand(1000,9999);

        return view('admin.box.create',compact('warehouses','number'));
    }

    public function store(BoxStoreRequest $request): RedirectResponse
    {
        Box::create($request->validated());
        return redirect()->route('admin.box.index');
    }

    public function edit(Box $box)
    {


        $warehouses = Warehouse::orderBy('name')->get();
        return view('admin.store.edit', compact('warehouses','box'));
    }

    public function update(Request $request, Box $box)
    {
        return redirect()->back();
    }

    public function show(Request $request, Box $box)
    {

        return view('admin.box.show', compact('box'));
    }

    public function delete(Box $box)
    {
        $box->delete();
        return redirect()->back();
    }


}
