<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Customer;

class CustomersController extends Controller
{
    public function list(){
        $q = request('q');
        $data = Customer::whereRaw($q ? '(full_name like "%'.$q.'%" or dni like "%'.$q.'%" or phone like "%'.$q.'%")' : 1)
                    ->where('deleted_at', NULL)->where('id', '>', 1)->get();
        return response()->json($data);
    }
}
