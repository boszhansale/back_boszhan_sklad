<?php
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BasketController;
use App\Http\Controllers\Admin\BoxController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CounteragentController;
use App\Http\Controllers\Admin\DiscountCardController;
use App\Http\Controllers\Admin\FormulaController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MovingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\RefundProducerController;
use App\Http\Controllers\Admin\RejectController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\StoreProductDiscountController;
use App\Http\Controllers\Admin\StoreProductPromotionController;
use App\Http\Controllers\Admin\UserController;
use App\Models\StoreProductDiscount;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'auth'])->name('auth');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['admin.check','auth:sanctum'])->group(function (){

    Route::get('main', [MainController::class, 'index'])->name('main');


    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::get('show/{user}', [UserController::class, 'show'])->name('show');
        Route::put('update/{user}', [UserController::class, 'update'])->name('update');
        Route::get('delete/{user}', [UserController::class, 'delete'])->name('delete');
        Route::get('position/{user}', [UserController::class, 'position'])->name('position');
    });
    Route::prefix('store')->name('store.')->group(function () {
        Route::get('/', [StoreController::class, 'index'])->name('index');
        Route::get('create', [StoreController::class, 'create'])->name('create');
        Route::post('store', [StoreController::class, 'store'])->name('store');
        Route::get('edit/{store}', [StoreController::class, 'edit'])->name('edit');
        Route::get('show/{store}', [StoreController::class, 'show'])->name('show');
        Route::put('update/{store}', [StoreController::class, 'update'])->name('update');
        Route::get('delete/{store}', [StoreController::class, 'delete'])->name('delete');
        Route::get('remove/{store}', [StoreController::class, 'remove'])->name('remove');
        Route::get('recover/{store}', [StoreController::class, 'recover'])->name('recover');
        Route::get('z-report/{store}', [StoreController::class, 'zReport'])->name('z-report');
        Route::get('z-report-show/{report}', [StoreController::class, 'zReportShow'])->name('z-report-show');
    });

    Route::prefix('box')->name('box.')->group(function () {
        Route::get('/', [BoxController::class, 'index'])->name('index');
        Route::get('create', [BoxController::class, 'create'])->name('create');
        Route::post('store', [BoxController::class, 'store'])->name('store');
        Route::get('edit/{box}', [BoxController::class, 'edit'])->name('edit');
        Route::get('show/{box}', [BoxController::class, 'show'])->name('show');
        Route::put('update/{box}', [BoxController::class, 'update'])->name('update');
        Route::get('delete/{box}', [BoxController::class, 'delete'])->name('delete');
    });

    Route::prefix('formula')->name('formula.')->group(function () {
        Route::get('/', [FormulaController::class, 'index'])->name('index');
        Route::get('create', [FormulaController::class, 'create'])->name('create');
        Route::post('store', [FormulaController::class, 'store'])->name('store');
        Route::get('edit/{formula}', [FormulaController::class, 'edit'])->name('edit');
        Route::get('show/{formula}', [FormulaController::class, 'show'])->name('show');
        Route::put('update/{formula}', [FormulaController::class, 'update'])->name('update');
        Route::get('delete/{formula}', [FormulaController::class, 'delete'])->name('delete');
    });



});


