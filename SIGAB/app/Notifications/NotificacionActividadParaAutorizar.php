<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;

class NotificacionActividadParaAutorizar extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($actividad)
    {
        $this->actividad = $actividad;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
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
        $persona = Persona::find($this->actividad->creada_por);
        $mensaje = $persona->nombre." ".$persona->apellido." ha enviado una actividad para autorización.";
        return [
            'idActividad' => $this->actividad->id,
            'mensaje' => $mensaje
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $persona = Persona::find($this->actividad->creada_por);
        $mensaje = $persona->nombre." ".$persona->apellido." ha enviado una actividad para autorización.";
        return new BroadcastMessage([
            'mensaje' => $mensaje
        ]);
    }
}
