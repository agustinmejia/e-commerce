<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Bootstrap-ecommerce by Vosidiy">

        <title>@yield('page_title', setting('site.title')." | ".setting('site.description'))</title>

		@yield('seo')

        <!-- Favicon -->
        <?php $admin_favicon = Voyager::setting('site.logo', ''); ?>
        @if($admin_favicon == '')
            <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/png">
        @else
            <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
        @endif

        <!-- jQuery -->
        <script src="{{ asset('ecommerce/js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>

        <!-- Bootstrap4 files-->
        <script src="{{ asset('ecommerce/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <link href="{{ asset('ecommerce/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Font awesome 5 -->
        <link href="{{ asset('ecommerce/fonts/fontawesome/css/fontawesome-all.min.css') }}" type="text/css" rel="stylesheet">

        <!-- plugin: fancybox  -->
        <script src="{{ asset('ecommerce/plugins/fancybox/fancybox.min.js') }}" type="text/javascript"></script>
        <link href="{{ asset('ecommerce/plugins/fancybox/fancybox.min.css') }}" type="text/css" rel="stylesheet">

        <!-- custom style -->
        <link href="{{ asset('ecommerce/css/ui.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('ecommerce/css/responsive.css') }}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

        <!-- custom javascript -->
        <script src="{{ asset('ecommerce/js/script.js') }}" type="text/javascript"></script>

        <!-- plugin: slickslider -->
        <link href="{{ asset('ecommerce/plugins/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('ecommerce/plugins/owlcarousel/assets/owl.theme.default.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{ asset('ecommerce/plugins/owlcarousel/owl.carousel.min.js') }}"></script>

        <script type="text/javascript">
        /// some script

            // jquery ready start
            $(document).ready(function() {
                // jQuery code

            }); 
        // jquery end
        </script>

        @yield('css')
                
        @yield('scripts')

        <style>
            .select2-selection{
                padding: 8px 0px;
                height: 44px !important;
            }
            .select2-selection__arrow{
                margin-top: 8px
            }
            .dark-mask{
                width: 100%;
                height: 100%;
                z-index: 10px;
                background-color: rgba(0,0,0,0.5);
                backdrop-filter: blur(5px);
            }
            .scroll-x{
                text-align: center;
            }
            @media (max-width: 576px) {
                .scroll-x{
                    width: 100%;
                    height: 50px;
                    overflow: auto;
                    white-space: nowrap;
                }   
            }
        </style>

    </head>
    <body>

        {{-- ===== Facebook Sdk ===== --}}
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v12.0&appId=465165315241707&autoLogAppEvents=1" nonce="AS1KRfwD"></script>
		{{-- ===== end Facebook Sdk ===== --}}

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ url('/') }}">
                <?php $admin_favicon = Voyager::setting('site.logo', ''); ?>
                @if($admin_favicon == '')
                    <img class="logo" src="{{ asset('images/icon.png') }}" alt="{{ setting('site.title') }}" />
                @else
                    <img class="logo" src="{{ Voyager::image($admin_favicon) }}" alt="{{ setting('site.title') }}" />
                @endif
                {{ setting('site.title') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                    <a class="nav-link" href="http://bootstrap-ecommerce.com">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="html-components.html"> Documentation </a></li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">  Dropdown  </a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"> Menu item 1</a></li>
                        <li><a class="dropdown-item" href="#"> Menu item 2 </a></li>
                        </ul>
                    </li> --}}
                    <li class="nav-item">
                    {{-- <a class="btn ml-2 btn-warning" href="http://bootstrap-ecommerce.com">Download</a></li> --}}
                </ul>
            </div>
        </nav>

        @yield('content')

        <!-- ========================= FOOTER ========================= -->
        <footer class="section-footer bg-dark">
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

        {{-- Select2 --}}
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				var productSelected, categoryFilter;
				$('#select-main-search').select2({
					style: "height: 60px !important;",
					placeholder: '<i class="fa fa-search"></i> &nbsp;&nbsp; Buscar producto...',
					escapeMarkup : function(markup) {
						return markup;
					},
					language: {
						inputTooShort: function (data) {
							return `Ingrese ${data.minimum - data.input.length} o más caracteres`;
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