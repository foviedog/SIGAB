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
    Route::get('/register', 'RegistroController@index')->name('register')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');
    Route::post('/registroselper', 'RegistroController@show')->name('registroselper')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');
    Route::post('/registro', 'RegistroController@register')->name('registro')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    /* Ruta para actualizar el rol */
    Route::get('/cambiar-rol', 'RegistroController@cambiarRol')->name('cambiar-rol')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');
    Route::post('/cambiar-rol', 'RegistroController@mostrarPersonaRol')->name('cambiar-rol.show')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');
    Route::patch('/cambiar-rol', 'RegistroController@actualizarRol')->name('cambiar-rol.update')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    //Esta ruta genera un script que protege que algunos datos sensibles sean visibles directamente en
    //el código fuente de la página
    Route::get('/js/scriptglobal.js', 'HomeController@scriptGeneral')->name('script.global');

});