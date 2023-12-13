<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthLoginRequest;
use App\Http\Requests\Api\OrderIndexRequest;
use App\Http\Requests\Api\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Basket;
use App\Models\CollectingProduct;
use App\Models\Moving;
use App\Models\MovingProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function all(Request $request)
    {

        $orders = [];

        Basket::query()
            ->join('orders', 'orders.id', 'baskets.order_id')
            ->join('products', 'products.id', 'baskets.product_id')
            ->where('baskets.type', 0)
            ->when($request->has('order_id'), function ($q){
                $q->where('order_id',\request('order_id'));
            })
            ->whereDate('orders.created_at', now())
            ->whereNull(['orders.deleted_at', 'orders.removed_at', 'baskets.deleted_at'])
            ->groupBy('products.id')
            ->selectRaw('products.id, products.name, products.article, measure, SUM(baskets.count) as sell_count')
            ->orderBy('products.name')
            ->each(function ($item) use (&$orders) {
                $item->count = MovingProduct::query()
                    ->join('movings','movings.id','moving_products.moving_id')
                    ->where('movings.from_user_id',Auth::id())
                    ->where('moving_products.product_id',$item->id)
                    ->where('movings.type',2)
                    ->whereDate('movings.created_at',now())
                    ->sum('moving_products.count');
                $orders[] = $item;
            });

        return response()->json($orders);
    }

    public function allByStore(Request $request)
    {
        $orders = [];

        Basket::query()
            ->join('orders', 'orders.id', 'baskets.order_id')
            ->join('products', 'products.id', 'baskets.product_id')
            ->where('baskets.type', 0)
            ->where('orders.store_id',$request->get('store_id'))
            ->when($request->has('order_id'), function ($q){
                $q->where('order_id',\request('order_id'));
            })
            ->whereDate('orders.delivery_date', now())
            ->whereNull(['orders.deleted_at', 'orders.removed_at', 'baskets.deleted_at'])
            ->groupBy('products.id')
            ->selectRaw('products.id, products.name, products.article, measure, SUM(baskets.count) as sell_count')
            ->orderBy('products.name')
            ->each(function ($item) use (&$orders) {
                $item->count = CollectingProduct::query()
                    ->join('collectings','collectings.id','collecting_products.collecting_id')
                    ->where('collectings.user_id',Auth::id())
                    ->where('product_id',$item->id)
                    ->whereDate('collectings.created_at',now())
                    ->sum('collecting_products.count');
                $orders[] = $item;
            });

        return response()->json($orders);
    }

    public function storeOrders(Request $request)
    {
        $stores = Store::query()
            ->join('orders','orders.store_id','stores.id')
            ->whereDate('delivery_date',now())
            ->where('orders.purchase_price','>',0)

            ->when($request->has('search'),function ($q){
                $q->where('orders.id','LIKE',request('search').'%');
            })
            ->groupBy('stores.id')
            ->orderBy('created_at')
            ->get();
        return response()->json($stores);
    }

    public function index(OrderIndexRequest $request)
    {
        $orders = Order::query()
            ->where('orders.purchase_price','>',0)
            ->when($request->has('order_id'), function ($q){
                $q->where('orders.id',\request('order_id'));
            })
            ->when($request->has('salesrep_id'), function ( $query) {
                $query->where('salesrep_id',\request('salesrep_id'));
            })
            ->whereDate('delivery_date',now())
            ->with(['baskets' => function($q){
                $q->where('type',0);
            },'baskets.product','store'])
            ->get();

        return response()->json($orders);
    }

    public function history(OrderIndexRequest $request)
    {
        $orders = Order::query()
            ->where('orders.purchase_price','>',0)
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
                $q->where('type',0);
            },'baskets.product','store'])
            ->latest()
            ->paginate(50);
        return response()->json($orders);
    }

    public function orderShow($id)
    {

        $order = Order::query()
            ->where('id',$id)
            ->with(['baskets','baskets.product'])
            ->first();
        return response()->json($order);
    }
}


