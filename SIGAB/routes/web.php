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

Route::get('/register', 'RegistroController@index');
Route::post('/registroselper', 'RegistroController@mostrarFormulario');
Route::post('/registro', 'RegistroController@registro');

Auth::routes([
    'register' => false, // Desactivado el auth con el registro
    'reset' => false, // Desactivado el auth con el reset de contrasennas
    'verify' => false, // Desactivado el auth con la verificacion de email
]);

Route::get('/listadoEstudiantil', 'EstudianteController@index');
/* Ruta de detalle del estudiante*/
Route::get('/detalle/{id_estudiante}', 'EstudianteController@show');


/* Rutas para informacion laboral */
Route::post('/trabajo', 'TrabajoController@store');
Route::get('/trabajo/{id_estudiante}', 'TrabajoController@create');


/* Rutas para informacion de estudiantes */
Route::get('/estudiante/registrar', 'EstudianteController@create')->name('estudiante.create');
Route::post('/estudiante', 'EstudianteController@store');


