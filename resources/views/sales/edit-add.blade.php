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
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_id">Buscar producto</label>
                                    <select class="form-control" id="select-product_id"></select>
                                </div>
                            </div>
                            <div class="col-md-12" style="height: 350px; max-height: 350px; overflow-y: auto">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px">N&deg;</th>
                                                <th>Detalles</th>
                                                <th style="min-width: 100px">Precio</th>
                                                <th style="min-width: 100px">Cantidad</th>
                                                <th style="min-width: 100px" class="text-right">Subtotal</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <tr id="tr-empty">
                                                <td colspan="6" style="height: 290px">
                                                    <h4 class="text-center text-muted" style="margin-top: 50px">
                                                        <i class="glyphicon glyphicon-shopping-cart" style="font-size: 50px"></i> <br><br>
                                                        Lista de venta vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="form-group col-md-12">
                                <label for="customer_id">Cliente</label>
                                <div class="input-group">
                                    <select name="customer_id" id="select-customer_id" class="form-control"></select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" title="Nuevo cliente" data-target="#modal-create-customer" data-toggle="modal" style="margin: 0px" type="button">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </button>
                                    </span>
                                </div>
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
                                <button type="submit" class="btn btn-primary btn-block">Vender <i class="voyager-basket"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Popup para imprimir el recibo --}}
    <div id="popup-button">
        <div class="col-md-12" style="padding-top: 5px">
            <h4 class="text-muted">Desea imprimir el recibo?</h4>
        </div>
        <div class="col-md-12 text-right">
            <button onclick="javascript:$('#popup-button').fadeOut('fast')" class="btn btn-default">Cerrar</button>
            <a id="btn-print" href="#" target="_blank" title="Imprimir" class="btn btn-danger">Imprimir <i class="glyphicon glyphicon-print"></i></a>
        </div>
    </div>

    {{-- Modal crear cliente --}}
    <form action="{{ url('admin/customers/store') }}" id="form-create-customer" method="POST">
        <div class="modal fade" tabindex="-1" id="modal-create-customer" role="dialog">
            <div class="modal-dialog modal-primary">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> Desea eliminar el siguiente registro?</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="type" value="normal">
                        <input type="hidden" name="status" value="activo">
                        <div class="form-group">
                            <label for="full_name">Nombre completo</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Juan Perez" required>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="full_name">NIT/CI</label>
                                <input type="text" name="dni" class="form-control" placeholder="123456789">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="full_name">Celular</label>
                                <input type="text" name="phone" class="form-control" placeholder="75199157">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="C/ 18 de nov. Nro 123 zona central"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary btn-save-customer" value="Guardar">
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .form-group{
            margin-bottom: 10px !important;
        }
        .label-description{
            cursor: pointer;
        }
        #popup-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 400px;
            height: 100px;
            background-color: white;
            box-shadow: 5px 5px 15px grey;
            z-index: 1000;

            /* Mostrar/ocultar popup */
            @if(session('sale_id'))
            animation: show-animation 1s;
            @else
            right: -500px;
            @endif
        }

        @keyframes show-animation {
            0% {
                right: -500px;
            }
            100% {
                right: 20px;
            }
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('vendor/tippy/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/tippy/tippy-bundle.umd.min.js') }}"></script>
    <script>
        var productSelected, customerSelected;
        var typeAmountReceived = "{{ setting('ventas.type_amount_received') }}"
        $(document).ready(function(){
            
            @if(session('sale_id'))
                let saleId = "{{ session('sale_id') }}";
                $('#btn-print').attr('href', `{{ url('admin/sales/print') }}/${saleId}`);
            @endif

            // Ocultar popup de impresión
            setTimeout(() => {
                $('#popup-button').fadeOut('fast');
            }, 8000);

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
                                    <b class="label-description" id="description-${product.id}">${product.name}<br> <small>${product.category.name}</small></b>
                                    <input type="hidden" name="product_id[]" value="${product.id}" />
                                </td>
                                <td>
                                    <select name="price[]" class="form-control" id="select-price-${product.id}" onchange="getSubtotal(${product.id})" required>
                                        <option value="${product.price}">${product.price}</option>
                                        ${product.wholesale_price ? `<option value="${product.wholesale_price}">${product.wholesale_price}</option>` : ''}
                                    </select>
                                </td>
                                <td><input type="number" name="quantity[]" class="form-control" id="input-quantity-${product.id}" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" value="1" min="1" step="1" max="${product.stock}" required/></td>
                                <td class="text-right"><h4 class="label-subtotal" id="label-subtotal-${product.id}">${product.price}</h4></td>
                                <td class="text-right"><button type="button" onclick="removeTr(${product.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                            </tr>
                        `);
                        // popover
                        let image = "{{ asset('images/default.jpg') }}";
                        if(product.images){
                            image = JSON.parse(product.images)[0];
                            image = "{{ asset('storage') }}/" + image.replace('.', '-cropped.');
                        }

                        let last_price = 'No definido';
                        if(product.purchases_details.length > 0){
                            last_price = product.purchases_details[0].price;
                        }

                        tippy(`#description-${product.id}`, {
                            content: `  <div style="display: flex; flex-direction: row">
                                            <div style="margin-right:10px">
                                                <img src="${image}" width="70px" alt="${product.name}" />
                                            </div>
                                            <div>
                                                <b>${product.name}</b><br>
                                                <small>categoría: <b>${product.category.name}</b></small><br>
                                                <small>Marca: <b>${product.brand.name}</b> | Precio: Bs. <b>${product.wholesale_price ? product.wholesale_price+' - ' : ''} ${product.price}</b></small><br>
                                                <small>Stock: <b>${product.stock} Unids.</b> | Ubicación: <b>${product.location ? product.location : ''}</b></small><br>
                                                <small>Último precio de compra: Bs. <b>${last_price}</b></small><br>
                                            </div>
                                        </div>`,
                            allowHTML: true,
                            maxWidth: 450,
                        });
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

            $('#form-create-customer').submit(function(e){
                e.preventDefault();
                $('.btn-save-customer').attr('disabled', true);
                $('.btn-save-customer').val('Guardando...');
                $.post($(this).attr('action'), $(this).serialize(), function(data){
                    if(data.customer.id){
                        toastr.success('Usuario creado', 'Éxito');
                        $(this).trigger('reset');
                    }else{
                        toastr.error(data.error, 'Error');
                    }
                })
                .always(function(){
                    $('.btn-save-customer').attr('disabled', false);
                    $('.btn-save-customer').text('Guardar');
                    $('#modal-create-customer').modal('hide');
                });
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
            
            // Si la opción de ingresar el monto recibido está deshabilitada se debe autocompletar el input
            if(!typeAmountReceived){
                $('#input-amount').attr('value', total.toFixed(2));
            }
        }

        function setNumber(){
            var length = 0;
            $(".td-item").each(function(index) {
                $(this).text(index +1);
                length++;
            });

            if(length > 0){
                $('#tr-empty').css('display', 'none');
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

            // Mostrar u ocultar el código en los resultados de busquedas
            let show_code = "{{ setting('productos.use_code') }}";

            // Mostrar las opciones encontradas
            return $(`  <div style="display: flex">
                            <div style="margin: 0px 10px">
                                <img src="${image}" width="60px" />
                            </div>
                            <div>
                                <b style="font-size: 16px">${show_code ? String(option.id).padStart(4, "0")+'.-' : ''} ${option.name}</b><br>
                                ${option.category.name} | ${option.brand.id > 1 ? option.brand.name+' - ' : ''} ${option.price} Bs. ${option.stock > 0 ? ' | '+option.stock+' Unidades' : '<label class="label label-danger">Agotado</label>'} ${option.location ? ' | '+option.location : ''}
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
