@extends('layouts.app')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('titulo')
Asistencia a
{{ $actividad->tema }}
@endsection

@section('css')
{{-- No hay --}}
@endsection


@section('contenido')


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
                <a href="{{ route('evidencias.show',$actividad->id ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>
                {{-- Boton que habilita opcion de editar --}}
                <button href="" class="btn btn-rojo" id="btn-agregar-part"> Añadir participante &nbsp; <i class="fas fa-plus-circle"></i> </button>
                {{-- Boton de cancelar edicion --}}
                <button type="button" id="cancelar-edi" class="btn btn-rojo"><i class="fas fa-close "></i> Cancelar </button>
            </div>
        </div>

        <hr>
        <form action="{{ route('evidencias.show',$actividad->id) }}" method="GET" id="form-reload" style="display: none">
            <input type="hidden" id="mensaje" name="mensaje" value="" />
        </form>
        {{-- Boton de cancelar edicion --}}
        @php
        $mensaje = Session::get('mensaje');
        @endphp
        @if($mensaje == 'success')

        {{-- Mensaje de exito  --}}
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

        @if(Session::has('eliminado'))
        {{-- Mensaje de exito al eliminar un participante de la lista --}}
        <div class="mensaje-container" id="mensaje-info" style="display:none;  ">
            <div class="col-3 icono-mensaje d-flex align-items-center" id="icono-mensaje" style="background-image: url('/img/recursos/iconos/success.png');"></div>
            <div class="col-9 texto-mensaje d-flex align-items-center text-center" id="texto-mensaje" style="color: #046704e8; "> {{ Session::get('eliminado') }} </div>
        </div>
        @endif



        <input class="form-control" type='hidden' id="actividad-id" name="acitividad_id" value="{{ $actividad->id }}">


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
                                        <span class="my-1" style='width: 134%; '> <strong>Público dirigido:</strong> {{ $actividad->actividadInterna->publico_dirigido  }}</span><br>
                                        <span class="my-1" style='width: 120%; '> <strong>Fecha de la actividad:</strong> {{ $actividad->fecha_inicio_actividad }} <i class="far fa-arrow-alt-circle-right"></i> {{ $actividad->fecha_final_actividad }}</span><br>
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
            <div class="col-6 mb-3 " id="agregar-participante-card">
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
                            <div class="input-group px-2 mb-3">
                                <input type="text" id="nombre-archivo" name="nombre_archivo" aria-label="Nombre archivo" class="form-control" placeholder="Nombre del archivo" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="tooltip" data-placement="right" title="Nombre con el que quiere guardar el archivo"><i class="far fa-edit"></i></span>
                                </div>
                            </div>
                            {{-- Input para seleccionar el tipo de archivo --}}
                            <div class="input-group px-2 mb-3">
                                <select class="form-select custom-select" id="tipo-archivo">
                                    <option selected>Elija una opción...</option>
                                    <option value="1">Documento</option>
                                    <option value="2">Imagen</option>
                                    <option value="3">Video de Youtube</option>
                                </select>

                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="tooltip" data-placement="right" title="Tipo de archivo que desea subir"><i class="fas fa-archive"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="file-upload">
                            <button class="file-upload-btn btn btn-contorno-rojo w-100" type="button" onclick="$('.file-upload-input').trigger( 'click' )">AGREGAR EVIDENCIA</button>

                            <div class="image-upload-wrap">
                                <input class="file-upload-input" name="avatar" type='file' onchange="readURL(this);" accept="image/*" />
                                <div class="drag-text">
                                    <h4>SELECCIONE LA EVIDENCIA</h4>
                                </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image rounded" src="#" alt="Previsualizacion de evidencia" />
                                <div class="image-title-wrap">
                                    <button type="button" onclick="removeUpload()" class="remove-image"><i class="fas fa-ban"></i> &nbsp; <span class="image-title">Subir evidencia</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center" id="agregar-participante-footer">
                            <button href="" class="btn btn-rojo" id="agregar-submit"> Añadir Documento &nbsp; <i class="fas fa-plus-circle"></i> </button>
                            <button href="" class="btn btn-gris ml-2" id="cancelar-agregar-part"> Cancelar &nbsp; <i class="fas fa-times-circle"></i> </button>
                        </div>
                    </div>
                </div>
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
                                <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Participaciones </h6>
                            </div>
                            <div>
                                <button href="" class="btn btn-contorno-azul-una" id="btn-listar-todo"><i class="fas fa-redo"></i>&nbsp; Listar todo </button>
                            </div>
                        </div>
                        <form action="{{ route('evidencias.show',$actividad->id) }}" method="GET" id="form-busqueda">
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
                                    <th>Tipo &nbsp; <i class="fas fa-caret-down"></i></th>
                                    <th>Nombre &nbsp; <i class="fas fa-caret-down"></i></th>
                                    <th>Fecha subido &nbsp; <i class="fas fa-caret-down"></i></th>
                                    <th>Previsualización &nbsp; <i class="fas fa-caret-down"></i></th>
                                    <th>Descargar &nbsp; <i class="fas fa-caret-down"></i></th>
                                    <th>Eliminar &nbsp; <i class="fas fa-caret-down"></i> </th>
                                </tr>
                            </thead>

                            {{-- Nombre de las columnas en la parte de abajo de la tabla --}}
                            <tfoot>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Fecha de subida</th>
                                    <th>Previsualización</th>
                                    <th>Descargar</th>
                                    <th>Eliminar </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

            </div>
            <div class="col-1">
                <div class="info-card" style="padding: 2px 0; max-width: 100%; ">
                    <span style="font-size: 36px; font-weight: bolder;" id="total">20</span><br>
                    <span style="font-size: 20px; font-weight: light;  ">Total</span>
                </div>
            </div>
        </div>
        <div class="row px-3 py-2">
            <div class="col-md-3 align-self-center">
                {{-- <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{ $listaAsistencia ?? ''->perPage() }} items por página de {{ $listaAsistencia ?? ''->total() }}</p> --}}
            </div>
            {{-- Items de paginación --}}
            <div class="col-md-5 ml-5 d-flex justify-content-center">
                {{-- {{ $listaAsistencia ?? ''->withQueryString()->links() }} --}}
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

{{-- <script src="{{ asset('js/control_actividades_internas/lista_asistencia.js') }}"></script> --}}
<script src="{{ asset('js/global/subirArchivos.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
@endsection


@section('pie')
Copyright
@endsection
