@extends('ecommerce.template_1.layouts.master')

@section('page_title', 'Bienvenido | '.setting('admin.title'))

@php
    $product = \App\Models\Product::with(['rating', 'sales_details'])->where('slug', $slug)->first();
    $image = 'images/default.jpg';
    $image_medium = 'images/default.jpg';
    if($product->images){
        $image = 'storage/'.json_decode($product->images)[0];
        $image_medium = 'storage/'.str_replace('.', '-social.', json_decode($product->images)[0]);
    }
@endphp

@section('seo')
	<meta property="og:url"           content="{{ url('details/'.$product->slug) }}" />
	<meta property="og:type"          content="E-Commerce" />
	<meta property="og:title"         content="{{ $product->name }}" />
	<meta property="og:description"   content="{{ $product->description }}" />
	<meta property="og:image"         content="{{ asset($image_medium) }}" />
	<meta name="keywords" content="ecommerce, e-commerce, ideacreativa, idea, creativa, ventas, {{ $product->name }}">
@endsection

@section('content')
	<!-- ========================= SECTION PAGETOP ========================= -->
	<section class="section-pagetop bg-secondary">
		<div class="container clearfix">
			<h2 class="title-page">Bienvenido a {{ setting('admin.title') }}</h2>
			<nav class="float-left">
				<ol class="breadcrumb text-white">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
					{{-- <li class="breadcrumb-item"><a href="#">Detalles</a></li> --}}
					{{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
				</ol>  
			</nav>
		</div>
	</section>
	<!-- ========================= SECTION INTRO END// ========================= -->

	<!-- ========================= SECTION CONTENT ========================= -->
	<section class="section-content bg padding-y">
		<div class="container">
			<div class="row">
				<section class="col-sm-12">
                    <div class="card">
                        <div class="row no-gutters">
                            <aside class="col-sm-5 border-right">
                                <article class="gallery-wrap"> 
                                <div class="img-big-wrap">
                                    <div> <a href="{{ asset($image) }}" data-fancybox=""><img src="{{ asset($image_medium) }}"></a></div>
                                </div>
                                <div class="img-small-wrap">
                                    @if($product->images)
                                        @foreach (json_decode($product->images) as $item)
                                            @php
                                                $image = 'storage/'.str_replace('.', '-cropped.', $item);
                                            @endphp
                                            <div class="item-gallery"> <img src="{{ url($image) }}"></div>
                                        @endforeach
                                    @endif
                                </div>
                                </article>
                                        </aside>
                                        <aside class="col-sm-7">
                                <article class="p-5">
                                    <h3 class="title mb-3">{{ $product->name }} | <small style="font-size: 18px">{{ $product->category->name }}</small></h3>

                                    <div class="mb-3"> 
                                        <var class="price h3 text-success"> 
                                            <span class="currency">Bs.</span>
                                            <span class="num">{{ $product->price }}</span>
                                        </var> 
                                        {{-- <span>/per kg</span> --}}
                                    </div>
                                    <dt>Description</dt>
                                    {!! $product->description !!}
                                    <br>
                                    <div class="rating-wrap">
                                        <ul class="rating-stars">
                                            <li style="width:0%" class="stars-active"> 
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                <i class="fa fa-star"></i> 
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                <i class="fa fa-star"></i> 
                                            </li>
                                        </ul>
                                        <div class="label-rating"> &nbsp; {{ $product->rating->count() }} reviews</div>
                                        <div class="label-rating">{{ $product->sales_details->count() }} Ventas </div>
                                    </div>
                                    {{-- <hr>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <dl class="dlist-inline">
                                                <dt>Quantity: </dt>
                                                <dd> 
                                                    <select class="form-control form-control-sm" style="width:70px;">
                                                        <option> 1 </option>
                                                        <option> 2 </option>
                                                        <option> 3 </option>
                                                    </select>
                                                </dd>
                                            </dl> 
                                        </div>
                                        <div class="col-sm-7">
                                            <dl class="dlist-inline">
                                                <dt>Size: </dt>
                                                <dd>
                                                    <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                    <span class="form-check-label">SM</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                    <span class="form-check-label">MD</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                    <span class="form-check-label">XXL</span>
                                                    </label>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div> --}}
                                    <hr>
                                    {{-- <a href="#" class="btn  btn-primary"> Buy now </a>
                                    <a href="#" class="btn  btn-outline-primary"> <i class="fas fa-shopping-cart"></i> Add to cart </a> --}}
                                    <div class="fb-like" data-href="{{ url('details/'.$product->slug) }}" data-width="" data-layout="button_count" data-action="like" data-size="large" data-share="true"></div>
                                    <a href="#" target="_blank" class="btn btn-success btn-sm" style="margin-top: -5px"><i class="fab fa-whatsapp"></i> WhastApp</a>
                                </article>
                            </aside>
                        </div>
                    </div>
				</section>
            </div>
            <div class="row">
                <section class="col-sm-12">
                    <div class="card">
                        <div class="fb-comments" data-href="{{ url('details/'.$product->slug) }}" data-width="100%" data-numposts="5"></div>
                    </div>
                </section>
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
    <link href="{{ asset('ecommerce/plugins/fancybox/fancybox.min.css') }}" type="text/css" rel="stylesheet">
@endsection

@section('scripts')
    <!-- plugin: fancybox  -->
    <script src="{{ asset('ecommerce/plugins/fancybox/fancybox.min.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function(){

		});
	</script>
@endsection