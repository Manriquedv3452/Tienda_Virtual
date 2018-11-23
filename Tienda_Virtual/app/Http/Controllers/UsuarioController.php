<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\User;
use Auth;
use Session;
use DB;

class UsuarioController extends Controller
{
    public function inicioSesionRegistro(Request $request) {
      return view('usuarios.registrar');
    }

    public function inicioSesion(Request $request) {
      if($request->isMethod('post')) {
        $datos = $request->all();
        if(Auth::attempt(['email'=>$datos['correo'], 'password'=>$datos['contrasena']])) {
          $usuario = DB::select("select name, email, admin from users where email = '".$datos['correo']."'");
          Session::put('frontSession', $usuario[0]);//las sesiones se guardan en storage/framework/sessions
          if($usuario[0]->admin){
            return redirect('admin/indexProducto');
          }
          else{
            return redirect('/cliente');
          }
        } else {
          return redirect()->back()->with('flash_message_error', '¡El correo o la contraseña son inválidos!');
        }
      }
    }

    public function cuenta() {
      return view('usuarios.cuenta');
    }

    public function registrar(Request $request) {
      if($request->isMethod('post')) {
        $datos = $request->all();
        $cuentaUsuario = User::where('email', $datos['correo'])->count();
        if ($cuentaUsuario>0) {
          return redirect()->back()->with('flash_message_error', '¡El correo introducido ya existe!');
        } else {
          $usuario = new User;
          $usuario->name = $datos['nombre'];
          $usuario->email = $datos['correo'];
          $usuario->password = bcrypt($datos['contrasena']);
          $usuario->admin = 0;
          $usuario->save();
        }
      }
      Session::forget('frontSession');
      return redirect('/cliente');
    }

    public function chequearEmail(Request $request) {
      $datos = $request->all();
      $cuentaUsuario = User::where('email', $datos['correo'])->count();
    }

    public function cerrarSesion() {
      //Auth::logot();
      Session::forget('frontSession');
      return redirect('/cliente');
    }
}
