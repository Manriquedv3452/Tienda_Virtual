<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\Producto;

use Illuminate\Support\Facades\Redirect;
use tiendaVirtual\Http\Requests\ClienteFormRequest;
use Illuminate\Support\Facades\Input;
use DB;
use Session;

class ClienteController extends Controller
{
    //
    public function __construct(){

    }

    public function index(Request $request){ //revisar https://laravel.com/docs/5.6/database
      if(!Session::has('carrito')){ //Pregunta si hay un carrito creado
        Session::put('carrito',array()); //Crea un carrito de forma temporal
        Session::put('total',0);
      }
    	$productos = DB::select("select * from producto order by idProducto desc");
    	$categorias = DB::select("select idCategoria, nombre,condicion from categoria");
      $filter = trim($request->get('buscador'));
      $user = Session::get('frontSession','NULL');//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
      $carritoLen = count(Session::get('carrito'));
      $total = Session::get('total');
    	return view('cliente.index', ['productos'=> $productos,'categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);

   	}
   	 public function search(Request $request){ //revisar https://laravel.com/docs/5.6/database
      $filter = trim($request->get('buscador'));
    	$productos = DB::select("select * from producto where nombre LIKE '%".$filter."%'");
    	$categorias = DB::select("select idCategoria, nombre,condicion from categoria");
      $user = Session::get('frontSession','NULL');
      $carritoLen = count(Session::get('carrito'));
      $total = Session::get('total');
    	return view('cliente.results', ['productos'=> $productos,'categorias' => $categorias,'filtro' =>$filter,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);

   	}

    public function show($id){
      return view('cliente.show', ['producto'=>Producto::findOrFail($id)]);
    }

    public function filtrar($id){
      $categorias = DB::select("select idCategoria, nombre,condicion from categoria");
      $user = Session::get('frontSession','NULL');
      $carritoLen = count(Session::get('carrito'));
      $total = Session::get('total');

      foreach ($categorias as $cat) {
        if($cat->idCategoria == $id){
          $nombreCat = $cat->nombre;
          break;
        }
      }
      $productos = DB::select("CALL productos_x_categoria(".$id.");");
      return view('cliente.categories',['productos'=> $productos,'categorias' => $categorias,'nombreCat' => $nombreCat,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);

    }

    public function infoProducto($id){
      $producto = DB::select("select idProducto,nombre,descripcion,imagen,precio,stock from producto where
        idProducto = ".$id);
      $categorias = DB::select("select idCategoria, nombre,condicion from categoria");
      $user = Session::get('frontSession','NULL');
      $carritoLen = count(Session::get('carrito'));
      $total = Session::get('total');
      return view('cliente/product',['producto' => $producto[0],'categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);

    }
}
