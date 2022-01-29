<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Registrado por</th>
                    <th>Fecha de venta</th>
                    <th>Total</th>
                    <th>Deuda</th>
                    <th>Estado</th>
                    <th>Observaciones</th>
                    <th>Creada el</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            <b>{{ $item->customer ? $item->customer->full_name : 'Sin nombre' }}</b> <br>
                            <small>NIT/CI: {{ $item->customer ? $item->customer->dni ?? 'No definido' : 'No definido' }}</small> <br>  
                            <small>Cel: {{ $item->customer ? $item->customer->phone ?? 'No definido' : 'No definido' }}</small>
                            @if ($item->status == 'pendiente')
                                @if (count($item->payment_schedules))
                                    <small>
                                        <br>
                                        @php
                                            $date = $item->payment_schedules->last('date')->date;
                                        @endphp
                                        Próximo pago 
                                        <b class="@if(date('Y-m-d', strtotime($date)) <= date('Y-m-d')) text-danger @endif">
                                            {{ strftime('%d/%b/%Y', strtotime($date)) }}
                                        </b>
                                    </small>
                                @endif
                            @endif
                        </td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ strftime('%d/%b/%Y', strtotime($item->date)) }}</td>
                        <td>{{ number_format($item->total - $item->discount, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->total - $item->discount - $item->payments->sum('amount'), 2, ',', '.') }}</td>
                        <td>
                            @if ($item->status == 'pendiente')
                                <span class="label label-success">{{ $item->status }}</span>
                            @elseif ($item->status == 'pagada')
                                <span class="label label-primary">{{ $item->status }}</span>
                            @elseif ($item->status == 'anulada')
                                <span class="label label-danger">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td>{{ $item->observations ?? 'Ninguna' }}</td>
                        <td>{{ strftime('%d/%b/%Y %H:%M', strtotime($item->created_at)) }}<br><small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></td>
                        <td>
                            <div class="no-sort no-click bread-actions text-right">
                                @if (!$item->deleted_at && $item->status == 'pendiente')
                                    <button type="button" data-toggle="modal" data-target="#payment-modal" data-item='@json($item)' title="Pagar" class="btn btn-sm btn-dark payment">
                                        <i class="voyager-dollar"></i> <span class="hidden-xs hidden-sm">Pagar</span>
                                    </button>
                                @endif
                                <a href="#" data-toggle="modal" data-target="#show-modal" data-item='@json($item)' title="Ver" class="btn btn-sm btn-warning view">
                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                </a>
                                @if (!$item->deleted_at)
                                    <button type="button" onclick="deleteItem({{ $item->id }})" data-toggle="modal" data-target="#delete-modal" title="Eliminar" class="btn btn-sm btn-danger edit">
                                        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="odd">
                        <td valign="top" colspan="10" class="text-center">No hay datos disponibles en la tabla</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4" style="overflow-x:auto">
        @if(count($data)>0)
            <p class="text-muted">Mostrando del {{$data->firstItem()}} al {{$data->lastItem()}} de {{$data->total()}} registros.</p>
        @endif
    </div>
    <div class="col-md-8" style="overflow-x:auto">
        <nav class="text-right">
            {{ $data->links() }}
        </nav>
    </div>
</div>

<style>
    .payment{
        border: 1px;
        padding: 5px 10px !important;
    }
</style>

<script>
    $(document).ready(function(){
        $('.view').click(function(){
            $('#table-details tbody').empty();
            $('#table-details-payments tbody').empty();
            let item = $(this).data('item');
            $('#label-customer').text(item.customer ? item.customer.full_name : 'Sin nombre');
            $('#label-user').text(item.user.name);
            $('#label-date').text(moment(item.date).format('DD [de] MMMM [de] YYYY'));
            $('#label-total').text(`${item.total - item.discount} Bs.`);
            $('#label-created_at').text(`${moment(item.created_at).format('DD/MMMM/YYYY h:mm:ss a')}`);
            $('#label-observations').text(item.observations ? item.observations : 'Ninguna');

            let status = 'default';
            switch (item.status) {
                case 'pendiente': status = 'success'; break;
                case 'pagada': status = 'primary'; break;
                case 'anulada': status = 'danger'; break;
            }
            $('#label-status').html(`<label class="label label-${status}">${item.status}</label>`);

            item.details.map((detail, index) => {
                let image = "{{ asset('images/default.jpg') }}";
                if(detail.product.images){
                    let images = JSON.parse(detail.product.images);
                    image = "{{ asset('storage') }}/"+images[0].replace('.', '-cropped.');
                }
                $('#table-details tbody').append(`
                    <tr>
                        <td style="width: 50px">${index+1}</td>
                        <td>
                            <div style="display: flex">
                                <div style="margin: 0px 10px">
                                    <img src="${image}" class="img-responsive" style="width: 50px; height: 50px;">
                                </div>
                                <div>
                                    <h5 style="margin: 0px">${detail.product.name} <br> <small style="font-size: 12px">${detail.product.category.name}</small> <br> <small>${detail.product.brand.name}</small></h5>
                                </div>
                            </div>
                        </td>
                        <td>${detail.quantity}</td>
                        <td>${detail.price}</td>
                        <td class="text-right"><b>${detail.quantity * detail.price} Bs.</b></td>
                    </tr>
                `);
            });

            let total_payment = 0;
            item.payments.map((payment, index) => {
                $('#table-details-payments tbody').append(`
                    <tr>
                        <td style="width: 50px">${index+1}</td>
                        <td>${payment.user.name}</td>
                        <td>${moment(payment.created_at).format('DD/MMMM/YYYY h:mm:ss a')}</td>
                        <td>${payment.observations ? payment.observations : ''}</td>
                        <td class="text-right"><b>${payment.amount} Bs.</b></td>
                    </tr>
                `);
                total_payment += parseFloat(payment.amount);
            });

            $('#label-total-payment').text(`${total_payment.toFixed(2)} Bs.`);
            $('#label-debt').text(`${(item.total - total_payment).toFixed(2)} Bs.`);

            if(item.payments.length == 0) {
                $('#table-details-payments tbody').append(`
                    <tr>
                        <td colspan="5"><h5 class="text-center">Ningún pago</h5></td>
                    </tr>
                `);
            }

        });

        $('.payment').click(function(){
            let item = $(this).data('item');
            let total_payment = 0;
            item.payments.map(payment => {
                total_payment += parseFloat(payment.amount);
            });
            $('#form-payment input[name="page"]').val("{{ $page }}");
            $('#form-payment input[name="sale_id"]').val(item.id);
            $('#form-payment input[name="amount"]').val(item.total - total_payment);
            $('#form-payment input[name="amount"]').attr('max', item.total - total_payment);
        });

        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                list(page);
            }
        });
    });
</script>