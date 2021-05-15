@extends('layouts.app')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('titulo')
Evidencias de {{ $actividad->tema }}
@endsection

@section('css')
{{-- Ninguna hoja de estilo por el momento --}}
@endsection

@php
$tiposDocumentos =
['video' => '<i class="fab fa-youtube fa-3x texto-rojo-medio"></i>',
'pdf' => '<i class="far fa-file-pdf fa-3x texto-rojo-medio"></i>',
'documento' => '<i class="far fa-file-word fa-3x texto-azul-una"></i>',
'excel'=> '<i class="far fa-file-excel fa-3x text-success"></i> ',
'presentacion' => '<i class="far fa-file-powerpoint fa-3x " style="color:#cb4424 !important"></i>',
'comprimido' => '<i class="far fa-file-archive fa-3x" style="color:#522d83 !important"></i>',
'imagen'=>'<i class="far fa-file-image fa-3x text-info"></i>'];
@endphp

@section('contenido')

@include('evidencias.info')
<div class="card">


    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Lista de evidencias </h3>&nbsp;&nbsp;&nbsp; <span class="border-left border-info texto-rojo-oscuro pl-2 p-0 font-weight-bold ">codigo de actividad: {{ $actividad->id }}</span>
            </div>
            {{-- Botones superiores --}}
            <div>
                @if(!is_null($actividad->actividadInterna))

                    @if(Accesos::ACCESO_LISTAR_ACTIVIDADES())
                    {{-- Botón para regresar al listado de actividades --}}
                    <a href="{{ route('actividad-interna.show',$actividad->id) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                    @endif

                @else

                    @if(Accesos::ACCESO_VISUALIZAR_ACTIVIDADES())
                    {{-- Botón para regresar al listado de actividades --}}
                    <a href="{{ route('actividad-promocion.show',$actividad->id) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                    @endif

                @endif

                @if(Accesos::ACCESO_REGISTRAR_EVIDENCIA())
                {{-- Boton que habilita opcion de agregar evidencia --}}
                <button href="" class="btn btn-rojo" id="btn-agregar-evid"> Añadir evidencia &nbsp; <i class="fas fa-plus-circle"></i> </button>
                @endif

                @if(Accesos::ACCESO_ELIMINAR_EVIDENCIAS_ACTIVIDADES())
                    @include('layouts.messages.confirmar_eliminar')
                @endif


            </div>
        </div>

        <hr>
        <form action="{{ route('evidencias.show',$actividad->id) }}" method="GET" id="form-reload" style="display: none">
            <input type="hidden" id="mensaje" name="mensaje" value="" />
        </form>
        @php
        $mensaje = Session::get('mensaje');
        @endphp
        @if($mensaje == 'success')

        {{-- Mensaje de exito  --}}
        <div class="mensaje-container" id="mensaje-info" style="display:none;  ">
            <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style="background-image: url('/img/recursos/iconos/success.png');"></div>
            <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #046704e8; ">Evidencia agregada correctamente</div>
        </div>
        @elseif($mensaje == 'error')
        {{-- Mensaje de error --}}
        <div class="mensaje-container" id="mensaje-info" style="display:none; ">
            <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style=" background-image: url('/img/recursos/iconos/error.png');"></div>
            <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #b30808e8; ">Ocurrió un error al agregar la evidencia</div>
        </div>
        @endif

        @if(Session::has('eliminado'))
        {{-- Mensaje de exito al eliminar una evidencia de la lista --}}
        <div class="mensaje-container" id="mensaje-info" style="display:none;  ">
            <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style="background-image: url('/img/recursos/iconos/success.png');"></div>
            <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #046704e8; "> {{ Session::get('eliminado') }} </div>
        </div>
        @endif



        <div class="row border-bottom mb-3 pb-2">

            <div class="col-5">
                <div class="card shadow mb-3">
                    <div class="card-body  ">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-4" id="img-actividad">
                                    <img src="{{ asset('img/logoEBDI.png') }}" class="transicion-max-width" id="logo-EBDI" alt="logo_ebdi" class="" style="max-width: 100%">
                                </div>
                                <div class="col-7 border-left d-flex align-items-center transicion-padding" id="info-actividad">
                                    <div class="overflow-auto">
                                        <span class="my-1" style='width: 134%; '> <strong>Nombre de actividad:</strong> {{ $actividad->tema }}</span> <br>
                                        @if(!is_null($actividad->actividadInterna))
                                        <span class="my-1" style='width: 134%; '> <strong>Público dirigido:</strong> {{ $actividad->actividadInterna->publico_dirigido  }}</span><br>
                                        <span class="my-1"> <strong> Tipo de actividad:</strong> {{$actividad->actividadInterna->tipo_actividad }}</span><br>
                                        @endif
                                        <span class="my-1" style='width: 120%; '> <strong>Fecha de la actividad:</strong> {{ $actividad->fecha_inicio_actividad }} <i class="far fa-arrow-alt-circle-right"></i> {{ $actividad->fecha_final_actividad }}</span><br>
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

            <div class="col-6 mb-3 " id="agregar-evidencia-card">
            @if(Accesos::ACCESO_REGISTRAR_EVIDENCIA())
                <form autocomplete="off" method="POST" action="{{ route('evidencias.store') }}" id="form-evidencia" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow">
                        <div class="card-header ">
                            <div class="s d-flex justify-content-between">
                                <div>
                                    <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo ml-2">Añadir evidencia </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="d-flex justify-content-between">
                                {{-- Input para colocar el nombre que se le desea poner al archivo --}}
                                <div class="input-group px-2 mb-3 w-75 ml-1 pl-3">
                                    <input type="text" id="nombre-archivo" name="nombre_archivo" aria-label="Nombre archivo" class="form-control" placeholder="Nombre del archivo" onkeyup="contarCaracteres(this,99)" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Nombre con el que quiere guardar el archivo"><i class="far fa-edit texto-azul-una"></i></span>
                                    </div>
                                    <span class="ml-1 text-muted d-flex align-items-center" id="mostrar_nombre-archivo"></span>
                                </div>

                                <div class="custom-control custom-checkbox mr-5" id="wrap-chec-video">
                                    <input type="checkbox" class="custom-control-input" id="es-video" onclick="mostrarUrlVideo(this)">
                                    <input type="hidden" id="check_video" name="check_video">
                                    <label class="custom-control-label" for="es-video">Es un video</label>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="alert alert-danger w-75 text-center font-weight-bold" role="alert" id="mensaje-alerta" style="display: none;"> <i class="fas fa-exclamation-triangle"></i> No ha agregado ninguna evidencia </div>
                            </div>
                            {{-- Input para registrar el url del video --}}
                            <div class="input-group px-2 mb-3 ml-1 pl-3" id="wrap-url-video">
                                <input type="text" id="url-video" name="url_video" aria-label="Url video" class="form-control" placeholder="Url o link del video">
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="tooltip" data-placement="right" title="Coloque el url del video de youtube"><i class="fab fa-youtube texto-rojo-medio"></i></span>
                                </div>
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="file-upload" id="file-upload">
                                <span class="text-danger">
                                    Los formatos permitidos son: <b>csv, xlx, xls, pdf, docx, rar, zip, 7zip, pptx, ppsx, pptm, jpg , jpeg, png, svg</b>.
                                    <br>El archivo no debe pesar más de <b>30MB</b>.
                                </span>
                                <button class="file-upload-btn btn btn-contorno-rojo w-100" type="button" onclick="$('.file-upload-input').trigger( 'click' )">AGREGAR EVIDENCIA</button>
                                <div class="file-upload-wrap">
                                    <input class="file-upload-input" id="evidencia-file" name="evidencia" type='file' onchange="readURL(this);" />
                                    <div class="drag-text">
                                        <h4>SELECCIONE LA EVIDENCIA</h4>
                                    </div>
                                </div>
                                <div class="file-upload-content">
                                    <img class="file-upload-image rounded" src="#" alt="Previsualizacion de evidencia" />
                                    <div class="file-title-wrap">
                                        <button type="button" class="remove-file" onclick="removeUpload()"><i class="fas fa-ban"></i> &nbsp; <span class="file-title">Subir evidencia</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-rojo" id="agregar-submit"> Añadir evidencia &nbsp; <i class="fas fa-plus-circle"></i> </button>
                                <button class="btn btn-gris ml-2" id="btn-cancelar-agregar"> Cancelar &nbsp; <i class="fas fa-times-circle"></i> </button>
                            </div>
                        </div>
                    </div>
                    <input type='hidden' class="form-control" id="actividad-id" name="actividad_id" value="{{ $actividad->id }}">
                    <button type="submit" id="hidden-submit" style="display: none;"> </button>
                </form>
                @endif
            </div>
            <div class="col-6 " id="loader" style="display: none;">
                <div class="d-flex justify-content-center mt-2 mb-4">
                    <h4 class="texto-rojo-oscuro">Agregando evidencia </h4>
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
                                <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Evidencias subidas </h6>
                            </div>
                            <div>
                                <form action="{{ route('evidencias.show',$actividad->id) }}" method="GET" id="form-busqueda">
                                    <button type="submit" class="btn btn-contorno-azul-una" id="btn-listar-todo"><i class="fas fa-redo"></i>&nbsp; Listar todo </button>
                                </form>
                            </div>
                        </div>

                        <form action="{{ route('evidencias.show',$actividad->id) }}" method="GET" id="form-busqueda">
                            <div class="row pt-3 px-3">

                                <div class="col-md-10 d-flex justify-content-start">
                                    <div class="d-flex justify-content-end w-50">
                                        <div class="input-group text-md-right dataTables_filter  mb-3 ">
                                            {{-- Input para realizar la búsqueda del archivo --}}
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control w-50" id="nombre_filtro" name="nombre_filtro" placeholder="Nombre de la evidencia." value="{{ $nombre_filtro ?? "" }}">
                                                <select name="tipo_filtro" id="tipo_filtro" class="custom-select w-25">
                                                    <option value=""> Todos los tipos </option>
                                                    @foreach($tiposDocumentos as $tipo => $icono)
                                                    <option value="{{ $tipo }}" @if($tipo==$tipo_filtro) selected @endif> {{ $tipo }} </option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <div class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Buscar por nombre y tipo de archivo (No es necesario seleccionar ambos)"><i class="far fa-question-circle fa-lg"></i></div>
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
                                        {{-- Select con la cantidad de items por páginas--}}
                                        <select class="form-control form-control-sm custom-select custom-select-sm w-50" name="itemsPagina">
                                            @foreach($paginaciones as $paginacion)
                                            <option value={{ $paginacion }} @if ($itemsPagina==$paginacion )selected @endif>{{ $paginacion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        </form>

                        <table class="table my-0" id="dataTable">
                            {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                            <thead>
                                <tr>
                                    <th>Tipo &nbsp; <i class="fas fa-caret-down"></i></th>
                                    <th colspan="4">Nombre &nbsp; <i class="fas fa-caret-down"></i></th>
                                    <th colspan="3">Fecha subido &nbsp; <i class="fas fa-caret-down"></i></th>
                                    <th>Descargar &nbsp; <i class="fas fa-caret-down"></i></th>
                                    @if(Accesos::ACCESO_ELIMINAR_EVIDENCIAS_ACTIVIDADES())
                                    <th>Eliminar &nbsp; <i class="fas fa-caret-down"></i> </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="lista-evidencias">

                                {{-- En caso de que no existan registros --}}
                                @if(count($evidencias) == 0)
                                <tr class="cursor-pointer">
                                    <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg"></i> &nbsp; No existen registros</td>
                                </tr>
                                @endif
                                {{-- Inserción iterativa de los estudiantes dentro de la tabla --}}
                                @foreach($evidencias as $evidencia)
                                <tr id="" class="cursor-pointer">
                                    <td class="d-flex justify-content-center"><span data-toggle="tooltip" data-placement="right" title="{{ $evidencia->tipo_documento }}">{!! $tiposDocumentos[$evidencia->tipo_documento] !!} </span></td>
                                    @if($evidencia->tipo_documento != "video" && $evidencia->tipo_documento != "imagen" && $evidencia->tipo_documento != "pdf" )
                                    <td colspan="4" style="max-width: 200px;">{{ $evidencia->nombre_archivo }}</td>
                                    @else
                                    <td colspan="4"> <span data-toggle="modal" data-target="#detalle-documento" class="text-primary" data-repositorio="{{ $evidencia->id_repositorio }}" data-tipo="{{ $evidencia->tipo_documento }}" style="cursor: pointer;">{{ $evidencia->nombre_archivo }}</span> </td>
                                    @endif
                                    <td colspan="3">{{ $evidencia->updated_at }}</td>
                                    @if($evidencia->tipo_documento != "video")
                                    <form action="{{ route('evidencias.download',$evidencia->id) }}" method="get">
                                        <td><button class="btn btn-contorno-rojo" type="submit"><i class="fas fa-download"></i> &nbsp;Descargar</button></td>
                                        <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
                                    </form>
                                    <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
                                    @else
                                    <td><a class="btn btn-contorno-rojo" href="{{ $evidencia->id_repositorio }}" target="_blank"><i class="fas fa-globe"></i> &nbsp; Visualizar</a></td>
                                    @endif

                                    @if(Accesos::ACCESO_ELIMINAR_EVIDENCIAS_ACTIVIDADES())
                                    <td>
                                        <a class="btn btn-contorno-rojo" onclick="rutaEvidencias({{ $evidencia->id }}, {{ $actividad->id }})" data-toggle="modal" data-target="#modal-eliminar"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</a>
                                    </td>
                                    @endif

                                </tr>
                                @endforeach
                            </tbody>
                            {{-- Nombre de las columnas en la parte de abajo de la tabla --}}
                            <tfoot>
                                <tr>
                                    <th>Tipo</th>
                                    <th colspan="4">Nombre</th>
                                    <th colspan="3">Fecha de subida</th>
                                    <th>Descargar</th>
                                    @if(Accesos::ACCESO_ELIMINAR_EVIDENCIAS_ACTIVIDADES())
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
                    <span style="font-size: 36px; font-weight: bolder;" id="total">{{ $evidencias->total() }}</span><br>
                    <span style="font-size: 20px; font-weight: light;  ">Total</span>
                </div>
            </div>
        </div>
        <div class="row px-3 py-2">
            <div class="col-md-3 align-self-center">
                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $evidencias->perPage() ?? ' ' }} items por página de {{ $evidencias->total() ?? ''  }}</p>
            </div>
            {{-- Items de paginación --}}
            <div class="col-md-5 ml-5 d-flex justify-content-center">
                {{ $evidencias->withQueryString()->links() ?? '' }}
            </div>
        </div>
    </div>


    {{-- <embed src="{{ URL::asset('storage/evidencias/1/1615573854_ejemplopdf.pdf')  }}" width="800px" height="800px" /> --}}
    {{-- <iframe src="http://docs.google.com/gview?url={{ URL::asset('storage/evidencias/1/1615574430_liderazgo.docx')  }}&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe> --}}
</div>

{{-- </form> --}}

@endsection

@section('scripts')
<script>
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = " {{ URL::asset('img/fotos/') }}";
    var iconosURL = "{{ URL::asset('img/recursos/iconos/') }}";
    var storageURL = "{{ URL::asset('storage/evidencias/'. $actividad->id . '/') }}";
</script>
<script src="{{ asset('js/control_actividades_internas/evidencias.js') }}"></script>
<script src="{{ asset('js/global/subirArchivos.js') }}"></script>
<script src="{{ asset('js/global/mensajes.js') }}"></script>
<script src="{{ asset('js/global/contarCaracteres.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection
