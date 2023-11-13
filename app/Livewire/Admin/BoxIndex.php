<?php

namespace App\Livewire\Admin;

use App\Models\Box;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class BoxIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $warehouseId;

    public function render()
    {
        return view('admin.box.index_live', [
            'warehouses' => Warehouse::orderBy('name')->get(),
            'boxes' => Box::query()
                ->when($this->warehouseId, function ($query) {
                    return $query->where('warehouse_id',$this->warehouseId);
                })
                ->orderBy('id','desc')
                ->paginate(50)
        ]);
    }

}
