<?php

namespace App\Notifications\Actividades;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;

class NotificarActividadAutorizada extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($actividad, $tipoActividad)
    {
        $persona = Persona::find(auth()->user()->persona_id);

        switch($tipoActividad){
            case 1: {
                $mensaje = $persona->nombre." ".$persona->apellido." ha autorizado una actividad: ".$actividad->tema.".";
                $url = route('actividad-interna.show', $actividad->id);
                $this->dataSet = [
                    'id' => $actividad->id,
                    'persona_id' => $persona->persona_id,
                    'nombre' => $persona->nombre." ".$persona->apellido,
                    'imagen_perfil' => $persona->imagen_perfil,
                    'informacion' => "ha autorizado una actividad: ".$actividad->tema.".",
                    'color' => 'verde',
                    'icono' => '<i class="fas fa-lock-open"></i>',
                    'modelo' => 'actividad',
                    'actividad' => 'interna',
                    'mensaje' => $mensaje,
                    'url' => $url
                ];
            }
            break;
            case 2: {
                $mensaje = $persona->nombre." ".$persona->apellido." ha autorizado una actividad: ".$actividad->tema.".";
                $url = route('actividad-promocion.show', $actividad->id);
                $this->dataSet = [
                    'id' => $actividad->id,
                    'persona_id' => $persona->persona_id,
                    'nombre' => $persona->nombre." ".$persona->apellido,
                    'imagen_perfil' => $persona->imagen_perfil,
                    'informacion' => "ha autorizado una actividad: ".$actividad->tema.".",
                    'color' => 'verde',
                    'icono' => '<i class="fas fa-lock-open"></i>',
                    'modelo' => 'actividad',
                    'actividad' => 'promocion',
                    'mensaje' => $mensaje,
                    'url' => $url
                ];
            }
            break;
        }
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->dataSet;
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->dataSet);
    }
}
