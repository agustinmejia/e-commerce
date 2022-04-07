<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Sale;

class ReportsController extends Controller
{
    public function sales_index(){
        return view('reports.sales-index');
    }

    public function sales_list(Request $request){
        $query = 1;
        switch ($request->type) {
            case 'day':
                $query = "DATE(created_at) = '$request->day'";
                break;
            case 'month':
                $query = "YEAR(created_at) = $request->year AND MONTH(created_at) = $request->month";
                break;
            case 'range':
                $query = "DATE(created_at) >= '$request->start' AND DATE(created_at) <= '$request->finish'";
                break;
        }
        $data = Sale::with(['user', 'details.product', 'customer', 'payments' => function($q){
                    $q->where('deleted_at', NULL);
                }])->whereRaw($query)->get();
        // dd($query);
        return view('reports.sales-list', compact('data'));
    }
}
