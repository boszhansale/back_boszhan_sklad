<?php

namespace App\Livewire\Admin;

use App\Models\Box;
use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithPagination;

class BoxIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $warehouseId;
    public $number;

    public function render()
    {
        $data = [
            'warehouses' => Warehouse::orderBy('name')->get(),
            'boxes' => Box::query()
                ->when($this->warehouseId, function ($query) {
                    return $query->where('warehouse_id',$this->warehouseId);
                })
                ->when($this->number, function ($query) {
                    return $query->where('number','LIKE',$this->number.'%');
                })
                ->with(['products','warehouse'])
                ->orderBy('id','desc')
                ->paginate(50),
        ];
        return view('admin.box.index_live', $data);

    }

}
