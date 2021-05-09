<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventListaAsistencia;
use App\Notifications\ListasAsistencia\NotificarEliminarListaAsistenciaInterna;
use App\Notifications\ListasAsistencia\NotificarEliminarListaAsistenciaPromocion;
use App\User;

class ListenerListaAsistencia
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
    public function handle(EventListaAsistencia $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '3')
                                ->orWhere('rol', '=', '4')
                                ->orWhere('rol', '=', '7')->get();
                if($event->tipoActividad == 1){
                    foreach ($usuarios as $usuario) {
                        $usuario->notify(new NotificarEliminarListaAsistenciaInterna($event->persona, $event->actividad, $event->tipoActividad, auth()->user()->persona_id));
                    }
                } else {
                    foreach ($usuarios as $usuario) {
                        $usuario->notify(new NotificarEliminarListaAsistenciaPromocion($event->persona, $event->actividad, $event->tipoActividad, auth()->user()->persona_id));
                    }
                }
                
            }
            break;
        }
    }
}
