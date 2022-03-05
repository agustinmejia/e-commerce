<div class="col-md-12 text-right">
    @if (count($data))
        {{-- <button type="button" onclick="report_export('excel')" class="btn btn-success"><i class="glyphicon glyphicon-cloud-download"></i> Excel</button> --}}
        {{-- <button type="button" onclick="report_export('print')" class="btn btn-danger btn-print"><i class="glyphicon glyphicon-print"></i> Imprimir</button> --}}
    @endif
</div>
<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Atendido por</th>
                    <th>Detalles</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1;
                    $total = 0;
                @endphp
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $cont }}</td>
                        <td>{{ $item->customer->full_name }}</td>
                        <td>{{ strftime('%d/%b/%Y', strtotime($item->date)) }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>
                            @php
                                $details = '';
                                foreach($item->details as $detail){
                                    $details .= number_format($detail->quantity, 0, '', '').' '.$detail->product->name. ' a <small>Bs.</small> ' . $detail->price . '<br>';
                                }
                            @endphp
                            <small>{!! $details !!}</small>
                        </td>
                        <td class="text-right"><b>{{ number_format($item->total - $item->discount, 2, ',', '.') }}</b></td>
                    </tr>
                    @php
                        $cont++;
                        $total += $item->total - $item->discount;
                    @endphp
                @empty
                    <tr>
                        <td colspan="6"><h4 class="text-center">No hya resultados</h4></td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="5" class="text-right"><h4>TOTAL</h4></td>
                    <td class="text-right"><h4><small>Bs.</small> {{ number_format($total, 2, ',', '.') }}</h4></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    th{
        text-align: center;
    }
    @print{
        .btn-print{
            display: none;
        }
    }
</style>

<script>
    $(document).ready(function(){

    })
</script>