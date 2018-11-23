@extends('layouts.cliente')
@section('contenidoCliente')
	<!-- Home -->
<link rel="stylesheet" type="text/css" href="{{asset('css/shop_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/shop_responsive.css')}}">
<header class="header">
	@include('cliente.search')
</header>

<div class="home">
	<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{asset('images/shop_background.jpg')}}"></div>
	<div class="home_overlay"></div>
	<div class="home_content d-flex flex-column align-items-center justify-content-center">
		<h2 class="home_title">Resultados de: {{$filtro}}</h2>
	</div>
</div>


<!-- Shop -->

<div class="shop">
	<div class="container">
		<div class="row">


			<div class="col-lg-9">
				
				<!-- Shop Content -->

				<div class="shop_content">
					<div class="shop_bar clearfix">
						<div class="shop_product_count"><span>{{sizeof($productos)}}</span> productos encontrados</div>
						<!-- Shop Content 
						<div class="shop_sorting">
							<span>Sort by:</span>
							<ul>
								<li>
									<span class="sorting_text">highest rated<i class="fas fa-chevron-down"></span></i>
									<ul>
										<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "original-order" }'>highest rated</li>
										<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>name</li>
										<li class="shop_sorting_button"data-isotope-option='{ "sortBy": "price" }'>price</li>
									</ul>
								</li>
							</ul>
						</div>-->
					</div>

					<div class="product_grid">
						<div class="product_grid_border"></div>

						<!-- Product Item -->
						@foreach($productos as $prod)
						<div class="product_item is_new">
							<div class="product_border"></div>
							<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{asset('images/productos/'.$prod->imagen)}}" alt=""></div>
							<div class="product_content">
								<div class="product_price">${{$prod->precio}}</div>
								<div class="product_name"><div><a href="{{URL::action('ClienteController@infoProducto',$prod->idProducto)}}" tabindex="0">{{$prod->nombre}}</a></div></div>
							</div>
							<div class="product_fav"><i class="fas fa-heart"></i></div>
							
						</div>
						@endforeach						

					</div>

					<!-- Shop Page Navigation -->
				</div>

			</div>
		</div>
	</div>
</div>
@stop