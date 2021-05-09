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
    public function __construct($persona, $actividad, $tipoActividad, $persona_id)
    {
        $this->persona = Persona::find($persona_id);
        $this->personaEliminada = Persona::find($persona);
        $this->actividad = $actividad;
        $this->tipoActividad = $tipoActividad;
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
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado a un participante: ".$this->personaEliminada->nombre." ".$this->personaEliminada->apellido.".";
        return [
            'id' => $this->actividad,
            'persona_id' => $this->persona->persona_id,
            'modelo' => 'lista_asistencia',
            'actividad' => 'interna',
            'mensaje' => $mensaje
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado a un participante: ".$this->personaEliminada->nombre." ".$this->persona->personaEliminada.".";
        return new BroadcastMessage([
            'id' => $this->actividad,
            'persona_id' => $this->persona->persona_id,
            'modelo' => 'lista_asistencia',
            'actividad' => 'interna',
            'mensaje' => $mensaje
        ]);
    }
}
