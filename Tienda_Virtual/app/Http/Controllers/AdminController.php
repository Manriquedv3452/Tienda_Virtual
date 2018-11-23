<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use tiendaVirtual\User;
use DB;

class AdminController extends Controller
{
    public function inicioSesion(Request $request) {
      if($request->isMethod('post')){
    		$datos = $request->input(); //Son las etiquetas del html
    		if (Auth::attempt(['email'=>$datos['email'],'password'=>$datos['password'],'admin'=>'1'])){
                $usuario = DB::select("select name, email, admin from users where email = '".$datos['email']."'");
                Session::put('frontSession', $usuario[0]);//las sesiones se guardan en storage/framework/sessions
    			return redirect('admin/indexProducto');
    		} else {
    			return redirect('/admin')->with('flash_message_error', 'Usuario o Contraseña incorrectos.');
    		}
    	}
    	return view('admin.login');
    }

    public function inicio() {
        return view('admin.inicio');
    }

    public function dashboard() {
        $user = Session::get('frontSession','NULL');
        if( $user == 'NULL'|| !$user->admin){
            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
        return view('admin.dashboard');

    }
    public function cierreSesion() {
        Session::flush();
        return redirect('/admin')->with('flash_message_success', '¡Cierre de sesión completo!');
    }
    public function configuraciones() {
        $user = Session::get('frontSession','NULL');
        if( $user == 'NULL'|| !$user->admin){

            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
        return view('admin.configuraciones');
    }

    public function revisarContrasena(Request $request) {
        $datos = $request->all();
        $contrasena = $datos['ctr_actual'];
        $chequearContrasena = User::where(['admin'=>'1'])->first();
        if (Hash::check($contrasenaActual, $chequearContrasena->contrasena)) {
            echo "true"; die;
        } else {
            echo "false"; die;
        }
    }

    public function crearUsuarioAdministrador(Request $request) {
        $user = Session::get('frontSession','NULL');
        if( $user == 'NULL'|| !$user->admin){
            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
      if($request->isMethod('post')) {
        $datos = $request->all();
        $cuentaUsuario = User::where('email', $datos['correo'])->count();
        if ($cuentaUsuario>0) {
          return redirect('/admin/crearAdmin')->with('flash_message_error', '¡El correo introducido ya existe!');
        } else {
          $usuario = new User;
          $usuario->name = $datos['nombre'];
          $usuario->email = $datos['correo'];
          $usuario->password = bcrypt($datos['ctr_nueva']);
          $usuario->admin = '1';
          $usuario->save();
          return redirect('/admin/crearAdmin')->with('flash_message_success', '¡Se ha creado un nuevo Administrador!');
          }
        }
      return view('admin.crearAdmin');
    }

    public function actualizarContrasena (Request $request) {
        $user = Session::get('frontSession','NULL');
        if( $user == 'NULL'|| !$user->admin){

            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
        if($request->isMethod('post')) {
            $datos = $request->all();
            $chequearContrasena = User::where(['email' => Auth::user()->email])->first();
            $contrasenaActual = $datos['ctr_actual'];
            if (Hash::check($contrasenaActual, $chequearContrasena->password)) {
                $contrasena = bcrypt($datos['ctr_nueva']);
                User::where('id','1')->update(['password' => $contrasena]);
                return redirect('/admin/configuraciones')->with('flash_message_success', 'Su contraseña ha sido actualizada.');
            } else {
                return redirect('/admin/configuraciones')->with('flash_message_error', 'Contraseña actual incorrecta.');
            }
        }
    }
}
