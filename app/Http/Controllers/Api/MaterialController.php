<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Counteragent;
use App\Models\Material;
use Illuminate\Http\JsonResponse;

class MaterialController extends Controller
{
    public function index()
    {
        return Material::all();
    }

}
