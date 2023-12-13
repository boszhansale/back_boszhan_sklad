<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BoxController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CollectingController;
use App\Http\Controllers\Api\ComingController;
use App\Http\Controllers\Api\CounteragentController;
use App\Http\Controllers\Api\CouplingController;
use App\Http\Controllers\Api\FormulaController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\MovingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReceiptController;
use App\Http\Controllers\Api\RefundController;
use App\Http\Controllers\Api\RefundProducerController;
use App\Http\Controllers\Api\RejectController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\StorageController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\WarehouseUserDateController;
use App\Http\Controllers\Api\WebkassaController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('brand',[BrandController::class,'index']);
Route::get('category',[CategoryController::class,'index']);
Route::get('product',[ProductController::class,'index']);
Route::get('material',[MaterialController::class,'index']);


Route::prefix('auth')->group(function (){
    Route::post('login',[AuthController::class,'login']);
    Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('user')->group(function (){
        Route::get('/',[UserController::class,'index']);
        Route::get('profile',[UserController::class,'profile']);
        Route::post('update',[UserController::class,'update']);
    });
    Route::prefix('formula')->group(function (){
        Route::get('/',[FormulaController::class,'index']);
    });

    Route::prefix('coupling')->group(function (){
        Route::get('/',[CouplingController::class,'index']);
        Route::post('/',[CouplingController::class,'store']);
    });

    Route::prefix('store')->group(function (){
        Route::get('/',[StoreController::class,'index']);
        Route::get('drivers',[StoreController::class,'drivers']);
    });

    Route::prefix('counteragent')->group(function (){
        Route::get('/',[CounteragentController::class,'index']);
    });
    //Продажа
    Route::prefix('order')->group(function (){
        Route::get('/',[OrderController::class,'index']);
        Route::get('show/{id}',[OrderController::class,'orderShow']);
        Route::get('all',[OrderController::class,'all']);
        Route::get('all-by-store',[OrderController::class,'allByStore']);
        Route::get('history',[OrderController::class,'history']);
    });
    Route::prefix('refund')->group(function (){
        Route::get('/',[RefundController::class,'index']);
        Route::get('all',[RefundController::class,'all']);
        Route::get('history',[RefundController::class,'history']);
    });
    Route::prefix('warehouse')->group(function (){
        Route::get('/',[WarehouseController::class,'index']);
        Route::get('users',[WarehouseController::class,'users']);

        Route::prefix('user-date')->group(function (){
            Route::get('/',[WarehouseUserDateController::class,'index']);
            Route::post('start',[WarehouseUserDateController::class,'start']);
            Route::post('end',[WarehouseUserDateController::class,'end']);
        });
    });
    Route::prefix('box')->group(function (){
        Route::get('show',[BoxController::class,'show'])->withoutMiddleware('auth:sanctum');
    });

    //Перемещения товара
    Route::prefix('moving')->group(function (){

        Route::get('from',[MovingController::class,'from']);
        Route::get('to',[MovingController::class,'to']);

        Route::post('/',[MovingController::class,'store']);
        Route::post('general',[MovingController::class,'general']);
        Route::post('by-store',[MovingController::class,'byStory']);

        Route::post('accept',[MovingController::class,'accept']);
        Route::post('reject',[MovingController::class,'reject']);

    });
    //поступление
    Route::prefix('coming')->group(function (){
        Route::get('/',[ComingController::class,'index']);
        Route::post('/',[ComingController::class,'store']);
    });
    //Списание
    Route::prefix('reject')->group(function (){
        Route::get('/',[RejectController::class,'index']);
        Route::get('history',[RejectController::class,'history']);
        Route::post('/',[RejectController::class,'store']);
        Route::delete('{reject}',[RejectController::class,'delete']);
    });

    Route::prefix('report')->group(function (){
        Route::get('remains',[ReportController::class,'remains']);
    });

    //Поступление товара
    Route::prefix('receipt')->group(function (){
        Route::get('/',[ReceiptController::class,'index']);
        Route::get('history',[ReceiptController::class,'history']);
        Route::post('/',[ReceiptController::class,'store']);
        Route::post('update/{receipt}',[ReceiptController::class,'update']);
        Route::delete('{receipt}',[ReceiptController::class,'delete']);
    });

});
