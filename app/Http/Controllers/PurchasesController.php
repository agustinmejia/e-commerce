<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

// Models
use App\Models\Purchase;
use App\Models\PurchasesDetail;
use App\Models\Product;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchases.browse');
    }

    public function list()
    {
        $paginate = request('paginate') ?? 10;
        $search = request('search');
        $data = Purchase::with(['user', 'details.product.brand', 'details.product.category'])
                    ->orWhereHas('user', function($query) use ($search) {
                        $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                    })
                    ->orWhereRaw($search ? 'DATE_FORMAT(date,"%d/%m/%Y") like "%'.$search.'%"' : 1)
                    ->orWhereRaw($search ? 'DATE_FORMAT(created_at,"%d/%m/%Y") like "%'.$search.'%"' : 1)
                    ->orderBy('id', 'DESC')->paginate($paginate);
        return view('purchases.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchases.edit-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
                'user_id' => Auth::user()->id,
                'date' => $request->date,
                'observations'  => $request->observations
            ]);

            $total = 0;
            for ($i=0; $i < count($request->product_id); $i++) { 
                PurchasesDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->price[$i]
                ]);
                
                $total += $request->quantity[$i] * $request->price[$i];
                
                $product = Product::findOrFail($request->product_id[$i]);
                $product->stock += $request->quantity[$i];
                $product->update();
            }
            Purchase::where('id', $purchase->id)->update(['total' => $total]);

            DB::commit();

            return redirect()->route('purchases.index')->with(['message' => 'Compra registrada correctamente.', 'alert-type' => 'success']);
        
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            return redirect()->route('purchases.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
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
            // Verificar que la cantidad de productos de la compra sea menor al stock actual para restar el stock 
            $purchase = Purchase::findOrFail($id);
            foreach($purchase->details as $detail){
                $product = Product::findOrFail($detail->product_id);
                if($product->stock < $detail->quantity){
                    return redirect()->route('purchases.index')->with(['message' => 'No puedes eliminar la compra.', 'alert-type' => 'error']);
                }
            }

            // Delete purchase
            $purchase->delete();

            foreach($purchase->details as $detail){
                $product = Product::findOrFail($detail->product_id);
                $product->stock -= $detail->quantity;
                $product->update();

                // Delete purchase detail
                $purchase_detail = PurchasesDetail::findOrFail($detail->id);
                $purchase_detail->delete();
            }

            DB::commit();

            return redirect()->route('purchases.index')->with(['message' => 'Compra eliminada correctamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return redirect()->route('purchases.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
}
