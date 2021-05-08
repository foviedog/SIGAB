<?php

namespace App\Notifications\Trabajos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;

class NotificarEliminarTrabajo extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trabajo, $persona_id)
    {
        $this->persona = Persona::find($persona_id);
        $this->trabajo = $trabajo;
        $this->persona_id = $persona_id;
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
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado información laboral para un estudiante.";
        return [
            'id' => $this->trabajo->persona_id,
            'modelo' => 'trabajo',
            'mensaje' => $mensaje
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado información laboral para un estudiante.";
        return new BroadcastMessage([
            'id' => $this->trabajo->persona_id,
            'modelo' => 'trabajo',
            'mensaje' => $mensaje
        ]);
    }
}
