@extends('voyager::master')

@section('page_title', 'Importar Datos')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-down-circled"></i>
        Importar Datos
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <form action="{{ route('imports.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="type">Tipo</label>
                                    <select name="type" class="form-control select2" required>
                                        <option value="">Seleccione tipo de datos</option>
                                        <option value="products">Productos</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="file">Archivo</label>
                                    <input type="file" name="file">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-primary">Importar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $(document).ready(function(){

        });
    </script>
@stop
