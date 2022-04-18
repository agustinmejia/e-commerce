@extends('layouts.print.master-portrait', ['title' => 'Recibo de Pago'])

@section('content')

    <br><br><br>
    <div class="content">
        <table width="100%" cellspacing="1" cellpadding="2">
            <tr>
                <td width="180px">NOMBRE/RAZÓN SOCIAL :</td>
                <td><b>{{ $sale->customer->full_name }}</b></td>
                @php
                    $months = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                @endphp
                <td align="right">NIT/CI : </td>
                <td><b>{{ $sale->customer->dni }}</b></td>
            </tr>
            <tr>
                <td>LUGAR :</td>
                <td colspan="3"><b>Santísima Trinidad, {{ date('d', strtotime($sale->date)) }} de {{ $months[intval(date('m', strtotime($sale->date)))] }} de {{ date('Y', strtotime($sale->date)) }}</b></td>
            </tr>
        </table>

        <br><br><br>
    
        <table width="100%" cellspacing="0" cellpadding="5" border="1">
            <thead style="background-color: {{ env('APP_COLOR') }}; color: white">
                <tr>
                    <th style="width: 50px">Nº</th>
                    <th>DESCRIPCIÓN</th>
                    <th style="width: 100px">CANT.</th>
                    <th style="width: 100px">PRECIO UNIT.</th>
                    <th style="width: 100px">IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 0;
                @endphp
                @foreach ($sale->details as $item)
                @php
                    $cont++;
                @endphp
                <tr>
                    <td>{{ $cont }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td style="text-align: right">{{ intval($item->quantity) }}</td>
                    <td style="text-align: right">{{ $item->price }}</td>
                    <td style="text-align: right">{{ number_format(($item->price * $item->quantity), 2, '.', ',') }}</td>
                </tr>
                @endforeach
                @for ($i = $cont; $i < 20; $i++)
                <tr>
                    <td>{{ $i +1 }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" rowspan="3">
                        <p>
                            @php
                                $formatter = new \Luecano\NumeroALetras\NumeroALetras();
                            @endphp
                            SON: <b>{{ $formatter->toInvoice($sale->total - $sale->discount, 2, 'BOLIVIANOS') }}</b> <br>
                            {{-- CÓDIGO DE CONTROL : <b>{{ $sale->bill->control_code }}</b> <br> --}}
                            {{-- FECHA LÍMITE: <b>{{ date('d/m/Y', strtotime($sale->bill->dosage->limit_date)) }}</b> --}}
                        </p>
                    </td>
                    <td colspan="2">SUBTOTAL</td>
                    <td style="text-align: right; background-color: rgb(209, 209, 209)"><b>{{ $sale->total }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">DESCUENTO</td>
                    <td style="text-align: right; background-color: rgb(209, 209, 209)"><b>{{ $sale->discount }}</b></td>
                </tr>
                <tr>
                    <td colspan="2">TOTAL</td>
                    <td style="text-align: right; background-color: rgb(209, 209, 209)"><b>{{ number_format($sale->total - $sale->discount, 2, ',', '.') }}</b></td>
                </tr>
                {{-- <tr>
                    <td colspan="2">IVA</td>
                    <td style="text-align: right"><b>{{ $sale->bill->fiscal_debit }}</b></td>
                </tr> --}}
            </tfoot>
        </table>
    </div>

@endsection

@section('css')
    <style>
        table, th, td {
            border-collapse: collapse;
            font-size: 13px
        }
    </style>
@endsection