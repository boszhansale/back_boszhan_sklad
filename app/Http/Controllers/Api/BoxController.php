<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function show(Request $request)
    {
        $boxes = Box::query()
//            ->when($request->has('id'), function ( $query) {
//                $query->where('id',request('id'));
//            })
            ->when($request->has('number'), function ( $query) {
                $query->where('number',request('number'));
            })
            ->when($request->has('warehouse_id'), function ($query) {
                $query->where('warehouse_id',request('warehouse_id'));
            })
//            ->with(['item.product','item.material'])
            ->with(['products.product'])
            ->first();

        return response()->json($boxes);
    }
    //YmdHi + 1234
}
