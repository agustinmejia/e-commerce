@extends('voyager::master')

@section('page_title', 'Viendo Productos')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-archive"></i> Productos
        </h1>
        <a href="{{ route('voyager.products.create') }}" class="btn btn-success btn-add-new">
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
                            
                            <div id="loader-filter"></div>
                            <div class="row" id="data-results"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete modal --}}
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
    <link href="{{ asset('ecommerce/plugins/fancybox/fancybox.min.css') }}" type="text/css" rel="stylesheet">
@stop

@section('javascript')
    <script src="{{ url('js/main.js') }}"></script>
    <script src="{{ asset('ecommerce/plugins/fancybox/fancybox.min.js') }}" type="text/javascript"></script>
    <script>
        const URL = "{{ url('admin/products/list/ajax') }}";
        var paginate = 10;
        $(document).ready(function() {
            list();

            $('#input-search').on('keyup', function(e) {
                if (e.keyCode == 13) {
                    list(1);
                }
            });

            $('#input-barcode').on('keyup', function(e) {
                if (e.keyCode == 13) {
                    list(1);
                }
            });

            $('#select-pagination').change(function(){
                paginate = $(this).val();
                list();
            });
        });

        function list(page = 1){
            $('#loader-filter').fadeIn('fast');
            let q = $('#input-search').val();
            $.get(`${URL}?paginate=${paginate}&page=${page}&q=${q}`, function(res){
                $('#loader-filter').fadeOut('fast', function(){
                    $('#data-results').html(res);
                });
            });
        }

        function deleteItem(id){
            let url = '{{ url("admin/products") }}/'+id;
            $('#delete_form').attr('action', url);
        }

    </script>
@stop
