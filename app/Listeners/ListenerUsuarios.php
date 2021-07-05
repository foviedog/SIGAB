<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventUsuarios;
use App\Notifications\Usuarios\NotificarInicioSesion;
use App\Notifications\Usuarios\NotificarUsuarioAgregado;
use App\Notifications\Usuarios\NotificarCambiarRol;
use App\User;

class ListenerUsuarios
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
    public function handle(EventUsuarios $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '4')
                                ->orWhere('rol', '=', '7')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarInicioSesion($event->usuario, auth()->user()->persona_id));
                }
            }
            break;
            case 2:{
                $usuarios = User::where('rol', '=', '1')
                                ->orWhere('rol', '=', '2')
                                ->orWhere('rol', '=', '3')
                                ->orWhere('rol', '=', '4')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarUsuarioAgregado($event->usuario, auth()->user()->persona_id));
                }
            }
            break;
            case 3:{
                $usuarios = User::where('rol', '=', '1')
                                ->orWhere('rol', '=', '2')
                                ->orWhere('rol', '=', '3')
                                ->orWhere('rol', '=', '4')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarCambiarRol($event->usuario, auth()->user()->persona_id));
                }
            }
            break;
        }
    }
}
