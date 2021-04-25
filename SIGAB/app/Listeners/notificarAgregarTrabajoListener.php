<?php

namespace App\Listeners;

use App\User;
use App\Events\notificarAgregarTrabajo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\notificacionAgregarTrabajo;

class notificarAgregarTrabajoListener
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
    public function handle(notificarAgregarTrabajo $event)
    {
        $usuarios = User::where('persona_id', '=', '5678')->get();

        foreach ($usuarios as $usuario) {
            $usuario->notify(new notificacionAgregarTrabajo($event->trabajo));
        }
    }
}
