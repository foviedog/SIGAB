<?php

namespace App\Notifications\ListasAsistencia;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\asistenciaPromocion;
use App\Persona;

class NotificarEliminarListaAsistenciaPromocion extends Notification implements ShouldBroadcast
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
        $this->personaEliminada = asistenciaPromocion::where('cedula', $persona)
            ->where("actividad_id", $actividad)->first();
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
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado a un participante: ".$this->personaEliminada->nombre." ".$this->personaEliminada->apellidos.".";
        return [
            'id' => $this->actividad,
            'modelo' => 'lista_asistencia',
            'actividad' => 'promocion',
            'mensaje' => $mensaje
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $mensaje = $this->persona->nombre." ".$this->persona->apellido." ha eliminado a un participante: ".$this->personaEliminada->nombre." ".$this->personaEliminada->apellidos.".";
        return new BroadcastMessage([
            'id' => $this->actividad,
            'modelo' => 'lista_asistencia',
            'actividad' => 'promocion',
            'mensaje' => $mensaje
        ]);
    }
}
