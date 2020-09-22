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

/* Ruta de detalle del estudiante*/
Route::get('/estudiante/detalle/{id_estudiante}', 'EstudianteController@show');
/* Rutas para editar  y actualizar la informacion del estudiante*/
Route::patch('/estudiante/detalle/{estudiante}', 'EstudianteController@update');
/* Ruta para cambiar imagen del estudiante*/
Route::post('/estudiante/imagen/cambiar', 'EstudianteController@update_avatar');

// Muestra el listado de los estudiantes ordenados por su apellido
Route::get('/listado-estudiantil', 'EstudianteController@index')->name('listado-estudiantil');
Route::get('/estudiantes/graduados/listar', 'GraduadoController@index')->name('graduados.listar');

/* Rutas para informacion de Guias academicas */
Route::patch('/estudiante/guia-academica/actualizar/{id_guia}', 'GuiasAcademicaController@update')->name('guia-academica.update');

Route::get('/estudiante/guia-academica/listar', 'GuiasAcademicaController@index')->name('guia-academica.listar');
Route::get('/estudiante/guia-academica/registrar/{id_estudiante}', 'GuiasAcademicaController@create')->name('guia-academica.create');
Route::get('/estudiante/guia-academica/{id_guia}', 'GuiasAcademicaController@show')->name('guia-academica.show');
Route::post('/estudiante/guia-academica', 'GuiasAcademicaController@store')->name('guia-academica.store');

/* Rutas para informacion de estudiantes */
Route::get('/estudiante/registrar', 'EstudianteController@create')->name('estudiante.create');
Route::post('/estudiante', 'EstudianteController@store');

/* Rutas para informacion laboral */
Route::get('/estudiante/trabajo/{id_estudiante}', 'TrabajoController@index');
Route::post('/estudiante/trabajo/registrar', 'TrabajoController@store')->name('trabajo.store');
Route::get('/estudiante/trabajo/registrar/{id_estudiante}', 'TrabajoController@create');
Route::get('/estudiante/trabajo/obtener/{id_trabajo}', 'TrabajoController@get');
Route::post('/estudiante/trabajo/actualizar/{id_trabajo}', 'TrabajoController@update');

/* Rutas para informacion de Graduados */
Route::get('/estudiante/graduacion/{id_estudiante}', 'GraduadoController@indexIndividual')->name('graduado.create');
Route::get('/estudiante/graduacion/registrar/{id_estudiante}', 'GraduadoController@create')->name('graduado.create');
Route::post('/estudiante/graduacion', 'GraduadoController@store')->name('graduado.store');
Route::get('/estudiante/graduacion/obtener/{id_graduacion}', 'GraduadoController@get');
Route::post('/estudiante/graduacion/actualizar/{id_graduacion}', 'GraduadoController@update');
