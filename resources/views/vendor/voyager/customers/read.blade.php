@extends('voyager::master')

@section('page_title', 'Ver Cliente')

@php
    $url = $_SERVER['REQUEST_URI'];
    $url_array = explode('/', $url);
    $id = $url_array[count($url_array)-1];
    $customer = \App\Models\Customer::find($id);
    // dd($customer->sales);
@endphp

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-people"></i> Viendo Cliente
        <a href="{{ route('voyager.customers.index') }}" class="btn btn-warning" style="margin-left: 10px">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            Volver a la lista
        </a>
        <a href="#" class="btn btn-danger" style="margin-left: 5px">
            <span class="glyphicon glyphicon-print"></span>&nbsp;
            Imprimir
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Nombre completo</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $customer->full_name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">NIT/CI</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $customer->dni ?? 'No definido' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Teléfono/celular</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $customer->phone ?? 'No definido' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Estado</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $customer->status ?? 'No definido' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-12">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Dirección</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $customer->address ?? 'No definida' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>N&deg;</th>
                                                <th>Detalles</th>
                                                <th>Creada el</th>
                                                <th>Productos</th>
                                                <th>Pagos</th>
                                                <th class="text-right">Subtotal</th>
                                                <th class="text-right">Descuento</th>
                                                <th class="text-right">Total</th>
                                                <th class="text-right">Deuda</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 1;
                                                $total = 0;
                                                $debt = 0;
                                            @endphp
                                            @forelse ($customer->sales->sortByDesc('date') as $sale)
                                                @php
                                                    $subtotal = $sale->total - $sale->discount;
                                                    $total += $subtotal;
                                                    $debt += $subtotal - $sale->payments->sum('amount');
                                                @endphp
                                                <tr>
                                                    <td>{{ $cont }}</td>
                                                    <td> 
                                                        {{ strftime('%d/%B/%Y', strtotime($sale->date)) }} <br>
                                                        @if ($sale->status == 'pendiente')
                                                            <span class="label label-success">{{ $sale->status }}</span>
                                                        @elseif ($sale->status == 'pagada')
                                                            <span class="label label-primary">{{ $sale->status }}</span>
                                                        @elseif ($sale->status == 'anulada')
                                                            <span class="label label-danger">{{ $sale->status }}</span>
                                                        @endif
                                                        <br>
                                                        {!! $sale->observations ? '<small><b>Observaciones: </b></small>'. $sale->observations : '' !!}
                                                    </td>
                                                    <td>{{ strftime('%d/%b/%Y %H:%M', strtotime($sale->created_at)) }}<br><small>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</small></td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($sale->details as $detail)
                                                                <li>{{ intval($detail->quantity) }} {{ $detail->product->name }} <b><small>Bs.</small> {{ number_format($detail->quantity * $detail->price, 2, ',', '.') }}</b></li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @forelse ($sale->payments as $payment)
                                                                <li>
                                                                    <b><small>Bs. </small> {{ $payment->amount }}</b> <small>Registrado por {{ $payment->user->name }}</small> <br>
                                                                    <small>{{ strftime('%d/%b/%Y %H:%M', strtotime($payment->created_at)) }}</small>
                                                                </li>
                                                            @empty
                                                                <li><i>Ninguno pago</i></li>
                                                            @endforelse
                                                        </ul>
                                                    </td>
                                                    <td class="text-right">{{ number_format($sale->total, 2, ',', '.') }}</td>
                                                    <td class="text-right">{{ number_format($sale->discount, 2, ',', '.') }}</td>
                                                    <td class="text-right"><b>{{ number_format($subtotal, 2, ',', '.') }}</b></td>
                                                    <td class="text-right"><b>{{ number_format($subtotal - $sale->payments->sum('amount'), 2, ',', '.') }}</b></td>
                                                </tr>
                                                @php
                                                    $cont++;
                                                @endphp
                                            @empty
                                                <tr>
                                                    <td colspan="9"><h5 class="text-center">Ningún registro</h5></td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7"><b>TOTAL</b></td>
                                                <td class="text-right"><b style="font-size: 16px"><small>Bs.</small> {{ number_format($total, 2, ',', '.') }}</b></td>
                                                <td class="text-right"><b style="font-size: 16px"><small>Bs.</small> {{ number_format($debt, 2, ',', '.') }}</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Monto total de ventas</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p><b style="font-size: 20px"><small>Bs.</small> {{ number_format($total, 2, ',', '.') }}</b></p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Monto total de deuda</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p><b style="font-size: 20px"><small>Bs.</small> {{ number_format($debt, 2, ',', '.') }}</b></p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@stop

@section('javascript')
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(document).ready(function () {
            // $('#dataTable').DataTable({language});
        });
    </script>
@stop
