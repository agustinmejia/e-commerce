@extends('voyager::master')

@section('page_title', 'Añadir Venta')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-basket"></i>
        Añadir Venta
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <form action="{{ route('sales.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        <div class="panel-body" style="min-height: 465px">
                            <div class="form-group">
                                <label for="product_id">Buscar producto</label>
                                <select class="form-control" id="select-product_id"></select>
                            </div>
                            <br>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>N&deg;</th>
                                        <th>Detalles</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th class="text-right">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <tr id="tr-empty">
                                        <td colspan="6"><h4 class="text-center">Lista de venta vacía</h4></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="customer_id">Cliente</label>
                                    <select name="customer_id" id="select-customer_id" class="form-control"></select>
                                </div>
                                <div class="form-group col-md-12">
                                    {{-- <label for="dni">NIT/CI</label> --}}
                                    <input type="text" name="dni" id="input-dni" value="" class="form-control" placeholder="NIT/CI">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="number" name="amount" id="input-amount" min="0" step="0.1" class="form-control" placeholder="Monto recibo Bs.">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date">Fecha de venta</label>
                                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="next_payment">Próximo pago</label>
                                    <input type="date" name="next_payment" min="{{ date('Y-m-d') }}"  class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <textarea name="observations" class="form-control" rows="3" placeholder="Observaciones"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <h2 class="text-right"><small>Total: Bs.</small> <b id="label-total">0.00</b></h2>
                                </div>
                                <div class="form-group col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-block">Vender</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
    <style>
        .form-group{
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('javascript')
    <script>
        var productSelected, customerSelected;
        $(document).ready(function(){
            $('#select-product_id').select2({
                placeholder: '<i class="fa fa-search"></i> Buscar...',
                escapeMarkup : function(markup) {
                    return markup;
                },
                language: {
                    inputTooShort: function (data) {
                        return `Por favor ingrese ${data.minimum - data.input.length} o más caracteres`;
                    },
                    noResults: function () {
                        return `<i class="far fa-frown"></i> No hay resultados encontrados`;
                    }
                },
                quietMillis: 250,
                minimumInputLength: 2,
                ajax: {
                    url: "{{ url('admin/products/list/ajax') }}",        
                    processResults: function (data) {
                        let results = [];
                        data.map(data =>{
                            results.push({
                                ...data,
                                disabled: data.stock > 0 ? false : true
                            });
                        });
                        return {
                            results
                        };
                    },
                    cache: true
                },
                templateResult: formatResultProducts,
                templateSelection: (opt) => {
                    productSelected = opt;
                    return opt.name;
                }
            }).change(function(){
                if($('#select-product_id option:selected').val()){
                    let product = productSelected;
                    if($('.table').find(`#tr-item-${product.id}`).val() === undefined){
                        $('#table-body').append(`
                            <tr class="tr-item" id="tr-item-${product.id}">
                                <td class="td-item"></td>
                                <td>
                                    ${product.name} - ${product.category.name} <br> <small>${product.brand.name}</small>
                                    <input type="hidden" name="product_id[]" value="${product.id}" />
                                </td>
                                <td style="width: 120px">
                                    <select name="price[]" class="form-control" id="select-price-${product.id}" onchange="getSubtotal(${product.id})" required>
                                        <option value="${product.price}">${product.price}</option>
                                        ${product.wholesale_price ? `<option value="${product.wholesale_price}">${product.wholesale_price}</option>` : ''}
                                    </select>
                                </td>
                                <td style="width: 120px"><input type="number" name="quantity[]" class="form-control" id="input-quantity-${product.id}" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" value="1" min="1" step="1" max="${product.stock}" required/></td>
                                <td class="text-right"><h4 class="label-subtotal" id="label-subtotal-${product.id}">${product.price}</h4></td>
                                <td style="width: 30px" class="text-right"><button type="button" onclick="removeTr(${product.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                            </tr>
                        `);
                    }else{
                        toastr.info('EL producto ya está agregado', 'Información')
                    }
                    setNumber();
                    getSubtotal(product.id);
                    $(`#select-price-${product.id}`).select2({tags: true})
                }
            });

            $('#select-customer_id').select2({
                // tags: true,
                placeholder: '<i class="fa fa-search"></i> Buscar...',
                escapeMarkup : function(markup) {
                    return markup;
                },
                language: {
                    inputTooShort: function (data) {
                        return `Por favor ingrese ${data.minimum - data.input.length} o más caracteres`;
                    },
                    noResults: function () {
                        return `<i class="far fa-frown"></i> No hay resultados encontrados`;
                    }
                },
                quietMillis: 250,
                minimumInputLength: 2,
                ajax: {
                    url: "{{ url('admin/customers/list/ajax') }}",        
                    processResults: function (data) {
                        let results = [];
                        data.map(data =>{
                            results.push({
                                ...data,
                                disabled: false
                            });
                        });
                        return {
                            results
                        };
                    },
                    cache: true
                },
                templateResult: formatResultCustomers,
                templateSelection: (opt) => {
                    customerSelected = opt;
                    return opt.full_name;
                }
            }).change(function(){
                if(customerSelected){
                    $('#input-dni').val(customerSelected.dni ? customerSelected.dni : '');
                }
            });
        });

        function getSubtotal(id){
            let price = $(`#select-price-${id}`).val() ? parseFloat($(`#select-price-${id}`).val()) : 0;
            let quantity = $(`#input-quantity-${id}`).val() ? parseFloat($(`#input-quantity-${id}`).val()) : 0;
            $(`#label-subtotal-${id}`).text((price * quantity).toFixed(2));
            getTotal();
        }

        function getTotal(){
            let total = 0;
            $(".label-subtotal").each(function(index) {
                total += parseFloat($(this).text());
            });
            $('#label-total').text(total.toFixed(2));
            $('#input-amount').attr('max', total.toFixed(2));
        }

        function setNumber(){
            var length = 0;
            $(".td-item").each(function(index) {
                $(this).text(index +1);
                length++;
            });

            if(length > 0){
                $('#tr-empty').fadeOut('fast');
            }else{
                $('#tr-empty').fadeIn('fast');
            }
        }

        function removeTr(id){
            $(`#tr-item-${id}`).remove();
            $('#select-product_id').val("").trigger("change");
            setNumber();
            getTotal();
        }

        function formatResultProducts(option){
            // Si está cargando mostrar texto de carga
            if (option.loading) {
                return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
            }
            let image = "{{ asset('images/default.jpg') }}";
            if(option.images){
                let images = JSON.parse(option.images);
                image = "{{ asset('storage') }}/"+images[0].replace('.', '-cropped.');
            }
            // Mostrar las opciones encontradas
            return $(`  <div style="display: flex">
                            <div style="margin: 0px 10px">
                                <img src="${image}" width="60px" />
                            </div>
                            <div>
                                <b style="font-size: 16px">${option.name} - ${option.category.name}</b><br>
                                <span>${option.brand.name}</span> - 
                                ${option.price} Bs. ${option.stock > 0 ? ' | '+option.stock+' Unidades' : '<label class="label label-danger">Agotado</label>'}
                                ${option.description ? '<br>'+option.description : ''}
                            </div>
                        </div>`);
        }

        function formatResultCustomers(option){
            // Si está cargando mostrar texto de carga
            if (option.loading) {
                return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
            }
            // Mostrar las opciones encontradas
            return $(`  <div>
                            <b style="font-size: 16px">${option.full_name}</b><br>
                            <small>NIT/CI: ${option.dni ? option.dni : 'No definido'} - Cel: ${option.phone ? option.phone : 'No definido'} ${option.sales.length > 0 ? '<br><label class="label label-danger">Deuda pendiente</label>' : ''}</small>
                        </div>`);
        }
    </script>
@stop
