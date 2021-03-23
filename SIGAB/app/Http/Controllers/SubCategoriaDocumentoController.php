<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Documento;

class SubCategoriaDocumentoController extends Controller{

    public function doc($sub_id){
        $documentos = Documento::where('sub_categoria_documento_id', $cat_id)->get();
        return $documentos;
    }

    public function store(Request $request){
        
    }
    
}
