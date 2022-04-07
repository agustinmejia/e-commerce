<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Product;

class ProductsControllers extends Controller
{
    public function list(){
        $search = request('q');
        $data = Product::with(['category', 'brand'])
                    ->whereRaw($search ? '(id = '.intval($search).' or name like "%'.$search.'%" or location like "%'.$search.'%")' : 1)
                    ->orWhere(function($query) use ($search){
                        if($search){
                            $query->OrwhereHas('category', function($query) use($search){
                                $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                            })
                            ->OrwhereHas('brand', function($query) use($search){
                                $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                            });
                        }
                    })->get();
        return response()->json($data);
    }
}
