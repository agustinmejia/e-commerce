<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\Customer;

class CustomersController extends Controller
{
    public function list(){
        $q = request('q');
        $data = Customer::with(['sales' => function($query){
                        $query->where('status', '=', 'Pendiente');
                    }])
                    ->whereRaw($q ? '(full_name like "%'.$q.'%" or dni like "%'.$q.'%" or phone like "%'.$q.'%")' : 1)
                    ->where('deleted_at', NULL)->where('id', '>', 1)->get();
        return response()->json($data);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $customer = Customer::create($request->all());
            DB::commit();
            return response()->json(['customer' => $customer]);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
