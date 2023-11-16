<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CouplingStoreRequest;
use App\Models\Box;
use App\Models\BoxProduct;
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

    public function index()
    {
        $couplings = Auth::user()
            ->couplings()
            ->latest()
            ->limit(100)
            ->with(['product','products.product'])
            ->get();

        return response()->json($couplings);
    }

    public function store(CouplingStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $formula = Formula::find($request->get('formula_id'));
            $toBox = Box::where('number',$request->get('box_number'))->first();
            $coupling =  Auth::user()->couplings()->create(array_merge($request->validated(),['product_id' => $formula->product_id,'box_id' => $toBox->id]));


            if (count($formula->products) == 0){
                throw new Exception('ошибка с стороны Админки');
            }
            foreach ($formula->products as $formulaProduct) {
                $count = $formulaProduct->count * $request->get('count');

                foreach ($request->get('boxes') as $boxNumber)
                {


                    $boxProduct = BoxProduct::query()
                        ->join('boxes','boxes.id','box_products.box_id')
                        ->where('boxes.number',$boxNumber)
                        ->where('product_id',$formulaProduct->product_id)
                        ->select('box_products.*')
                        ->first();

                    if (!$boxProduct){
                        continue;
                    }

                    if ($boxProduct->count < $count){
                        throw new Exception("Продукт с ID:$formulaProduct->product_id не хватает ".$count-$boxProduct->count);
                    } elseif ($boxProduct->count == $count)
                    {
                        $boxProduct->delete();
                    } else{
                        $boxProduct->decrement('count',$count);
                    }

                    $coupling->products()->create([
                        'product_id' => $boxProduct->product_id,
                        'count' => $count,
                        'box_id' => $boxProduct->box_id,
                    ]);

                    continue 2;
                }

                throw new Exception("Продукт ID:$formulaProduct->product_id не указано или не найден");
            }

            if ($toBox->products()->where('product_id',$formula->product_id)->exists()){
                $toBox->products()->where('product_id',$formula->product_id)->increment('count',$request->get('count'));
            }else{
                $toBox->products()->create([
                    'product_id' => $formula->product_id,
                    'count' => $request->get('count'),
                ]);
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
