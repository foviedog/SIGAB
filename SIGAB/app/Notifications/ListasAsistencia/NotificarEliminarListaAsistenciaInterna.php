<?php

namespace App\Notifications\ListasAsistencia;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Persona;

class NotificarEliminarListaAsistenciaInterna extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($personaEli, $actividad, $persona_id)
    {
        $persona = Persona::find($persona_id);
        $personaEliminada = Persona::find($personaEli);
        $mensaje = $persona->nombre." ".$persona->apellido." ha eliminado a un participante: ".$personaEliminada->nombre." ".$personaEliminada->apellido.".";
        $url = route('lista-asistencia.show', $actividad);
        $this->dataSet = [
            'id' => $actividad,
            'persona_id' => $persona->persona_id,
            'nombre' => $persona->nombre." ".$persona->apellido,
            'imagen_perfil' => $persona->imagen_perfil,
            'informacion' => "ha eliminado a un participante: ".$personaEliminada->nombre." ".$personaEliminada->apellido.".",
            'color' => 'roja',
            'icono' => '<i class="fas fa-user-slash"></i>',
            'modelo' => 'lista_asistencia',
            'actividad' => 'interna',
            'mensaje' => $mensaje,
            'url' => $url
        ];
    }

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
