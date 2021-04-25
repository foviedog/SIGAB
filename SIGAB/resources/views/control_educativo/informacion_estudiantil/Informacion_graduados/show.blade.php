@extends('layouts.app')

@section('titulo')
Graduaciones de {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_graduaciones/listado-individual.js') }}" defer></script>
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        {{-- Modal para ver el detalle de la gradución --}}
        <div class="modal fade" id="detalle-graduacion-modal" tabindex="-1" aria-labelledby="detalle-graduacion-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="detalle-graduacion-modal">Detalle de la gradución</h5>
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
                                {{-- Campo: Grado académico --}}
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between w-100">
                                        <label for="grado_academico">Grado académico <i class="text-danger">*</i></label>
                                        <span class="text-muted ml-2" id="mostrar_cant_grado_academico"></span>
                                    </div>
                                    {{-- <input type='text' class="form-control" id="grado_academico" name="grado_academico" onkeyup="contarCarGradoAcademico(this)" required disabled>  --}}
                                    <select class="form-control w-100" id="grado_academico" name="grado_academico" required disabled>
                                        <option value="" selected>Seleccione</option>
                                        <option value="Diplomado"> Diplomado</option>
                                        <option value="Bachillerato"> Bachillerato </option>
                                        <option value="Licenciatura"> Licenciatura </option>
                                        <option value="Maestría"> Maestría </option>
                                        <option value="Doctorado"> Doctorado </option>
                                    </select>
                                </div>

                                {{-- Campo: Carrera cursada--}}
                                <div class=" mb-3">
                                    <div class="d-flex justify-content-between w-100">
                                        <label for="carrera_cursada">Carrera cursada <i class="text-danger">*</i></label>
                                        <span class="text-muted ml-2" id="mostrar_cant_carrera_cursada"></span>
                                    </div>
                                    <input type='text' class="form-control" id="carrera_cursada" name="carrera_cursada" onkeyup="contarCarCarrCursada(this)" required disabled>
                                </div>

                                {{-- Campo: Año de graduación --}}
                                <div class=" mb-3">
                                    <div class="d-flex justify-content-between w-100">
                                        <label for="anio_graduacion">Año de graduación <i class="text-danger">*</i></label>
                                        <span class="text-muted ml-2" id="mostrar_cant_anio_graduacion"></span>
                                    </div>
                                    <input type='number' class="form-control" id="anio_graduacion" name="anio_graduacion" onkeyup="contarCarAnioGraduacion(this)" min="1975" required disabled>
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
            <h2 class="texto-gris-oscuro mb-4">Graduaciones de {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</h2>
            <div>
                {{-- Regresar al detalle del estudiante --}}
                <a href="/estudiante/detalle/{{ $estudiante->persona->persona_id }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                {{-- //Botón para añadir graduación --}}
                <a href="/estudiante/graduacion/registrar/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo"> Añadir nueva graduación &nbsp; <i class="fas fa-plus-circle"></i> </a>
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
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Graduaciones</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>Grado Académico</th>
                                <th>Carrera Cursada</th>
                                <th>Año de graduación</th>
                                <th>Ver más</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Si no vienen registros --}}
                            @if(count($graduaciones))
                            {{-- Inserción iterativa de las graduaciones dentro de la tabla --}}
                            @foreach($graduaciones as $graduacion)
                            <tr id="graduacion" class="cursor-pointer">
                                <td>{{ $graduacion->grado_academico }}</td>
                                <td>{{ $graduacion->carrera_cursada }} </td>
                                <td>{{ $graduacion->anio_graduacion }}<br /> </td>
                                <td>
                                    {{-- Botón para ver información de la gradución --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-graduacion-modal" data-idgraduacion="{{ $graduacion->id }}">
                                        Ver más
                                    </button>
                                    <br />
                                </td>
                                <form action="{{ route('graduado.delete',$graduacion->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <td>
                                        <button class="btn btn-contorno-rojo" type="submit"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                                    </td>

                                </form>
                            </tr>
                            @endforeach
                            @else
                            <tr class="cursor-pointer">
                                <td colspan="4"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr @endif </tbody>
                            {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Grado Académico</th>
                                <th>Carrera Cursada</th>
                                <th>Año de graduación</th>
                                <th>Ver más</th>
                                <th>Eliminar</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div>
                        <span class="ml-2"> Total de registros: <span class="font-weight-bold">{{ count($graduaciones) }}</span></span>
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
