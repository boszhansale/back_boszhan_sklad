<?php

namespace App\Livewire\Admin;

use App\Models\Box;
use App\Models\BoxProduct;
use App\Models\Product;
use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithPagination;

class BoxProducts extends Component
{

    public $boxId;
    public $products;

    public $productId;
    public $count;

    public function render()
    {
        return view('admin.box.products',[
            'boxProducts' => BoxProduct::where('box_id',$this->boxId)->with('product')->get()
        ]);
    }
    public function mount($boxId){
        $this->boxId = $boxId;

        $this->products = Product::query()
            ->orderBy('products.name')
            ->get();
    }
    public function plus($id)
    {
        BoxProduct::where('id',$id)->increment('count');
    }
    public function minus($id)
    {
       if (BoxProduct::where('id',$id)->where('count','>',1)->exists()){
           BoxProduct::where('id',$id)->decrement('count');
       }
    }
    public function delete($id)
    {
        BoxProduct::where('id',$id)->delete();
    }
    public function add()
    {
        if (BoxProduct::where('box_id',$this->boxId)->where('product_id',$this->productId)->exists()){
            BoxProduct::where('box_id',$this->boxId)->where('product_id',$this->productId)->increment('count',$this->count);
        }else{
            BoxProduct::create([
                'count' => $this->count,
                'product_id' => $this->productId,
                'box_id' => $this->boxId,
            ]);
        }

    }

}
