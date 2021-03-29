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

@include('control_actividades_internas.lista_asistencia.invitado')
@include('control_actividades_internas.lista_asistencia.info')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div>

                <h3>Lista de asistencia de Promocion</h3>
            </div>
            {{-- Botones superiores --}}
            <div>
                {{-- Botón para regresar al listado de actividades --}}
                <a href="{{ route('actividad-promocion.show',$actividad->id ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Volver al detalle </a>

            </div>
        </div>
        <hr>
        <form action="{{ route('lista-asistencia.show',$actividad->id) }}" method="GET" id="form-reload" style="display: none">
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


        <div class="row border-bottom pb-2">

            <div class="col-5">
                <div class="card shadow">
                    <div class="card-body  ">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-4" id="img-actividad">
                                    <img src="{{ asset('img/logoEBDI.png') }}" class="transicion-max-width" id="logo-EBDI" alt="logo_ebdi" class="" style="max-width: 100%">
                                </div>
                                <div class="col-7 border-left d-flex align-items-center transicion-padding" id="info-actividad">
                                    <div class="overflow-auto">
                                        <span class="my-1" style='width: 134%; '> <strong>Nombre de actividad:</strong> {{ $actividad->tema }}</span> <br>
                                        <span class="my-1" style='width: 120%; '> <strong>Fecha de la actividad:</strong> {{ $actividad->fecha_inicio_actividad }} <i class="far fa-arrow-alt-circle-right"></i> {{ $actividad->fecha_final_actividad }}</span><br>
                                        <span class="my-1"> <strong> Tipo de actividad:</strong> {{ $actividad->actividadPromocion->tipo_actividad }}</span><br>
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
            <div class="col-6 " >
                <form action="{{ route('asistencia-promocion.store', $actividad->id) }}" enctype="multipart/form-data"  method="POST" >

                    <input class="form-control" type='hidden' id="actividad-id" name="acitividad_id" value="{{ $actividad->id }}">

                <div class="card shadow">
                    <div class="card-header ">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo">Añadir participante </h6>
                            </div>

                        </div>
                    </div>
                    <div class="card-body ">
                    
                            <div class="row">
                                <div class="col">
                                    {{-- Campo: cedula --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <label for="cedula">Cedula <i class="text-danger">*</i></label>
                                                </div>
                                                <span class="text-muted " id="mostrar_cedula"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="cedula" name="cedula" onkeyup="contarCaracteres(this,100)" required>                                                   
                                                <div class="input-group-append">
                                                    <div class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Buscar por nombre y tipo de archivo (No es necesario seleccionar ambos)"><i class="far fa-question-circle fa-lg"></i></div>
                                                </div>   
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    {{-- Campo: nombre --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between w-100">
        
                                                <div>
                                                    <label for="nombre">Nombre <i class="text-danger">*</i></label>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes  --}}
                                                <span class="text-muted" id="mostrar_nombre"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="nombre" name="nombre" onkeyup="contarCaracteres(this,60)" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Buscar por nombre y tipo de archivo (No es necesario seleccionar ambos)"><i class="far fa-question-circle fa-lg"></i></div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    {{-- Campo: apellidos --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between w-100">
        
                                                <div>
                                                    <label for="apellidos">Apellidos <i class="text-danger">*</i></label>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes  --}}
                                                <span class="text-muted" id="mostrar_apellidos"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="apellidos" name="apellidos" onkeyup="contarCaracteres(this,60)" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Buscar por nombre y tipo de archivo (No es necesario seleccionar ambos)"><i class="far fa-question-circle fa-lg"></i></div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                            <div class="row">
                                <div class="col">
                                    {{-- Campo: correo --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between w-100">
                                                <div>
                                                    <label for="correo">Correo </label>
                                                </div>
                                                <span class="text-muted " id="mostrar_correo"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="correo" name="correo" onkeyup="contarCaracteres(this,100)" >
                                                <div class="input-group-append">
                                                    <div class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Buscar por nombre y tipo de archivo (No es necesario seleccionar ambos)"><i class="far fa-question-circle fa-lg"></i></div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    {{-- Campo: telefono --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between w-100">
        
                                                <div>
                                                    <label for="telefono">Telefono </label>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes  --}}
                                                <span class="text-muted" id="mostrar_telefono"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="telefono" name="telefono" onkeyup="contarCaracteres(this,60)">
                                                <div class="input-group-append">
                                                    <div class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Buscar por nombre y tipo de archivo (No es necesario seleccionar ambos)"><i class="far fa-question-circle fa-lg"></i></div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    {{-- Campo: procedencia --}}
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="w-75">
                                            <div class="d-flex justify-content-between w-100">
        
                                                <div>
                                                    <label for="procedencia">Procedencia </label>
                                                </div>
                                                {{-- espacio donde se muestran los caracteres restantes  --}}
                                                <span class="text-muted" id="mostrar_procedencia"></span>
                                            </div>
                                            <div class="d-flex">
                                                <input type='text' class="form-control w-100" id="procedencia" name="procedencia" onkeyup="contarCaracteres(this,60)">
                                                <div class="input-group-append">
                                                    <div class="input-group-text texto-azul-una" data-toggle="tooltip" data-placement="top" title="Buscar por nombre y tipo de archivo (No es necesario seleccionar ambos)"><i class="far fa-question-circle fa-lg"></i></div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 



                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center" id="agregar-participante-footer">
                            <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">

                        </div>
                    </div>
                </form>
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
                        <form action="{{ route('lista-asistencia.show',$actividad->id) }}" method="GET" id="form-busqueda">
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
                                    <th>Eliminar </th>
                                </tr>
                            </thead>
                            <tbody id="lista-participantes">


                            </tbody>
                            {{-- Nombre de las columnas en la parte de abajo de la tabla --}}
                            <tfoot>
                                <tr>
                                    <th>N° de Cédula</th>
                                    <th>Nombre</th>
                                    <th>Teléfono celular</th>
                                    <th>Correo institucional</th>
                                    <th>Informacion</th>
                                    <th>Eliminar </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

            </div>
            <div class="col-1">
                <div class="info-card" style="padding: 2px 0; max-width: 100%; ">

                    <span style="font-size: 20px; font-weight: light;  ">Total</span>
                </div>
            </div>
        </div>
        <div class="row px-3 py-2">
            <div class="col-md-3 align-self-center">

        
            
            </div>
            {{-- Items de paginación --}}
            <div class="col-md-5 ml-5 d-flex justify-content-center">



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
<script src="{{ asset('js/control_actividades_internas/lista_asistencia.js') }}"></script>
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


@section('pie')
Copyright
@endsection
