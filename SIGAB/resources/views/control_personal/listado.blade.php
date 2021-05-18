@extends('layouts.app')

@section('titulo')
Listado de Personal
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')
@php
(Session::has('personalExisteError')) ? $personalExisteError = Session::get('personalExisteError') : $personalExisteError = null;
@endphp

<!-- Button trigger modal -->
<!-- Modal -->
@if(Accesos::ACCESO_REGISTRAR_PERSONAL())
<form action="{{ route('personal.create') }}" method="GET">
    @csrf
    <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <span class="modal-header" data-toggle="tooltip" data-placement="left" title="Este paso se realiza con el fin de verficar que el personal que desee agregar no se haya registrado con anterioridad como estudiante o como participante en alguna actividad">
                    <h5 class="modal-title texto-rojo-medio" id="agregarModalLabel">Verificación del personal </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </span>
                <div class="modal-body d-flex justify-content-center">
                    <div class="w-90">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-dark">Cédula: <i class="text-danger">*</i></span>
                            </div>
                            <input type='text' class="form-control " id="cedula" name="cedula" onkeyup="contarCaracteres(this,50)" required>
                            <div class="input-group-append">
                                <span class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Insertar la identificación del personal sin guiones y sin espacios." class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                            </div>
                            <div class="d-flex justify-content-end align-items-center w-5">
                                <span id="mostrar_cedula"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-rojo" >Siguiente <i class="fas fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
@endif


<div class="card">
    <div class="card-body">
        {{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- //Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Control de Personal</h2>
            <div class="d-flex justify-content-between">
                <div class="mr-2">
                    <a href="{{ route('personal.listar') }}" class="btn btn-contorno-rojo"> Listar todo &nbsp; <i class="fas fa-bars"></i> </a>
                </div>

                @if(Accesos::ACCESO_REGISTRAR_PERSONAL())
                <div>
                    {{-- //Botón para añadir personal --}}
                    <button class="btn btn-rojo" data-toggle="modal" data-target="#agregarModal"> Añadir Personal &nbsp; <i class="fas fa-plus-circle"></i> </button>
                </div>
                @endif
            </div>
        </div>
        {{-- Alerts --}}
        @include('layouts.messages.alerts')
        {{-- // Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- //Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información del Personal</p>
            </div>
            <div class="card-body">
                @if(Accesos::ACCESO_BUSCAR_PERSONAL())
                {{-- // Form para la paginación y para la búsqueda del personal --}}
                <form autocomplete="off" action="{{ route('personal.listar') }}" method="GET" role="form" id="item-pagina">
                    <div class="row d-flex justify-content-between">

                        <div class="col-6 d-flex ">
                            <div class="input-group ">
                                <div class="input-group-prepend ">
                                    {{-- Input para realizar la búsqueda del personal --}}
                                    <span class="input-group-text texto-azul-una font-weight-bold" data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido, cédula o cargo"><i class="far fa-question-circle fa-lg texto-azul-una"></i></span>
                                </div>
                                <input type="search" class="form-control form-control-md" placeholder="Buscar personal" aria-controls="dataTable" placeholder="Buscar personal" name="filtro" @if (!is_null($filtro)) value="{{ $filtro }}" @endif />
                            </div>
                            {{-- Botón de submit para realizar la búsqueda del personal --}}
                            <div class="d-flex justify-content-center" style="width: 30%">
                                <button class="btn btn-rojo" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        {{-- Cantidad de items --}}
                        <div class="col-2 text-nowrap d-flex justify-content-end">
                            <label class="font-weight-bold " for="itemsPagina">Mostrar &nbsp;</label>
                            {{-- Select con la cantidad de items por páginas--}}
                            <div class="w-50">
                                <select class="form-control form-control-sm custom-select custom-select-sm" name="itemsPagina" onchange="document.getElementById('item-pagina').submit()">
                                    @foreach($paginaciones as $paginacion)
                                    <option value={{ $paginacion }} @if ($itemsPagina==$paginacion )selected @endif>{{ $paginacion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
                <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>N° de Cédula</th>
                                <th>Nombre</th>
                                <th>Cargo</th>
                                <th>Teléfono celular</th>
                                <th>Correo</th>
                                @if(Accesos::ACCESO_VISUALIZAR_PERSONAL())
                                <th>Ver detalle</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- En caso de que no existan registros --}}
                            @if(count($personal) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            {{-- Inserción iterativa del personal dentro de la tabla --}}
                            @foreach($personal as $perso)
                            <tr id="personal" class="cursor-pointer">
                                <td>{{ $perso->persona_id }}</td>
                                {{-- Aquí se debería de agregar la foto del personal, si así se desea. --}}
                                <td>{{ $perso->persona->apellido.", ". $perso->persona->nombre }}</td>
                                <td>{{ $perso->cargo }}</td>
                                <td>{{ $perso->persona->telefono_celular }}<br /> </td>
                                <td><strong>{{ $perso->persona->correo_institucional }}</strong></td>
                                @if(Accesos::ACCESO_VISUALIZAR_PERSONAL())
                                <td>
                                    {{-- Botón para ver el detalle del personal --}}
                                    <strong>
                                        <a href="{{ route('personal.show', $perso->persona_id) }}" class="btn btn-contorno-rojo"> Detalle </a>
                                    </strong><br />
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <td><strong>N° de Cédula<br /></strong></td>
                                <td><strong>Nombre<strong></td>
                                <td><strong>Cargo<br /></strong></td>
                                <td><strong>Teléfono Celular</strong><br /></td>
                                <td><strong>Correo<br /></strong></td>
                                @if(Accesos::ACCESO_VISUALIZAR_PERSONAL())
                                <td><strong>Ver detalle<br /></strong></td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-3 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $personal->perPage() }} de {{ $personal->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-5 ml-5">
                        {{ $personal->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script defer="">
    @if(!is_null($personalExisteError))
    setTimeout(function() {
        toastr.error("{{ $personalExisteError }}");
    }, 100);
    @endif

</script>
@endsection
