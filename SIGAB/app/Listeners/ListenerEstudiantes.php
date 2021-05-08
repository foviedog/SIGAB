<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventEstudiantes;
use App\Notifications\Estudiantes\NotificarAgregarEstudiante;
use App\Notifications\Estudiantes\NotificarModificarEstudiante;
use App\Notifications\Estudiantes\NotificarEliminarEstudiante;
use App\User;

class ListenerEstudiantes
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
    public function handle(EventEstudiantes $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarAgregarEstudiante($event->estudiante, auth()->user()->persona_id));
                }
            }
            break;
            case 2: {
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarModificarEstudiante($event->estudiante, auth()->user()->persona_id));
                }
            }
            break;
            case 3: {
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarEliminarEstudiante($event->estudiante, auth()->user()->persona_id));
                }
            }
            break;
        }
    }
}
