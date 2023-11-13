<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CouplingStoreRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\Coupling;
use App\Models\Formula;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CouplingController extends Controller
{
    public function store(CouplingStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $formula = Formula::find($request->get('formula_id'));
            $coupling =  Auth::user()->couplings()->create(array_merge($request->validated(),['product_id' => $formula->product_id]));


            foreach ($formula->products as $formulaProduct) {
                $count = $formulaProduct->count * $request->get('count');

            }

            foreach ($request->get('products') as $item)
            {

            }


            DB::commit();

            return  response()->json([
                'coupling' => $coupling
            ]);


        }catch ( Exception $exception)
        {

            DB::rollBack();

            return response()->json(['message' => $exception->getMessage()],400);
        }
    }
}
