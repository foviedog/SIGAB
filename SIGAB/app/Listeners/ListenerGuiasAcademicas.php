<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\EventGuiasAcademicas;
use App\Notifications\Guias\NotificarAgregarGuia;
use App\Notifications\Guias\NotificarModificarGuia;
use App\Notifications\Guias\NotificarEliminarGuia;
use App\User;

class ListenerGuiasAcademicas
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
    public function handle(EventGuiasAcademicas $event)
    {
        switch($event->accion){
            case 1:{
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarAgregarGuia($event->guia, auth()->user()->persona_id));
                }
            }
            break;
            case 2: {
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarModificarGuia($event->guia, auth()->user()->persona_id));
                }
            }
            break;
            case 3: {
                $usuarios = User::where('rol', '=', '1')->get();
                foreach ($usuarios as $usuario) {
                    $usuario->notify(new NotificarEliminarGuia($event->guia, auth()->user()->persona_id));
                }
            }
            break;
        }
    }
}
