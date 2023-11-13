<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthLoginRequest;
use App\Http\Requests\Api\OrderIndexRequest;
use App\Http\Requests\Api\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    public function all(Request $request)
    {

        $orders = Basket::query()
            ->join('orders','orders.id','baskets.order_id')
            ->join('products','products.id','baskets.product_id')
//            ->when($request->has('start_date'),function ($q){
//                $q->whereDate('orders.delivery_date','>=',request('start_date'));
//            })
//            ->when($request->has('end_date'),function ($q){
//                $q->whereDate('orders.delivery_date','<=',request('end_date'));
//            })
            ->whereDate('delivery_date',now())
            ->where('baskets.type',1)
            ->when($request->has('store_id'), function ($query) {
                $query->where('orders.store_id',\request('store_id'));
            })
//            ->when($request->has('search'),function ($q){
//                $q->where('orders.id','LIKE',request('search').'%');
//            })
            ->groupBy('products.id')
            ->selectRaw('products.id,products.name,products.article,measure,SUM(baskets.count) as count')
            ->orderBy('products.name')
            ->get();
        return response()->json($orders);
    }


    public function index(OrderIndexRequest $request)
    {
        $orders = Order::query()
            ->where('orders.return_price','>',0)
            ->whereDate('delivery_date',now())
            ->with(['baskets' => function($q){
                $q->where('type',1);
            },'baskets.product','store'])
            ->paginate(50);

        return response()->json($orders);
    }

    public function history(OrderIndexRequest $request)
    {
        $orders = Order::query()
            ->where('orders.return_price','>',0)
            ->when($request->has('start_date'),function ($q){
                $q->whereDate('delivery_date','>=',request('start_date'));
            })
            ->when($request->has('end_date'),function ($q){
                $q->whereDate('delivery_date','<=',request('end_date'));
            })
            ->when($request->has('search'),function ($q){
                $q->where('orders.id','LIKE',request('search').'%');
            })
            ->with(['baskets' => function($q){
                $q->where('type',1);
            },'baskets.product','store'])
            ->latest()
            ->paginate(50);
        return response()->json($orders);
    }

}
