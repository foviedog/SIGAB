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
        $this->persona = Persona::find(auth()->user()->persona_id);
        $this->actividad = $actividad;
        $this->tipoActividad = $tipoActividad;
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
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha autorizado una actividad: ".$this->actividad->tema.".";
        switch($this->tipoActividad){
            case 1: {
                return [
                    'id' => $this->actividad->id,
                    'modelo' => 'actividad',
                    'actividad' => 'interna',
                    'mensaje' => $mensaje
                ];
            }
            break;
            case 2: {
                return [
                    'id' => $this->actividad->id,
                    'modelo' => 'actividad',
                    'actividad' => 'promocion',
                    'mensaje' => $mensaje
                ];
            }
            break;
        }
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha autorizado una actividad: ".$this->actividad->tema.".";
        switch($this->tipoActividad){
            case 1: {
                return new BroadcastMessage([
                    'id' => $this->actividad->id,
                    'modelo' => 'actividad',
                    'actividad' => 'interna',
                    'mensaje' => $mensaje
                ]);
            }
            break;
            case 2: {
                return new BroadcastMessage([
                    'id' => $this->actividad->id,
                    'modelo' => 'actividad',
                    'actividad' => 'promocion',
                    'mensaje' => $mensaje
                ]);
            }
            break;
        }
    }
}
