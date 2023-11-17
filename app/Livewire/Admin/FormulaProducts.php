<?php

namespace App\Livewire\Admin;

use App\Models\Box;
use App\Models\FormulaProduct;
use App\Models\Formula;
use App\Models\Product;
use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithPagination;

class FormulaProducts extends Component
{

    public $formulaId;
    public $products;

    public $productId;
    public $count;

    public function render()
    {
        return view('admin.formula.products',[
            'formulaProducts' => FormulaProduct::where('formula_id',$this->formulaId)->with('product')->get()
        ]);
    }
    public function mount($formulaId){
        $this->formulaId = $formulaId;

        $this->products = Product::query()
            ->orderBy('products.name')
            ->get();
    }
    public function plus($id)
    {
        FormulaProduct::where('id',$id)->increment('count');
    }
    public function minus($id)
    {
        if (FormulaProduct::where('id',$id)->where('count','>',1)->exists()){
            FormulaProduct::where('id',$id)->decrement('count');
        }
    }
    public function delete($id)
    {
        FormulaProduct::where('id',$id)->delete();
    }
    public function add()
    {
        if (FormulaProduct::where('formula_id',$this->formulaId)->where('product_id',$this->productId)->exists()){
            FormulaProduct::where('formula_id',$this->formulaId)->where('product_id',$this->productId)->increment('count',$this->count);
        }else{
            FormulaProduct::create([
                'count' => $this->count,
                'product_id' => $this->productId,
                'formula_id' => $this->formulaId,
            ]);
        }

    }

}
