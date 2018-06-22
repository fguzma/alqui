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
//Route::get('/prueba','ClienteController@prueba');

//CLIENTE
Route::resource('/cliente','ClienteController');
Route::get('/clientev/{valor?}/{valor2?}','ClienteController@index');//luego de agregar un cliente redireccionamos al index
Route::get('/vercliente/{valor?}','ClienteController@agregado');//Hacer lo mismo que en el index pero con un parametro desde el inicio
Route::get('/filtrocliente/{valor?}/{valor2?}','ClienteController@lista');//llamar a la funcion lista enviando parametro opcional

//Personal
Route::resource('/personal','PersonalController');
Route::get('personalv/{valor?}/{valor2?}','PersonalController@index');
Route::get('/verpersonal/{valor?}','PersonalController@agregado');//Hacer lo mismo que en el index pero con un parametro desde el inicio
Route::resource('/personalA','PersonalController@create');
Route::get('/filtropersonal/{valor?}/{valor2?}','PersonalController@lista');//llamar a la funcion lista enviando parametro opcional
Route::post('/personalcargo','PersonalController@agregarcargo');
Route::post('/pcargoupdate','PersonalController@actualizarcargos');//No se si deberia ir aca

//INVENTARIO
Route::resource('/inventario','InventarioController');
Route::get('/inventariov/{valor?}/{valor2?}/{valor3?}','InventarioController@index');
Route::resource('/inventarioA','InventarioController@create');
Route::get('/mensaje/{valor?}/{valor2?}','InventarioController@mensaje');//Deberia crear un controlador solo para esto ?
Route::get('/filtroinventario/{valor1?}/{valor2?}','InventarioController@lista');//llamar a la funcion lista enviando parametro opcional

//Servicio
Route::resource('/servicio','ServicioController');
Route::get('/serviciov/{valor?}/{valor2?}/{valor3?}','ServicioController@index');
Route::get('/filtroservicio/{valor?}','ServicioController@lista');//llamar a la funcion lista enviando parametro opcional

//RESERVACION
Route::resource('/reservacion','ReservacionController');
Route::get('/reservacliente/{valor?}','ReservacionController@index');//Retorna la vista de agregar reservacion con los datos del cliente
Route::get('/add','ReservacionController@listing');
Route::resource('pdf', 'PdfController');
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
Route::get('/filtrocargo/{valor?}','CargosController@lista');

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
