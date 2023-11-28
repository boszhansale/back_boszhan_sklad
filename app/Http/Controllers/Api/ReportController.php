<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function remains()
    {
        $products = Product::query()
            ->join('user_products','user_products.product_id','products.id')
            ->where('user_products.user_id',Auth::id())
            ->select(['products.name','products.article','user_products.count'])
            ->get();

        return response()->json($products);
    }
}
