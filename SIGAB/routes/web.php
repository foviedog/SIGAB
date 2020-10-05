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

/* Ruta principal */
Route::get('/home', function () {
    return view('home');
})->name('home');

/* Ruta para registrar usuario */
Route::get('/register', 'RegistroController@index')->name('register');
Route::post('/registroselper', 'RegistroController@show');
Route::post('/registro', 'RegistroController@register');

/* Ruta del auth */
Auth::routes([
    'register' => false, // Desactivado el auth con el registro
    'reset' => false, // Desactivado el auth con el reset de contraseñas
    'verify' => false, // Desactivado el auth con la verificación de email
]);
// ======================================================================================================================================
//                                                           Control Estudiantil
// ======================================================================================================================================


/* Ruta de detalle del estudiante*/
Route::get('/estudiante/detalle/{id_estudiante}', 'EstudianteController@show');
/* Rutas para editar  y actualizar la informacion del estudiante*/
Route::patch('/estudiante/detalle/{id_estudiante}', 'EstudianteController@update')->name('estudiante.update');
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
Route::patch('/estudiante/trabajo/registrar', 'TrabajoController@store')->name('trabajo.store');
Route::get('/estudiante/trabajo/registrar/{id_estudiante}', 'TrabajoController@create');
Route::get('/estudiante/trabajo/obtener/{id_trabajo}', 'TrabajoController@edit');
Route::patch('/estudiante/trabajo/actualizar/{id_trabajo}', 'TrabajoController@update');

/* Rutas para informacion de Graduados */
Route::get('/estudiante/graduacion/{id_estudiante}', 'GraduadoController@show')->name('graduado.show');
Route::get('/estudiante/graduacion/registrar/{id_estudiante}', 'GraduadoController@create')->name('graduado.create');
Route::patch('/estudiante/graduacion', 'GraduadoController@store')->name('graduado.store');
Route::get('/estudiante/graduacion/obtener/{id_graduacion}', 'GraduadoController@edit');
Route::patch('/estudiante/graduacion/actualizar/{id_graduacion}', 'GraduadoController@update');

// ======================================================================================================================================
//                                                           Control de Personal
// ======================================================================================================================================
/* Ruta de detalle del estudiante*/
Route::get('/personal/registrar', 'PersonalController@create');
Route::get('/personal/listar', 'PersonalController@index')->name('personal.listar');

// ======================================================================================================================================
//                                                           Control de Actividades Internas
// ======================================================================================================================================
/* Rutas para informacion de actividades internas */
Route::get('/actividad-interna/registrar', 'ActividadesInternaController@create')->name('actividad-interna.create');
Route::post('/actividad-interna', 'ActividadesInternaController@store');