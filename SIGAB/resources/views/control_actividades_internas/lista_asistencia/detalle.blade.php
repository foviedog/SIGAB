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

@include('control_actividades_internas.lista_asistencia.invitado')
@include('control_actividades_internas.lista_asistencia.info')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Lista de asistencia</h3>&nbsp;&nbsp;&nbsp; <span class="border-left border-info texto-rojo-oscuro pl-2 p-0 font-weight-bold ">codigo de actividad: {{ $actividad->id }}</span>
            </div>
            {{-- Botones superiores --}}
            <div>
                @if(Accesos::ACCESO_VISUALIZAR_ACTIVIDADES())
                {{-- Botón para regresar al listado de actividades --}}
                <a href="{{ route('actividad-interna.show',$actividad->id ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                @endif

                @if(Accesos::ACCESO_REGISTRAR_PARTICIPANTES())
                {{-- Boton que habilita opcion de agregar participante --}}
                <button href="" class="btn btn-rojo" id="btn-agregar-part"> Añadir participante &nbsp; <i class="fas fa-plus-circle"></i> </button>
                {{-- Boton de cancelar --}}
                <button type="button" id="cancelar-edi" class="btn btn-rojo"><i class="fas fa-close "></i> Cancelar </button>
                @endif

                @if(Accesos::ACCESO_ELIMINAR_PARTICIPANTE())
                @include('layouts.messages.confirmar_eliminar')
                @endif

            </div>
        </div>
        <hr>

        <form action="{{ route('lista-asistencia.show',$actividad->id) }}" method="GET" id="form-reload" style="display: none">
            <input type="hidden" id="mensaje" name="mensaje" value="" />
            <input type="hidden" id="error" name="error" value="" />
        </form>

        {{-- Mensajes FIXED --}}
        @include('layouts.messages.sticky')

        <input class="form-control" type='hidden' id="actividad-id" name="acitividad_id" value="{{ $actividad->id }}">

        <div class="row border-bottom pb-2">

            <div class="col-5">
                <div class="card shadow">
                    <div class="card-body  ">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-3 d-flex justify-content-center align-content-center" id="img-actividad">
                                    <img src="{{ asset('img/logoEBDI.png') }}" class="transicion-max-width" id="logo-EBDI" alt="logo_ebdi" class="" style="width: 110px;">
                                </div>

                                <div class="col-9 border-left d-flex align-items-center transicion-padding" id="info-actividad">

                                    <div class="overflow-auto">
                                        <span class="my-1" style='max-width: 134%; width: max-content;'> <strong>Nombre de actividad:</strong> {{ $actividad->tema }}</span> <br>
                                        <span class="my-1" style='max-width: 134%; width: max-content; '> <strong>Público dirigido:</strong> {{ $actividad->actividadInterna->publico_dirigido  }}</span><br>
                                        <span class="my-1" style='max-width: 134%; width: max-content; '> <strong>Fecha de la actividad:</strong> {{ $actividad->fecha_inicio_actividad }} <i class="far fa-arrow-alt-circle-right"></i> {{ $actividad->fecha_final_actividad }}</span><br>
                                        <span class="my-1"> <strong> Tipo de actividad:</strong> {{ $actividad->actividadInterna->tipo_actividad }}</span><br>
                                        <span class="my-1"> <strong>Estado:</strong></span>
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

            @if(Accesos::ACCESO_REGISTRAR_PARTICIPANTES())
            <div class="col-6 " id="agregar-participante-card" style="display:none;">
                <div class="card shadow">
                    <div class="card-header ">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Añadir participante </h6>
                            </div>
                            <div>
                                <a href="#" class="btn btn-contorno-azul-una texto-azul-una" id="invitado-btn" data-toggle="modal" data-target="#agregar-invitado">Agregar invitado</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">

                        <div class="d-flex justify-content-center ml-4" id="input-buscar-agregar">
                            <div class="input-group w-50">
                                <input type='text' id="cedula-participante" name="participante" class="form-control" required>
                                <div class="input-group-append">
                                    <button type="button" id="buscar" class="btn btn-contorno-rojo">Buscar</button>
                                    <span data-toggle="tooltip" data-placement="right" title="Ingrese sin espacio y sin guiones el número de cédula del participante de coordinar la actividad y presione buscar" class="ml-2"> <i class="far fa-question-circle fa-lg mr-2"></i></span>
                                </div>
                            </div>
                            <input class="form-control" type='hidden' id="participante-encontrado" name="participante-encontrado" value="false">
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="alert alert-danger w-75 text-center" role="alert" id="mensaje-alerta" style="display:none;"></div>
                        </div>
                        <div class="row transicion-opacity" id="tarjeta-participante">
                            <div class="w-100 d-flex border-top  mt-3 ">
                                <div class="col-3 p-4">
                                    <div class="d-flex justify-content-center">
                                        <div class="overflow-hidden rounded " style="max-width: 160px; max-height: 160px; ">
                                            <img class=" rounded mb-3" id="imagen-participante" style="max-width: 100%;  " />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9  d-flex justify-content-start align-items-center transicion-opacity" id="info-parti" style="opacity:0;">
                                    <div class="w-100 text-start mb-3">
                                        <strong>Persona id:</strong> &nbsp;&nbsp;<span id="cedula-participante-card"> </span> <br>
                                        <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre-participante"> </span> <br>
                                        <strong>Correo institucional: </strong> &nbsp;&nbsp;<span id="correo-participante"> </span> <br>
                                        <strong>Número de teléfono: </strong> &nbsp;&nbsp;<span id="num-telefono-participante"></span> <br>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center" id="agregar-participante-footer">
                            <button href="" class="btn btn-rojo" id="agregar-submit"> Añadir participante &nbsp; <i class="fas fa-plus-circle"></i> </button>
                            <button href="" class="btn btn-gris ml-2" id="cancelar-agregar-part"> Cancelar &nbsp; <i class="fas fa-times-circle"></i> </button>
                        </div>
                    </div>
                </div>
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
                        <form autocomplete="off" action="{{ route('lista-asistencia.show',$actividad->id) }}" method="GET" id="form-busqueda">
                            <div class="row pt-3 px-3">
                                <div class="col-md-6 text-nowrap">
                                    <div class="" aria-controls="dataTable">
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
                                    <div class="d-flex justify-content-end w-50">
                                        <div class="text-md-right dataTables_filter input-group mb-3 ">
                                            {{-- Input para realizar la búsqueda del estudiante --}}
                                            <span data-toggle="tooltip" data-placement="bottom" title="Buscar por nombre, apellido o cédula"><i class="far fa-question-circle fa-lg"></i></span>

                                            &nbsp;&nbsp; <input type="search" class="form-control form-control-md" placeholder="Buscar estudiante" aria-controls="dataTable" placeholder="Buscar estudiante." name="filtro" @if (!is_null($filtro)) value="{{ $filtro }}" @endif />
                                        </div>
                                    </div>
                                    {{-- Botón de submit para realizar la búsqueda del estudiante --}}
                                    <div>
                                        <button class="btn btn-rojo ml-3" type="submit">Buscar &nbsp;<i class="fas fa-search"></i></button>
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
                                    <th>Correo institucional</th>
                                    <th>Informacion</th>
                                    @if(Accesos::ACCESO_ELIMINAR_PARTICIPANTE())
                                    <th>Eliminar</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="lista-participantes">

                                {{-- En caso de que no existan registros --}}
                                @if(count($listaAsistencia) == 0)
                                <tr class="cursor-pointer">
                                    <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                                </tr>
                                @endif
                                {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}
                                @foreach($listaAsistencia as $participante)
                                <tr id="" class="cursor-pointer">
                                    <td>{{ $participante->persona_id }}</td>
                                    {{-- Aquí se debería de agregar la foto del estudiante, si así se desea. --}}
                                    <td>{{ $participante->apellido.", ".  $participante->nombre }}</td>
                                    <td>{!! $participante->telefono_celular ?? '<i class="font-weight-light"> No registrado</i>' !!}<br /> </td>
                                    <td>
                                        <strong>
                                            {!! $participante->correo_institucional ?? '<i class="font-weight-light"> No registrado</i>'!!}
                                        </strong>
                                    </td>
                                    <td>
                                        <button id="mostrar-{{ $participante->persona_id }}" class="btn btn-contorno-rojo" type="button" onclick="mostrarInfo(this)"><i class="fas fa-eye"></i> &nbsp;Detalle</button>
                                    </td>

                                    @if(Accesos::ACCESO_ELIMINAR_PARTICIPANTE())
                                    <td>
                                        <a class="btn btn-contorno-rojo" onclick="rutaParticipanteInternas('{{ $participante->persona_id }}', {{ $actividad->id }})" data-toggle="modal" data-target="#modal-eliminar"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</a>
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
                                    <th>Correo institucional</th>
                                    <th>Informacion</th>
                                    @if(Accesos::ACCESO_ELIMINAR_PARTICIPANTE())
                                    <th>Eliminar </th>
                                    @endif
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
                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $listaAsistencia->perPage() }} items por página de {{ $listaAsistencia->total() }}</p>
            </div>
            {{-- Items de paginación --}}
            <div class="col-md-5 ml-5 d-flex justify-content-center">
                {{ $listaAsistencia->withQueryString()->links() }}
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
<script src="{{ asset('js/control_actividades_internas/lista_asistencia.js') }}"></script>
<script src="{{ asset('js/global/subirArchivos.js') }}"></script>
<script src="{{ asset('js/global/contarCaracteres.js') }}"></script>
<script src="{{ asset('js/global/mensajes.js') }}"></script>
<script type="text/javascript" defer="">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function eliminarParametros(){
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
