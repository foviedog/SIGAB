<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Listeners\ListenerActividades;
use App\Events\EventActividades;

use App\Listeners\ListenerEstudiantes;
use App\Events\EventEstudiantes;

use App\Listeners\ListenerTrabajos;
use App\Events\EventTrabajos;

use App\Listeners\ListenerTitulos;
use App\Events\EventTitulos;

use App\Listeners\ListenerGuiasAcademicas;
use App\Events\EventGuiasAcademicas;

use App\Listeners\ListenerPersonal;
use App\Events\EventPersonal;

use App\Listeners\ListenerListaAsistencia;
use App\Events\EventListaAsistencia;

use App\Listeners\ListenerEvidencias;
use App\Events\EventEvidencias;

use App\Listeners\ListenerUsuarios;
use App\Events\EventUsuarios;

//Se añaden el Listener y el Event creados
use App\Listeners\ListenerCursos;
use App\Events\EventCursos;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EventActividades::class =>[
            ListenerActividades::class
        ],
        EventEstudiantes::class =>[
            ListenerEstudiantes::class
        ],
        EventTrabajos::class =>[
            ListenerTrabajos::class
        ],
        EventTitulos::class =>[
            ListenerTitulos::class
        ],
        EventGuiasAcademicas::class =>[
            ListenerGuiasAcademicas::class
        ],
        EventPersonal::class =>[
            ListenerPersonal::class
        ],
        EventListaAsistencia::class =>[
            ListenerListaAsistencia::class
        ],
        EventEvidencias::class =>[
            ListenerEvidencias::class
        ],
        EventUsuarios::class =>[
            ListenerUsuarios::class
        ],
        //Se añaden de la siguiente manera:
        EventCursos::class =>[
            ListenerCursos::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
