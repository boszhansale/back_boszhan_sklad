<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{

    public function index()
    {
        return response(Warehouse::with('boxes')->get());
    }

    public function users()
    {

        $users = User::query()
            ->join('warehouses','users.warehouse_id','warehouses.id')
            ->where('warehouses.user_id',Auth::id())
            ->orderBy('users.name')
            ->select('users.*')
            ->get();

        return response()->json($users);

    }
}
