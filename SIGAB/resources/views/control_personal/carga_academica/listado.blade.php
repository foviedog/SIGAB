@extends('layouts.app')

@section('titulo')
Cargas académicas de {{ $personal->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
<script src="{{ asset('js/Control_personal/carga_academica.js') }}" defer></script>
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/global/mensajes.js') }}" defer></script>
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        {{-- Modal para ver el detalle de la gradución --}}
        <div class="modal fade" id="detalle-carga_academica-modal" tabindex="-1" aria-labelledby="detalle-carga_academica-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="detalle-carga_academica-modal">Detalle de la carga académica</h5>
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

                        {{-- Formulario para actualizar informacion de la graduación --}}
                        <form method="POST" role="form" enctype="multipart/form-data" id="form-actualizar">
                        @csrf
                        @method('PATCH')

                            <div class="d-flex justify-content-center flex-column">
                                {{-- Campo: Ciclo lectivo --}}
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between w-100">
                                        <label for="ciclo_lectivo">Ciclo lectivo <i class="text-danger">*</i></label>
                                        <span class="text-muted ml-2" id="mostrar_ciclo_lectivo"></span>
                                    </div>
                                    <select class="form-control" name="ciclo_lectivo" id="ciclo_lectivo" disabled required>
                                        <option>I Ciclo</option>
                                        <option>II Ciclo</option>
                                    </select>
                                </div>

                                {{-- Campo: Año de graduación --}}
                                <div class=" mb-3">
                                    <div class="d-flex justify-content-between w-100">
                                        <label for="anio">Año <i class="text-danger">*</i></label>
                                        <span class="text-muted ml-2" id="mostrar_anio"></span>
                                    </div>
                                    <input type='number' class="form-control" id="anio" name="anio" onkeyup="contarCaracteres(this,4)" min="1975" disabled required>
                                </div>

                                {{-- Campo: Nombre del curso--}}
                                <label for="nombre_curso">Nombre del curso <i class="text-danger">*</i></label>
                                <select class="form-control mb-3" id="nombre_curso" name="nombre_curso" size="10" disabled required>
                                    @foreach($cursos as $curso)
                                        <option>{{ $curso }}</option>
                                    @endforeach
                                </select>

                                {{-- Campo: NRC--}}
                                <div class=" mb-3">
                                    <div class="d-flex justify-content-between w-100">
                                        <label for="nrc">NRC <i class="text-danger">*</i></label>
                                        <span class="text-muted ml-2" id="mostrar_nrc"></span>
                                    </div>
                                    <input type='number' class="form-control" id="nrc" name="nrc" onkeyup="contarCaracteres(this,7)" min="0" disabled required>
                                </div>
                            </div>
                        </form>

                    </div>

                    {{-- Botones para cerrar el modal o para guardar la edición --}}
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-gris" data-dismiss="modal" onclick="cancelarEdicion()">Cerrar</button>
                        <button onclick="actualizar()" class="btn btn-rojo ml-3" id="terminar-edicion">Terminar edición</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro mb-4">Cargas académicas de {{ $personal->persona->nombre." ".$personal->persona->apellido }}</h2>
            <div>
                {{-- Regresar al detalle del personal --}}
                <a href="/personal/detalle/{{ $personal->persona->persona_id }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                {{-- //Botón para añadir carga académica --}}
                <a href="/personal/carga-academica/registrar/{{ $personal->persona->persona_id }}" class="btn btn-rojo"> Añadir nueva carga académica &nbsp; <i class="fas fa-plus-circle"></i> </a>
            </div>
        </div>

        {{-- Mensaje de exito
            (solo se muestra si ha sido exitoso la edicion) --}}
        @if(Session::has('exito'))
            <div class="alert alert-success" role="alert" id="mensaje-exito">
                {!! \Session::get('exito') !!}
            </div>
        @endif

        {{-- Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Cargas académicas</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>Nombre del curso</th>
                                <th>Ciclo lectivo</th>
                                <th>Año</th>
                                <th>NRC</th>
                                <th>Ver más</th>
                            </tr>
                        </thead>
                        <tbody>
                    {{-- Si no vienen registros --}}
                            @if(count($cargas_academicas))
                            {{-- Inserción iterativa de las cargas academicas dentro de la tabla --}}
                            @foreach($cargas_academicas as $carga_academica)
                            <tr id="carga_academica" class="cursor-pointer">
                                <td>{{ $carga_academica->nombre_curso }}</td>
                                <td>{{ $carga_academica->ciclo_lectivo }} </td>
                                <td>{{ $carga_academica->anio }} </td>
                                <td>{{ $carga_academica->nrc }}<br /> </td>
                                <td>
                                    {{-- Botón para ver información de la gradución --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-carga_academica-modal" data-idcarga_academica="{{ $carga_academica->id }}">
                                        Ver más
                                    </button>
                                    <br />
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr class="cursor-pointer">
                                    <td colspan="4" > <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                                </tr
                            @endif
                        </tbody>
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Nombre del curso</th>
                                <th>Ciclo lectivo</th>
                                <th>Año</th>
                                <th>NRC</th>
                                <th>Ver más</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div>
                        <span class="ml-2"> Total de registros: <span class="font-weight-bold">{{ count($cargas_academicas) }}</span></span>
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
