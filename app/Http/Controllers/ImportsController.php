<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

// Imporst
use App\Imports\ProductsImport;

class ImportsController extends Controller
{
    public function index(){
        return view('imports.edit-add');
    }

    public function store(Request $request){
        Excel::import(new ProductsImport($request->type), request()->file('file'));
        return redirect()->route('imports.index')->with(['message' => 'Importación completa.', 'alert-type' => 'success']);
    }
}
