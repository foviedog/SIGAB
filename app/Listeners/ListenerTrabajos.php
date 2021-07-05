<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventTrabajos;
use App\Notifications\Trabajos\NotificarAgregarTrabajo;
use App\Notifications\Trabajos\NotificarModificarTrabajo;
use App\Notifications\Trabajos\NotificarEliminarTrabajo;
use App\User;

class ListenerTrabajos
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
    public function handle(EventTrabajos $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '3')
                                ->orWhere('rol', '=', '4')
                                ->orWhere('rol', '=', '7')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarAgregarTrabajo($event->trabajo, auth()->user()->persona_id));
                }
            }
            break;
            case 2: {
                $usuarios = User::where('rol', '=', '4')
                                ->orWhere('rol', '=', '7')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarModificarTrabajo($event->trabajo, auth()->user()->persona_id));
                }
            }
            break;
            case 3: {
                $usuarios =User::where('rol', '=', '3')
                                ->orWhere('rol', '=', '4')
                                ->orWhere('rol', '=', '7')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarEliminarTrabajo($event->trabajo, auth()->user()->persona_id));
                }
            }
            break;
        }
    }
}
