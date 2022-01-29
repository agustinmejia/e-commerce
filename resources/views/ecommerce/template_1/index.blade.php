@extends('ecommerce.template_1.layouts.master')

@section('page_title', 'Bienvenido | '.setting('admin.title'))

@section('seo')
	@php
		$admin_favicon = Voyager::setting('admin.icon_image', '');
		$image = $admin_favicon == '' ? asset('images/icon.png') : Voyager::image($admin_favicon);
	@endphp

	<meta property="og:url"           content="{{url('')}}" />
	<meta property="og:type"          content="E-Commerce" />
	<meta property="og:title"         content="{{ setting('admin.title') }}" />
	<meta property="og:description"   content="{{ setting('admin.description') }}" />
	<meta property="og:image"         content="{{ $image }}" />
	<meta name="keywords" content="ecommerce, e-commerce, ideacreativa, idea, creativa, ventas, {{ setting('admin.title') }}">
@endsection

@section('content')
	<!-- ========================= SECTION PAGETOP ========================= -->
	<section class="section-pagetop bg-secondary">
		<div class="container clearfix">
			<h2 class="title-page">Bienvenido a {{ setting('admin.title') }}</h2>

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
				<aside class="col-sm-3">
					<div class="card card-filter">
						<article class="card-group-item">
							<header class="card-header">
								<a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse22">
									<i class="icon-action fa fa-chevron-down"></i>
									<h6 class="title">Por Categoría</h6>
								</a>
							</header>
							<div style="" class="filter-content collapse show" id="collapse22">
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
								</div> <!-- card-body.// -->
							</div> <!-- collapse .// -->
						</article> <!-- card-group-item.// -->
						<article class="card-group-item">
							<header class="card-header">
								<a href="#" data-toggle="collapse" data-target="#collapse44">
									<i class="icon-action fa fa-chevron-down"></i>
									<h6 class="title">Por Marca </h6>
								</a>
							</header>
							<div class="filter-content collapse show" id="collapse44">
								<div class="card-body" style="max-height: 300px;overflow-y: auto">
								<form>
									@forelse (App\Models\ProductsBrand::with(['products'])->where('deleted_at', NULL)->get() as $item)
									<label class="form-check">
										<input class="form-check-input brand-filter" value="{{ $item->id }}" type="checkbox">
										<span class="form-check-label">
											<span class="float-right badge badge-secondary round">{{ $item->products->count() }}</span>
											{{ $item->name }}
										</span>
									</label>
									@empty
									@endforelse
								</form>
								</div> <!-- card-body.// -->
							</div> <!-- collapse .// -->
						</article> <!-- card-group-item.// -->
						<article class="card-group-item">
							<header class="card-header">
								<a href="#" data-toggle="collapse" data-target="#collapse33">
									<i class="icon-action fa fa-chevron-down"></i>
									<h6 class="title">Por Precio </h6>
								</a>
							</header>
							<div class="filter-content collapse show" id="collapse33">
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
									</div> <!-- form-row.// -->
									<button class="btn btn-block btn-outline-primary btn-filter"><i class="fa fa-filter"></i> Filtrar</button>
								</div> <!-- card-body.// -->
							</div> <!-- collapse .// -->
						</article> <!-- card-group-item.// -->
					</div> <!-- card.// -->
				</aside> <!-- col.// -->

				<div id="loader-filter" class="col-sm-9  my-auto text-center" style="height: 300px">
					<img src="{{ asset('images/loading.gif') }}" alt="empty" width="120px">
				</div>

				<main class="col-sm-9" id="list-products">

				</main> <!-- col.// -->
			</div>
		</div>
	</section>
	<!-- ========================= SECTION CONTENT END// ========================= -->

	<!-- ========================= SECTION  ========================= -->
	<section class="section-name bg-white padding-y">
		<div class="container">
			<h4>Another section if needed</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div><!-- container // -->
	</section>
	<!-- ========================= SECTION  END// ========================= -->
@endsection

@section('css')
	<style>
		#loader-filter{
			display: none
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
			list();

			$('.category-filter').click(function(e){
				e.preventDefault();
				categoryFilter = $(this).data('id');
				list();
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
			});

			$('.btn-filter').click(function(){
				list();
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
	</script>
@endsection