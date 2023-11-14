<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\Formula;
use Illuminate\Http\JsonResponse;

class FormulaController extends Controller
{

    public function index()
    {
        return response()->json(Formula::with(['product','products.product'])->get());
    }
}
