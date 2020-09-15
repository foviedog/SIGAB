@extends('layouts.app')

@section('titulo')
Listado de Guias Academicas
@endsection

@section('css')

@endsection


@section('contenido')

{{-- MODAL para agregar una guía académica --}}
<div class="modal fade" id="agregar-guia-modal" tabindex="-1" aria-labelledby="agregar-guia-modal" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregar-guia-modal"><strong>Añadir Guía cadémica</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    El estudiante ingresado no existe!
                </div>
                <form>
                    <div class="form-group">
                        <label for="id-estudiante" class="col-form-label">Cédula del estudiante:</label>
                        <input type="text" class="form-control" id="id-estudiante">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-rojo">Crear Guía Académica</button>
            </div>
        </div>
    </div>
</div>
{{-- MODAL para ver el detalle de una guía académica--}}
<div class="modal fade" id="detalle-guia-modal" tabindex="-1" aria-labelledby="detalle-guia-modal" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalle-guia-modal">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row d-flex">
                    <div class="col">
                        <img src="{{ asset('img/login/logo_sin_fondo.png') }}" alt="logo_ebdi" class="mx-3 w-50" id="img-ebdi">
                    </div>
                    <div class="col">
                        <button class="btn btn-rojo" id="habilitar-edicion">
                            Habilitar edición
                        </button>
                    </div>
                </div>
                <form>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Motivo:</label>
                                <input type="text" class="form-control" id="recipient-name" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha:</label>
                                <input type="text" class="form-control" id="recipient-name" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Ciclo lectivo:</label>
                                <input type="text" class="form-control" id="recipient-name" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Lugar de atención:</label>
                                <input type="text" class="form-control" id="recipient-name" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Situación:</label>
                        <textarea class="form-control" id="message-text" rows="4" cols="50" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label" for="recomendacion">Recomendaciones:</label>
                        <textarea class="form-control" id="recomendacion" rows="8" cols="50" disabled>
                            asdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaa
                            asdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaa
                            asdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaa
                            asdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaa
                            asdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaa
                            asdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaaasdaaaaaaaaaaaaaaaaaaaaa
                        </textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-guia-modal" data-idestudiante="117380366"> Ver detalle </button>

{{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
<div class="d-flex justify-content-between">
    {{-- //Título de la página --}}
    <h2 class="texto-gris-oscuro mb-4">Lista de Guias Academicas</h2>
    <div>
        {{-- //Botón para añadir estudainte --}}
        <a href="/estudiante/registrar" class="btn btn-rojo" data-toggle="modal" data-target="#agregar-guia-modal" data-whatever="Añadir Guía"> Añadir Guía académica &nbsp; <i class="fas fa-plus-circle"></i> </a>
    </div>
</div>
{{-- // Contenedor de la tabla --}}
<div class="card shadow">
    <div class="card-header py-3">
        {{-- //Título de la tabla --}}
        <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de estudiantes </p>
    </div>



    <div class="card-body">
        {{-- // Form para la paginación de la página y para la búsqueda de estudiantes --}}
        <form action="listadoEstudiantil" method="GET" role="form" id="item-pagina">
            <div class="row">
                <div class="col-md-6 text-nowrap d-flex align-items-end">
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
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="mx-2 ">
                        <label for="fecha-inicio">Fecha inicio: </label>
                        <input type="date" class="form-control form-control-sm" name="" id="fecha-final">
                    </div>
                    <div class="mx-3 ">
                        <label for="fecha-final"> Fecha final: </label>
                        <input type="date" class="form-control form-control-sm" name="" id="fecha-final">
                    </div>
                    <div class="d-flex justify-content-end w-25">
                        <div class="text-md-right dataTables_filter d-flex align-items-end">
                            {{-- Input para realizar la búsqueda del estudiante --}}
                            <input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="filtro" />
                        </div>
                    </div>
                    {{-- Botón de submit para realizar la búsqueda del estudiante --}}
                    <div class="d-flex align-items-end">
                        <button class="btn btn-rojo ml-3" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

            <table class="table my-0" id="dataTable">
                {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                <thead>
                    <tr>
                        <th>N° de Cédula</th>
                        <th>Nombre</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th>Ciclo lectivo</th>
                        <th>Lugar de atencion</th>
                        <th>Ver detalle</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}
                    @foreach($estudiantes as $estudiante)
                    <tr id="estudiante" class="cursor-pointer">
                        <td>{{ $estudiante->persona_id }}</td>
                        {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                        <td>{{ $estudiante->persona->apellido.", ". $estudiante->persona->nombre }}</td>
                        <td> {{ $estudiante->motivo }} </td>
                        <td> {{ $estudiante->fecha }}</td>
                        <td> {{ $estudiante->ciclo_lectivo }}</td>
                        <td> {{ $estudiante->lugar_atencion }}</td>
                        <td>
                            {{-- Botón para ver las guías académicas del estudiante --}}
                            <strong>
                                <a class="btn btn-contorno-rojo"> Ver detalle </a>
                            </strong><br />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                <tfoot>
                    <tr>
                        <th>N° de Cédula</th>
                        <th>Nombre</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th>Ciclo lectivo</th>
                        <th>Lugar de atencion</th>
                        <th>Ver detalle</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            {{-- Información general de los items por página y el total de resultados --}}
            <div class="col-md-6 align-self-center">
                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $estudiantes->perPage() }} de {{ $estudiantes->total() }}</p>
            </div>
            {{-- Items de paginación --}}
            <div class="col-md-6">
                {{ $estudiantes->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="{{ asset('js/control_educativo/informacion_guias_academicas/listado.js') }}" defer></script>
@endsection

@section('pie')
Copyright
@endsection
