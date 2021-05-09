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
        $persona = Persona::find($persona_id);
        $mensaje = $persona->nombre." ".$persona->apellido." ha eliminado una evidencia: ".$evidencia->nombre_archivo.".";
        $url = route('evidencias.show', $evidencia->actividad_id);
        $this->dataSet = [
            'id' => $evidencia->actividad_id,
            'persona_id' => $persona->persona_id,
            'modelo' => 'evidencia',
            'mensaje' => $mensaje,
            'url' => $url
        ];
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
        return $this->dataSet;
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->dataSet);
    }
}
