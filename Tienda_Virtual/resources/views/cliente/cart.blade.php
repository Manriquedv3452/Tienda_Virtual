<!DOCTYPE html>
<html lang="en">
<head>
<title>Tienda Virtual</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="OneTech shop project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap4/bootstrap.min.css')}}">
<link href="{{asset('plugins/fontawesome-free-5.0.1/css/fontawesome-all.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/slick-1.8.0/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/main_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_responsive.css')}}">
</head>

<body>

<div class="super_container">

	<!-- Header -->

	<!-- Banner -->



	<!-- Characteristics -->

	<header class="header">
	@include('cliente.search')
	</header>
	<!-- Cart -->

	<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="cart_container">
						<div class="cart_title">Carrito de compras</div>
						<div class="cart_items">
							<ul class="cart_list">
							@foreach($carrito as $producto)
								<li class="cart_item clearfix">
									<div class="cart_item_image">
										<img src="{{asset('images/productos/'.$producto->imagen)}}" alt="">
									</div>
									<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
										<div class="cart_item_name cart_info_col">
											<div class="cart_item_title">Nombre</div>
											<div class="cart_item_text">{{$producto->nombre}}</div>
										</div>
										<div class="cart_item_price cart_info_col">
											<div class="cart_item_title">Precio</div>
											<div class="cart_item_text">${{$producto->precio}}</div>
										</div>
										<div class="cart_item_total cart_info_col">
											<div class="cart_item_title">Total</div>
											<div class="cart_item_text">${{$producto->precio}}</div>
										</div>
										<div class="cart_item_name cart_info_col">
											<div class="cart_item_text">
												<a href="{{url('/carrito/quitar/'.$producto->idProducto)}}">
													<button type="button" class="button cart_button_clear">Quitar</button>
												</a>
											</div>
										</div>
									</div>
								</li>
								@endforeach
							</ul>
						</div>
						
						<!-- Order Total -->
						<div class="order_total">
							<div class="order_total_content text-md-right">
								<div class="order_total_title">Precio total:</div>
								<div class="order_total_amount">${{$total}}</div>
							</div>						
						</div>

						<div class="cart_buttons">
							<a href="{{url('/carrito/eliminar')}}">
								<button type="button" class="button cart_button_clear">Eliminar carrito</button>
							</a>
							<!--<a href="{{url('/carrito/verificar')}}">-->
							<button type="button" class="button cart_button_checkout" data-toggle="modal" data-target="#exampleModal">Proceder con pago</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('cliente.popups.modalCarrito')


	<!-- Footer -->

	<footer class="footer">
		<div class="container">
			<div class="row">

				<div class="col-lg-3 footer_col">
					<div class="footer_column footer_contact">
						<div class="logo_container">
							<div class="logo"><a href="#">Tienda Virtual</a></div>
						</div>
					</div>
				</div>

				<div class="col-lg-2">
					<div class="footer_column">
						<div class="footer_title">Servicio al cliente</div>
						<ul class="footer_list">
							<li><a href="#">Mi cuenta</a></li>
							<li><a href="#">Mis órdenes</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- Copyright -->

	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col">

					<div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
						<div class="copyright_content"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</div>
>>>>>>> Interfaz-Usuario
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('css/bootstrap4/popper.js')}}"></script>
<script src="{{asset('css/bootstrap4/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/TweenMax.min.js')}}"></script>
<script src="{{asset('plugins/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('plugins/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('plugins/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('plugins/slick-1.8.0/slick.js')}}"></script>
<script src="{{asset('plugins/easing/easing.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
<script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>


@if(Session::has('address_error'))
<script type="text/javascript">
	$(function() {
		$("#exampleModal").modal('show');
	});
</script>
@endif

</body>

</html>
