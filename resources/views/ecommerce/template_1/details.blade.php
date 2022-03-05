@extends('ecommerce.template_1.layouts.master')

@section('page_title', 'Bienvenido | '.setting('site.title'))

@php
    $product = \App\Models\Product::with(['rating', 'sales_details'])->where('slug', $slug)->first();
    $image = 'images/default.jpg';
    $image_medium = 'images/default.jpg';
    $image_social = 'images/default.jpg';
    if($product->images){
        $image = 'storage/'.json_decode($product->images)[0];
        $image_medium = 'storage/'.str_replace('.', '-medium.', json_decode($product->images)[0]);
        $image_social = 'storage/'.str_replace('.', '-social.', json_decode($product->images)[0]);
    }
@endphp

@section('seo')
	<meta property="og:url"           content="{{ url('details/'.$product->slug) }}" />
	<meta property="og:type"          content="E-Commerce" />
	<meta property="og:title"         content="{{ $product->name }}" />
	<meta property="og:description"   content="{{ $product->description }}" />
	<meta property="og:image"         content="{{ asset($image_social) }}" />
	<meta name="keywords" content="ecommerce, e-commerce, ideacreativa, idea, creativa, ventas, {{ $product->name }}">
@endsection

@section('content')
	<!-- ========================= SECTION PAGETOP ========================= -->
	<section class="section-pagetop bg-secondary">
		<div class="container clearfix">
			<h2 class="title-page">Bienvenido a {{ setting('site.title') }}</h2>
			<nav class="float-left">
				<ol class="breadcrumb text-white">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
					{{-- <li class="breadcrumb-item"><a href="#">Detalles</a></li> --}}
					<li class="breadcrumb-item active" aria-current="page">Data</li>
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
                                        <div> <a href="{{ asset($image) }}" data-fancybox=""><img src="{{ asset($image_medium) }}" style="width: 100%; height: 100%"></a></div>
                                    </div>
                                    <div class="img-small-wrap">
                                        @if($product->images)
                                            @foreach (json_decode($product->images) as $item)
                                                @php
                                                    $image = 'storage/'.str_replace('.', '-cropped.', $item);
                                                @endphp
                                                <div class="item-gallery"> <img src="{{ url($image) }}" data-image="{{ $item }}"></div>
                                            @endforeach
                                        @endif
                                    </div>
                                </article>
                            </aside>
                            <aside class="col-sm-7">
                                <article class="section-details">
                                    <h3 class="title mb-3">{{ $product->name }} | <small style="font-size: 18px">{{ $product->category->name }}</small></h3>

                                    <div class="mb-3"> 
                                        <var class="price h3 text-success"> 
                                            <small><span class="currency">Bs.</span></small>
                                            <span class="num">{{ $product->price }}</span>
                                        </var> 
                                        {{-- <span>/per kg</span> --}}
                                    </div>
                                    <dt>Descripción</dt>
                                    {!! $product->long_description ?? 'Ninguna' !!}
                                    <br><br>
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
                                    {{-- <div class="col-md-12 mt-3 mb-4 p-0" >
                                        <a href="#" class="btn  btn-primary mb-2"> Comprar ahora </a>
                                        <a href="#" class="btn  btn-outline-primary mb-2"> <i class="fas fa-shopping-cart"></i> Agregar al carrito </a>
                                    </div> --}}
                                    <hr>
                                    <div class="col-md-12 p-0 pb-5">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="https://wa.me/59175199157?text=Me%20interesa%20la/el%20{{ $product->name }}" target="_blank" class="btn btn-success btn-sm" style="height: 28px;"><i class="fab fa-whatsapp"></i> WhastApp</a>
                                                </td>
                                                <td>
                                                    <div class="fb-like" data-href="{{ url('details/'.$product->slug) }}" data-width="" data-layout="button_count" data-action="like" data-size="large" data-share="true"></div>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </div>
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
	{{-- <section class="section-name bg-white padding-y">
		<div class="container">
			<h4>Another section if needed</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
	</section> --}}
	<!-- ========================= SECTION  END// ========================= -->
@endsection

@section('css')
    <link href="{{ asset('ecommerce/plugins/fancybox/fancybox.min.css') }}" type="text/css" rel="stylesheet">
    <style>
        .section-details{
            padding: 45px
        }
        @media (max-width: 768px) {
            .btn-sm{
                margin: 2px !important;
            }
            .section-details{
                padding: 15px
            }
        }
    </style>
@endsection

@section('scripts')
    <!-- plugin: fancybox  -->
    <script src="{{ asset('ecommerce/plugins/fancybox/fancybox.min.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function(){
            $('.item-gallery img').click(function(){
                let image = $(this).data('image');
                let url = "{{ url('storage') }}";
                $('.img-big-wrap img').attr('src', `${url}/${image.replace('.', '-medium.')}`);
                $('.img-big-wrap a').attr('href', `${url}/${image}`);
            });
		});
	</script>
@endsection