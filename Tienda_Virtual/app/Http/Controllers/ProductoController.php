<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\Producto;
use tiendaVirtual\Categoria;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use DB;

class ProductoController extends Controller
{

    public function indexProducto(Request $request) {

      /*Verifica que haya alguien logueado como admin y despliega todos los productos de la
      base de datos*/

      $user = Session::get('frontSession','NULL');
        if( $user == 'NULL' || !$user->admin){
            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
      $productos = Producto::get();
      $productos = json_decode(json_encode($productos));

      // $categorias = DB::select();
      // foreach ($productos as $key => $val) {
    	// 	$nombreCategoria = Categoria::where(['idCategoria'=>$val->idCategoria])->first();
    	// 	$productos[$key]->nombreCategoria = $nombreCategoria->nombre;
    	// }

    	return view('admin.producto.indexProducto')->with(compact('productos'));
    }

    public function agregarProducto(Request $request)
    {
      $user = Session::get('frontSession','NULL');
        if( $user == 'NULL' || !$user->admin){//Revisa que haya un usuario logueado y que sea admin

            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
      if($request->isMethod('post')) {
    		$datos = $request->all();
        $producto = new Producto;
      	$producto->nombre = $datos['nombre'];//objeto en html ya validado por ProductoFormRequest
      	$producto->descripcion = $datos['descripcion'];
        if($request->hasFile('imageInput')){ //Primero pregunta si se subió una foto
              $imagen = Input::file('imageInput');
              $imagen->move(public_path().'/images/productos/',$imagen->getClientOriginalName());//guarda la imagen en: \qa-grupo7\Tienda_Virtual\storage\app\images
              $producto->imagen = $imagen->getClientOriginalName();
        }
      	$producto->precio = $datos['precio'];
      	$producto->stock = $datos['disponibles'];
      	DB::insert("call insertarProducto('".$producto->nombre."','".$producto->descripcion."','".$producto->imagen."',".$producto->precio.",".$producto->stock.",1);");//Inserta el producto en la base de datos
        $ultimoProducto = DB::select("select idProducto FROM producto ORDER BY idProducto DESC LIMIT 1")[0]->idProducto; //Obtiene el último producto en la base para sociarlo con una categoría
        DB::insert("call insertarCategoriaXProducto(".$datos['categorias']." ,".$ultimoProducto.");");
    	 	return redirect('/admin/indexProducto')->with('flash_message_success', 'El producto ha sido añadido correctamente.');
    	}

    	$categorias = Categoria::where(['condicion'=>1])->get();
    	$listadoCategorias = "<option value='' selected disabled>Elija una opción</option>";
    	foreach ($categorias as $cat) {//ciclo para desplegar las categorías
    		$listadoCategorias .= "<option value='".$cat->idCategoria."'>".$cat->nombre."</option>";
    	}
    	return view('admin.producto.agregarProducto')->with(compact('listadoCategorias'));
    }

    public function editarProducto(Request $request, $id) {
      /*Busca el producto en la base de datos para desplegar en la interfaz y que se pueda
      editar*/
      $user = Session::get('frontSession','NULL');
        if( $user == 'NULL' || !$user->admin){//Revisa que haya un usuario logueado y que sea admin

            return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
        }
      if ($request->isMethod('post')) {
    	 	$datos = $request->all();
        if($request->hasFile('imageInput')){
              $imagen = Input::file('imageInput');
              $imagen->move(public_path().'/images/productos/',$imagen->getClientOriginalName());//guarda la imagen en: \qa-grupo7\Tienda_Virtual\storage\app\images
              $imagenNombre = $imagen->getClientOriginalName();
        }
        else {
          return redirect()->back()->with('flash_message_error', 'Es necesario agregar una imagen al Producto.');
        }
        Producto::where(['idProducto'=>$id])->update(['nombre'=>$datos['nombre'], 'descripcion'=>$datos['descripcion'], 'imagen'=>$imagenNombre,'precio'=>$datos['precio'], 'stock'=>$datos['disponibles']]);
        DB::table('categoria_x_producto')->where(['Producto_idProducto'=>$id])->update(['Categoria_idCategoria'=>$datos['categorias']]);
    	 	return redirect('/admin/indexProducto')->with('flash_message_success', '¡El Producto ha sido actualizado correctamente!');
    	}
    	$detallesProducto = Producto::where(['idProducto'=>$id])->first();
      $categoriaProducto = DB::table('Categoria_x_Producto')->select('Categoria_idCategoria')->where(['Producto_idProducto'=>$id])->get()[0]->Categoria_idCategoria;
      $categorias = Categoria::where(['condicion'=>1])->get();
      $listadoCategorias = "<option value='' selected disabled>Elija una opción</option>";
      foreach ($categorias as $cat) {
          $selected = "";
          if ($cat->idCategoria == $categoriaProducto) {
              $selected = "selected";
          }
          $listadoCategorias .= "<option value='".$cat->idCategoria."' ".$selected." >".$cat->nombre."</option>";
      }
    	return view('admin.producto.editarProducto')->with(compact('detallesProducto','listadoCategorias'));
    }

    public function eliminarProducto($id) {
      /**/
      $user = Session::get('frontSession','NULL');
      if( $user == 'NULL' || !$user->admin){//Revisa que haya un usuario logueado y que sea admin
          return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
      }        
    	if (!empty($id)) {
        DB::delete('delete from categoria_x_producto where Producto_idProducto = '.$id);
        DB::delete('delete from Producto where idProducto = '.$id);
    		return redirect()->back()->with('flash_message_success', '¡El producto ha sido eliminado correctamente!');
    	}
    }
}
