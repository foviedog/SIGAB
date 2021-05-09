<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventEvidencias;
use App\Notifications\Evidencias\NotificarEliminarEvidencia;
use App\User;

class ListenerEvidencias
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
    public function handle(EventEvidencias $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '3')
                                ->orWhere('rol', '=', '4')
                                ->orWhere('rol', '=', '7')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarEliminarEvidencia($event->evidencia, auth()->user()->persona_id));
                }
            }
            break;
        }
    }
}
