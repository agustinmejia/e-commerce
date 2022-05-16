<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>COD</th>
                    <th>Detalles</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Ubicación</th>
                    <th>Creada el</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        @php
                                            $image = $small_image = asset('images/default.jpg');
                                            if($item->images){
                                                $images = json_decode($item->images);
                                                $image = asset('storage/'.$images[0]);
                                                $small_image = asset('storage/'.str_replace('.', '-cropped.', $images[0]));
                                            }
                                        @endphp
                                        <a href="{{ $image }}" data-fancybox=""><img src="{{ $small_image }}" alt="{{ $item->name }}" style="width: 70px; padding: 0px 10px"></a>
                                    </td>
                                    <td>
                                        <h5>{{ $item->name }} <br> <small style="font-size: 15px">{{ $item->category->name }} - {{ $item->brand->name }}</small> </h5>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td> <small>Bs.</small> {{ $item->wholesale_price ? $item->wholesale_price.' - ' : '' }} {{ $item->price }}</td>
                        <td>
                            @if ($item->stock > 0)
                                {{ $item->stock }}
                            @else
                                <label class="label label-danger">Agotado</label>
                            @endif
                        </td>
                        <td>{{ $item->location }}</td>
                        <td>{{ strftime('%d/%b/%Y %H:%M', strtotime($item->created_at)) }}<br><small>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></td>
                        <td>
                            <div class="no-sort no-click bread-actions text-right">
                                <div class="btn-group" style="margin-right: 5px">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        Más <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="btn-barcode" data-item='@json($item)' data-toggle="modal" data-target="#barcode-modal">código de barras</a></li>
                                        {{-- <li class="divider"></li> --}}
                                    </ul>
                                </div>
                                <a href="{{ route('voyager.products.show', ['id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                </a>
                                <a href="{{ route('voyager.products.edit', ['id' => $item->id]) }}" title="Editar" class="btn btn-sm btn-info edit">
                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                </a>
                                <button type="button" onclick="deleteItem({{ $item->id }})" data-toggle="modal" data-target="#delete-modal" title="Eliminar" class="btn btn-sm btn-danger delete">
                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                </button>
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

{{-- Barcode modal --}}
<div class="modal modal-primary fade" tabindex="-1" id="barcode-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="voyager-tag"></i> Códigos de barra</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="code">Código de barras</label>
                    <input type="text" id="input-barcode" class="form-control">
                    <small>Escanee el código de barras o escribalo y presione <b>Enter</b>.</small>
                </div>
                <div class="form-group">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>N&deg;</th>
                                <th>Código</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="table-barcodes"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    
</style>

<script>
    $(document).ready(function(){

        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                list(page);
            }
        });

        $('.btn-barcode').click(function(){
            $('#table-barcodes').empty();
            let item = $(this).data('item');
            if(item.barcodes){
                let barcodes = JSON.parse(item.barcodes);
                if(barcodes.length > 0){
                    barcodes.map((code, index) => {
                        $('#table-barcodes').append(`
                            <tr>
                                <td>${index +1}</td>
                                <td>${code}</td>
                                <td class="text-right"><i class="voyager-trash text-danger"></i></td>
                            </tr>
                        `);
                    });
                }else{
                    barcodes.map((code, index) => {
                        $('#table-barcodes').html(`<tr><td colspan="3">No hay resultados</td></tr>`);
                    });
                }
                
            }
        });
    });
</script>