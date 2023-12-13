<?php

namespace App\Livewire\Admin;

use App\Models\Box;
use App\Models\Moving;
use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithPagination;

class MovingIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $warehouseId;
    public $number;

    public function render()
    {
        $data = [
            'warehouses' => Warehouse::orderBy('name')->get(),
            'movings' => Moving::query()
                ->with(['products'])
                ->orderBy('id','desc')
                ->paginate(50),
        ];
        return view('admin.moving.index_live', $data);

    }

}
