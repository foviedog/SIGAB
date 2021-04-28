@extends('layouts.app')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('titulo')
Asistencia a {{ $actividad->tema }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@section('contenido')

@include('control_actividades_promocion.lista_asistencia.info')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Lista de asistencia</h3>&nbsp;&nbsp;&nbsp; <span class="border-left border-info texto-rojo-oscuro pl-2 p-0 font-weight-bold ">codigo de actividad: {{ $actividad->id }}</span>
            </div>
            {{-- Botones superiores --}}
            <div>
                {{-- Botón para regresar al listado de actividades --}}
                <a href="{{ route('actividad-promocion.show', $actividad->id) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
            </div>
        </div>
        <hr>
        <form action="{{ route('asistencia-promocion.show', $actividad->id) }}" method="GET" id="form-reload" style="display: none">
            <input type="hidden" id="mensaje" name="mensaje" value="" />
        </form>
        {{-- Boton de cancelar edicion --}}
        @php
        $mensaje = Session::get('mensaje');
        @endphp
        @if ($mensaje == 'success')
        {{-- Mensaje de exito --}}
        <div class="mensaje-container" id="mensaje-info" style="display:none;  ">
            <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style="background-image: url('/img/recursos/iconos/success.png');"></div>
            <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #046704e8; ">Participante agregado correctamente</div>
        </div>
        @elseif($mensaje == 'error')
        {{-- Mensaje de error --}}
        <div class="mensaje-container" id="mensaje-info" style="display:none; ">
            <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style=" background-image: url('/img/recursos/iconos/error.png');"></div>
            <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #b30808e8; ">Ocurrió un error al agregar el participante</div>
        </div>
        @endif

        @if (Session::has('eliminado'))
        {{-- Mensaje de exito al eliminar un participante de la lista --}}
        <div class="mensaje-container" id="mensaje-info" style="display:none;  ">
            <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style="background-image: url('/img/recursos/iconos/success.png');"></div>
            <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #046704e8; "> {{ Session::get('eliminado') }} </div>
        </div>
        @endif



        <input class="form-control" type='hidden' id="actividad-id" name="acitividad_id" value="{{ $actividad->id }}">


        <div class="row border-bottom pb-4 mb-4">

            <div class="col-5">
                <div class="card shadow">
                    <div class="card-body  ">
                        <div class="container-fluid">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col d-flex justify-content-center align-items-center" id="img-actividad">
                                    <img src="{{ asset('img/logoEBDI.png') }}" class="transicion-max-width" id="logo-EBDI" alt="logo_ebdi" style="max-width: 40%">
                                </div>
                                <div class="col-12 border-top d-flex align-items-center transicion-padding" id="info-actividad">
                                    <div class="w-100">
                                        <span class="my-1"> <strong>Nombre de actividad:</strong>
                                            {{ $actividad->tema }}</span> <br>
                                        <span class="my-1"> <strong>Fecha de la
                                                actividad:</strong> {{ $actividad->fecha_inicio_actividad }} <i class="far fa-arrow-alt-circle-right"></i> {{ $actividad->fecha_final_actividad }}</span><br>
                                        <span class="my-1"> <strong> Tipo de actividad:</strong>
                                            {{ $actividad->actividadPromocion->tipo_actividad }}</span><br>
                                        <span class="my-1"> <strong>Estado:</strong> </span>
                                        @if ( $actividad->estado == 'Para ejecución' )
                                        <span class=" bg-info text-dark font-weight-bold px-2 rounded">{{ $actividad->estado  }}</span>
                                        @elseif($actividad->estado == 'Cancelada')
                                        <span class=" bg-danger text-white px-2 rounded">{{ $actividad->estado  }}</span>
                                        @elseif($actividad->estado == 'En progreso')
                                        <span class=" bg-warning text-dark px-2 rounded">{{ $actividad->estado  }}</span>
                                        @elseif($actividad->estado == 'Ejecutada')
                                        <span class=" bg-success text-white px-2 rounded">{{ $actividad->estado  }}</span>

                                        @endif
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-6" id="nuevoParticipante">
                <form action="{{ route('asistencia-promocion.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input class="form-control" type='hidden' id="actividad-id" name="acitividad_id" value="{{ $actividad->id }}">
                    <input class="form-control" type='hidden' id="participante-encontrado2" name="participante-encontrado2" value="false">

                    <div class="card-header ">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Añadir participante
                                </h6>
                            </div>

                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    {{-- Campo: cedula --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <label for="cedula">Cedula <i class="text-danger">*</i></label>
                                                </div>
                                                <span class="text-muted " id="mostrar_cedula"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="cedula" name="cedula" onkeyup="contarCaracteres(this,100)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    {{-- Campo: nombre --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <label for="nombre">Nombre <i class="text-danger">*</i></label>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes --}}
                                                <span class="text-muted" id="mostrar_nombre"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="nombre" name="nombre" onkeyup="contarCaracteres(this,60)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    {{-- Campo: apellidos --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between w-100">

                                                <div>
                                                    <label for="apellidos">Apellidos <i class="text-danger">*</i></label>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes --}}
                                                <span class="text-muted" id="mostrar_apellidos"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="apellidos" name="apellidos" onkeyup="contarCaracteres(this,60)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    {{-- Campo: correo --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <label for="correo">Correo </label>
                                                </div>
                                                <span class="text-muted " id="mostrar_correo"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="correo" name="correo" onkeyup="contarCaracteres(this,100)">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    {{-- Campo: telefono --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between w-100">

                                                <div>
                                                    <label for="telefono">Telefono </label>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes --}}
                                                <span class="text-muted" id="mostrar_telefono"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="telefono" name="telefono" onkeyup="contarCaracteres(this,60)">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    {{-- Campo: procedencia --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <label for="procedencia">Procedencia </label>
                                                    <span data-toggle="tooltip" data-placement="bottom" title="Se ingresa el nombre del colegio de procedencia o colegio del cual es egresado(a)"><i class="far fa-question-circle fa-lg"></i></span>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes --}}
                                                <span class="text-muted" id="mostrar_procedencia"></span>
                                            </div>

                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="procedencia" name="procedencia" onkeyup="contarCaracteres(this,60)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                <input type="button" id="agregar-submit2" value="Agregar" class="btn btn-rojo btn-lg">
                            </div>
                        </div>
                        <input type="submit" id="submitStore" value="" style="display: none;">
                    </div>
                </form>
            </div>
            <div class="col-6 " id="loader" style="display:none;">
                <div class="d-flex justify-content-center mt-2 mb-4">
                    <h4 class="texto-rojo-oscuro">Agregando participante a la lista </h4>
                </div>
                <div class="loader-container d-flex justify-content-center">
                    <div class="loader1"></div>
                    <div class="loader2"> </div>
                </div>
            </div>


        </div>


        <div id="table_data">
            <div class="row mt-2 d-flex justify-content-center">
                <div class="col-11">
                    <div class="card shadow">
                        <div class="d-flex justify-content-between card-header py-3">
                            <div>
                                <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Participaciones </h6>
                            </div>
                            <div>
                                <button href="" class="btn btn-contorno-azul-una" id="btn-listar-todo"><i class="fas fa-redo"></i>&nbsp; Listar todo </button>
                            </div>
                        </div>
                        <form action="{{ route('asistencia-promocion.show', $actividad->id) }}" method="GET" id="form-busqueda">
                            <div class="row pt-3 px-3">

                                <div class="col-md-10 d-flex justify-content-start">
                                    <div class="d-flex justify-content-end w-25">
                                        <div class="text-md-right dataTables_filter input-group mb-3 ">
                                            {{-- Input para realizar la búsqueda del archivo --}}
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control w-50" id="filtro" name="filtro" placeholder="Búsqueda del participante." value="{{ $filtro ?? '' }}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Buscar por nombre, apellido o cédula">
                                                        <i class="far fa-question-circle fa-lg"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Botón de submit para realizar la búsqueda del archivo --}}
                                    <div>
                                        <button class="btn btn-rojo ml-3" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class=" d-flex justify-content-end" aria-controls="dataTable">
                                        <label class="font-weight-bold mr-2">Mostrar &nbsp; </label>
                                        {{-- Select con la cantidad de items por páginas --}}
                                        <select class="form-control form-control-sm custom-select custom-select-sm w-50" name="itemsPagina">
                                            @foreach ($paginaciones as $paginacion)
                                            <option value={{ $paginacion }} @if ($itemsPagina==$paginacion) selected @endif>{{ $paginacion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        </form>

                        <table class="table my-0" id="dataTable">
                            {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                            <thead>
                                <tr>
                                    <th>N° de Cédula</th>
                                    <th>Nombre</th>
                                    <th>Teléfono celular</th>
                                    <th>Correo</th>
                                    <th>Información</th>
                                    <th>Eliminar </th>
                                </tr>
                            </thead>
                            <tbody id="lista-participantes">
                                {{-- En caso de que no existan registros --}}
                                @if (count($listaAsistencia) == 0)
                                <tr class="cursor-pointer">
                                    <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i>
                                        &nbsp; No existen registros</td>
                                </tr>
                                @endif
                                {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}
                                @foreach ($listaAsistencia as $participante)
                                <tr id="" class="cursor-pointer">
                                    <td>{{ $participante->cedula }}</td>
                                    {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                                    <td>{{ $participante->apellidos . ', ' . $participante->nombre }}</td>
                                    <td>{!! $participante->numero_telefono ?? '<i class="font-weight-light"> No registrado</i>' !!}<br /> </td>
                                    <td>
                                        <strong>
                                            {!! $participante->correo ?? '<i class="font-weight-light"> No registrado</i>' !!}
                                        </strong>
                                    </td>
                                    <td>
                                        <button id="mostrar2-{{ $participante->cedula }}" data-idactividad="{{ $actividad->id }}" class="btn btn-contorno-rojo" type="button" onclick="mostrar2Info(this)"><i class="fas fa-eye"></i>
                                            &nbsp;Detalle</button>
                                    </td>
                                    <form action="{{ route('asistencia-promocion.destroy' ,$participante->cedula) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <td>
                                            <button class="btn btn-contorno-rojo" type="submit"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                                        </td>
                                        <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
                                    </form>

                                </tr>
                                @endforeach

                            </tbody>
                            {{-- Nombre de las columnas en la parte de abajo de la tabla --}}
                            <tfoot>
                                <tr>
                                    <th>N° de Cédula</th>
                                    <th>Nombre</th>
                                    <th>Teléfono celular</th>
                                    <th>Correo</th>
                                    <th>Información</th>
                                    <th>Eliminar </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

            </div>
            <div class="col-1">
                <div class="info-card" style="padding: 2px 0; max-width: 100%; ">
                    <span style="font-size: 36px; font-weight: bolder;" id="total">{{ $listaAsistencia->total() }}</span><br>
                    <span style="font-size: 20px; font-weight: light;  ">Total</span>
                </div>
            </div>
        </div>
        <div class="row px-3 py-2">
            <div class="col-md-3 align-self-center">

                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando
                    {{ $listaAsistencia->perPage() }} items por página de {{ $listaAsistencia->total() }}</p>


            </div>
            {{-- Items de paginación --}}
            <div class="col-md-5 ml-5 d-flex justify-content-center">

                {{ $listaAsistencia->withQueryString()->links() }}

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
{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>
<script src="{{ asset('js/control_actividades_promocion/lista_asistencia.js') }}"></script>
<script src="{{ asset('js/global/subirArchivos.js') }}"></script>
<script src="{{ asset('js/global/contarCaracteres.js') }}"></script>
<script src="{{ asset('js/global/mensajes.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection
