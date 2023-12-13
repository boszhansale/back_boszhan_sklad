<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MovingStoreRequest;
use App\Models\Brand;
use App\Models\Counteragent;
use App\Models\Moving;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class MovingController extends Controller
{
    public function index()
    {
        return view('admin.moving.index');
    }
    public function create()
    {
        return view('admin.moving.create');
    }
    public function store(MovingStoreRequest $request)
    {
        $moving =  Moving::create($request->validated());
        foreach ($request->products as $product) {
            $moving->products()->create($product);
        }
        return response()->json($moving);
    }
    //edit and update
    public function edit(Moving $moving)
    {
        return view('admin.moving.edit', compact('moving'));
    }
    public function update(MovingStoreRequest $request, Moving $moving)
    {
        $moving->update($request->validated());
        $moving->products()->delete();
        foreach ($request->products as $product) {

        }
        return response()->json($moving);
    }


    public function delete(Moving $moving)
    {
        $moving->delete();
        return response()->json($moving);
    }



}
