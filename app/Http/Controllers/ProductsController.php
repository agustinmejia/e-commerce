<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Product;

class ProductsController extends Controller
{

    public function index(){
        return view('products.browse');
    }

    public function list(){
        $paginate = request('paginate');
        $search = request('q');
        $data = Product::with(['category', 'brand', 'purchases_details' => function($q){
                        $q->orderBy('id', 'DESC');
                    }])
                    ->whereRaw($search ? '(id = '.intval($search).' or name like "%'.$search.'%" or location like "%'.$search.'%" or barcodes like "%'.$search.'%")' : 1)
                    ->orWhere(function($query) use ($search){
                        if($search){
                            $query->OrwhereHas('category', function($query) use($search){
                                $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                            })
                            ->OrwhereHas('brand', function($query) use($search){
                                $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                            });
                        }
                    });
        
        // Si hay parámetro de paginación, se usa el método paginate, si no, se usa el método get
        if($paginate){
            $data = $data->orderBy('id', 'DESC')->paginate($paginate);
            return view('products.list', compact('data'));
        }else{
            return response()->json($data->get());
        }
    }
}
