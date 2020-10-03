<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function create()
    {
        return view('control_personal.registrar');
    }
}
