<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ComingStoreRequest;
use App\Models\Box;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coming;
use App\Models\Counteragent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComingController extends Controller
{
    public function index()
    {
        $comings = Auth::user()->comings()
            ->latest()
            ->with(['product','material','box'])
            ->get();

        return response()->json($comings);
    }
    public function store(ComingStoreRequest $request){
        DB::beginTransaction();

        try {
            $coming = Auth::user()->comings()->create($request->validated());

            $box = Box::findOrFail($request->get('box_id'));
            if ($box->item_id){
                if ($box->item->product_id != $request->get('product_id')){
                    throw new \Exception('коробка не пусто');
                }
                if ($box->item->material_id != $request->get('material_id')){
                    throw new \Exception('коробка не пусто');
                }
                $box->item()->increment('count',$request->get('count'));

            }else{
                $item = $box->items()->create([
                    'product_id' => $request->get('product_id'),
                    'material_id' => $request->get('material_id'),
                    'count' => $request->get('count'),
                    'coming_id' => $coming->id,
                ]);

                $box->update(['item_id' => $item->id]);
            }

            DB::commit();
            return  response()->json([
                'box' => $box,
                'coming' => $coming
            ]);
        } catch (\Exception $exception){
            DB::rollback();

            return  response()->json([
                'message' => $exception->getMessage()
            ],400);
        }

    }
    public function delete()
    {

    }
}
