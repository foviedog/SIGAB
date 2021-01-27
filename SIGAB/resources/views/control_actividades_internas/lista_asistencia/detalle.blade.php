@extends('layouts.app')

@section('titulo')
Asistencia
{{-- {{ $actividad->tema }} --}}
@endsection

@section('css')
{{-- No hay --}}
@endsection


@section('contenido')

{{-- Arreglos de opciones de los select utilizados --}}
@php

$propositos = ['Inducción','Capacitación','Actualización','Involucramiento del personal','Otro'];


@endphp

{{-- Formulario general de estudiante --}}
{{-- <form action="{{ route('actividad-interna.update', $actividad->id) }}" method="POST" role="form" enctype="multipart/form-data" id="actividad-form"> --}}
{{-- Metodo invocado para realizar la modificacion correctamente del estudiante --}}
@method('PATCH')
{{-- Seguridad de envío de datos --}}
@csrf

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div>

                <h3>Lista de asistencia </h3>
            </div>
            {{-- Botones superiores --}}
            <div>
                {{-- Botón para regresar al listado de actividades --}}
                <a href="{{ route('actividad-interna.listado' ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Listado de actividades </a>
                {{-- Boton que habilita opcion de editar --}}
                <button type="button" id="editar-actividad" class="btn btn-rojo"><i class="fas fa-edit "></i> Editar </button>
                {{-- Boton de cancelar edicion --}}
                <button type="button" id="cancelar-edi" class="btn btn-rojo"><i class="fas fa-close "></i> Cancelar </button>
            </div>
        </div>
        <hr>
        {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
        @if(Session::has('mensaje'))
        <div class="alert alert-success text-center font-weight-bold" role="alert" id="mensaje_exito">
            {!! \Session::get('mensaje') !!}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger text-center font-weight-bold" role="alert">
            {{ "¡Oops! Algo ocurrió mal. ".$error }}
        </div>
        @endif

        <div class="row border-bottom pb-2">
            <div class="col-5">
                <div class="card shadow">

                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('img/logoEBDI.png') }}" alt="logo_ebdi" class="" style="max-width: 100%">
                                </div>
                                <div class="col-8 border-left d-flex align-items-center">
                                    <div>
                                        <span>Nombre de actividad: Movimiento naranja</span> <br>
                                        <span>Público dirigido: Estudiantes</span><br>
                                        <span>Fecha de la actividad: 20-04-2021</span><br>
                                        <span> Tipo de actividad: Charla </span><br>
                                        <span> Estado:</span> <span class="badge bg-warning text-dark">En progreso</span>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-7">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Añadir participante </h6>
                    </div>
                    <div class="card-body d-flex justify-content-center" style="padding:59px;">
                        <div class="input-group w-50">
                            <input type='text' id="cedula-responsable" name="responsable_coordinar" class="form-control " required>
                            <div class="input-group-append">
                                <button type="button" id="buscar" class="btn btn-contorno-rojo">Buscar</button>
                                <span data-toggle="tooltip" data-placement="right" title="Ingrese sin espacio y sin guiones el número de cédula del responsable de coordinar la actividad y presione buscar" class="ml-2"> <i class="far fa-question-circle fa-lg mr-2"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mt-2 d-flex justify-content-center">
            <div class="col-10">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Participaciones </h6>
                    </div>
                    <div class="row pt-3 px-3">
                        <div class="col-md-6 text-nowrap">
                            <div class="" aria-controls="dataTable">
                                <label class="font-weight-bold">Mostrar &nbsp;
                                    {{-- Select con la cantidad de items por páginas--}}
                                    <select class="form-control form-control-sm custom-select custom-select-sm" name="itemsPagina" onchange="document.getElementById('item-pagina').submit()">
                                        {{-- @foreach($paginaciones as $paginacion) --}}
                                        {{-- <option value={{ $paginacion }} @if ($itemsPagina==$paginacion )selected @endif>{{ $paginacion }}</option> --}}
                                        {{-- @endforeach --}}
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="d-flex justify-content-end w-50">
                                <div class="text-md-right dataTables_filter input-group mb-3 ">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg"></i></span>
                                    {{-- @if (!is_null($filtro)) value="{{ $filtro }}" @endif --}}
                                    &nbsp;&nbsp; <input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="filtro" />
                                </div>
                            </div>
                            {{-- Botón de submit para realizar la búsqueda del estudiante --}}
                            <div>
                                <button class="btn btn-rojo ml-3" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <table class="table my-0" id="dataTable">
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <thead>
                            <tr>
                                <th>N° de Cédula</th>
                                <th>Nombre</th>
                                <th>Carrera (Principal) matriculada</th>
                                <th>Teléfono celular</th>
                                <th>Correo</th>
                                <td><strong>Ver detalle<br /></strong></td>
                                <th>Guía Académica</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- En caso de que no existan registros --}}
                            {{-- @if(count($estudiantes) == 0) --}}
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr>
                            {{-- @endif --}}
                            {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}

                        </tbody>
                        {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                        <tfoot>
                            <tr>
                                <td><strong>N° de Cédula<br /></strong></td>
                                <td><strong>Nombre<strong></td>
                                <td><strong>Carrera (Principal) matriculada<br /></strong></td>
                                <td><strong>Teléfono Celular</strong><br /></td>
                                <td><strong>Correo<br /></strong></td>
                                <td><strong>Ver detalle<br /></strong></td>
                                <td><strong>Guia académica<br /></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-2">
                <div class="info-card" style="padding: 2px 32px; max-width: 54%; ">
                    <span style="font-size: 36px; font-weight: bolder;">28</span><br>
                    <span style="font-size: 20px; font-weight: light;  ">Total</span>
                </div>
            </div>
        </div>



    </div>
</div>

{{-- </form> --}}

@endsection

@section('scripts')
<script>
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

</script>
<script src="{{ asset('js/control_educativo/informacion_estudiante/editar.js') }}" defer></script>
<script src="{{ asset('js/control_actividades_internas/detalle_editar.js') }}" defer></script>
{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>
<script>
    $("input[type='number']").inputSpinner();

</script>
@endsection


@section('pie')
Copyright
@endsection
