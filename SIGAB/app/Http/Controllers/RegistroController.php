<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{

    public function registro(Request $request){
        DB::table('users')
                ->insert(['persona_id'=>$request->persona_id,
                            'rol'=> $request->rol,
                                'password'=>Hash::make($request->password)]);

        return view('auth.register');
    }

}
