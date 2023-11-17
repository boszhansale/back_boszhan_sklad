<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BoxStoreRequest;
use App\Http\Requests\Admin\FormulaStoreRequest;
use App\Models\Box;
use App\Models\Formula;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormulaController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.formula.index');
    }

    public function create()
    {
        $products =  Product::orderBy('name')->get();

        return view('admin.formula.create',compact('products'));
    }

    public function store(FormulaStoreRequest $request): RedirectResponse
    {
        $formula = Formula::create($request->validated());

        return redirect()->route('admin.formula.edit',$formula->id);
    }

    public function edit(Formula $formula)
    {
        $products =  Product::orderBy('name')->get();
        return view('admin.formula.edit', compact('products','formula'));
    }

    public function update(Request $request, Formula $formula)
    {
        return redirect()->back();
    }

    public function show(Request $request, Formula $formula)
    {

        return view('admin.formula.show', compact('formula'));
    }

    public function delete(Formula $formula)
    {
        $formula->delete();
        return redirect()->back();
    }


}
