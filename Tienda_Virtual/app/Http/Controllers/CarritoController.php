<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class CarritoController extends Controller
{
    //
    public function agregarItem($id){
    	$producto = DB::select("call verificarProducto(".$id.");");//Devuelve un array, de largo 1 o largo 0
    	if(count($producto) != 0){
    		$carrito = Session::get('carrito');
    		$carrito[] = $producto[0];
    		Session::put('carrito',$carrito);
    		$total = Session::get('total');
    		$total += $producto[0]->precio;
    		Session::put('total',$total);
    	}
    	return redirect()->back();
    }

    public function verCarrito(){
    	$categorias = DB::select("select idCategoria, nombre,condicion from categoria");
    	$user = Session::get('frontSession','NULL');
    	$carritoLen = count(Session::get('carrito'));
      	$total = Session::get('total');
      	$carrito = Session::get('carrito');
    	return view('cliente.cart',['categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total,'carrito' => $carrito]);
    }

    public function eliminarCarrito(){
    	Session::forget('carrito');
    	Session::forget('total');
    	return redirect('cliente');
    }

    public function quitarDelCarrito($id){
    	$carrito = Session::get('carrito');
    	$total = Session::get('total');
    	for($i = 0; $i < count($carrito); $i++){
    		if($carrito[$i]->idProducto == $id){
    			$total -= $carrito[$i]->precio;
    			unset($carrito[$i]);
    		}
    	}	
    	Session::put('total',$total);
    	Session::put('carrito',$carrito);
    	return redirect()->back();
    }

    public function pagar(){
    	$user = Session::get('frontSession','NULL');
        if($user == 'NULL'){
            return redirect('/usuarios/inicioSesionRegistro');
        }
        else{
            return redirect('/cliente/cart');
        }
    }
}
