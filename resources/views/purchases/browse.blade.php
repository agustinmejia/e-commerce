@extends('voyager::master')

@section('page_title', 'Viendo Compras')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-logbook"></i> Compras
        </h1>
        <a href="{{ route('purchases.create') }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Crear</span>
        </a>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_length" id="dataTable_length">
                                        <label>Mostrar
                                            <select name="dataTable_length" id="select-pagination" class="form-control input-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            entradas
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <div class="form-inline">
                                        <label for="input-search" class="control-label">Buscar:</label>
                                        <input type="search" class="form-control input-sm" id="input-search">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="data-results"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Show modal --}}
    <div class="modal fade" tabindex="-1" id="show-modal" role="dialog">
        <div class="modal-dialog modal-warning modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Detalles de la compra</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom:0;">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Registrado por</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p id="label-user">Value</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6" style="margin-bottom:0;">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha de venta</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p id="label-date">Value</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6" style="margin-bottom:0;">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Total</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p id="label-total">Value</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6" style="margin-bottom:0;">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Creado el</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p id="label-created_at">Value</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-12">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Observaciones</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p id="label-observations">Value</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-12">
                            <table id="table-details" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">Detalles de compra</th>
                                    </tr>
                                    <tr>
                                        <th>N&deg;</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Desea eliminar el siguiente registro?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Sí, eliminar">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script>
        const URL = "{{ url('admin/purchases/list/ajax') }}";
        var pagination = 10;
        $(document).ready(function() {
            list();

            $('#input-search').on('keyup', function(e) {
                if (e.keyCode == 13) {
                    list(1);
                }
            });

            $('#select-pagination').change(function(){
                pagination = $(this).val();
                list();
            });
        });

        function list(page = 1){
            let search = $('#input-search').val();
            $.get(`${URL}?pagination=${pagination}&page=${page}&search=${search}`, function(res){
                $('#data-results').html(res);
            });
        }

        function deleteItem(id){
            let url = '{{ url("admin/purchases") }}/'+id;
            $('#delete_form').attr('action', url);
        }

    </script>
@stop
