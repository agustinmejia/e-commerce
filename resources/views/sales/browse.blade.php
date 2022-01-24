@extends('voyager::master')

@section('page_title', 'Viendo Ventas')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-basket"></i> Ventas
        </h1>
        <a href="{{ route('sales.create') }}" class="btn btn-success btn-add-new">
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
                    <h4 class="modal-title"><i class="voyager-trash"></i> Detalles de la venta</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6" style="margin-bottom:0;">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Cliente</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p id="label-customer">Value</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
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
                        <div class="col-md-6" style="margin-bottom:0;">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Estado</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p id="label-status">Value</p>
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
                                        <th colspan="5" class="text-center">Detalles de venta</th>
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
                        <div class="col-md-12">
                            <table id="table-details-payments" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">Detalles de pagos</th>
                                    </tr>
                                    <tr>
                                        <th>N&deg;</th>
                                        <th>Registrado por</th>
                                        <th>Fecha</th>
                                        <th>Observaciones</th>
                                        <th class="text-right">Monto</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><b>PAGO TOTAL</b></td>
                                        <td class="text-right"><b style="font-size: 18px" id="label-total-payment">0,00 Bs.</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right"><b>DEUDA TOTAL</b></td>
                                        <td class="text-right"><b style="font-size: 18px" id="label-debt">0,00 Bs.</b></td>
                                    </tr>
                                </tfoot>
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

    {{-- Single payment modal --}}
    <form action="{{ route('sales.payments.store') }}" id="form-payment" method="POST">
        @csrf
        <input type="hidden" name="sale_id">
        <input type="hidden" name="page">
        <div class="modal modal-primary fade" tabindex="-1" id="payment-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-dollar"></i> Agregar pago</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount">Monto</label>
                            <input type="number" class="form-control" name="amount" min="1" step="0.1" placeholder="Monto" required>
                        </div>
                        <div class="form-group">
                            <label for="observations">Observaciones</label>
                            <textarea class="form-control" name="observations" placeholder="Observaciones"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-dark delete-confirm" value="Pagar">
                    </div>
                </div>
            </div>
        </div>
    </form>

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
        const URL = "{{ url('admin/sales/list/ajax') }}";
        var pagination = 10;
        $(document).ready(function() {
            let page = "{{ session('page') ?? 1 }}";
            list(page);

            $('#input-search').on('keyup', function(e) {
                if (e.keyCode == 13) {
                    list(1);
                }
            });
        });

        function list(page = 1){
            let search = $('#input-search').val();
            $.get(`${URL}?pagination=${pagination}&page=${page}&search=${search}`, function(res){
                $('#data-results').html(res);
            });
        }

        function deleteItem(id){
            let url = '{{ url("admin/sales") }}/'+id;
            $('#delete_form').attr('action', url);
        }

    </script>
@stop
