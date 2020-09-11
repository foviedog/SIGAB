@extends('layouts.app')

@section('titulo')
Listado Estudiantil
@endsection

@section('css')

@endsection



@section('contenido')

<div class="d-flex justify-content-between">
    <h2 class="texto-gris-oscuro mb-4">Control Estudiantil</h2>
    <div>
        <a href="/estudiante/registrar" class="btn btn-rojo"> Añadir Estudiante &nbsp; <i class="fas fa-plus-circle"></i> </a>




    </div>

</div>

<div class="card shadow">
    <div class="card-header py-3">
        <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de estudiantes </p>
    </div>
    <div class="card-body">
        <form action="listadoEstudiantil" method="GET" role="form" id="item-pagina">
            <div class="row">
                <div class="col-md-6 text-nowrap">
                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                        <label class="font-weight-bold">Mostrar &nbsp;
                            <select class="form-control form-control-sm custom-select custom-select-sm" name="itemsPagina" onchange="document.getElementById('item-pagina').submit()">
                                @foreach($paginaciones as $paginacion)
                                <option value={{ $paginacion }} @if ($itemsPagina==$paginacion )selected @endif>{{ $paginacion }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="d-flex justify-content-end w-50">
                        <div class="text-md-right dataTables_filter input-group mb-3 ">
                            <input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." aria-label="buscaEstudiante" aria-describedby="filtro estudiante" name="filtro" />
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-rojo ml-3" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">

            <table class="table my-0" id="dataTable">
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
                    @foreach($estudiantes as $estudiante)
                    <tr id="estudiante" class="cursor-pointer" onclick="clickEnEstudiante()">
                        <td>{{ $estudiante->persona_id }}</td>
                        {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                        <td>{{ $estudiante->persona->apellido.", ". $estudiante->persona->nombre }}</td>
                        <td>{{ $estudiante->carrera_matriculada_1 }} </td>
                        <td>{{ $estudiante->persona->telefono_celular }}<br /> </td>
                        <td>
                            <strong>
                                {{ $estudiante->persona->correo_personal }}
                            </strong>
                        </td>
                        <td>
                            <strong>
                                <a href="/detalle/{{ $estudiante->persona_id }}" class="btn btn-contorno-rojo"> Detalle </a>
                            </strong><br />
                        </td>
                        <td>
                            <strong>
                                <a href="/detalle/{{ $estudiante->persona_id }}" class="btn btn-contorno-rojo"> Ver guías </a>
                            </strong><br />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td><strong>N° de Cédula<br /></strong></td>
                        <td><strong>Nombre<strong></td>
                        <td><strong>Carrera (Principal) matriculada<br /></strong></td>
                        <td><strong>Telefono Celular</strong><br /></td>
                        <td><strong>Correo<br /></strong></td>
                        <td><strong>Ver detalle<br /></strong></td>
                        <td><strong>Guia académica<br /></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6 align-self-center">
                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $estudiantes->perPage() }} de {{ $estudiantes->total() }}</p>
            </div>
            <div class="col-md-6">
                {{ $estudiantes->links() }}
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
