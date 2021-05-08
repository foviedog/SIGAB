<?php

namespace App\Notifications\Evidencias;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;

class NotificarEliminarEvidencia extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($evidencia, $persona_id)
    {
        $this->persona = Persona::find($persona_id);
        $this->evidencia = $evidencia;
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
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado una evidencia: ".$this->evidencia->nombre_archivo.".";
        return [
            'id' => $this->evidencia->actividad_id,
            'modelo' => 'evidencia',
            'mensaje' => $mensaje
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado una evidencia: ".$this->evidencia->nombre_archivo.".";
        return new BroadcastMessage([
            'id' => $this->evidencia->actividad_id,
            'modelo' => 'evidencia',
            'mensaje' => $mensaje
        ]);
    }
}
