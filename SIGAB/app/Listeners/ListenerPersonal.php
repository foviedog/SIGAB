<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventPersonal;
use App\Notifications\Personal\NotificarAgregarPersonal;
use App\Notifications\Personal\NotificarModificarPersonal;
use App\Notifications\Personal\NotificarEliminarPersonal;
use App\User;

class ListenerPersonal
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
    public function handle(EventPersonal $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarAgregarPersonal($event->personal, auth()->user()->persona_id));
                }
            }
            break;
            case 2: {
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarModificarPersonal($event->personal, auth()->user()->persona_id));
                }
            }
            break;
            case 3: {
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarEliminarPersonal($event->personal, auth()->user()->persona_id));
                }
            }
            break;
        }
    }
}
