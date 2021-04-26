<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Acceso;
use App\Persona;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function username()
    {
        return 'persona_id';
    }

    function authenticated(Request $request, $user)
    {
        $accesos = DB::table('accesos')->where('rol_id', $user->rol)->get();
        $persona =  Persona::findOrFail($user->persona_id);
        session(['persona' => $persona]);
        session(['accesos_usuario' => $accesos]);
    }
}
