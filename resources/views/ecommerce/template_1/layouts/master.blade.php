<!DOCTYPE HTML>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="max-age=604800" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>@yield('page_title', setting('site.title') . " - " . setting('site.description'))</title>

		@yield('seo')

        <!-- Favicon -->
        <?php $admin_favicon = Voyager::setting('site.logo', ''); ?>
        @if($admin_favicon == '')
            <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/png">
        @else
            <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
        @endif

		{{-- Custom CSS --}}
		<style>
			.section-pagetop{
				padding-top: 120px !important;
			}
			.select2-selection, .select2-selection__rendered, .select2-selection__arrow{
				height: 40px !important;
			}
			.select2-selection__rendered{
				line-height: 35px !important;
			}
			.select2-selection__placeholder{
				font-size: 18px !important;
			}

			.shopping-cart-mobile{
				display: none;
				z-index: 10;
			}

			.shopping-cart-mobile .icon-wrap{
				background-color: white;
				border-radius: 30px
			}

			@media (max-width: 425px) {
				.div-header-right{
					display: none;
				}
				.shopping-cart-mobile{
					display: block;
				}
			}

			@media (max-width: 768px) {
				.section-pagetop{
					padding-top: 150px !important;
				}
				.div-contact-whatsapp{
					display: none !important;
				}
			}
		</style>

		<!-- jQuery -->
		<script src="{{ asset('ecommerce/js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>

		<!-- Bootstrap4 files-->
		<script src="{{ asset('ecommerce/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
		<link href="{{ asset('ecommerce/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

		<!-- Font awesome 5 -->
		<link href="{{ asset('ecommerce/fonts/fontawesome/css/fontawesome-all.min.css') }}" type="text/css" rel="stylesheet">

		<!-- custom style -->
		<link href="{{ asset('ecommerce/css/ui.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('ecommerce/css/responsive.css') }}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

		<!-- custom javascript -->
		<script src="{{ asset('ecommerce/js/script.js') }}" type="text/javascript"></script>

		<!-- plugin: owl carousel  -->
		<link href="{{ asset('ecommerce/plugins/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
		<link href="{{ asset('ecommerce/plugins/owlcarousel/assets/owl.theme.default.css') }}" rel="stylesheet">
		<script src="{{ asset('ecommerce/plugins/owlcarousel/owl.carousel.min.js') }}"></script>

	</head>
	<body>

		{{-- ===== Facebook Sdk ===== --}}
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v12.0&appId=465165315241707&autoLogAppEvents=1" nonce="AS1KRfwD"></script>
		{{-- ===== end Facebook Sdk ===== --}}

		<header class="section-header fixed-top bg-white">
			{{-- <nav class="navbar navbar-top navbar-expand-lg navbar-dark bg-secondary">
				<div class="container">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav">
							<li class="nav-item active">
							<a class="nav-link" href="http://bootstrap-ecommerce.com">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item"><a class="nav-link" href="html-components.html"> Documentation </a></li>
							<li class="nav-item dropdown">
								<a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">  Dropdown  </a>
								<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="#"> Menu item 1</a></li>
								<li><a class="dropdown-item" href="#"> Menu item 2 </a></li>
								</ul>
							</li>
							<li class="nav-item"><a class="nav-link" href="http://bootstrap-ecommerce.com"> Download <i class="fa fa-download"></i></a></li>
						</ul>
					</div>
				</div> <!-- container //  -->
			</nav> --}}
			<section class="header-main shadow">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-3 col-sm-3">
							<div class="brand-wrap">
								<a href="{{ url('') }}">
									<?php $admin_favicon = Voyager::setting('site.logo', ''); ?>
									@if($admin_favicon == '')
										<img class="logo" src="{{ asset('images/icon.png') }}" alt="{{ setting('site.title') }}" />
									@else
										<img class="logo" src="{{ Voyager::image($admin_favicon) }}" alt="{{ setting('site.title') }}" />
									@endif
									<h2 class="logo-text text-dark">{{ setting('site.title') }}</h2>
								</a>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6">
                            <form action="#" class="search-wrap">
                                <div class="input-group w-100">
                                    <select class="custom-select" id="select-main-search" name="category_name"></select>
                                </div>
                            </form>
						</div>
						<div class="col-lg-3 col-sm-3 text-right div-header-right">
							<a href="tel:{{ setting('social.whatsapp') ?? '59175199157' }}" class="widget-header text-left div-contact-whatsapp">
								<div class="icontext">
									<div class="icon-wrap"><i class="flip-h fa-lg fab fa-whatsapp"></i></div>
									<div class="text-wrap">
										<small>WhatsApp</small>
										<div>+{{ setting('social.whatsapp') ?? '59175199157' }}</div>
									</div>
								</div>
							</a>
							{{-- <a href="#" class="widget-header">
								<div class="icontext">
									<div class="icon-wrap icon-sm round border"><i class="fa fa-shopping-cart"></i></div>
								</div>
								<span class="badge badge-pill badge-danger notify count-shopping-cart">0</span>
							</a> --}}
						</div>
					</div>
				</div>
			</section>
		</header>

		@yield('content')

		{{-- <div class="shopping-cart-mobile" style="position: fixed; bottom: 20px; right: 20px">
			<a href="#" class="widget-header">
				<div class="icontext">
					<div class="icon-wrap icon-sm round border" style="width: 60px; height: 60px">
						<i class="fa fa-shopping-cart" style="font-size: 30px; padding-top: 15px"></i>
					</div>
				</div>
				<span class="badge badge-pill badge-danger notify count-shopping-cart" style="font-size: 13px">0</span>
			</a>
		</div> --}}

		<!-- ========================= FOOTER ========================= -->
		<footer class="section-footer bg-secondary">
			<div class="container">
				<section class="footer-top padding-top">
					<div class="row">
						<aside class="col-sm-12 col-md-12 col-lg-3 white">
							<h4 class="title">{{ setting('site.title') }}</h4>
							<p>{{ setting('site.description') }}</p>

							<div class="btn-group white mt-3 mb-5">
								<a class="btn btn-facebook" title="Facebook" target="_blank" href="{{ setting('social.facebook') ?? '#' }}"><i class="fab fa-facebook-f fa-fw"></i></a>
								<a class="btn btn-instagram" title="Instagram" target="_blank" href="{{ setting('social.instagram') ?? '#' }}"><i class="fab fa-instagram fa-fw"></i></a>
								<a class="btn btn-youtube" title="Youtube" target="_blank" href="{{ setting('social.youtube') ?? '#' }}"><i class="fab fa-youtube fa-fw"></i></a>
								<a class="btn btn-twitter" title="Twitter" target="_blank" href="{{ setting('social.twitter') ?? '#' }}"><i class="fab fa-twitter fa-fw"></i></a>
							</div>
						</aside>
						<aside class="col-xs-6 col-sm-6 col-md-4 col-lg-3 white">
							<h5 class="title">Nuestros servicios</h5>
							<ul class="list-unstyled">
								<li> <a href="#">Help center</a></li>
								<li> <a href="#">Money refund</a></li>
								<li> <a href="#">Terms and Policy</a></li>
								<li> <a href="#">Open dispute</a></li>
							</ul>
						</aside>
						<aside class="col-xs-6 col-sm-6  col-md-4 col-lg-3 white">
							<h5 class="title">Mi cuenta</h5>
							<ul class="list-unstyled">
								<li> <a href="#"> User Login </a></li>
								<li> <a href="#"> User register </a></li>
								<li> <a href="#"> Account Setting </a></li>
								<li> <a href="#"> My Orders </a></li>
								<li> <a href="#"> My Wishlist </a></li>
							</ul>
						</aside>
						<aside class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
							<article class="white">
								<h5 class="title">Contacto</h5>
								<p>
									<strong>Telefono/Celular: <br> </strong> {{ setting('site.phones') ?? '75199157' }} <br> 
									<strong>Email: <br> </strong> {{ setting('site.email') ?? 'agustinmejiamuiba@gmail.com' }} <br>
									<strong>Dirección: <br> </strong> {{ setting('site.address') ?? 'Calle Ipurupuru Nro 75' }} <br> 
								</p>
							</article>
						</aside>
					</div> <!-- row.// -->
					<br> 
				</section>
				<section class="footer-bottom row border-top-white">
					<div class="col-sm-6"> 
						{{-- <p class="text-white-50"> Made with <3 <br>  by Vosidiy M.</p> --}}
					</div>
					<div class="col-sm-6 text-right">
						<p class="text-sm-right text-white-50">Copyright &copy {{ date('Y') }} <br> Desarrollado por <a href="https://ideacreativa.ml" class="text-white" target="_blank">IdeaCreativa</a></p>
					</div>
				</section> <!-- //footer-top -->
			</div><!-- //container -->
		</footer>
		<!-- ========================= FOOTER END // ========================= -->

		@yield('css')
		
		@yield('scripts')

		{{-- Select2 --}}
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				var productSelected;
				$('#select-main-search').select2({
					style: "height: 60px !important;",
					placeholder: '<i class="fa fa-search"></i> &nbsp;&nbsp; Buscar producto...',
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
					minimumInputLength: 4,
					ajax: {
						url: "{{ url('admin/products/list/ajax') }}",
						processResults: function (data) {
							let results = [];
							console.log(data);
							data.forEach(function(item){
								results.push({
									...item,
									id: item.slug,
								});
							});
							return {
								results
							};
						},
						cache: true
					},
					templateResult: formatResult,
				})
				.change(function(e){
					// console.log(productSelected);
					if(e.target.value != ''){
						window.location.href = "{{ url('/details') }}" + "/" + e.target.value;
					}
				});
			});

			function formatResult(option){
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
				return $(`<div style="display: flex">
								<div style="margin: 0px 10px">
									<img src="${image}" width="60px" />
								</div>
								<div>
									<b style="font-size: 16px">${option.name}</b><br>
									<span>${option.category.name} | ${option.brand > 1 ? option.brand.name+' |' : ''}</span>
									${option.price} Bs. ${option.stock > 0 ? '' : '<label class="label label-danger">Agotado</label>'}
									<small>${option.description ? '<br>'+option.description : ''}</small>
								</div>
							</div>`);
			}

		</script>
	</body>
</html>