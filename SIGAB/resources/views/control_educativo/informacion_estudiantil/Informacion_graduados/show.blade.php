@extends('layouts.app')

@section('titulo')
Graduaciones de {{ $estudiante->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        {{-- Modal para ver el detalle de la gradución --}}
        @include('modal.detalle-titulacion')

        {{-- Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro mb-4">Graduaciones de {{ $estudiante->persona->nombre." ".$estudiante->persona->apellido }}</h2>
            <div>
                @if(Accesos::ACCESO_VISUALIZAR_ESTUDIANTES())
                {{-- Regresar al detalle del estudiante --}}
                <a href="/estudiante/detalle/{{ $estudiante->persona->persona_id }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                @endif
                
                @if(Accesos::ACCESO_REGISTRAR_TITULACIONES())
                {{-- //Botón para añadir graduación --}}
                <a href="/estudiante/graduacion/registrar/{{ $estudiante->persona->persona_id }}" class="btn btn-rojo"> Añadir nueva graduación &nbsp; <i class="fas fa-plus-circle"></i> </a>
                @endif
            </div>
        </div>

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

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
                                @if(Accesos::ACCESO_ELIMINAR_TITULACIONES())
                                <th>Eliminar</th>
                                @endif
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

                                @if(Accesos::ACCESO_ELIMINAR_TITULACIONES())
                                <form action="{{ route('graduado.delete',$graduacion->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <td>
                                        <button class="btn btn-contorno-rojo" onclick="activarLoader('Eliminando titulacion');" type="submit"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                                    </td>
                                </form>
                                @endif

                            </tr>
                            @endforeach
                            @else
                            <tr class="cursor-pointer">
                                <td colspan="4"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr> @endif 
                        </tbody>
                            {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Grado Académico</th>
                                <th>Carrera Cursada</th>
                                <th>Año de graduación</th>
                                <th>Ver más</th>
                                @if(Accesos::ACCESO_ELIMINAR_TITULACIONES())
                                <th>Eliminar</th>
                                @endif
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

@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_graduaciones/listado-individual.js') }}" defer></script>
@endsection
