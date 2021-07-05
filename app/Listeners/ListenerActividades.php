<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventActividades;
use App\Notifications\Actividades\NotificarActividadParaAutorizar;
use App\Notifications\Actividades\NotificarActividadAutorizada;
use App\Notifications\Actividades\NotificarModificarActividad;
use App\Notifications\Actividades\NotificarEliminarActividad;
use App\User;

class ListenerActividades
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventActividades $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '1')
                                ->orWhere('rol', '=', '2')
                                ->orWhere('rol', '=', '3')
                                ->orWhere('rol', '=', '4')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarActividadParaAutorizar($event->actividad, $event->tipoActividad));
                }
            }
            break;
            case 2:{
                $usuarios = User::where('rol', '=', '1')
                                ->orWhere('rol', '=', '2')
                                ->orWhere('rol', '=', '3')
                                ->orWhere('rol', '=', '4')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarActividadAutorizada($event->actividad, $event->tipoActividad));
                }
            }
            break;
            case 3:{
                $usuarios = User::where('rol', '=', '4')
                                ->orWhere('rol', '=', '7')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarModificarActividad($event->actividad, $event->tipoActividad));
                }
            }
            break;
            case 4:{
                $usuarios = User::where('rol', '=', '3')
                                ->orWhere('rol', '=', '4')
                                ->orWhere('rol', '=', '7')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarEliminarActividad($event->actividad, $event->tipoActividad));
                }
            }
            break;
        }
    }
}
