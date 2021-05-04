@extends('layouts.app')

@section('titulo')
Cargas académicas de {{ $personal->persona->nombre }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
        {{-- Modal para ver el detalle de la gradución --}}
        @include('modal.detalle-carga-academica')
        @endif

        {{-- Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- Título de la página --}}
            <h2 class="texto-gris-oscuro mb-4">Cargas académicas de {{ $personal->persona->nombre." ".$personal->persona->apellido }}</h2>
            <div>

                @if(Accesos::ACCESO_VISUALIZAR_PERSONAL())
                {{-- Regresar al detalle del personal --}}
                <a href="{{ route('personal.show', $personal->persona->persona_id) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                @endif

                @if(Accesos::ACCESO_REGISTRAR_CARGAS_ACADEMICAS())
                {{-- //Botón para añadir carga académica --}}
                <a href="{{ route('cargaacademica.create', $personal->persona->persona_id) }}" class="btn btn-rojo"> Añadir nueva carga académica &nbsp; <i class="fas fa-plus-circle"></i> </a>
                @endif
                
            </div>
        </div>

        {{-- Alerts --}}
        @include('layouts.messages.alerts')

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
                                @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
                                <th>Ver más</th>
                                @endif
                                @if(Accesos::ACCESO_ELIMINAR_CARGAS_ACADEMICAS())
                                <th>Eliminar</th>
                                @endif
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

                                @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
                                <td>
                                    {{-- Botón para ver información de la gradución --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-carga_academica-modal" data-idcarga_academica="{{ $carga_academica->id }}">
                                        Ver más
                                    </button>
                                    <br />
                                </td>
                                @endif

                                @if(Accesos::ACCESO_ELIMINAR_CARGAS_ACADEMICAS())
                                <form action="{{ route('cargaacademica.delete',$carga_academica->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <td>
                                        <button class="btn btn-contorno-rojo" onclick="activarLoader('Eliminando carga academica');"  type="submit"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                                    </td>
                                </form>
                                @endif

                            </tr>
                            @endforeach
                            @else
                            <tr class="cursor-pointer">
                                <td colspan="5"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr> @endif 
                        </tbody>
                        {{-- Nombre de las columnas en la parte de abajo de la tabla --}}
                        <tfoot>
                            <tr>
                                <th>Nombre del curso</th>
                                <th>Ciclo lectivo</th>
                                <th>Año</th>
                                <th>NRC</th>
                                @if(Accesos::ACCESO_VISUALIZAR_CARGAS_ACADEMICAS())
                                <th>Ver más</th>
                                @endif
                                @if(Accesos::ACCESO_ELIMINAR_CARGAS_ACADEMICAS())
                                <th>Eliminar</th>
                                @endif
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

@section('scripts')
<script src="{{ asset('js/Control_personal/carga_academica.js') }}" defer></script>
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/global/mensajes.js') }}" defer></script>
@endsection
