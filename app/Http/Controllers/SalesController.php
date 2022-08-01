<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

// Models
use App\Models\Sale;
use App\Models\SalesDetail;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesPayment;
use App\Models\PaymentSchedule;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.browse');
    }

    public function list()
    {
        $paginate = request('paginate') ?? 10;
        $page = request('page') ?? 1;
        $search = request('search');
        $status = request('status');
        $data = Sale::with(['user', 'customer', 'details.product.brand', 'details.product.category', 'payments.user', 'payment_schedules' => function($query){
                        $query->where('status', '=', 'pendiente');
                    }])
                    ->where(function($q) use ($search){
                        if($search){
                            $q->orWhereHas('customer', function($query) use ($search) {
                                $query->whereRaw('full_name like "%'.$search.'%"');
                            })
                            ->orWhereHas('user', function($query) use ($search) {
                                $query->whereRaw('name like "%'.$search.'%"');
                            })
                            ->orWhereRaw('id like "%'.$search.'%"')
                            ->orWhereRaw('DATE_FORMAT(date,"%d/%m/%Y") like "%'.$search.'%"')
                            ->orWhereRaw('DATE_FORMAT(created_at,"%d/%m/%Y") like "%'.$search.'%"');
                        }
                    })
                    ->whereRaw($status ? "status = '$status'" : 1)
                    ->withTrashed()->orderBy('id', 'DESC')->paginate($paginate);
        return view('sales.list', compact('data', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.edit-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->product_id){
            return redirect()->route('sales.create')->with(['message' => 'Detalle de ventas vacío.', 'alert-type' => 'warning']);
        }

        // dd($request->all());
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'user_id' => Auth::user()->id,
                'date' => $request->date,
                'customer_id' => $request->customer_id ?? 1,
                'observations'  => $request->observations,
                'proforma' => $request->proforma ? 1 : 0,
            ]);

            Customer::where('id', $request->customer_id)->update(['dni' => $request->dni]);

            $total = 0;
            for ($i=0; $i < count($request->product_id); $i++) { 
                SalesDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->price[$i]
                ]);
                
                $total += $request->quantity[$i] * $request->price[$i];
                
                // Si no es proforma se descuenta del stock
                if (!$request->proforma) {
                    $product = Product::findOrFail($request->product_id[$i]);
                    $product->stock -= $request->quantity[$i];
                    $product->update();
                }
            }
            Sale::where('id', $sale->id)->update([
                'total' => $total,
                'status' => $request->proforma ? 'proforma' : ($total == $request->amount ? 'pagada' : 'pendiente')
            ]);

            // En caso de realizar pago
            if($request->amount && !$request->proforma){
                SalesPayment::create([
                    'sale_id' => $sale->id,
                    'user_id' => Auth::user()->id,
                    'amount' => $request->amount,
                    'observations' => 'Pago al momento de la venta'
                ]);
            }

            // En caso de definir fecha de próximo pago
            if($request->next_payment){
                PaymentSchedule::create([
                    'sale_id' => $sale->id,
                    'user_id' => Auth::user()->id,
                    'date' => $request->next_payment,
                    'observations' => 'Fecha definida al momento de la venta',
                    'status' => 'Pendiente'
                ]);
            }

            DB::commit();

            return redirect()->route('sales.create')->with(['message' => 'Venta registrada correctamente.', 'alert-type' => 'success', 'sale_id' => $sale->id]);
        
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            return redirect()->route('sales.create')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($id);
            $sale->status = 'anulada';
            $sale->update();
            $sale->delete();

            SalesPayment::where('sale_id', $id)->delete();

            foreach($sale->details as $detail){
                
                // Si no es una proforma se renueva el stock
                if (!$sale->proforma) {
                    $product = Product::findOrFail($detail->product_id);
                    $product->stock += $detail->quantity;
                    $product->update();
                }

                // Delete sale detail
                $sale_detail = SalesDetail::findOrFail($detail->id);
                $sale_detail->delete();
            }

            DB::commit();

            return redirect()->route('sales.index')->with(['message' => 'Venta eliminada correctamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
            return redirect()->route('sales.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }


    // Payments

    public function payments_store(Request $request){
        DB::beginTransaction();
        try {

            SalesPayment::create([
                'sale_id' => $request->sale_id,
                'user_id' => Auth::user()->id,
                'amount' => $request->amount
            ]);

            $sale = Sale::find($request->sale_id);
            $payments = $sale->payments->sum('amount');
            if($payments >= $sale->total){
                $sale->status = 'pagada';
                $sale->update();
            }

            $last_payment = PaymentSchedule::where('sale_id', $request->sale_id)->orderBy('id', 'DESC')->first();
            if($last_payment){
                $last_payment->updated_at = Carbon::now();
                $last_payment->status = 'pagada';
                $last_payment->update();
            }

            // En caso de definir fecha de próximo pago
            if($request->next_payment){
                PaymentSchedule::create([
                    'sale_id' => $sale->id,
                    'user_id' => Auth::user()->id,
                    'date' => $request->next_payment,
                    'observations' => $request->observations,
                    'status' => 'Pendiente'
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')->with(['message' => 'Pago registrado correctamente.', 'alert-type' => 'success', 'page' => $request->page]);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->route('sales.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error', 'page' => $request->page]);
        }
    }

    // Recipes
    
    public function print($id){
        $sale = Sale::findOrFail($id);
        // return view('sales.print.recipe', compact('sale'));
        $pdf = PDF::loadView('sales.print.recipe', ['sale' => $sale]);
        return $pdf->stream();
    }
}
