@extends('voyager::master')

@section('page_title', 'Reporte de ventas')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bar-chart"></i> Reporte de ventas
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form id="form-report" name="form_report" action="{{ route('reports.sales.list') }}" method="post">
                            @csrf
                            <input type="hidden" name="type_show">
                            <div class="col-md-12" style="margin-bottom: 10px">
                                <label class="radio-inline"><input type="radio" name="type" class="radio-option" value="day" checked>Diario</label>
                                <label class="radio-inline"><input type="radio" name="type" class="radio-option" value="month">Mensual</label>
                                <label class="radio-inline"><input type="radio" name="type" class="radio-option" value="range">Rango de fecha</label>
                            </div>
                            <div class="col-md-12 form-inline div-option" id="div-day">
                                <input type="date" class="form-control" name="day" value="{{ date('Y-m-d') }}">
                                <button type="submit" class="btn btn-primary">Generar</button>
                            </div>
                            <div class="col-md-12 form-inline div-option hide" id="div-month">
                                <select name="month" id="select-month" class="form-control">
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                                <input type="number" class="form-control" name="year" min="2020" max="{{ date('Y') }}" value="{{ date('Y') }}" >
                                <button type="submit" class="btn btn-primary">Generar</button>
                            </div>
                            <div class="col-md-12 form-inline div-option hide" id="div-range">
                                <input type="date" class="form-control" name="start">
                                <input type="date" class="form-control" name="finish">
                                <button type="submit" class="btn btn-primary">Generar</button>
                            </div>
                        </form>

                        <div class="clearfix"></div>

                        <div id="loader-filter"></div>
                        <div id="data-results" style="margin-top: 20px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
	<style>
		
	</style>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#select-month').val({{ date('m') }});
            // Mostrar/ocultar opciones de reporte
            $('.radio-option').click(function(){
                $('.div-option').addClass('hide');
                $('#div-'+$(this).val()).removeClass('hide');
            });

            // Generar reporte
            $('#form-report').submit(function(e){
                $('#data-results').empty();
			    $('#loader-filter').fadeIn('fast');
                e.preventDefault();
                $.post($(this).attr('action'), $(this).serialize(), function(res){
                    $('#loader-filter').fadeOut('fast', function(){
                        $('#data-results').html(res);
                    });
                });
            });
        });


        function report_export(type_show){
            $('#form-report').attr('target', '_blank');
            $('#form-report input[name="type_show"]').val(type_show);
            window.form_report.submit();
            $('#form-report').removeAttr('target');
            $('#form-report input[name="type_show"]').val('');
        }
    </script>
@stop
