@extends('voyager::master')

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h3>Hola, {{ Auth::user()->name }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @php
            $sales = App\Models\Sale::with('payments')->where('deleted_at', null)->get();
            $sales_today = App\Models\Sale::where('deleted_at', null)->whereDate('date', date('Y-m-d'))->get();
            $total_debt = $sales->sum('total') - $sales->sum('discount');
            foreach ($sales as $item) {
                $total_debt -= $item->payments->sum('amount');
            }
            $products = App\Models\Product::where('deleted_at', null)->where('status', 'disponible')->get();
        @endphp
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-bordered" style="border-left: 5px solid #52BE80">
                    <div class="panel-body" style="height: 100px;padding: 15px 20px">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Ventas del día</h5>
                                <h2><small>Bs.</small>{{ number_format($sales_today->sum('total') - $sales_today->sum('discount'), 2, ',', '.') }}</h2>
                            </div>
                            <div class="col-md-4 text-right">
                                <i class="icon voyager-dollar" style="color: #52BE80"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-bordered" style="border-left: 5px solid #3498DB">
                    <div class="panel-body" style="height: 100px;padding: 15px 20px">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Clientes con deuda</h5>
                                <h2>{{ $sales->where('status', 'pendiente')->count() }}</h2>
                            </div>
                            <div class="col-md-4 text-right">
                                <i class="icon voyager-people" style="color: #3498DB"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-bordered" style="border-left: 5px solid #E74C3C">
                    <div class="panel-body" style="height: 100px;padding: 15px 20px">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Deuda total</h5>
                                <h2><small>Bs.</small>{{ number_format($total_debt, 2, ',', '.') }}</h2>
                            </div>
                            <div class="col-md-4 text-right">
                                <i class="icon voyager-book" style="color: #E74C3C"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-bordered" style="border-left: 5px solid #E67E22">
                    <div class="panel-body" style="height: 100px;padding: 15px 20px">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Producto en escasez</h5>
                                <h2>{{ $products->where('stock', '<', 10)->count() }}</h2>
                            </div>
                            <div class="col-md-4 text-right">
                                <i class="icon voyager-archive" style="color: #E67E22"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body" style="height: 250px">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body" style="height: 250px">
                        <canvas id="bar-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body" style="height: 250px">
                        <canvas id="doughnut-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@php
    $sales = App\Models\Sale::where('deleted_at', null)->groupBy('date')
                ->selectRaw('COUNT(id) as count,SUM(total) as total, SUM(discount) as discount, date')
                ->whereDate('date', '>', date('Y-m-d', strtotime(date('Y-m-d').' -7 days')))->orderBy('date', 'ASC')->get();
    $payments = App\Models\SalesPayment::where('deleted_at', null)->groupByRaw('DATE(created_at)')
                    ->selectRaw('COUNT(id) as count,SUM(amount) as total, DATE(created_at) as date')
                    ->whereDate('created_at', '>', date('Y-m-d', strtotime(date('Y-m-d').' -7 days')))->orderBy('date', 'ASC')->get();
    $products = App\Models\SalesDetail::with('product')->where('deleted_at', null)
                    ->selectRaw('COUNT(id) as count,SUM(quantity) as total, product_id')
                    ->groupBy('product_id')->orderBy('total', 'DESC')->limit(5)->get();
@endphp

@section('css')
    <style>
        .icon{
            font-size: 50px
        }
    </style>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            let sales = @json($sales);
            let labels = [];
            let values = [];

            sales.map(sale => {
                labels.push(moment(sale.date).format('dd'));
                values.push(sale.total - sale.discount);
            });

            var data = {
                labels,
                datasets: [{
                    label: 'Ventas del día',
                    data: values,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    hoverOffset: 4
                }]
            };
            var config = {
                type: 'line',
                data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                },
            };
            var myChart = new Chart(
                document.getElementById('line-chart'),
                config
            );

            // ==============================================
            let payments = @json($payments);
            labels = [];
            values = [];

            payments.map(payment => {
                labels.push(moment(payment.date).format('dd'));
                values.push(payment.total);
            });

            var data = {
                labels,
                datasets: [{
                    label: 'Pagos del día',
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(39, 174, 96, 1)',
                        'rgba(155, 89, 182, 1)',
                        'rgba(235, 152, 78, 1)',
                        'rgba(52, 73, 94, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(39, 174, 96, 1)',
                        'rgba(155, 89, 182, 1)',
                        'rgba(235, 152, 78, 1)',
                        'rgba(52, 73, 94, 1)'
                    ],
                }]
            };
            var config = {
                type: 'bar',
                data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                },
            };
            var myChart = new Chart(
                document.getElementById('bar-chart'),
                config
            );

            // ==============================================
            let products = @json($products);
            labels = [];
            values = [];

            products.map(item => {
                labels.push(item.product.name);
                values.push(parseInt(item.total));
            });

            var data = {
                labels,
                datasets: [{
                    label: 'Productos más vendidos',
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(39, 174, 96, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(235, 152, 78, 1)',
                    ],
                    hoverOffset: 4
                }]
            };
            var config = {
                type: 'doughnut',
                data
            };
            var myChart = new Chart(
                document.getElementById('doughnut-chart'),
                config
            );
        });
    </script>
@stop
