<?php

namespace Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        try{
            DB::connection()->getPdo();
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    } catch (\Illuminate\Database\QueryException $ex) { //el catch atrapa la excepcion en caso de haber errores
        return Redirect::back()//se redirecciona a la pagina anteriror
            ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    } catch (\Exception $ex) {
        return Redirect::back()//se redirecciona a la pagina anteriror
        ->with('error', $ex->getMessage()); //Retorna mensaje de error con el response a la vista despues de fallar al registrar el objeto
    }
    }
    
}
