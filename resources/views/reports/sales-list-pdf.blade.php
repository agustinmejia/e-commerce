@extends('layouts.print.master-portrait', ['title' => 'Reporte de ventas'])

@section('content')
    <table border="1" width="100%" style="margin-top: 20px" cellpadding="5">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Cliente</th>
                <th>Atendido por</th>
                <th>Detalles</th>
                <th>Deuda</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cont = 1;
                $total = 0;
                $debt = 0;
            @endphp
            @forelse ($data as $item)
                <tr>
                    <td>{{ $cont }}</td>
                    <td>{{ $item->customer->full_name }} <br> <small>{{ strftime('%d/%b/%Y', strtotime($item->date)) }}</small> </td>
                    <td>{{ $item->user->name }}</td>
                    <td>
                        @php
                            $details = '';
                            $payments = $item->payments->sum('amount');
                            foreach($item->details as $detail){
                                $details .= number_format($detail->quantity, 0, '', '').' '.$detail->product->name. ' a <small>Bs.</small> ' . $detail->price . '<br>';
                            }
                        @endphp
                        <small>{!! $details !!}</small>
                    </td>
                    <td style="text-align: right"><b>{{ number_format($item->total - $item->discount - $payments, 2, ',', '.') }}</b></td>
                    <td style="text-align: right"><b>{{ number_format($item->total - $item->discount, 2, ',', '.') }}</b></td>
                </tr>
                @php
                    $cont++;
                    $total += $item->total - $item->discount;
                    $debt += $item->total - $item->discount - $payments;
                @endphp
            @empty
                <tr>
                    <td colspan="6"><h5 class="text-center">No hay resultados</h5></td>
                </tr>
            @endforelse
            <tr>
                <td colspan="4" style="text-align: right"><h5>TOTAL</h5></td>
                <td style="text-align: right"><b style="font-size: 16px"><small>Bs.</small> {{ number_format($debt, 2, ',', '.') }}</b></td>
                <td style="text-align: right"><b style="font-size: 16px"><small>Bs.</small> {{ number_format($total, 2, ',', '.') }}</b></td>
            </tr>
        </tbody>
    </table>
@endsection

@section('css')
    <style>
        table, th, td {
            border-collapse: collapse;
            font-size: 13px
        }
    </style>
@endsection