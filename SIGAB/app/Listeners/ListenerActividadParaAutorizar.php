<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\User;
use App\Notifications\NotificacionActividadParaAutorizar;
use App\Events\EventActividadParaAutorizar;

class ListenerActividadParaAutorizar
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
    public function handle(EventActividadParaAutorizar $event)
    {

        $usuarios = User::where('rol', '=', '1')->get();

        foreach ($usuarios as $usuario) {
            $usuario->notify(new NotificacionActividadParaAutorizar($event->actividad));
        }
    }
}
