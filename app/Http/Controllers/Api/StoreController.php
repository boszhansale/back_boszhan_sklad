<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index(Request $request)
    {

        $stores = Store::query()
            ->join('orders','orders.store_id','stores.id')
            ->whereDate('orders.delivery_date',now())
            ->where('purchase_price','>',0)
            ->groupBy('stores.id')
            ->orderBy('stores.name')
            ->select('stores.*')
            ->get();


        return response()->json($stores);
    }


    public function drivers(Request $request)
    {
//        $drivers = User::query()
//            ->where('users.status',1)
//            ->join('orders','orders.driver_id','users.id')
//            ->groupBy('users.id')
//            ->orderBy('users.name')
//            ->get();

        $drivers = Order::query()
            ->join('driver_salesreps','driver_salesreps.salesrep_id','orders.salesrep_id')
            ->join('users','driver_salesreps.driver_id','users.id')
            ->where('orders.store_id',$request->get('store_id'))
            ->where('users.status',1)
            ->select('users.*')
            ->groupBy('users.id')
            ->orderBy('users.name')
            ->get();

        return response()->json($drivers);
    }
}
