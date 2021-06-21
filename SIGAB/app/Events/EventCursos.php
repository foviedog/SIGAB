<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

//Se añade el modelo
use App\Curso;

class EventCursos
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    //Se crean los atributos: el curso y las diferentes acciones para notificar
    public $curso;
    public $accion;
    
    public function __construct(Curso $curso, $accion) //Se recibe por parámetro el curso y la acción
    {
        //Se inicializan
        $this->curso = $curso;
        $this->accion = $accion;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //El canal va a ser 'events'
        return new PrivateChannel('events');
    }
}
