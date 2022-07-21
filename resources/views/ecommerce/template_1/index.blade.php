@extends('ecommerce.'.setting('ecommerce.template').'.layouts.master')

@section('seo')
	@php
		$admin_favicon = Voyager::setting('site.logo', '');
		$image = $admin_favicon == '' ? asset('images/icon.png') : Voyager::image($admin_favicon);
	@endphp

	<meta property="og:url"           content="{{url('')}}" />
	<meta property="og:type"          content="E-Commerce" />
	<meta property="og:title"         content="{{ setting('site.title') }}" />
	<meta property="og:description"   content="{{ setting('site.description') }}" />
	<meta property="og:image"         content="{{ $image }}" />
	<meta name="keywords" content="ecommerce, e-commerce, ideacreativa, idea, creativa, ventas, {{ setting('site.title') }}">
@endsection

@section('content')
    <!-- ========================= SECTION INTRO ========================= -->
    <section class="section-intro bg-secondary text-white text-center" style="background-image:url('{{ Voyager::image( Voyager::setting("admin.bg_image"), asset("images/banner.jpg") ) }}'); background-size: cover; background-repeat: no-repeat; background-position: center">
        <div class="dark-mask">
        <div class="container d-flex flex-column"  style="min-height:85vh;">

        <div class="row mt-auto">
            <div class="col-lg-8 col-sm-12 text-center mx-auto">
                <h1 class="display-4 mb-3 mt-5">{{ setting('site.title') }}</h1>
                <p class="lead mb-5">{{ setting('site.description') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12 mx-auto text-center">
                <form class="form-noborder">
                    <div class="form-row mb-5">
                        <div class="col-md-8 offset-md-2 form-group">
                            {{-- <input class="form-control form-control-lg" placeholder="Search keyword" type="text"> --}}
                            <select class="custom-select form-control-lg" id="select-main-search" name="category_name"></select>
                        </div>
                        {{-- <div class="col-lg-4 col-sm-12 form-group">
                            <select class="custom-select form-control-lg">
                                <option value=""> Todas las categorías </option>
                                @forelse (App\Models\ProductsCategory::where('deleted_at', NULL)->orderBy('name')->get() as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- <div class="col-lg-3 col-sm-12 form-group">
                            <button class="btn btn-info btn-block btn-lg" type="submit"><i class="fa fa-search"></i> Buscar</button>
                        </div> --}}
                    </div>
                </form>
                <p class="small">Puedes seguirnos en todas nuestras redes sociales</p>
                <ul class="list-inline my-5">
                    <li class="list-inline-item">
                        <a class="h4 text-light p-2" href="{{ setting('social.facebook') }}" title="Facebook" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="h4 text-light p-2" href="{{ setting('social.instagram') }}" title="Instagram" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="h4 text-light p-2" href="{{ setting('social.whatsapp-group') }}" title="Grupo de Whatsapp" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="h4 text-light p-2" href="{{ setting('social.youtube') }}" title="Canal de youtube" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                </ul>
            </div> <!-- col.// -->
        </div> <!-- row.// -->

        </div>
    </section>
    <!-- ========================= SECTION INTRO END// ========================= -->


    <section class="section-content padding-bottom">
        <div class="container">
            <header class="clearfix">
                <div class="title-text">
                    <span class="h4">Populares</span>
                    <div class="btn-group btn-group-sm float-right">
                        <button type="button" class="custom-nav-first owl-custom-prev btn btn-secondary"> < </button>
                        <button type="button" class="custom-nav-first owl-custom-next btn btn-secondary"> > </button>
                    </div>
                </div>
            </header>
            <div class="owl-carousel owl-init slide-items" id="slide_custom_nav" data-custom-nav="custom-nav-first" data-items="5" data-margin="20" data-dots="true" data-nav="false" data-autoplay="true" data-delay="2000">
                @php
                    $products = \App\Models\Product::with(['rating', 'sales_details'])
                                    ->withCount('sales_details')
                                    ->orderBy('sales_details_count', 'desc')
                                    ->where('deleted_at', NULL)->limit(20)->get();
                    // dd($products);
                @endphp
                @foreach ($products as $item)
                    @php
                        $image = 'images/default.jpg';
                        if($item->images){
                            $image = 'storage/'.str_replace('.', '-cropped.', json_decode($item->images)[0]);
                        }
                    @endphp
                    <div class="item-slide">
                        <figure class="card card-product">
                            {{-- <span class="badge-new"> NEW </span> --}}
                            <a href="{{ url('details/'.$item->slug) }}">
                                <div class="img-wrap"> <img src="{{ asset($image) }}" alt="{{ $item->name }}" title="{{ $item->name }}"> </div>
                            </a>
                            <figcaption class="info-wrap">
                                <div style="height: 1.5em;overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    <a href="{{ url('details/'.$item->slug) }}" class="title" title="{{ $item->name }}">{{ $item->name }}</a>
                                </div>
                                <div class="action-wrap">
                                    <a href="https://wa.me/{{ setting('social.whatsapp') ?? '59175199157' }}?text={{ url('details/'.$item->slug) }} Vi%20esto%20en%20tu%20sitio%20web" target="_blank" class="btn btn-success btn-sm float-right"> <i class="fab fa-whatsapp"></i> Whastapp </a>
                                    <div class="price-wrap h5">
                                        <span class="price-new"><small>Bs.</small> {{ $item->price }}</span>
                                        {{-- <del class="price-old">$1980</del> --}}
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="mb-5" style="margin-top: 80px !important">
            <div class="card-banner" style="height:300px; background-image: url('https://cdn.pixabay.com/photo/2017/03/13/17/26/ecommerce-2140603_960_720.jpg');">
                <article class="overlay overlay-cover d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <h5 class="card-title">Únete a nuestro grupo de Whatsapp</h5>
                    <p>Para estar al día sobre las novedades que traemos puedes unirte a nuestro grupo de wharsapp</p>
                    <a href="{{ setting('social.whatsapp-group') }}" class="btn btn-success btn-sm"> <i class="fa fa-whatsapp"></i> Unirse ahora </a>
                </div>
                </article>
            </div>
        </div>

        <div class="container">
            <div class="scroll-x">
                <a href="#" class="btn btn-light category-filter active" data-id="">Todos</a>
                @foreach (App\Models\ProductsCategory::where('deleted_at', NULL)->whereHas('products', function($q){$q->where('deleted_at', NULL);})->limit(20)->get() as $item)
                    <a href="#" class="btn btn-light category-filter mt-1" data-id="{{ $item->id }}">{{ $item->name }}</a>
                @endforeach
            </div>

            <div id="loader-filter" class="col-md-12 my-auto text-center" style="height: 300px; padding-top: 100px">
                <img src="{{ asset('images/loading.gif') }}" alt="empty" width="120px">
            </div>
            <div class="clearfix"></div>
            <div class="mt-5" id="list-products"></div>
        </div>

    </section>
    <!-- ========================= SECTION CONTENT END// ========================= -->
@endsection

@section('css')
    <style>

    </style>
@endsection

@section('scripts')
	<script>
		var categoryFilter = '';

		$(document).ready(function(){

			list();

			$('.category-filter').click(function(e){
				e.preventDefault();
                $('.category-filter').removeClass('active');
                $(this).addClass('active');
				categoryFilter = $(this).data('id');
				list();
			});
		});

		function list(page = 1){
			$('#list-products').empty();
			$('#loader-filter').fadeIn('fast');
			minFilter = $('#input-min').val();
			maxFilter = $('#input-max').val();
			$.get(`/list/products/filter?page=${page}&category=${categoryFilter}`, function(data){
				$('#loader-filter').fadeOut('fast', function(){
					$('#list-products').html(data);
				});
			});
		}
	</script>
@endsection