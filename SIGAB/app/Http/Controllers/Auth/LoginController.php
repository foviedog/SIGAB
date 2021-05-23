<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Events\EventUsuarios;
use App\Exceptions\ControllerFailedException;
use App\Persona;
use App\Acceso;

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
        try{
            DB::connection()->getPdo();

            $accesos = DB::table('accesos')->where('rol_id', $user->rol)->get();
            $persona =  Persona::findOrFail($user->persona_id);

            $rol = DB::table('roles')->where('id', '=', $user->rol)->get()[0]->nombre;

            session(['persona' => $persona]);
            session(['accesos_usuario' => $accesos]);
            session(['rol' => $rol]);


             //Se envía la notificación
            //event(new EventUsuarios($user, 1));

        } catch (\Illuminate\Database\QueryException $ex) {  
            return redirect()->route('login')
                ->with('mensaje-error', $ex->getMessage());
        } catch (ModelNotFoundException $ex) {  
            return Redirect::back()
                ->with('mensaje-error', $ex->getMessage());
                
        } catch (\Exception $ex) {
            return Redirect::back()
            ->with('mensaje-error', $ex->getMessage());
        }
        catch (PDOException $e) {
            return Redirect::back()
            ->with('mensaje-error', $ex->getMessage());
        }
        catch (\Exception $exception) {
            throw new ControllerFailedException();
        }
    }

}
