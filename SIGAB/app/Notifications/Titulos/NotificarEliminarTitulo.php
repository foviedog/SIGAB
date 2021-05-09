<?php

namespace App\Notifications\Titulos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;

class NotificarEliminarTitulo extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($graduado, $persona_id)
    {
        $this->persona = Persona::find($persona_id);
        $this->graduado = $graduado;
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
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado una graduación a un estudiante.";
        return [
            'id' => $this->graduado->persona_id,
            'persona_id' => $this->persona->persona_id,
            'modelo' => 'graduado',
            'mensaje' => $mensaje
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado una graduación a un estudiante.";
        return new BroadcastMessage([
            'id' => $this->graduado->persona_id,
            'persona_id' => $this->persona->persona_id,
            'modelo' => 'graduado',
            'mensaje' => $mensaje
        ]);
    }
}
