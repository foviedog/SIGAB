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
@if(Accesos::ACCESO_ELIMINAR_PARTICIPANTE())
@include('layouts.messages.confirmar_eliminar')
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Lista de asistencia</h3>&nbsp;&nbsp;&nbsp; <span class="border-left border-info texto-rojo-oscuro pl-2 p-0 font-weight-bold ">código de actividad: {{ $actividad->id }}</span>
            </div>
            {{-- Botones superiores --}}
            @if(Accesos::ACCESO_VISUALIZAR_ACTIVIDADES())
            <div>
                {{-- Botón para regresar al detalle de la actividad --}}
                <a href="{{ route('actividad-promocion.show', $actividad->id) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
            </div>
            @endif

        </div>
        <hr>

        <form action="{{ route('asistencia-promocion.show', $actividad->id) }}" method="GET" id="form-reload" style="display: none">
            <input type="hidden" id="mensaje" name="mensaje" value="" />
            <input type="hidden" id="error" name="error" value="" />
        </form>

        <input class="form-control" type='hidden' id="actividad-id" name="acitividad_id" value="{{ $actividad->id }}">

        <div class="row border-bottom pb-4 mb-4">

            <div class="col-5">
                <div class="card shadow">
                    <div class="card-body  ">
                        <div class="container-fluid">
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col d-flex justify-content-center align-items-center" id="img-actividad">
                                    <img src="{{ asset('img/logoEBDI.png') }}" class="transicion-max-width" id="logo-EBDI" alt="logo_ebdi" style="max-width: 26%; padding-bottom: 1.2rem;">
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

            @if(Accesos::ACCESO_MODIFICAR_ACTIVIDADES())
            <div class="col-6" id="nuevoParticipante">
                <form autocomplete="off" action="{{ route('asistencia-promocion.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input class="form-control" type='hidden' id="actividad-id" name="acitividad_id" value="{{ $actividad->id }}">
                    <input class="form-control" type='hidden' id="participante-encontrado2" name="participante-encontrado2" value="false">

                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Añadir participante
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    {{-- Campo: cedula --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <label for="cedula">Cédula <i class="text-danger">*</i></label>
                                                </div>
                                                <span class="text-muted " id="mostrar_cedula"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="cedula" name="cedula" onkeypress="contarCaracteres(this,100)" required>
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
                                                <input type='text' class="form-control w-100" id="nombre" name="nombre" onkeypress="contarCaracteres(this,60)" required>
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
                                                <input type='text' class="form-control w-100" id="apellidos" name="apellidos" onkeypress="contarCaracteres(this,60)" required>
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
                                                <input type='text' class="form-control w-100" id="correo" name="correo" onkeypress="contarCaracteres(this,100)">

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
                                                    <label for="telefono">Teléfono </label>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes --}}
                                                <span class="text-muted" id="mostrar_telefono"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="telefono" name="telefono" onkeypress="contarCaracteres(this,60)">

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
                                                <input type='text' class="form-control w-100" id="procedencia" name="procedencia" onkeypress="contarCaracteres(this,60)">
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
            @endif

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
                            <div class="row d-flex justify-content-between m-1 mt-3">

                                <div class="col-6 d-flex ">
                                    <div class="input-group ">
                                        <div class="input-group-prepend ">
                                            {{-- Input para realizar la búsqueda del participante --}}
                                            <span class="input-group-text texto-azul-una font-weight-bold" data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg texto-azul-una"></i></span>
                                        </div>
                                        <input type="search" class="form-control form-control-md" aria-controls="dataTable" placeholder="Búsqueda del participante." name="filtro" @if (!is_null($filtro)) value="{{ $filtro }}" @endif />
                                    </div>
                                    {{-- Botón de submit para realizar la búsqueda del participante --}}
                                    <div class="d-flex justify-content-center" style="width: 30%">
                                        <button class="btn btn-rojo" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
                                    </div>
                                </div>
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

                        <div class="table-responsive table p-3 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 " id="dataTable">
                                {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                                <thead>
                                    <tr>
                                        <th>N° de Cédula</th>
                                        <th>Nombre</th>
                                        <th>Teléfono celular</th>
                                        <th>Correo</th>
                                        <th>Información</th>
                                        @if(Accesos::ACCESO_ELIMINAR_PARTICIPANTE())
                                        <th>Eliminar</th>
                                        @endif
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

                                        @if(Accesos::ACCESO_ELIMINAR_PARTICIPANTE())
                                        <td>
                                            <a class="btn btn-contorno-rojo" onclick="rutaParticipantePromocion('{{ $participante->cedula }}', {{ $actividad->id }})" data-toggle="modal" data-target="#modal-eliminar"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</a>
                                        </td>
                                        @endif

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
                                        @if(Accesos::ACCESO_ELIMINAR_PARTICIPANTE())
                                        <th>Eliminar </th>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>

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
                <div class="col-1">
                    <div class="info-card" style="padding: 2px 0; max-width: 100%; ">
                        <span style="font-size: 36px; font-weight: bolder;" id="total">{{ $listaAsistencia->total() }}</span><br>
                        <span style="font-size: 20px; font-weight: light;  ">Total</span>
                    </div>
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

    function eliminarParametros() {
        var url = window.location.href;
        var indexHref = url.indexOf("?");
        url = url.substr(0, indexHref)
        window.history.pushState({}, '', url);
    }

    @if(!is_null($mensaje))
    setTimeout(function() {
        toastr.success("{{ $mensaje }}");
        eliminarParametros()
    }, 100);
    @endif

    @if(!is_null($error))
    setTimeout(function() {
        toastr.error("{{ $error }}");
        eliminarParametros()
    }, 100);
    @endif

</script>

@endsection
