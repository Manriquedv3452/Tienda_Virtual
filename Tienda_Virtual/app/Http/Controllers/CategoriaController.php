<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\Categoria;
use Session;

class CategoriaController extends Controller
{
    public function indexCategoria() {
        $user = Session::get('frontSession','NULL');
        if( $user == 'NULL' || !$user->admin){
            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
      $categorias = Categoria::get();
    	$categorias = json_decode(json_encode($categorias));
    	return view('admin.categoria.indexCategoria')->with(compact('categorias'));
    }

    public function agregarCategoria(Request $request) {
        $user = Session::get('frontSession','NULL');
        if( $user == 'NULL' || !$user->admin){
            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
    	if($request->isMethod('post')) {
    		$datos = $request->all();
    		$categoria = new Categoria;
    		$categoria->nombre = $datos['nombre'];
    		$categoria->descripcion = $datos['descripcion'];
    		$categoria->condicion = '1';
    		$categoria->save();
    		return redirect('/admin/indexCategoria')->with('flash_message_success', 'La categoría fue añadida correctamente.');
    	}
    	return view('admin.categoria.agregarCategoria');
    }

    public function editarCategoria(Request $request, $id = null) {
        $user = Session::get('frontSession','NULL');
        if( $user == 'NULL' || !$user->admin){
            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
    	if ($request->isMethod('post')) {
    		$datos = $request->all();
    		Categoria::where(['idCategoria'=>$id])->update(['nombre'=>$datos['nombre'], 'descripcion'=>$datos['descripcion'], 'condicion'=>$datos['condicion']]);
    		return redirect('/admin/indexCategoria')->with('flash_message_success', '¡La categoría fue actualizada correctamente!');
    	}
    	$detallesCategoria = Categoria::where(['idCategoria'=>$id])->first();
    	return view('admin.categoria.editarCategoria')->with(compact('detallesCategoria'));
    }
    
    public function eliminarCategoria($id = null) {
        $user = Session::get('frontSession','NULL');
        if( $user == 'NULL' || !$user->admin){
            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
    	if (!empty($id)) {
    		Categoria::where(['idCategoria'=>$id])->update(['condicion'=>'0']);
    		return redirect()->back()->with('flash_message_success', '¡La condición de la Categoría fue actualizada correctamente!');
    	}
    }
}
