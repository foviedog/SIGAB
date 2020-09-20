@extends('layouts.app')

@section('titulo')
Listado de Guias Academicas
@endsection

@section('css')

@endsection


@section('contenido')
<div class="card">
    <div class="card-body">
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
                    <form action="/estudiante/guia-academica/registrar" method="GET" role="form" enctype="multipart/form-data" id="guia">
                        @csrf
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert">
                                El estudiante ingresado no existe!
                            </div>
                            <div class="form-group">
                                <label for="id-estudiante" class="col-form-label">Cédula del estudiante:</label>
                                <input type="text" class="form-control" name="cedula">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-rojo">Crear Guía Académica</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- MODAL para ver el detalle de una guía académica--}}
        <div class="modal fade" id="detalle-guia-modal" tabindex="-1" aria-labelledby="detalle-guia-modal" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="detalle-guia-modal">Detalle de guía académica</h5>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-rojo" id="habilitar-edicion">
                                    Habilitar edición
                                </button>
                            </div>
                    </div>
                    <div class="modal-body">

                        <div class="d-flex justify-content-center mb-2">
                            <img class="rounded mb-3" width="160" height="160" id="imagen-modal" />
                        </div>
                        <div class="d-flex justify-content-center align-items-center border-bottom">
                            <div class=" text-center mb-3">
                                <strong> Persona id:</strong> &nbsp;&nbsp;<span id="cedula"></span> <br>
                                <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre"></span> <br>
                                <strong>Correo personal: </strong> &nbsp;&nbsp;<span id="correo"></span> <br>
                            </div>
                        </div>


                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="motivo" class="col-form-label">Motivo:</label>
                                        <input type="text" class="form-control" id="motivo" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="fecha" class="col-form-label">Fecha:</label>
                                        <input type="text" class="form-control" id="fecha" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="ciclo" class="col-form-label">Ciclo lectivo:</label>
                                        <input type="text" class="form-control" id="ciclo" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="lugar-atencion" class="col-form-label">Lugar de atención:</label>
                                        <input type="text" class="form-control" id="lugar-atencion" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="situacion" class="col-form-label">Situación:</label>
                                <textarea class="form-control" id="situacion" rows="2" cols="50" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="recomendaciones">Recomendaciones:</label>
                                <textarea class="form-control" id="recomendaciones" rows="4" cols="50" disabled>
                        </textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-rojo ml-3">Terminar edición</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- //Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Lista de Guías Academicas</h2>
            <div>
                {{-- //Botón para añadir estudainte --}}
                <button class="btn btn-rojo" data-toggle="modal" data-target="#agregar-guia-modal" data-whatever="Añadir Guía">
                    Añadir Guía académica &nbsp; <i class="fas fa-plus-circle"></i>
                </button>
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
                            @foreach($guias as $guia)
                            <tr class="cursor-pointer">
                                <td>{{ $guia->persona_id }}</td>
                                {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                                <td>{{ $guia->apellido.", ". $guia->nombre }}</td>
                                <td> {{ $guia->motivo }} </td>
                                <td> {{ $guia->fecha }}</td>
                                <td> {{ $guia->ciclo_lectivo }}</td>
                                <td> {{ $guia->lugar_atencion }}</td>
                                <td>
                                    {{-- Botón para ver el detalle de la guía académica del estudiante --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-guia-modal" data-idestudiante="{{ $guia->id }}">
                                        Ver detalle
                                    </button>
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
                        {{-- <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $estudiantes->perPage() }} de {{ $estudiantes->total() }}</p> --}}
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-6">
                        {{-- {{ $estudiantes->withQueryString()->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    // "global" vars, built using blade
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

</script>

<script src="{{ asset('js/control_educativo/informacion_guias_academicas/listado.js') }}" defer></script>
@endsection

@section('pie')
Copyright
@endsection
