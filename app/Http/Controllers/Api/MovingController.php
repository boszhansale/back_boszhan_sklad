<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MovingByStoreRequest;
use App\Http\Requests\Api\MovingGeneralRequest;
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
        if (Auth::id() == $request->get('to_user_id')){
            return  response()->json(['message' => 'перемещения себе'],400);
        }
        DB::beginTransaction();

        try {
            $fromBox = Box::whereNumber($request->get('from_box_number'))->first();
            $toBox = Box::whereNumber($request->get('to_box_number'))->first();
            $toUser = User::find($request->get('to_user_id'));

            $moving = Moving::create([
                'type' => 1,
                'from_user_id' => Auth::id(),
                'from_box_id' =>  $fromBox->id,
                'to_user_id' => $toUser->id,
                'to_box_id' => $toBox->id,
            ]);
            if (!$moving){
                throw  new \Exception('error create moving');
            }

            foreach ($request->get('products') as $item) {
                $count = (float)$item['count'];
                $moving->products()->create([
                    'product_id' => $item['product_id'],
                    'count' => $item['count'],
                    'from_box_id' => $fromBox->id,
                    'to_box_id' => $toBox->id,
                ]);

                $fromBoxProduct = $fromBox->products()->where('product_id',$item['product_id'])->first();
                if ($fromBoxProduct){
                    if ($fromBoxProduct->count == $count){
                        $fromBoxProduct->delete();
                    }else if($fromBoxProduct->count > $count){
                        $fromBoxProduct->decrement('count',$count);
                        Auth::user()->decrementProduct($item['product_id'],$count);
                    }else{
                        throw new \Exception('нехватка');
                    }
                }else{
                    throw new \Exception('не найден продукт: '.$item['product_id']);
                }

                $toBoxProduct = $toBox->products()->where('product_id',$item['product_id'])->first();
                if (!$toBoxProduct){
                    $toBoxProduct = new BoxProduct();
                    $toBoxProduct->box_id = $toBox->id;
                    $toBoxProduct->product_id = $item['product_id'];
                    $toBoxProduct->count = $count;
                }
                else{
                    $toBoxProduct->count += $count;
                }
                $toBoxProduct->save();
                $toUser->incrementProduct($item['product_id'],$count);
            }

            DB::commit();

            return  response()->json([
                'to_box' => $toBox,
                'from_box' => $fromBox,
                'moving' => $moving,
            ]);
        } catch (\Exception $exception){
            DB::rollback();

            return  response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    public function general(MovingGeneralRequest $request)
    {

        DB::beginTransaction();

        try {
            $toBox = Box::whereNumber($request->get('to_box_number'))->first();

            $toUserId = $toBox->warehouse->user_id;

            $moving = Moving::create([
                'type' => 2,
                'from_user_id' => Auth::id(),
                'to_user_id' => $toUserId,
                'to_box_id' => $toBox->id,
            ]);

            if (!$moving){
                throw  new \Exception('error create moving');
            }

            foreach ($request->get('products') as $item) {
                $moving->products()->create([
                    'product_id' => $item['product_id'],
                    'count' => $item['count'],
                    'to_box_id' => $toBox->id,
                ]);


               foreach ($item['boxes'] as $itemBox)
               {
                   $toBoxProduct = $toBox->products()->where('product_id',$item['product_id'])->first();
                   if (!$toBoxProduct){
                       $toBoxProduct = new BoxProduct();
                       $toBoxProduct->box_id = $toBox->id;
                       $toBoxProduct->product_id = $item['product_id'];
                       $toBoxProduct->count = $itemBox['count'];
                   }
                   else{
                       $toBoxProduct->count += $itemBox['count'];
                   }
                   $toBoxProduct->save();
                   Auth::user()->incrementProduct($item['product_id'],$itemBox['count']);
               }
            }

            DB::commit();

            return  response()->json([
                'box' => $toBox,
                'moving' => $moving,
            ]);
        } catch (\Exception $exception){
            DB::rollback();
            return  response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
    }

    public function byStory(MovingByStoreRequest $request)
    {

        DB::beginTransaction();

        try {

            $order = Order::find($request->get('order_id'));
            if (!$order){
                throw new \Exception('order not found');
            }
            $order->collect_at = now();
            $order->save();

            $moving = Moving::create([
                'type' => 3,
                'from_user_id' => Auth::id(),
                'to_user_id' => $order->driver_id,
                'order_id' => $request->get('order_id'),
            ]);
            if (!$moving){
                throw  new \Exception('error create moving');
            }

            foreach ($request->get('products') as $item) {
                $count = (float)$item['count'];
                $fromBox = Box::query()
                    ->where('boxes.number',$item['from_box_number'])
                    ->first();

                if (!$fromBox){
                    throw new \Exception('QR:'.$item['from_box_number'].' не найден');
                }

                $fromBoxProduct = $fromBox->products()->where('product_id',$item['product_id'])->first();
                if ($fromBoxProduct){
                    if ($fromBoxProduct->count == $count){
                        $fromBoxProduct->delete();
                    }else if($fromBoxProduct->count > $count){
                        $fromBoxProduct->decrement('count',$count);
                        Auth::user()->decrementProduct($item['product_id'],$count);
                    }else{
                        throw new \Exception('нехватка');
                    }
                }else{
                    throw new \Exception('не найден продукт: '.$item['product_id']);
                }
                $moving->products()->create([
                    'product_id' => $item['product_id'],
                    'from_box_id' => $fromBox->id,
                    'count' => $item['count'],
                ]);

            }


            DB::commit();

            return  response()->json([
                'box' => $fromBox,
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
