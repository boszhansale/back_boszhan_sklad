<?php

namespace App\Http\Controllers\Api;

use App\Actions\ReceiptStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthLoginRequest;
use App\Http\Requests\Api\OrderCheckRequest;
use App\Http\Requests\Api\ReceiptIndexRequest;
use App\Http\Requests\Api\ReceiptStoreRequest;
use App\Http\Requests\Api\ReceiptUpdateRequest;
use App\Http\Requests\Api\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Receipt;
use App\Models\ReceiptProduct;
use App\Models\PriceType;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Поступление товара
class ReceiptController extends Controller
{
    public function index(ReceiptIndexRequest $request)
    {
        $receipts = Receipt::query()
            ->where('receipts.warehouse_id',Auth::user()->warehouse_id)
            ->when($request->has('date_from'),function ($q){
                $q->whereDate('created_at','>=',request('date_from'));
            })
            ->when($request->has('date_to'),function ($q){
                $q->whereDate('created_at','<=',request('date_to'));
            })
            ->with(['products','products.product','store'])
            ->latest()
            ->get();
        return response()->json($receipts);
    }

    public function history(ReceiptIndexRequest $request)
    {
        $receipts = Receipt::query()
            ->where('receipts.warehouse_id',Auth::user()->warehouse_id)
            ->when($request->has('date_from'),function ($q){
                $q->whereDate('created_at','>=',request('date_from'));
            })
            ->when($request->has('date_to'),function ($q){
                $q->whereDate('created_at','<=',request('date_to'));
            })
            ->with(['products','products.product','store'])
            ->latest()
            ->get();
        return response()->json($receipts);
    }

    public function store(ReceiptStoreRequest $request)
    {
        $data['warehouse_id'] = Auth::user()->warehouse_id;
        try {

            $receipt = Auth::user()->receipts()->create(array_merge($request->validated(),$data));
            if (isset($data['products']))
            {
                foreach ($data['products'] as $item) {
                    $product = Product::find($item['product_id']);
                    if (!$product) continue;
                    if (!isset($item['price'])){
                        $receiptProduct = ReceiptProduct::query()->join('receipts','receipts.id','receipt_products.receipt_id')
                            ->where('receipts.user_id',Auth::id())
                            ->where('receipt_products.product_id',$item['product_id'])
                            ->select('receipt_products.*')
                            ->latest()
                            ->first();
                        if ($receiptProduct){
                            $item['price'] = $receiptProduct->price;
                        }else{
                            $priceType = $product->prices()->where('price_type_id',5)->first();
                            if (!$priceType) throw new Exception("price not found");
                            $item['price'] = $priceType->price;
                        }
                    }else{
                        if ($data['nds'] == 1){
                            $item['price'] = $item['price'] -  (($item['price'] / 112) * 12);
                        }
                    }
                    $receiptProduct = ReceiptProduct::query()->join('receipts','receipts.id','receipt_products.receipt_id')
                        ->where('receipts.user_id',Auth::id())
                        ->where('receipt_products.product_id',$item['product_id'])
                        ->select('receipt_products.*')
                        ->latest()
                        ->first();
                    if ($receiptProduct){
                        $item['old_price'] = $receiptProduct->price;
                    }
                    $item['all_price'] = $item['count'] * $item['price'];
                    $receipt->products()->updateOrCreate(['product_id' => $product->id,'receipt_id' => $receipt->id ],$item);
                }
                $receipt->update(['product_history' => $receipt->products()->select('product_id','count','price','all_price','comment')->get()->toArray(), 'total_price' => $receipt->products()->sum('all_price')]);
            }else{
                throw new Exception("products not found");
            }


            return response()->json($receipt);


        }catch (\Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage()],400);
        }
    }

    public function update(ReceiptUpdateRequest $request,Receipt $receipt)
    {

        try {

            foreach ($request->get('products') as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                $item['all_price'] = $item['count'] * $item['price'];
                $receipt->products()->updateOrCreate(['product_id' => $product->id,'receipt_id' => $receipt->id ],$item);
            }
            $receipt->update(['product_history' => $receipt->products()->select('product_id','count','price','all_price','comment')->get()->toArray(), 'total_price' => $receipt->products()->sum('all_price')]);

        }catch (\Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage()],400);
        }

    }

    public function delete(Receipt $receipt)
    {
        $receipt->delete();
        return response()->json($receipt);
    }

}
