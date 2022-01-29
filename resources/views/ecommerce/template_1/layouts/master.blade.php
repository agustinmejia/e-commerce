<!DOCTYPE HTML>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="max-age=604800" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>@yield('page_title', setting('admin.title') . " - " . setting('admin.description'))</title>

		@yield('seo')

        <!-- Favicon -->
        <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
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

			@media (max-width: 768px) {
				.div-contact-whatsapp{
					display: none;
				}
				.section-pagetop{
					padding-top: 150px !important;
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

		<script type="text/javascript">
		/// some script

		// jquery ready start
		$(document).ready(function() {
			// jQuery code

		}); 
		// jquery end
		</script>

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
						<div class="col-lg-3 col-sm-4">
						<div class="brand-wrap">
                            <a href="{{ url('') }}">
								<?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
								@if($admin_favicon == '')
									<img class="logo" src="{{ asset('images/icon.png') }}" alt="{{ setting('admin.title') }}" />
								@else
									<img class="logo" src="{{ Voyager::image($admin_favicon) }}" alt="{{ setting('admin.title') }}" />
								@endif
								<h2 class="logo-text text-dark">{{ setting('admin.title') }}</h2>
							</a>
						</div> <!-- brand-wrap.// -->
						</div>
						<div class="col-lg-6 col-sm-8">
                            <form action="#" class="search-wrap">
                                <div class="input-group w-100">
                                    <input type="text" class="form-control" style="width:55%;" placeholder="Buscar...">
                                    <select class="custom-select"  name="category_name">
                                            <option value="">Todos</option>
                                            <option value="codex">Más vendidos</option>
                                            <option value="comments">Más puntuados</option>
                                            <option value="content">Nuevos</option>
                                    </select>
                                    <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    </div>
                                </div>
                            </form> <!-- search-wrap .end// -->
						</div> <!-- col.// -->
						<div class="col-lg-3 col-sm-12 div-contact-whatsapp">
								<a href="#" class="widget-header float-md-right">
									<div class="icontext">
										<div class="icon-wrap"><i class="flip-h fa-lg fab fa-whatsapp"></i></div>
										<div class="text-wrap">
											<small>WhatsApp</small>
											<div>+591 75199157</div>
										</div>
									</div>
								</a>
						</div> <!-- col.// -->
					</div> <!-- row.// -->
				</div> <!-- container.// -->
			</section> <!-- header-main .// -->
		</header> <!-- section-header.// -->

		@yield('content')


		<!-- ========================= FOOTER ========================= -->
		<footer class="section-footer bg-secondary">
			<div class="container">
				<section class="footer-top padding-top">
					<div class="row">
						<aside class="col-sm-12 col-md-4 white">
							<h4 class="title">{{ setting('admin.title') }}</h4>
							<p>{{ setting('admin.description') }}</p>
						</aside>
						<aside class="col-xs-6 col-sm-6 col-md-2 white">
							<h5 class="title">Customer Services</h5>
							<ul class="list-unstyled">
								<li> <a href="#">Help center</a></li>
								<li> <a href="#">Money refund</a></li>
								<li> <a href="#">Terms and Policy</a></li>
								<li> <a href="#">Open dispute</a></li>
							</ul>
						</aside>
						<aside class="col-xs-6 col-sm-6  col-md-2 white">
							<h5 class="title">My Account</h5>
							<ul class="list-unstyled">
								<li> <a href="#"> User Login </a></li>
								<li> <a href="#"> User register </a></li>
								<li> <a href="#"> Account Setting </a></li>
								<li> <a href="#"> My Orders </a></li>
								<li> <a href="#"> My Wishlist </a></li>
							</ul>
						</aside>
						<aside class="col-xs-6 col-sm-6  col-md-2 white">
							<h5 class="title">About</h5>
							<ul class="list-unstyled">
								<li> <a href="#"> Our history </a></li>
								<li> <a href="#"> How to buy </a></li>
								<li> <a href="#"> Delivery and payment </a></li>
								<li> <a href="#"> Advertice </a></li>
								<li> <a href="#"> Partnership </a></li>
							</ul>
						</aside>
						<aside class="col-xs-6 col-sm-6 col-md-2">
							<article class="white">
								<h5 class="title">Contacts</h5>
								<p>
									<strong>Celular: </strong> +591 75199157 <br> 
									<strong>Email:</strong> user@example.com
								</p>

								<div class="btn-group white">
									<a class="btn btn-facebook" title="Facebook" target="_blank" href="#"><i class="fab fa-facebook-f  fa-fw"></i></a>
									<a class="btn btn-instagram" title="Instagram" target="_blank" href="#"><i class="fab fa-instagram  fa-fw"></i></a>
									<a class="btn btn-youtube" title="Youtube" target="_blank" href="#"><i class="fab fa-youtube  fa-fw"></i></a>
									<a class="btn btn-twitter" title="Twitter" target="_blank" href="#"><i class="fab fa-twitter  fa-fw"></i></a>
								</div>
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
						<p class="text-sm-right text-white-50">Copyright &copy {{ date('Y') }} <br> Desarrolado por <a href="https://ideacreativa.ml" class="text-white" target="_blank">IdeaCreativa</a></p>
					</div>
				</section> <!-- //footer-top -->
			</div><!-- //container -->
		</footer>
		<!-- ========================= FOOTER END // ========================= -->

		@yield('css')
		
		@yield('scripts')
	</body>
</html>