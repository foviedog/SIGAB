@extends('layouts.app')

@section('titulo')
Listado de Guías Académicas
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

                        <h5 class="modal-title" id="agregar-guia-modal"><strong>Añadir Guía Académica</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert" id="no-existe-estudiante">
                            El estudiante ingresado no existe.
                        </div>
                        <div class="form-group">
                            <label for="id-estudiante" class="col-form-label">Cédula del estudiante:</label>
                            <input type="text" class="form-control" name="cedula" id="id-estudiante" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-rojo" id="crear-guia-modal">Crear Guía Académica</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL para ver el detalle de una guía académica--}}
        <div class="modal fade" id="detalle-guia-modal" tabindex="-1" aria-labelledby="detalle-guia-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog   modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold" id="detalle-guia-modal">Detalle de Guía Académica</h5>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-rojo" id="habilitar-edicion">
                                    Habilitar edición
                                </button>
                                <button type="button" class="btn btn-rojo" id="cancelar-edicion">
                                    Cancelar edición
                                </button>
                            </div>
                    </div>
                    <div class="modal-body">

                        <div class="container">
                            <div class="d-flex justify-content-center mb-2">
                                <img class="rounded mb-3" width="160" height="160" id="imagen-modal" />
                            </div>
                            <div class="d-flex justify-content-center align-items-center border-bottom">
                                <div class="text-center mb-3">
                                    <strong>Persona id:</strong> &nbsp;&nbsp;<span id="cedula"></span> <br>
                                    <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre"></span> <br>
                                    <strong>Correo personal: </strong> &nbsp;&nbsp;<span id="correo"></span> <br>
                                </div>
                            </div>

                            <form action="" method="post" id="form-actualizar" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label for="motivo" class="col-form-label mt-3">Tipo &nbsp;<i class="text-danger">*</i></label>
                                    <select class="form-control mb-3" id="tipo" name="tipo" size="10" required disabled>
                                        @foreach($tipos as $tipo)
                                        <option>{{ $tipo }}</option>
                                        @endforeach
                                    </select>
                                    <div id="tipo-mostrar"></div>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between w-100">
                                        <label for="lugar" class="col-form-label">Lugar de atención &nbsp;<i class="text-danger">*</i></label>
                                        <span class="text-muted" id="mostrar_lugar"></span>
                                    </div>
                                    <input type="text" class="form-control" id="lugar" name="lugar" onkeyup="contarCaracteres(this,44)" required disabled>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fecha" class="col-form-label">Fecha &nbsp;<i class="text-danger">*</i></label>
                                            <input type="date" class="form-control" id="fecha" name="fecha" required disabled>
                                        </div>
                                    </div>
                                    <div class="col mt-2">
                                        <div class="form-group">
                                            <label for="ciclo">Ciclo lectivo &nbsp;<i class="text-danger">*</i></label>
                                            <select class="form-control" id="ciclo" name="ciclo" required disabled>
                                                <option value="Ciclo I">Ciclo I </option>
                                                <option value="Ciclo II">Ciclo II </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <label class="col-form-label">Solicitado por &nbsp;<i class="text-danger">*</i></label><br>
                                <div class="row my-3 mx-1">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="radio" id="radio1" value="est" disabled>
                                            <label class="form-check-label" for="radio">
                                                Estudiante
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="radio" id="radio2" value="docen" disabled>
                                            <label class="form-check-label" for="radio">
                                                Docente
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="collapse mb-3" id="lista_docentes">
                                    Seleccione el docente
                                    <select class="form-control mb-3" size="10" id="docente" disabled>
                                        @foreach($docentes as $docente)
                                        <option>{{ $docente->persona->persona_id." - ".$docente->persona->nombre." ".$docente->persona->apellido }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div id="docente-mostrar"></div>

                                {{-- Input oculto que envia si es la guía es solicitada por un estudiante o por un educador --}}
                                <input type="hidden" name="solicitud" id="solicitud">

                                <div class="form-group">
                                    <label for="situacion" class="col-form-label">Situación &nbsp;<i class="text-danger">*</i></label>
                                    <textarea class="form-control" id="situacion" rows="2" cols="50" name="situacion" disabled required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="recomendaciones">Recomendaciones </label>
                                    <textarea class="form-control" id="recomendaciones" rows="4" cols="50" name="recomendaciones" disabled></textarea>
                                    <span class="text-muted" id="mostrar_cant_recomendaciones"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="col-form-label" for="adjuntar-archivo">Adjuntar archivo</label> <br>
                                    <input type="file" name="archivo" class="border" id="adjuntar-archivo" disabled> &nbsp;
                                    <span data-toggle="tooltip" id="tooltip" data-placement="bottom" title="Si el archivo adjunto ya existe, se reemplazará al elegir otro"><i class="far fa-question-circle fa-lg"></i></span>
                                    <br><span style="cursor: pointer" onclick="quitarArchivo()" id="quitar-archivo">Quitar archivo</span>
                                    <div class="text-danger" id="mensaje-informacion-archivo">Los formatos permitidos son: <b>csv, txt, xlx, xls, pdf, docx, zip, rar, 7zip</b>.
                                        <br>El archivo no debe pesar más de <b>30MB</b>.</div>

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>

                                <div id="archivo-adjunto-existente"></div>
                                <div id="eliminar-archivo"></div>

                                <div class="alert alert-danger text-center" role="alert" id="rellenar-campos-modificar">
                                    Hay campos vacíos que son obligatorios.
                                </div>

                        </div>

                        </form>
                    </div>
                    <input type="hidden" name="id-guia-modal" id="id-guia-modal">

                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-gris" data-dismiss="modal" id="cerrar-modal-edicion">Cerrar</button>
                        <button type="button" class="btn btn-rojo ml-3" id="terminar-edicion">Terminar edición</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- // Items de la parte alta de la página (Título y botón de añadir) --}}
        <div class="d-flex justify-content-between">
            {{-- //Título de la página --}}
            <h2 class="texto-gris-oscuro ml-3 mb-4">Lista de Guías Académicas</h2>

            <div class="d-flex ">
                <div class="mr-2">
                    {{-- Regresar al listado de estudiantes --}}
                    <a href="/listado-estudiantil" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Ir al listado de estudiantes</a>
                </div>
                <div class="mr-2">
                    <a href="{{ route('guia-academica.listar') }}" class="btn btn-contorno-rojo"> Listar todo &nbsp; <i class="fas fa-bars"></i> </a>
                </div>
                <div>
                    <button class="btn btn-rojo" data-toggle="modal" data-target="#agregar-guia-modal" data-whatever="Añadir Guía">
                        Añadir Guía Académica &nbsp; <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
        @if(Session::has('exito'))
        <div class="alert alert-success" role="alert" id="mensaje-exito">
            {!! \Session::get('exito') !!}
        </div>
        @endif
        {{-- Mensaje de error (solo se muestra si ha sido ocurrio algun error en la insercion) --}}
        @php
        $error = Session::get('error');
        @endphp

        @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ "¡Oops! Algo ocurrió. ".$error }}
        </div>
        @endif
        {{-- // Contenedor de la tabla --}}
        <div class="card shadow">
            <div class="card-header py-3">
                {{-- //Título de la tabla --}}
                <p class="text-primary m-0 font-weight-bold texto-rojo-oscuro">Información de guías académicas</p>
            </div>

            <div class="card-body">
                {{-- // Form para la paginación de la página y para la búsqueda de estudiantes --}}
                <form action="{{ route('guia-academica.listar') }}" method="GET" role="form" id="item-pagina">
                    <div class="row">
                        <div class="col-md-4 text-nowrap d-flex align-items-end">
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
                        <div class="col-md-8 d-flex justify-content-end">
                            <div class="mx-2 ">
                                <label for="fecha-inicio" class="ml-3"> &nbsp;Fecha inicio: </label>
                                <div class="d-flex">
                                    <span id="fechaIni" class="fechaIni" data-toggle="tooltip" data-placement="bottom" title="Limpiar Fecha de inicio"><i class="far fa-times-circle fa-lg"></i> &nbsp;</span>
                                    <input type="date" class="form-control form-control-sm" name="fechaIni" id="fecha-inicio" @if (!is_null($fechaIni)) value={{ $fechaIni }} @endif>
                                </div>
                            </div>
                            <div class=" mx-3 ">
                                <label for=" fecha-final" class="ml-3"> &nbsp; Fecha final: </label>
                                <div class="d-flex">
                                    <span id="fechaFin" class="fechaFin" data-toggle="tooltip" data-placement="bottom" title="Limpiar Fecha final"><i class="far fa-times-circle fa-lg"></i> &nbsp;</span>
                                    <input type="date" class="form-control form-control-sm" name="fechaFin" id="fecha-final" @if (!is_null($fechaFin)) value={{ $fechaFin }} @endif>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end w-25">
                                <div class="text-md-right dataTables_filter d-flex align-items-center mt-3">
                                    {{-- Input para realizar la búsqueda del estudiante --}}
                                    <span data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg"></i></span>
                                    &nbsp;&nbsp;<input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="nombreFiltro" @if (!is_null($filtro)) value={{ $filtro }} @endif />
                                </div>
                            </div>
                            {{-- Botón de submit para realizar la búsqueda del estudiante --}}
                            <div class="d-flex align-items-center mt-3">
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
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Ciclo lectivo</th>
                                <th>Lugar de atención</th>
                                <th>Ver detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}
                            @if(count($guias) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            @foreach($guias as $guia)
                            <tr class="cursor-pointer">
                                <td>{{ $guia->persona_id }}</td>
                                {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                                <td>{{ $guia->apellido.", ". $guia->nombre }}</td>
                                <td> {{ $guia->tipo }}  </td>
                                <td> {{ date("d-m-Y",strtotime($guia->fecha)) }} </td>
                                <td> {{ $guia->ciclo_lectivo }} </td>
                                <td> {{ $guia->lugar_atencion }}</td>
                                <td>
                                    {{-- Botón para ver el detalle de la guía académica del estudiante --}}
                                    <button type="button" class="btn btn-contorno-rojo" data-toggle="modal" data-target="#detalle-guia-modal" data-idguia="{{ $guia->id }}">
                                        Detalle
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
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Ciclo lectivo</th>
                                <th>Lugar de atención</th>
                                <th>Ver detalle</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    {{-- Información general de los items por página y el total de resultados --}}
                    <div class="col-md-3 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $guias->perPage() }} de {{ $guias->total() }}</p>
                    </div>
                    {{-- Items de paginación --}}
                    <div class="col-md-6">
                        {{ $guias->withQueryString()->links() }}
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
    var documentosURL = "{{ URL::asset('/estudiante/guia-academica/download/') }}";

</script>

<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_educativo/informacion_guias_academicas/listado.js') }}" defer></script>
@endsection

@section('pie')
Copyright
@endsection
