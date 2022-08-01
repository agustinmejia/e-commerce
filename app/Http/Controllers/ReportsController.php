<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
                }])->whereRaw($query)->where('proforma', '<>', 1)->where('deleted_at', NULL)->get();
        if($request->type_show == 'pdf'){
            // return view('reports.sales-list-pdf', compact('data'));
            $pdf = PDF::loadView('reports.sales-list-pdf', ['data' => $data])->setPaper('letter', 'landscape');
            return $pdf->stream();
        }else{
            return view('reports.sales-list', compact('data'));
        }
        
    }
}
