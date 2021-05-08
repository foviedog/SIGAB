<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventTitulos;
use App\Notifications\Titulos\NotificarAgregarTitulo;
use App\Notifications\Titulos\NotificarModificarTitulo;
use App\Notifications\Titulos\NotificarEliminarTitulo;
use App\User;

class ListenerTitulos
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
    public function handle(EventTitulos $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarAgregarTitulo($event->graduado, auth()->user()->persona_id));
                }
            }
            break;
            case 2: {
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarModificarTitulo($event->graduado, auth()->user()->persona_id));
                }
            }
            break;
            case 3: {
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarEliminarTitulo($event->graduado, auth()->user()->persona_id));
                }
            }
            break;
        }
    }
}
