<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('cliente/index');
});

//Admin - Inicio y Ciere de Sesión
Route::match(['get','post'],'/admin','AdminController@inicioSesion');
Route::get('/logout', 'AdminController@cierreSesion');
Auth::routes();

Route::group(['middleware' => ['auth']], function(){
  //Admin - Manejo de cuentas
	Route::get('/admin/inicio','AdminController@inicio');
	Route::match(['get', 'post'], '/admin/configuraciones', 'AdminController@configuraciones');
  Route::match(['get', 'post'], '/admin/crearAdmin', 'AdminController@crearUsuarioAdministrador');
	Route::post('/admin/revisarContrasena', 'AdminController@revisarContrasena');
	Route::match(['get','post'], '/admin/actualizarContrasena', 'AdminController@actualizarContrasena');
	//Admin - Manejo de Categorías
	Route::match(['get','post'], '/admin/agregarCategoria', 'CategoriaController@agregarCategoria');
	Route::get('/admin/indexCategoria', 'CategoriaController@indexCategoria');
	Route::match(['get','post'], '/admin/editarCategoria/{id}', 'CategoriaController@editarCategoria');
	Route::match(['get','post'], '/admin/eliminarCategoria/{id}', 'CategoriaController@eliminarCategoria');
	//Admin - Manejo de Productos
	Route::match(['get','post'], '/admin/agregarProducto', 'ProductoController@agregarProducto');
	Route::get('/admin/indexProducto', 'ProductoController@indexProducto');
	Route::match(['get','post'], '/admin/editarProducto/{id}', 'ProductoController@editarProducto');
	Route::match(['get','post'], '/admin/eliminarProducto/{id}', 'ProductoController@eliminarProducto');
});
// FrontEnd
Route::get('cliente','ClienteController@index');
Route::get('cliente/categories/{id}','ClienteController@filtrar');
Route::get('cliente/results','ClienteController@search');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('cliente/product/{id}','ClienteController@infoProducto');

Route::group(['middleware'=>['frontLogin']],function(){
  Route::match(['get','post'],'cuenta','UsuarioController@cuenta');
});
Route::get('/usuarios/inicioSesionRegistro','UsuarioController@inicioSesionRegistro');
Route::post('/usuarios/registrar','UsuarioController@registrar');
Route::get('usuarios/cierreSesion','UsuarioController@cerrarSesion');
Route::post('/usuarios/inicioSesion', 'UsuarioController@inicioSesion');


Route::match(['GET','POST'],'/usuarios/chequearEmail','UsuarioController@chequearEmail');

Route::match(['GET','POST'],'/usuarios/chequearEmail','UsuarioController@chequearEmail');

Route::get('/carrito/agregar/{id}','CarritoController@agregarItem');
Route::get('/cliente/cart','CarritoController@verCarrito');
Route::get('/carrito/eliminar','CarritoController@eliminarCarrito');
Route::get('/carrito/quitar/{id}','CarritoController@quitarDelCarrito');
Route::get('/carrito/pagar','CarritoController@pagar');

