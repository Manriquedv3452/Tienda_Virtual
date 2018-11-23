@extends('layouts.cliente')
@section('contenidoCliente')
	<!-- Home -->
<link rel="stylesheet" type="text/css" href="{{asset('css/product_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/product_responsive.css')}}">
<header class="header">
	@include('cliente.search')
</header>

	<div class="single_product">
		<div class="container">
			<div class="row">

				<!-- Images 
				<div class="col-lg-2 order-lg-1 order-2">
					<ul class="image_list">
						<li data-image="images/single_4.jpg"><img src="images/single_4.jpg" alt=""></li>
						<li data-image="images/single_2.jpg"><img src="images/single_2.jpg" alt=""></li>
						<li data-image="images/single_3.jpg"><img src="images/single_3.jpg" alt=""></li>
					</ul>
				</div> -->

				<!-- Selected Image -->
				<div class="col-lg-5 order-lg-2 order-1">
					<div class="image_selected"><img src="{{asset('images/productos/'.$producto->imagen)}}" alt=""></div>
				</div>

				<!-- Description -->
				<div class="col-lg-5 order-3">
					<div class="product_description">
						<div class="product_category"></div>
						<div class="product_name">{{$producto->nombre}}</div>
						<div class="product_text"><p>{{$producto->descripcion}}</p></div>
						<div class="order_info d-flex flex-row">
							<form action="#">
								<div class="product_price">${{$producto->precio}}</div>
								<div class="button_container">
									<a href="{{url('/carrito/agregar/'.$producto->idProducto)}}">
									<button type="button" class="button cart_button">Agregar a carrito</button></a>
									<div class="product_fav"><i class="fas fa-heart"></i></div>
								</div>
								
							</form>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
