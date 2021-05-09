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
        $this->persona = Persona::find($persona_id);
        $this->personaRol = Persona::find($usuario->persona_id);
        $this->usuario = $usuario;
        $this->rol = GlobalArrays::ROLES_USUARIO[$usuario->rol - 1];
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
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha cambiado el rol a ".$this->personaRol->nombre." ".$this->personaRol->apellido.": ".$this->rol.".";
        return [
            'id' => $this->usuario->persona_id,
            'persona_id' => $this->persona->persona_id,
            'modelo' => 'usuario',
            'mensaje' => $mensaje
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha cambiado el rol a ".$this->personaRol->nombre." ".$this->personaRol->apellido.": ".$this->rol.".";
        return new BroadcastMessage([
            'id' => $this->usuario->persona_id,
            'persona_id' => $this->persona->persona_id,
            'modelo' => 'usuario',
            'mensaje' => $mensaje
        ]);
    }
}
