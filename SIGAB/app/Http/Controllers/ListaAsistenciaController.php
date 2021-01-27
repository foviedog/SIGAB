<?php

namespace App\Http\Controllers;

use App\ListaAsistencia;
use Illuminate\Http\Request;

class ListaAsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function show(ListaAsistencia $listaAsistencia)
    {
        return view('control_actividades_internas.lista_asistencia.detalle');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaAsistencia $listaAsistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaAsistencia $listaAsistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListaAsistencia  $listaAsistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaAsistencia $listaAsistencia)
    {
        //
    }
}
