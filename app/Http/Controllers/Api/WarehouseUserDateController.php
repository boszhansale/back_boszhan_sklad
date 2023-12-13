<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseUserDate;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseUserDateController extends Controller
{

    public function index(Request $request)
    {
        try {
            $user = User::find($request->get('user_id'));



            if (!$user->warehouse) {
                throw new Exception('склад не найден');
            }
            if ($user->warehouse->user_id != Auth::id()){
                throw new Exception('нет доступа к складу');
            }

            $wud = WarehouseUserDate::query()
                ->where('warehouse_id',$user->warehouse->id)
                ->where('user_id',$user->id)
                ->whereNull('end_at')
                ->first();

            if ($wud){
                throw new \Exception('у пользователя сессия не закрыта');
            }

            $wud = WarehouseUserDate::create([
                'user_id' => $user->id,
                'warehouse_id' => $user->warehouse->id,
                'start_at' => now()
            ]);

            return response()->json([
                'warehouse' => $user->warehouse->id,
                'user_date' => $wud
            ]);


        }catch (\Exception $exception)
        {
            return  response()->json(['message' => $exception->getMessage()],400);
        }
    }
    public function end(Request $request)
    {
        $users = User::query()
            ->join('warehouses','users.warehouse_id','warehouses.id')
            ->where('warehouses.user_id',Auth::id())
            ->orderBy('users.name')
            ->select('users.*')
            ->get();

        $dateUsers = [];
        foreach ($users as $user) {
            $dateUsers[] = [
                'user' => $user,
                'errors' => 0 ,
                'session' => WarehouseUserDate::query()
                    ->where('warehouse_id',$user->warehouse->id)
                    ->where('user_id',$user->id)
                    ->where(function ( $query) {
                        $query->whereNull('end_at')->orWhereDate('end_at',now());
                    })
                    ->first()
            ];
        }

        return response()->json($dateUsers);

    }
    public function start(Request $request)
    {
        try {
            $user = User::find($request->get('user_id'));
            if (!$user->warehouse) {
                throw new Exception('склад не найден');
            }
            if ($user->warehouse->user_id != Auth::id()){
                throw new Exception('нет доступа к складу');
            }


            $wud = WarehouseUserDate::query()
                ->where('warehouse_id',$user->warehouse->id)
                ->where('user_id',$user->id)
                ->latest()
                ->first();

            if (!$wud){
                throw new \Exception('у пользователя сессия не открыта');
            }

            if ($wud->end_at){
                throw new \Exception('у пользователя сессия уже закрыта');
            }

            $wud->end_at = now();
            $wud->save();

            return response()->json([
                'warehouse' => $user->warehouse,
                'user_date' => $wud
            ]);


        }catch (\Exception $exception)
        {
            return  response()->json(['message' => $exception->getMessage()],400);
        }
    }
}
