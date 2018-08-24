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

Route::get('/','FrontController@index');
Route::get('/principal','FrontController@principal');
//Route::get('/users','FrontController@users');
//Route::get('/log','FrontController@log');
Route::get('/landing','FrontController@landing');

//CLIENTE
Route::resource('/cliente','ClienteController');
Route::get('/clientev/{valor?}/{valor2?}','ClienteController@index');//luego de agregar un cliente redireccionamos al index
Route::get('/filtrocliente/{valor?}/{valor2?}','ClienteController@lista');//llamar a la funcion lista enviando parametro opcional

//Personal
Route::resource('/personal','PersonalController');
Route::get('personalv/{valor?}/{valor2?}','PersonalController@index');
Route::post('/personalcargo','PersonalController@agregarcargo');
Route::post('/pcargoupdate','PersonalController@actualizarcargos');//No se si deberia ir aca
Route::get('/cargopersonal/{cedula?}','PersonalController@cargos');

//INVENTARIO
Route::resource('/inventario','InventarioController');
Route::get('/inventariov/{valor?}/{valor2?}/{valor3?}','InventarioController@index');
Route::resource('/inventarioA','InventarioController@create');
Route::get('/filtroinventario/{valor1?}/{valor2?}','InventarioController@lista');//llamar a la funcion lista enviando parametro opcional

//Servicio
Route::resource('/servicio','ServicioController');
Route::get('/serviciov/{valor?}/{valor2?}/{valor3?}','ServicioController@index');
Route::get('/filtroservicio/{valor?}','ServicioController@lista');//llamar a la funcion lista enviando parametro opcional

//RESERVACION
Route::resource('/reservacion','ReservacionController');
Route::get('/reservacliente/{valor?}','ReservacionController@index');//Retorna la vista de agregar reservacion con los datos del cliente
Route::post('/reservamenu','ReservacionController@menu');
Route::get('/recargaarticulos/{valor1}/{valor2}','ReservacionController@recargaarticulos');
Route::resource('reserva','ReservasController');
Route::get('/filtroreservas/{valor1?}/{valor2?}','ReservasController@lista');//llamar a la funcion lista enviando parametro opcional

//usuario
Route::resource('/usuario','usuariocontroller');
Route::get('/usuariov/{valor?}/{valor2?}','usuariocontroller@index');
Route::get('/userexist/{valor1}/{valor2}','usuariocontroller@existe');//verificar si existe el correo o el name
Route::get('/filtrousuario/{valor1?}/{valor2?}','usuariocontroller@lista');

//cargo
Route::resource('/cargo','CargosController');
Route::get('/cargov/{valor?}/{valor2?}','CargosController@index');
Route::post('/cargosave','CargosController@guardar');
Route::get('/listacargo','CargosController@recargarlista');

//vetado create
Route::resource('/vetado','vetadocontroller');
Route::get('/vetado/{valor0?}/{valor1?}/{valor2?}','vetadocontroller@index');
Route::get('/listacliente/{valor?}','vetadocontroller@listacliente');
Route::get('/listapersonal/{valor?}','vetadocontroller@listapersonal');
Route::post('/vetar','vetadocontroller@vetar');
//vetado index
Route::get('/descripcion/{valor?}/{valor2?}','vetadocontroller@descripcion');

//Menu
Route::resource('/menus','MenuController');
Route::get('/menus/{valor?}/{valor2?}','MenuController@index');//luego de agregar un cliente redireccionamos al index

//imagenes
Route::get('/imagenes','ImageController@index');
Route::post('/change/image', [
    'uses' => 'ImageController@changeImg',
    'as' => 'changeImage'
]);
Route::post('/change/video', [
    'uses' => 'ImageController@changeVid',
    'as' => 'changeVideo'
]);
Route::post('/changeModal', [
    'uses' => 'ImageController@changeInModal',
    'as' => 'changeModal'
]);

Route::resource('/calendario','CalendarController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
