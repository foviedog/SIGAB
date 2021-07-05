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

class NotificarUsuarioAgregado extends Notification implements ShouldBroadcast
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
        $personaAgregada = Persona::find($usuario->persona_id);
        $rol = GlobalArrays::ROLES_USUARIO[$usuario->rol - 1];
        $mensaje = $persona->nombre." ".$persona->apellido." ha agregado un nuevo usuario al sistema: ".$personaAgregada->nombre." ".$personaAgregada->apellido." con el rol de ".$rol.".";
        $this->dataSet = [
            'id' => $usuario->persona_id,
            'persona_id' => $persona->persona_id,
            'nombre' => $persona->nombre." ".$persona->apellido,
            'imagen_perfil' => $persona->imagen_perfil,
            'informacion' => "ha agregado un nuevo usuario al sistema: ".$personaAgregada->nombre." ".$personaAgregada->apellido." con el rol de ".$rol.".",
            'color' => 'verde',
            'icono' => '<i class="fas fa-user-plus"></i>',
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
