<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

//Se añaden el evento, las diferentes notificaciones y el modelo de los usuarios para notificarles
use App\Events\EventCursos;
use App\Notifications\Cursos\NotificarAgregarCurso;
use App\User;

class ListenerCursos
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

    public function handle(EventCursos $event) //Se recibe el evento de tipo Cursos
    {
        switch($event->accion){ //Se verifica dependiendo de la acción
            case 1:{
                $usuarios = User::where('rol', '=', '3')
                                ->orWhere('rol', '=', '4')->get(); //Se asignan los usuarios a notificar
                //Por cada usuario se va a construir la notificación
                //Se envía el curso y la persona en sesión
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarAgregarCurso($event->curso, auth()->user()->persona_id));
                }
            }
            break;
        }
    }

}
