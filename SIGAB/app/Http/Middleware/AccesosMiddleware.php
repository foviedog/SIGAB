<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\DB;

class AccesosMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $accesoGarantizado = false;
        $roles = preg_split('/\s*\n(\s*\n)*\s*/', trim($roles));
        dd($roles);
        foreach ($roles as $rol){
            if($this->verificarAccesos($rol)){
                $accesoGarantizado = true;
            }
        }

        if($accesoGarantizado){
            return $next($request);
        } else {
            return redirect('/home')
                ->with('mensaje-advertencia', 'No cuenta con los privilegios suficientes para acceder.');
        }

    }

    public function verificarAccesos($rol){
        $rolUsuario = DB::table('roles')->where('id', '=', auth()->user()->rol)->get();
        return $rol == $rolUsuario[0]->nombre;
    }
}