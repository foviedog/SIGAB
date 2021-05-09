<?php

use Illuminate\Support\Facades\Route;

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

/* Ruta principal que lleva al login */

Route::get('/', function () {
    return view('auth.login');
});

/* Ruta del auth */
Auth::routes([
    'register' => false, // Desactivado el auth con el registro
    'reset' => false, // Desactivado el auth con el reset de contraseñas
    'verify' => false, // Desactivado el auth con la verificación de email
]);

Route::group(['middleware' => ['auth']], function () {

    /* Ruta principal */
    Route::get('/home', 'HomeController@index')->name('home');

    /* Ruta para registrar usuario */
    Route::get('/register', 'RegistroController@index')->name('register');
    Route::post('/registroselper', 'RegistroController@show')->name('registroselper');
    Route::post('/registro', 'RegistroController@register')->name('registro');

    /* Ruta para actualizar el rol */
    Route::get('/cambiar-rol', 'RegistroController@cambiarRol')->name('cambiar-rol');
    Route::post('/cambiar-rol', 'RegistroController@mostrarPersonaRol')->name('cambiar-rol.show');
    Route::patch('/cambiar-rol', 'RegistroController@actualizarRol')->name('cambiar-rol.update');

    //Esta ruta genera un script que protege que algunos datos sensibles sean visibles directamente en
    //el código fuente de la página
    Route::get('/js/scriptglobal.js', 'HomeController@scriptGeneral')->name('script.global');

});
