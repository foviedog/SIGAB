<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapRutasControlEstudiantil();

        $this->mapRutasControlPersonal();

        $this->mapRutasControlActividadesInternas();

        $this->mapRutasControlActividadesPromocion();

        $this->mapRutasControlEstadisticas();

        $this->mapRutasControlPerfil();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapRutasControlEstudiantil(){
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/control_estudiantil.php'));
    }

    protected function mapRutasControlPersonal(){
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/control_personal.php'));
    }

    protected function mapRutasControlActividadesInternas(){
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/control_actividades_internas.php'));
    }

    protected function mapRutasControlActividadesPromocion(){
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/control_actividades_promocion.php'));
    }

    protected function mapRutasControlEstadisticas(){
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/control_estadisticas.php'));
    }

    protected function mapRutasControlPerfil(){
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/control_perfil.php'));
    }

}
