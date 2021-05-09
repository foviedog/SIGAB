<?php

use Illuminate\Support\Facades\Route;

// ======================================================================================================================================
//                                                           Control de perfil
// ======================================================================================================================================

Route::group(['middleware' => ['auth']], function () {

    /* Ruta para acceder a las notificaciones */
    Route::get('/perfil/notificaciones', 'PersonaController@notifications')->name('perfil.notifications');
    /* Ruta para obtener la cantidad de notificaciones */
    Route::get('/perfil/cant-notificaciones', 'PersonaController@obtenerNotificaciones')->name('perfil.cant.notifications');
    /* Ruta para acceder a mis actividades */
    Route::get('/perfil/mis-actividades', 'PersonaController@misActividades')->name('perfil.mis-actividades');
    /* Ruta para acceder actualizar contraseña */
    Route::get('/perfil/actualizar-contrasenna', 'PersonaController@cambiarContrasenna')->name('perfil.actualizar-contrasenna');
    /* Ruta para acceder a mis actividades */
    Route::patch('/perfil/actualizar-contrasenna', 'PersonaController@actualizarContrasenna')->name('perfil.actualizar-contrasenna');
    /* Ruta de detalle del perfil*/
    Route::get('/perfil', 'PersonaController@show')->name('perfil.show');
    /* Ruta de update del perfil*/
    Route::patch('/perfil/{persona_id}', 'PersonaController@update')->name('perfil.update');

});