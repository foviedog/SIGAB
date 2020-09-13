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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/register', 'RegistroController@index')->name('register');
Route::post('/registroselper', 'RegistroController@show');
Route::post('/registro', 'RegistroController@register');

Auth::routes([
    'register' => false, // Desactivado el auth con el registro
    'reset' => false, // Desactivado el auth con el reset de contrasennas
    'verify' => false, // Desactivado el auth con la verificacion de email
]);



// Muestra el listado de los estudiantes ordenados por su apellido
Route::get('/listadoEstudiantil', 'EstudianteController@index')->name('listadoEstudiantil');

/* Ruta de detalle del estudiante*/
Route::get('/estudiante/detalle/{id_estudiante}', 'EstudianteController@show');


/* Rutas para informacion laboral */
Route::get('/trabajo/{id_estudiante}', 'TrabajoController@index');
Route::post('/trabajo/registrar', 'TrabajoController@store')->name('trabajo.store');
Route::get('/trabajo/registrar/{id_estudiante}', 'TrabajoController@create');


/* Rutas para informacion de estudiantes */
Route::get('/estudiante/registrar', 'EstudianteController@create')->name('estudiante.create');
Route::post('/estudiante', 'EstudianteController@store');
