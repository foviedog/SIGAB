@extends('layouts.app')

@section('titulo')
Listado Estudiantil
@endsection

@section('css')

@endsection



@section('contenido')

{{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
<div class="d-flex justify-content-between">
    {{-- //Título de la página --}}
    <h2 class="texto-gris-oscuro mb-4">Lista de Guias Academicas</h2>
    <div>
        {{-- //Botón para añadir estudainte --}}
        <a href="/estudiante/registrar" class="btn btn-rojo"> Añadir Estudiante &nbsp; <i class="fas fa-plus-circle"></i> </a>
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
                <div class="col-md-6 text-nowrap">
                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                        <label class="font-weight-bold">Mostrar &nbsp;
                            {{-- Select con la cantidad de items por páginas--}}
                            <select class="form-control form-control-sm custom-select custom-select-sm" name="itemsPagina" onchange="document.getElementById('item-pagina').submit()">

                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="d-flex justify-content-end w-50">
                        <div class="text-md-right dataTables_filter input-group mb-3 ">
                            {{-- Input para realizar la búsqueda del estudiante --}}
                        </div>
                    </div>
                    {{-- Botón de submit para realizar la búsqueda del estudiante --}}
                    <div>
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

                    <tr id="estudiante" class="cursor-pointer">
                        <td></td>
                        {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                        <td></td>
                        <td> </td>
                        <td><br /> </td>
                        <td>
                            <strong>

                            </strong>
                        </td>
                        <td>
                            {{-- Botón para ver el detalle del estudiante --}}
                            <strong>
                                <a class="btn btn-contorno-rojo"> Detalle </a>
                            </strong><br />
                        </td>
                        <td>
                            {{-- Botón para ver las guías académicas del estudiante --}}
                            <strong>
                                <a  class="btn btn-contorno-rojo"> Ver guías </a>
                            </strong><br />
                        </td>
                    </tr>

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
                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando </p>
            </div>
            {{-- Items de paginación --}}
            <div class="col-md-6">

            </div>
        </div>
    </div>
</div>



@endsection


@section('scripts')

@endsection

@section('pie')
Copyright
@endsection
