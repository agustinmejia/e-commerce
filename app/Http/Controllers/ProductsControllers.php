<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Product;

class ProductsControllers extends Controller
{
    public function list(){
        $q = request('q');
        $data = Product::with(['category', 'brand'])->whereRaw($q ? 'name like "%'.$q.'%"' : 1)->get();
        return response()->json($data);
    }
}
