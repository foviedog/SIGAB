<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categoria_documento;

class DocumentoController extends Controller
{
    public function index(){
        $categorias = Categoria_documento::all();
        return view('manejo_documentacion.index', [
            'categorias' => $categorias
        ]);
    }
}
