<?php

namespace App\Notifications\Cursos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

//Se llaman las siguientes clases:
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

//Se añade el modelo de Persona
use App\Persona;

class NotificarAgregarCurso extends Notification implements ShouldBroadcast //Se implementa esta clase
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    
    public function __construct($curso, $persona_id) //Se recibe el curso y el id de la persona que está actualmente en sesion
    {
        //Se construye el dataset

        $persona = Persona::find($persona_id);

        $mensaje = $persona->nombre." ".$persona->apellido." ha agregado un curso.";
        $url = route('cursos.show', $curso->codigo);
        $this->dataSet = [
            'id' => $curso->codigo,
            'persona_id' => $persona->persona_id,
            'nombre' => $persona->nombre." ".$persona->apellido,
            'imagen_perfil' => $persona->imagen_perfil,
            'informacion' => "ha agregado un curso.",
            'color' => 'verde',
            'icono' => '<i class="fas fa-plus-circle"></i>',
            'modelo' => 'curso',
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
        return ['database', 'broadcast']; //Tiene que ser 'database' y 'broadcast'
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    //Se añaden los siguientes métodos:
    public function toArray($notifiable)
    {
        return $this->dataSet;
    }

    public function toBroadcast($notifiable): BroadcastMessage //Este método debe implementar esta clase
    {
        return new BroadcastMessage($this->dataSet);
    }
}
