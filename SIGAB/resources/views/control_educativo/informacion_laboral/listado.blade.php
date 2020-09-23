@extends('layouts.app')

@section('titulo')
Trabajos de {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_laboral/listado.js') }}" defer></script>
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        {{-- Modal para ver el detalle del trabajo --}}
        <div class="modal fade" id="detalle-trabajo-modal" tabindex="-1" aria-labelledby="detalle-trabajo-modal" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="detalle-trabajo-modal">Detalle del trabajo</h5>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-rojo" id="habilitar-edicion">
                                    Habilitar edición
                                </button>
                                <button type="button" class="btn btn-rojo" id="cancelar-edicion">
                                    Cancelar
                                </button>
                            </div>
                    </div>
                    <div class="modal-body">

                        {{-- Formulario para actualizar informacion laboral --}}
                        <form method="POST" role="form" enctype="multipart/form-data" id="form-actualizar">
                            @csrf

                            <div class="row">

                                {{-- Campos de la izquierda --}}
                                <div class="col">

                                    {{-- Campo: Nombre de la organizacion --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="nombre_organizacion">Nombre de la organización:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type='text' class="form-control w-100" id="nombre_organizacion" name="nombre_organizacion" onkeyup="contarCarNomOrg(this)" required disabled>
                                        </div>
                                        <div class="col-1">
                                            <span class="text-muted" id="mostrar_cant_nom_org"></span>
                                        </div>
                                    </div>

                                    {{-- Campo: Jornada laboral --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="jornada_laboral">Jornada laboral:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type='text' class="form-control w-100" id="jornada_laboral" name="jornada_laboral" onkeyup="contarCarJornLab(this)" required disabled>
                                        </div>
                                        <div class="col-1">
                                            <span class="text-muted" id="mostrar_cant_jorn_lab"></span>
                                        </div>
                                    </div>

                                    {{-- Campo: Jefe inmediato --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="jefe_inmediato">Jefe inmediato:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type='text' class="form-control w-100" id="jefe_inmediato" name="jefe_inmediato" onkeyup="contarCarJefInme(this)" disabled>
                                        </div>
                                        <div class="col-1">
                                            <span class="text-muted" id="mostrar_cant_jef_inme"></span>
                                        </div>
                                    </div>

                                    {{-- Campo: Tiempo desempleado --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="tiempo_desempleado">Tiempo desempleado:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type='text' class="form-control w-100" id="tiempo_desempleado" name="tiempo_desempleado" onkeyup="contarCarTiempDesempl(this)" disabled>
                                        </div>
                                        <div class="col-1">
                                            <span class="text-muted" id="mostrar_cant_tiemp_desmp"></span>
                                        </div>
                                    </div>

                                    {{-- Campo: Intereses Capacitacion --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="interes_capacitacion">Intereses capacitación:</label>
                                        </div>
                                        <div class="col-6">
                                            <textarea class="form-control w-100" id="interes_capacitacion" name="interes_capacitacion" disabled></textarea>
                                        </div>
                                    </div>

                                </div>

                                {{-- Campos de la derecha --}}
                                <div class="col">

                                    {{-- Campo: Tipo de organizacion --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="tipo_organizacion">Tipo de organización:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type='text' class="form-control w-100" id="tipo_organizacion" name="tipo_organizacion" onkeyup="contarCarTipOrg(this)" required disabled>
                                        </div>
                                        <div class="col-1">
                                            <span class="text-muted" id="mostrar_cant_tip_org"></span>
                                        </div>
                                    </div>

                                    {{-- Campo: Cargo actual --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="cargo_actual">Cargo actual:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type='text' class="form-control w-100" id="cargo_actual" name="cargo_actual" onkeyup="contarCarCargAct(this)" required disabled>
                                        </div>
                                        <div class="col-1">
                                            <span class="text-muted" id="mostrar_cant_carg_act"></span>
                                        </div>
                                    </div>

                                    {{-- Campo: Telefono trabajo --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="telefono_trabajo">Teléfono trabajo:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type='text' class="form-control w-100" id="telefono_trabajo" name="telefono_trabajo" onkeyup="contarCarTelfTrbj(this)" disabled>
                                        </div>
                                        <div class="col-1">
                                            <span class="text-muted" id="mostrar_cant_tel_trbj"></span>
                                        </div>
                                    </div>

                                    {{-- Campo: Correo trabajo --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="correo_trabajo">Correo trabajo:</label>
                                        </div>
                                        <div class="col-6">
                                            <input type='text' class="form-control w-100" id="correo_trabajo" name="correo_trabajo" onkeyup="contarCarCorrTrbj(this)" disabled>
                                        </div>
                                        <div class="col-1">
                                            <span class="text-muted" id="mostrar_cant_corr_trbj"></span>
                                        </div>
                                    </div>

                                    {{-- Campo: Otros estudios --}}
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="col-4">
                                            <label for="otros_estudios">Otros estudios:</label>
                                        </div>
                                        <div class="col-6">
                                            <textarea class="form-control w-100" id="otros_estudios" name="otros_estudios" disabled></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Botones para cerrar el modal o para guardar la edición --}}
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                        <button onclick="actualizar()" class="btn btn-rojo ml-3" id="terminar-edicion">Terminar edición</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro mb-4">Trabajos de {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</h2>
            <div>
                {{-- Regresar al detalle del estudiante --}}
                <a href="/estudiante/detalle/{{ $estudiante->persona->persona_id }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                {{-- //Botón para añadir trabajo --}}
                <a href="/estudiante/trabajo/registrar/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo"> Añadir nuevo trabajo &nbsp; <i class="fas fa-plus-circle"></i> </a>
            </div>
        </div>

        {{-- Mensaje de exito
            (solo se muestra si ha sido exitoso la edicion) --}}
        @if(Session::has('exito'))
        <div class="alert alert-success" role="alert">
            {!! \Session::get('exito') !!}
        </div>
        @endif

        {{-- Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Trabajos</p>
            </div>
            <div class="card-body">
                {{-- Form para la paginación de la página y para la búsqueda de trabajos --}}
                <form action="/estudiante/trabajo/{{ $estudiante->persona->persona_id }}" method="GET" role="form" id="item-pagina">
                    <div class="row">
                        <div class="col-md-6 text-nowrap">
                            <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                <label class="font-weight-bold">Mostrar &nbsp;
                                    {{-- Select con la cantidad de items por páginas--}}
                                    <select class="form-control form-control-sm custom-select custom-select-sm" name="itemsPagina" onchange="document.getElementById('item-pagina').submit()">
                                        @foreach($paginaciones as $paginacion)
                                        <option value={{ $paginacion }} @if ($itemsPagina==$paginacion )selected @endif>{{ $paginacion }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>Nombre de la organización</th>
                                <th>Cargo actual</th>
                                <th>Jornada laboral</th>
                                <th>Ver más</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($trabajos))
                            {{-- Inserción iterativa de los trabajos dentro de la tabla --}}
                            @foreach($trabajos as $trabajo)
                            <tr id="trabajo" class="cursor-pointer">
                                <td>{{ $trabajo->nombre_organizacion }}</td>
                                <td>{{ $trabajo->cargo_actual }} </td>
                                <td>{{ $trabajo->jornada_laboral }}<br /> </td>
                                <td>
                                    {{-- Botón para ver información del trabajo --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-trabajo-modal" data-idtrabajo="{{ $trabajo->id }}">
                                        Ver más
                                    </button>
                                    <br />
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <td>
                                No existen registros aún
                            </td>
                            @endif
                        </tbody>
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Nombre de la organización</th>
                                <th>Cargo actual</th>
                                <th>Jornada laboral</th>
                                <th>Ver más</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $trabajos->perPage() }} de {{ $trabajos->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-6">
                        {{ $trabajos->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pie')
Copyright
@endsection
