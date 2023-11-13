<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MovingIndexRequest;
use App\Http\Requests\Api\MovingStoreRequest;
use App\Models\Box;
use App\Models\BoxProduct;
use App\Models\Moving;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovingController extends Controller
{
    public function from(MovingIndexRequest $request)
    {
        $movings = Auth::user()->fromMovings()
            ->when($request->has('start_date'), function ( $query) {
                $query->whereDate('created_at','>=',request('start_date'));
            })
            ->when($request->has('end_date'), function ( $query) {
                $query->whereDate('created_at','<=',request('end_date'));
            })
            ->with(['fromUser','toUser','fromBox','toBox','products.product'])
            ->latest()
            ->get();

        return response()->json($movings);
    }

    public function to(MovingIndexRequest $request)
    {
        $movings = Auth::user()->toMovings()
            ->when($request->has('start_date'), function ( $query) {
                $query->whereDate('created_at','>=',request('start_date'));
            })
            ->when($request->has('end_date'), function ( $query) {
                $query->whereDate('created_at','<=',request('end_date'));
            })
            ->with(['fromUser','toUser','fromBox','toBox','products.product'])
            ->latest()
            ->get();

        return response()->json($movings);
    }

    public function store(MovingStoreRequest $request)
    {

        DB::beginTransaction();

        try {
            $fromBox = Box::find($request->get('from_box_id'));
            $toBox = Box::find($request->get('to_box_id'));

//            if ($fromBox)
//            {
//                if ($fromBox->item == null){
//                    throw new \Exception('коробка "C" пусто');
//                }
//                if($fromBox->item->count == $request->get('count')){
//                    $fromBox->item()->update(['item_id' => null]);
//                }else if ($fromBox->item->count  < $request->get('count')){
//                    throw new \Exception('не хватка');
//                }else if ($fromBox->item->count > $request->get('count')){
//                    $fromBox->item()->decrement('count',$request->get('count'));
//                }else{
//                    throw new \Exception('error');
//                }
//            }

//            if ($toBox->item_id){
//                if ($toBox->item->product_id != $request->get('product_id')){
//                    throw new \Exception('коробка не пусто');
//                }
//            }

            $toUserId = $request->get('to_user_id');
            if ($request->has('order_id')){
                $order = Order::find($request->get('order_id'));
                if (!$order){
                    throw new \Exception('order not found');
                }
                $order->collect_at = now();
                $order->save();
                $toUserId = $order->driver_id;
            }

            $moving = Moving::create([
                'from_user_id' => Auth::id(),
                'from_box_id' =>  $request->get('from_box_id'),
                'to_user_id' => $toUserId,
                'to_box_id' => $request->get('to_box_id'),
                'order_id' => $request->get('order_id'),
                'coming_id' => $fromBox?->item?->coming_id
            ]);
            if (!$moving){
                throw  new \Exception('error create moving');
            }

            foreach ($request->get('products') as $item) {
                $moving->products()->create([
                    'product_id' => $item['product_id'],
                    'count' => $item['count'],
                ]);

                if ($fromBox){
                    $fromBoxProduct = $fromBox->products()->where('product_id',$item['product_id'])->first();
                    if ($fromBoxProduct){
                        if ($fromBoxProduct->count = $item['count']){
                            $fromBoxProduct->delete();
                        }else if($fromBoxProduct->count > $item['count']){
                            $fromBoxProduct->decrement('count',$item['count']);
                        }
                        else if($fromBoxProduct->count < $item['count']){
                            throw new \Exception('нехватка');
                        }
                    }
                }

                if ($toBox)
                {
                    $toBoxProduct = $toBox->products()->where('product_id',$item['product_id'])->first();
                    if (!$toBoxProduct){
                        $toBoxProduct = new BoxProduct();
                        $toBoxProduct->box_id = $toBox->id;
                        $toBoxProduct->product_id = $item['product_id'];
                        $toBoxProduct->count = $item['count'];
                    }
                    else{
                        $toBoxProduct->count += $item['count'];
                    }
                    $toBoxProduct->save();
                }

            }


//            if ($toBox->item){
//                $item = $toBox->item()->increment('count',$request->get('count'));
//            }else{
//                $item = $toBox->items()->create([
//                    'product_id' => $request->get('product_id'),
//                    'material_id' => $request->get('material_id'),
//                    'count' => $request->get('count'),
//                    'moving_id' => $moving->id,
//                ]);
//                $toBox->update(['item_id' => $item->id]);
//            }


            DB::commit();

            return  response()->json([
                'box' => $toBox,
                'item' => $item,
                'moving' => $moving,
            ]);
        } catch (\Exception $exception){
            DB::rollback();

            if ($request->has('order_id')){
                $order = Order::find($request->get('order_id'));
                if ($order){
                    $order->collect_at = null;
                    $order->save();
                }
            }


            return  response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    public function accept(Request $request)
    {
        $moving = Moving::query()
        ->where('to_user_id',Auth::id())
        ->where('id',$request->get('id'))
        ->first();

        if (!$moving){
            return response()->json(['message' => 'moving not found'],404);
        }

        $moving->update(['accept_at' => now(),'reject_at' => null]);

        return response()->json(['moving' => $moving]);
    }

    public function reject(Request $request)
    {
        $moving = Moving::query()
        ->where('to_user_id',Auth::id())
        ->where('id',$request->get('id'))
        ->firstOrFail();

        $moving->update(['accept_at' => null,'reject_at' => now()]);

        return response()->json(['moving' => $moving]);
    }


}
