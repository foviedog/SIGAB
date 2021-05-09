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
    public function __construct($personaEli, $actividad, $persona_id)
    {
        $persona = Persona::find($persona_id);
        $personaEliminada = asistenciaPromocion::where('cedula', $personaEli)
            ->where("actividad_id", $actividad)->first();
        $mensaje = $persona->nombre." ".$persona->apellido." ha eliminado a un participante: ".$personaEliminada->nombre." ".$persona->personaEliminada.".";
        $url = route('asistencia-promocion.show', $actividad);
        $this->dataSet = [
            'id' => $actividad,
            'persona_id' => $persona->persona_id,
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
