<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sub_categoria_documento;

class CategoriaDocumentoController extends Controller{

    public function sub($cat_id){
        $subCategorias = Sub_categoria_documento::where('categoria_documento_id', $cat_id)->get();
        return $subCategorias;
    }

    public function store(Request $request){
        
    }

}
