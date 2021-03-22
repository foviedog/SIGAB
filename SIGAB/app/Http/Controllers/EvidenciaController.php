<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actividades;
use App\Actividades_interna;
use App\Evidencia;
use Storage;
use Illuminate\Support\Facades\File;


class EvidenciaController extends Controller
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
        try {
            $evidencia = new Evidencia();
            $evidencia->actividad_id = $request->actividad_id;
            $evidencia->nombre_archivo = $request->nombre_archivo;

            $video = $request->check_video;
            if ($video == "on")
                $this->guardarVideo($request, $evidencia);
            else
                $this->guardarDocumento($request, $evidencia);

            $mensaje = "success";

            return redirect()->route('evidencias.show', request()->actividad_id)->with('mensaje', $mensaje);;
        } catch (\Illuminate\Database\QueryException $ex) {
            return abort(500, 'No se ha podido registrar la evidencia');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\evidencias  $evidencias
     * @return \Illuminate\Http\Response
     */
    public function show($actividadId)
    {
        $paginaciones = [5, 10, 25, 50];
        $itemsPagina = request('itemsPagina', 5);
        $nombreFiltro = request('nombre_filtro', NULL);
        $tipoFiltro = request('tipo_filtro', NULL);

        $mensaje = request('mensaje', NULL);

        $evidencias = $this->obtenerLista($actividadId, $itemsPagina, $nombreFiltro, $tipoFiltro);
        $actividad = Actividades::find($actividadId);

        if (!is_null($mensaje)) {
            return redirect()->route('evidencias.show', $actividadId)->with('mensaje', $mensaje);
        }

        return view('control_actividades_internas.evidencias.detalle', [
            'actividad' => $actividad,
            'paginaciones' => $paginaciones,
            'itemsPagina' => $itemsPagina,
            'nombre_filtro' => $nombreFiltro,
            'tipo_filtro' => $tipoFiltro,
            'mensaje' => $mensaje,
            'evidencias' => $evidencias
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\evidencias  $evidencias
     * @return \Illuminate\Http\Response
     */
    public function edit(evidencias $evidencias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\evidencias  $evidencias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evidencia $evidencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\evidencias  $evidencias
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $evidenciaId)
    {
        try {

            $evidencia = Evidencia::where('id', $evidenciaId)->first();
            if ($evidencia->tipo_documento != "video") {
                File::delete(public_path('storage/evidencias/' . $request->actividad_id . "/" . $evidencia->id_repositorio));
            }
            $evidencia->delete();

            return redirect()->route('evidencias.show', $request->actividad_id)->with('eliminado', 'Participante eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->route('lista-asistencias.show', $request->actividad_id)->with('mensaje', 'error');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\evidencias  $evidencias
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request,  $evidenciaId)
    {
        $evidencia = Evidencia::where('id', $evidenciaId)->first();
        $ruta = 'storage/evidencias/' . $request->actividad_id . '/' . $evidencia->id_repositorio;
        return response()->download(public_path($ruta));
    }

    public function obtenerLista($actividadId, $itemsPagina, $nombreFiltro, $tipoFiltro)
    {
        try {
            $lista = NULL;
            if (!is_null($nombreFiltro || $tipoFiltro)) {
                $lista = Evidencia::where('actividad_id', $actividadId)
                    ->where('nombre_archivo', 'like', '%' . $nombreFiltro . '%')
                    ->where('tipo_documento', 'like', '%' . $tipoFiltro . '%')
                    ->paginate($itemsPagina);
            } else {
                $lista = Evidencia::where('actividad_id', $actividadId)
                    ->paginate($itemsPagina);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            report($ex);
        }

        return $lista;
    }

    private function guardarVideo($request, &$evidencia)
    {
        $evidencia->id_repositorio = request()->url_video;
        $evidencia->tipo_documento = "video";
        $evidencia->save();
    }

    private function guardarDocumento($request, &$evidencia)
    {
        if ($request->hasFile('evidencia')) {
            $evidenciaArchivo = $request->file('evidencia');
            $evidencia->tipo_documento = $this->obtenerTipoDocumento($evidenciaArchivo->getClientOriginalExtension());
            $id_repositorio = time() . '_' . preg_replace('/\s+/', '', $request->nombre_archivo) . "." . $evidenciaArchivo->getClientOriginalExtension();
            $file =  $request->file('evidencia');
            //Se guarda el documento en el repositorio PUBLICO para luego poder acceder a él para su previsualización
            $file->storeAs('/evidencias/' . $request->actividad_id, $id_repositorio, ['disk' => 'public_storage']);

            // ? En caso de que se desee guardar de manera privada se puede hacer de la forma de abajo
            // $ruta = $request->file('evidencia')->storeAs('evidencias/' . $request->actividad_id, $id_repositorio, 'public');

            $evidencia->id_repositorio = $id_repositorio;

            $evidencia->save();
        }
    }

    private function obtenerTipoDocumento($extension)
    {
        $extension = strtolower($extension);
        if (strcmp($extension, "pdf") == 0) {
            return "pdf";
        } elseif (strcmp($extension, "docx") == 0 || strcmp($extension, "odt") ==  0 || strcmp($extension, "doc") == 0 || strcmp($extension, "txt") == 0) {
            return "documento";
        } elseif (strcmp($extension, "rar") == 0 || strcmp($extension, "zip") == 0 || strcmp($extension, "7z") == 0 || strcmp($extension, "rar5") == 0) {
            return "comprimido";
        } elseif (strcmp($extension, "xls") == 0 || strcmp($extension, "xlsm") == 0 || strcmp($extension, "xlsx") == 0 || strcmp($extension, "csv") == 0) {
            return "excel";
        } elseif (strcmp($extension, "pps") == 0 || strcmp($extension, "ppt") == 0 || strcmp($extension, "ppsx") == 0 || strcmp($extension, "pptm") == 0 || strcmp($extension, "potx") == 0 || strcmp($extension, "pptx") == 0) {
            return "presentacion";
        } else {
            return "imagen";
        }
    }
}
