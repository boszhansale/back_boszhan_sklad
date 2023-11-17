<?php

namespace App\Livewire\Admin;

use App\Models\Box;
use App\Models\Formula;
use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithPagination;

class FormulaIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = [
            'formulas' => Formula::query()
                ->with(['product'])
                ->orderBy('id','desc')
                ->paginate(50),
        ];
        return view('admin.formula.index_live', $data);

    }

}
