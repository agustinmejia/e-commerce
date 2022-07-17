@extends('ecommerce.'.setting('ecommerce.template').'.layouts.master')

@section('page_title', 'Bienvenido | '.setting('site.title'))

@section('seo')
	@php
		$admin_favicon = Voyager::setting('admin.icon_image', '');
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
	<!-- ========================= SECTION PAGETOP ========================= -->
	<section class="section-pagetop bg-secondary">
		<div class="container clearfix">
			<h2 class="title-page">Bienvenido a {{ setting('site.title') }}</h2>

			<nav class="float-left">
				<ol class="breadcrumb text-white">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
					{{-- <li class="breadcrumb-item"><a href="#">Ofertas</a></li> --}}
					{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
				</ol>  
			</nav>
		</div> <!-- container //  -->
	</section>
	<!-- ========================= SECTION INTRO END// ========================= -->

	<!-- ========================= SECTION CONTENT ========================= -->
	<section class="section-content bg padding-y">
		<div class="container">
			<div class="row">
				<aside class="col-md-12 col-lg-3">
					<div class="card card-filter">
						<article class="card-group-item">
							<header class="card-header">
								<a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse-category">
									<i class="icon-action fa fa-chevron-down"></i>
									<h6 class="title">Por Categoría</h6>
								</a>
							</header>
							<div style="" class="filter-content collapse show" id="collapse-category">
								<div class="card-body" style="max-height: 300px;overflow-y: auto">
									{{-- <form class="pb-3">
										<div class="input-group">
											<input class="form-control" placeholder="Buscar..." type="text">
											<div class="input-group-append">
												<button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</form> --}}

									<ul class="list-unstyled list-lg">
										<li><a href="#" class="category-filter" data-id="">Todas </a></li>											
										@forelse (App\Models\ProductsCategory::with(['products'])->where('deleted_at', NULL)->get() as $item)
										<li><a href="#" class="category-filter" data-id="{{ $item->id }}">{{ $item->name }} <span class="float-right badge badge-secondary round">{{ $item->products->count() }}</span> </a></li>											
										@empty
										@endforelse
									</ul>  
								</div>
							</div>
						</article>

						@php
							$products_brand = App\Models\ProductsBrand::with(['products'])->where('deleted_at', NULL)->get();
						@endphp

						@if (count($products_brand) > 1)
						<article class="card-group-item">
							<header class="card-header">
								<a href="#" data-toggle="collapse" data-target="#collapse-brands">
									<i class="icon-action fa fa-chevron-down"></i>
									<h6 class="title">Por Marca </h6>
								</a>
							</header>
							<div class="filter-content collapse show" id="collapse-brands">
								<div class="card-body" style="max-height: 300px;overflow-y: auto">
									@foreach ($products_brand as $item)
										@if ($item->products->count() > 0)
											<label class="form-check">
												<input class="form-check-input brand-filter" value="{{ $item->id }}" type="checkbox">
												<span class="form-check-label">
													<span class="float-right badge badge-secondary round">{{ $item->products->count() }}</span>
													{{ $item->name }}
												</span>
											</label>
										@endif
									@endforeach
								</div>
							</div>
						</article>
						@endif

						<article class="card-group-item">
							<header class="card-header">
								<a href="#" data-toggle="collapse" data-target="#collapse-price">
									<i class="icon-action fa fa-chevron-down"></i>
									<h6 class="title">Por Precio </h6>
								</a>
							</header>
							<div class="filter-content collapse show" id="collapse-price">
								<div class="card-body">
									{{-- <input type="range" class="custom-range" min="0" max="100" name=""> --}}
									<div class="form-row">
									<div class="form-group col-md-6">
									<label>Min</label>
									<input class="form-control" placeholder="Bs.0" type="number" min="0" id="input-min">
									</div>
									<div class="form-group text-right col-md-6">
									<label>Max</label>
									<input class="form-control" placeholder="Bs.1.000" type="number" min="1" id="input-max">
									</div>
									</div>
									<button class="btn btn-block btn-outline-primary btn-filter"><i class="fa fa-filter"></i> Filtrar</button>
								</div>
							</div>
						</article>
					</div>
					{{-- <div class="card-banner mt-3" style="height:250px; background-image: url('/ecommerce/images/posts/2.jpg');">
						<article class="overlay overlay-cover d-flex align-items-center justify-content-center">
							<div class="text-center">
								<h5 class="card-title">Proximamente nuevo stock de productos</h5>
								<a href="#" class="btn btn-warning btn-sm"> Ver más </a>
							</div>
						</article>
					</div> --}}
				</aside>

				<div id="loader-filter" class="col-md-12 col-lg-9 my-auto text-center" style="height: 300px">
					<img src="{{ asset('images/loading.gif') }}" alt="empty" width="120px">
				</div>

				<main class="col-md-12 col-lg-9" id="list-products"></main>
			</div>
		</div>
	</section>
	<!-- ========================= SECTION CONTENT END// ========================= -->

	<!-- ========================= SECTION  ========================= -->
	<section class="section-name padding-y">
		<div class="card-banner" style="height:250px; background-image: url('/ecommerce/images/banners/banner-request.jpg');">
			<article class="overlay overlay-cover d-flex align-items-center justify-content-center">
			  <div class="container">
				  <h5 class="card-title">Another section if needed</h5>
				  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.</p>
			  </div>
			</article>
		  </div>
	</section>
	<!-- ========================= SECTION  END// ========================= -->

	@if (count($products_brand) > 3)
		<section class="section-brands bg-white p-5 mt-2 mb-5">
			<div class="col-md-12">
				<h3 class="text-center mb-5">Nuestras marcas</h3>
				<div class="owl-carousel owl-init slide-items" data-items="5" data-margin="20" data-dots="true" data-nav="true">
					@foreach ($products_brand as $item)
						@if ($item->images != '')
							@php
								$image = 'storage/'.str_replace('.', '-cropped.', json_decode($item->images)[0]);
							@endphp	
							<div class="item-slide">
								<figure class="card">
									<div class="img-wrap"> <img src="{{ $image }}" alt="{{ $item->name }}"> </div>
								</figure>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</section>
	@endif
@endsection

@section('css')
	<style>
		#loader-filter{
			display: none
		}
		@media (min-width: 1024px) {

			.section-brands{
				padding: 50px 150px !important
			}
		}
	</style>
@endsection

@section('scripts')
	<script>
		var categoryFilter = '';
		var brandFilter = '';
		var minFilter = '';
		var maxFilter = '';

		$(document).ready(function(){

			// Si la pnatalla es menor a 768px colapsar los filtros
			if($(window).width()<1024){
                setTimeout(() => {
					$('#collapse-brands').collapse('toggle')
					$('#collapse-price').collapse('toggle')
					$('#collapse-category').collapse('toggle')
				}, 700);
            }

			list();

			$('.category-filter').click(function(e){
				e.preventDefault();
				categoryFilter = $(this).data('id');
				list();
				scrollToList();
			});

			$('.brand-filter').click(function(e){
				brandFilter = '';
				$('.brand-filter').each(function(){
					if($(this).is(':checked')){
						brandFilter += $(this).val() + ',';
					}
				});
				// Quitar última coma
				brandFilter = brandFilter.slice(0, -1);
				list();
				scrollToList();
			});

			$('.btn-filter').click(function(){
				list();
				scrollToList();
			});
		});

		function list(page = 1){
			$('#list-products').empty();
			$('#loader-filter').fadeIn('fast');
			minFilter = $('#input-min').val();
			maxFilter = $('#input-max').val();
			$.get(`/list/products/filter?page=${page}&category=${categoryFilter}&brands=${brandFilter}&min_price=${minFilter}&max_price=${maxFilter}`, function(data){
				$('#loader-filter').fadeOut('fast', function(){
					$('#list-products').html(data);
				});
			});
		}

		function scrollToList(){
			$('html, body').animate({scrollTop : $('#loader-filter').position().top -150}, 500);
		}
	</script>
@endsection