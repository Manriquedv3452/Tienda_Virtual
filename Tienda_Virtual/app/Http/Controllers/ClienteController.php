<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\Producto;
use tiendaVirtual\Tarjeta;
use tiendaVirtual\Categoria;
use tiendaVirtual\Carrito;
use tiendaVirtual\User;
use Illuminate\Support\Facades\Redirect;
use tiendaVirtual\Http\Requests\ClienteFormRequest;
use tiendaVirtual\Http\Requests\TarjetaFormRequest;
use Illuminate\Support\Facades\Input;
use DB;
use Session;
use Auth;

class ClienteController extends Controller
{
    //
    public function __construct(){

    }

    public function index(Request $request){
      /*Función principal de la página de inicio: http://localhost:8000/cliente
      Despliega los productos al usuario. Además de verificar si hay un carro creado en
      la sesión*/
      try{
        $productos = Producto::producosHabilitados();//Obtiene los productos en la base
    	  $categorias = Categoria::getCategorias(); //Si no hay conexión le avisa al usuario
      }catch (\Exception $e){
        return self::avisarError();
      }
      $user = User::getUsuario();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
      $carritoLen = Carrito::getTamano();
      $total = Carrito::precioTotal();
    	return view('cliente.index', ['productos'=> $productos,'categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);

   	}

    public function show($id){
      return view('cliente.show', ['producto'=>Producto::findOrFail($id)]);
    }

    public function metodosPago(){
      /*Retorna las tarjetas que tenga el usuario, si no hay usuario retorna la página de log in*/
      if(User::hayUsuarioLogueado()){
        return view('cliente/metodos');
      }
      return redirect('/usuarios/inicioSesionRegistro');
    }

    public function agregarMetodo(TarjetaFormRequest $request){
      /*Agrega una tarjeta al usuario logueado, se revisó previamente que hubiera alguien logueado*/
      $datos = $request->all();
      if($datos['mes'] < 10){
        $fecha_expiracion = "'".$datos['year']."-0".$datos['mes']."-01'";
      }else{
        $fecha_expiracion = "'".$datos['year']."-".$datos['mes']."-01'";
      }
      $Usuario_correo = User::getUsuario()->email;
      $tarjeta = new Tarjeta($datos['titular'],$datos['numero'],$datos['ccv'],$fecha_expiracion,$Usuario_correo);
      if($tarjeta->nuevaTarjeta()){//La función retorna true si se insertó en la base, false si no
        $tarjeta = null;
        return Redirect::back()->with('success', '1');
      }else{
        return self::avisarError();
      }    
    }

    public function verMetodos(){
      /*llama para desplegar las tarjetas asociadas al usuario*/
      $user = User::getUsuario();
      $carritoLen = Carrito::getTamano();
      $total = Carrito::precioTotal();
      if(User::hayUsuarioLogueado()){//revisa que haya alguien logueado
        try{
          $tarjetas = Tarjeta::verTarjetas($user->email);//obtiene las tarjetas asociadas al usuario loguado
          $categorias = Categoria::getCategorias(); //si no hay conexión a la base, le avisa al usuario
        }catch (\Exception $e){
          return self::avisarError();
        }
      }
      else{
        return Redirect::back();
      }
      return view('cliente.vermetodos',['categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total, 'tarjetas' => $tarjetas]);
    }

    public function inicioSesion(Request $request) {//Hay diferencia con el otro login
      /*Inicia sesión en la página del carrito si se hace click en proceder con pago y no hay alguien
      logueado. Despliega un pop-up con el aviso. Esta es la diferencia con inicioSesion en UsuarioController*/
      if($request->isMethod('post')) {
        $datos = $request->all();
        try{//revisar la conexión con la base de datos
          if(Auth::attempt(['email'=>$datos['correo'], 'password'=>$datos['contrasena']])) {
            User::loguearUsuario($datos['correo']);
            return redirect('/cliente/cart');
          } else {
            return Redirect::back()->with('flash_message_error', '¡El correo o la contraseña son inválidos!');
          }
        }catch (\Exception $e){
          return self::avisarError();
        }
      }
    }
        

    public static function avisarError(){
      $user = User::getUsuario();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
      $carritoLen = Carrito::getTamano();
      $total = Carrito::precioTotal();
      return view('cliente.error',['usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);
    }
}
