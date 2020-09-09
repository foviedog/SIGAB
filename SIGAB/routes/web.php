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
});

Auth::routes([
    //'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/listadoEstudiantil', 'EstudianteController@index');

/* Rutas para informacion laboral */
Route::post('/trabajo', 'TrabajoController@store');
Route::get('/trabajo/{id_estudiante}', 'TrabajoController@create');


/* Rutas para informacion de estudiantes */
Route::get('/estudiante/registrar', 'EstudianteController@create')->name('estudiante.create');
Route::post('/estudiante', 'EstudianteController@store');
