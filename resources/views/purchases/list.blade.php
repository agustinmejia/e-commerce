<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Registrado por</th>
                    <th>Fecha de venta</th>
                    <th>Total</th>
                    <th>Proveedor</th>
                    <th>Observaciones</th>
                    <th>Creada el</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ strftime('%d/%b/%Y', strtotime($item->date)) }}</td>
                        <td>{{ number_format($item->total, 2, ',', '.') }}</td>
                        <td>{{ $item->supplier ? $item->supplier->full_name : 'Ninguno' }}</td>
                        <td>{{ $item->observations }}</td>
                        <td>{{ strftime('%d/%b/%Y %H:%M', strtotime($item->created_at)) }}<br><small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></td>
                        <td>
                            <div class="no-sort no-click bread-actions text-right">
                                <a href="#" data-toggle="modal" data-target="#show-modal" data-item='@json($item)' title="Ver" class="btn btn-sm btn-warning view">
                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                </a>
                                {{-- <a href="#" title="Editar" class="btn btn-sm btn-info edit">
                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                </a> --}}
                                <button type="button" onclick="deleteItem({{ $item->id }})" data-toggle="modal" data-target="#delete-modal" title="Eliminar" class="btn btn-sm btn-danger edit">
                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="odd">
                        <td valign="top" colspan="8" class="text-center">No hay datos disponibles en la tabla</td>
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

<script>
    $(document).ready(function(){
        $('.view').click(function(){
            $('#table-details tbody').empty();
            let item = $(this).data('item');
            $('#label-user').text(item.user.name);
            $('#label-date').text(moment(item.date).format('DD [de] MMMM [de] YYYY'));
            $('#label-total').text(item.total);
            $('#label-created_at').text(`${moment(item.created_at).format('DD/MMMM/YYYY h:mm:ss a')}`);
            $('#label-observations').text(item.observations ? item.observations : '');
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