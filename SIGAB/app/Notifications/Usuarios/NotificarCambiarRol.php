<?php

namespace App\Notifications\Usuarios;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Helper\GlobalArrays;
use App\Persona;
use App\User;

class NotificarCambiarRol extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($usuario, $persona_id)
    {
        $persona = Persona::find($persona_id);
        $personaRol = Persona::find($usuario->persona_id);
        $usuario = $usuario;
        $rol = GlobalArrays::ROLES_USUARIO[$usuario->rol - 1];
        $mensaje = $persona->nombre." ".$persona->apellido." ha cambiado el rol a ".$personaRol->nombre." ".$personaRol->apellido.": ".$rol.".";
        $this->dataSet = [
            'id' => $usuario->persona_id,
            'persona_id' => $persona->persona_id,
            'modelo' => 'usuario',
            'mensaje' => $mensaje
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
