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
        $persona = Persona::find($persona_id);
        $mensaje = $persona->nombre." ".$persona->apellido." ha eliminado información laboral para un estudiante.";
        $url = route('trabajo.listar', $trabajo->persona_id);
        $this->dataSet = [
            'id' => $trabajo->persona_id,
            'persona_id' => $persona->persona_id,
            'nombre' => $persona->nombre." ".$persona->apellido,
            'imagen_perfil' => $persona->imagen_perfil,
            'informacion' => "ha eliminado información laboral para un estudiante.",
            'color' => 'roja',
            'icono' => '<i class="fas fa-trash-alt"></i>',
            'modelo' => 'trabajo',
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
