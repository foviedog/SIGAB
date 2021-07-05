<?php

namespace App\Notifications\Personal;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;

class NotificarEliminarPersonal extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($personal, $persona_id)
    {
        $persona = Persona::find($persona_id);
        $personaEliminda = Persona::find($personal->persona_id);
        $mensaje = $persona->nombre." ".$persona->apellido." ha eliminado un miembro del personal.";
        $url = route('personal.listar');
        $this->dataSet = [
            'id' => $personal->persona_id,
            'persona_id' => $persona->persona_id,
            'nombre' => $persona->nombre." ".$persona->apellido,
            'imagen_perfil' => $persona->imagen_perfil,
            'informacion' => "ha eliminado un miembro del personal: ".$personaEliminda->nombre." ".$personaEliminda->apellido.".",
            'color' => 'roja',
            'icono' => '<i class="fas fa-user-times"></i>',
            'modelo' => 'personal',
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
