@extends('layouts.app')

@section('titulo')
Reportes de involucramiento
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

{{-- Arreglos de opciones de los select utilizados --}}
@php
$estados = GlobalArrays::ESTADOS_ACTIVIDAD;
@endphp

@section('contenido')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Reportes y estadísticas de involucramiento del personal</span>
            </div>
        </div>
        <hr>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#general" data-toggle="tab">Involucramiento general</a>
            </li>

        </ul>

        <div class="container-fluid pb-5">
            <div class="tab-content pb-5">
                <div role="tabpanel" class="tab-pane fade-in active show" id="general">
                    <div id="cartas-actividad" class="row d-flex justify-content-between px-3 mt-4">
                        {{-- Cantidad total de responsables de activdades registrados en el sistema--}}
                        <div class="col-lg-6 col-xl-3 py-3">
                            <div class="row card-info  ">
                                <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                    <i class="fas fa-chalkboard-teacher fa-3x texto-rojo-medio"></i>
                                </div>
                                <div class="col-8 p-0 ">
                                    <div class="border-left">
                                        <div class="ml-2 texto-info">Interinos</div>
                                        <div class="ml-2 numero-info">{{ $datosCuantitativos[0] ?? 0 }} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Cantidad total de responsables de activdades registrados en el sistema--}}
                        <div class="col-lg-6 col-xl-3 py-3">
                            <div class="row card-info  ">
                                <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                    <i class="fas fa-university fa-3x texto-rojo-medio"></i>
                                </div>
                                <div class="col-8 p-0 ">
                                    <div class="border-left">
                                        <div class="ml-2 texto-info">Propietarios</div>
                                        <div class="ml-2 numero-info">{{ $datosCuantitativos[1] ?? 0 }} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Cantidad total de responsables de activdades registrados en el sistema--}}
                        <div class="col-lg-6 col-xl-3 py-3">
                            <div class="row card-info  ">
                                <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                    <i class="fas fa-briefcase fa-3x texto-rojo-medio"></i>
                                </div>
                                <div class="col-8 p-0 ">
                                    <div class="border-left">
                                        <div class="ml-2 texto-info">Plazo fijo</div>
                                        <div class="ml-2 numero-info">{{ $datosCuantitativos[2] ?? 0 }} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Cantidad total de responsables de activdades registrados en el sistema--}}
                        <div class="col-lg-6 col-xl-3 py-3">
                            <div class="row card-info  ">
                                <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                    <i class="fas fa-calculator  fa-3x texto-rojo-medio"></i>
                                </div>
                                <div class="col-8 p-0 ">
                                    <div class="border-left">
                                        <div class="ml-2 texto-info">Total</div>
                                        <div class="ml-2 numero-info">{{ $datosCuantitativos[3] ?? 0 }} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sección para gráficos generados por el año en curso --}}
                    <div class="container-fluid pb-5 mt-5">
                        <div class="row">
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Porcentaje de participación del {{ date("Y") }} en actividades internas</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas del año en curso. Se toman en cuenta las actividades en ejecución y ejecutadas. El cálculo toma en cuenta la participación en lista de asistencia como coordinación y facilitador." style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-3">
                                    <div id="grafico_porc_act">

                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Porcentaje de participación del {{ date("Y") }} en actividades internas por ámbito</h4>&nbsp;
                                    <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas del año en curso por ámbito. Se toman en cuenta las actividades en ejecución y ejecutadas. El cálculo toma en cuenta la participación en lista de asistencia como coordinación y facilitador." style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-3 ml-3">
                                    <div id="grafico_porc_amb">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <form autocomplete="off" action="{{ route('reportes-involucramiento.resultado') }}" method="GET" enctype="multipart/form-data" id="formulario-reporte">

                        <div class="row d-flex justify-content-center my-3">
                            <div class="display-5 w-75 texto-rojo-medio pb-5">
                                <h2>Generación de gráficos y reportes</h2>
                            </div>
                            <div class="w-75">
                                <div class="row d-flex justify-content-center mb-3">

                                    <div class="col-6">

                                        <div class="card">
                                            <div class="justify-content-center align-items-center p-3" style="text-align:center">
                                                <img src="{{ asset('img/fotos/default.jpg') }}" class="mb-3" id="imagen-personal" style="max-width: 160px; max-height: 160px; border-radius: 100%;" />
                                                <div class="text-start mt-2" id="info-personal">
                                                    <strong>Nombre:</strong> &nbsp;&nbsp;<span id="nombre-personal">Sin seleccionar</span><br>
                                                    <strong>Tipo de puesto 1:</strong> &nbsp;&nbsp;<span id="tipo-puesto1-personal">Sin seleccionar</span><br>
                                                    <strong>Tipo de puesto 2: </strong>&nbsp;&nbsp; <span id="tipo-puesto2-personal">Sin seleccionar</span><br>
                                                    <strong>Jornada Laboral: </strong> &nbsp;&nbsp;<span id="jornada-laboral-personal">Sin seleccionar</span><br>
                                                </div>
                                                <div id="no-seleccionado">
                                                    No se ha seleccionado un personal
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <div class="row d-flex justify-content-left">
                                            <div class="col-11">
                                                <div class="d-flex justify-content-left" id="input-buscar-agregar">
                                                    <div class="input-group w-75">
                                                        <input type='text' id="cedula-personal" name="personal" class="form-control" @if(!is_null($personal)) value={{ $personal }} @endif required>
                                                        <div class="input-group-append">
                                                            <button type="button" onclick="buscarPersonal()" class="btn btn-contorno-rojo">Buscar</button>
                                                            <span data-toggle="tooltip" data-placement="right" title="Ingrese sin espacio y sin guiones el número de cédula del personal" class="ml-2"> <i class="far fa-question-circle fa-lg mr-2"></i></span>
                                                        </div>
                                                    </div>
                                                    <input class="form-control" type='hidden' id="personal-encontrado" name="personal_encontrado" value="false">
                                                </div>
                                                <div class="row d-flex justify-content-left mt-3">
                                                    <div class="alert alert-danger w-75 text-center" role="alert" id="mensaje-alerta" style="display:none;"></div>
                                                </div>

                                                <div class="col-9 input-group pl-0">
                                                    <input type="month" name="mes_inicio" class="form-control" value='{{ $mesInicio ?? "" }}' required>
                                                    <input type="month" name="mes_final" class="form-control" value='{{ $mesFinal ?? "" }}' required>
                                                </div>

                                                <select class="col-8 mt-3 form-control" id="estado" name="estado_actividad" class="form-control">
                                                    <option value="">Todos los estados</option>
                                                    @foreach($estados as $estado)
                                                    <option value='{{ $estado }}' @if ($estadoActividad==$estado) selected @endif>{{ $estado }}</option>
                                                    @endforeach
                                                </select>

                                                <button class="btn btn-lg btn-rojo mt-4" type="submit" id="boton-enviar" onclick="activarLoader('Generando gráficos');"><i class="fas fa-chart-line"></i> Generar gráficos</button>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="container-fluid mt-5 mb-5 pt-2" id="seccion-graficos" style="width: 90%">

                        <div class="display-5 texto-rojo-medio pb-1 text-center">
                            <h2>Gráficos para medir el involucramiento de {{ $nombre }}</h2>
                        </div>

                        <hr>
                        <div class="row mt-5">
                            <div class="col-6 d-flex flex-column ">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Asistencia en actividades internas por tipos</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas según lista de asistencia" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-1">
                                    <div id="grafico_asis_tipos">

                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Coordinación de actividades internas por tipos</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas según responsabilidad de coordinación" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-1">
                                    <div id="grafico_coord_tipos">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-5 mb-5">
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Asistencia en actividades internas por fechas</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas según lista de asistencia en un rango de fechas" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-1">
                                    <div id="grafico_asis_fecha">

                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Coordinación de actividades internas por fechas</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas según responsabilidad de coordinación en un rango de fechas" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-1">
                                    <div id="grafico_coord_fecha">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-5 mb-5">
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Asistencia en actividades internas por ámbito</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas según lista de asistencia por su ámbito" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-1">
                                    <div id="grafico_asis_ambito">

                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Coordinación de actividades internas por ámbito</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas según responsabilidad de coordinación por su ámbito" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-1">
                                    <div id="grafico_coord_ambito">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-5 mb-5">
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Facilitador en actividades internas por tipos</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas según responsabilidad de facilitador" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-1">
                                    <div id="grafico_facili_tipo">

                                    </div>
                                </div>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex">
                                    <h4>Facilitador en actividades internas por fechas</h4>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Total de participación en actividades internas según responsabilidad de facilitador en un rango de fechas" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-100 mt-1">
                                    <div id="grafico_facili_fecha">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var fotosURL = "{{ URL::asset('img/fotos/') }}";
    @if(!is_null($personal))
    let flagInfoPersonal = true;
    @else
    let flagInfoPersonal = false;
    @endif

    let porcentajeParticipacionActual = JSON.parse('{!! $porcentajeActualParticipacion !!}');
    let porcentajeAmbitoActual = JSON.parse('{!! $porcentajeActualAmbito !!}');

</script>

<script src="{{ asset('js/reportes/involucramiento/reportes.js') }}" defer></script>
<script src="{{ asset('js/reportes/involucramiento/graficosPredeterminados.js') }}" defer></script>

@if(!is_null($datos))
<script>
    //Datos generales para los gráficos
    let dataSet = JSON.parse('{!! $datos !!}');

    //Mostrar espacio para los gráficos
    $("#seccion-graficos").show();

    // Variable global utilizada para obtener el url de las imágenes con js.
    var url = window.location.href;
    window.location.href = url + "#formulario-reporte";

</script>
<script src="{{ asset('js/reportes/involucramiento/graficosDinamicos.js') }}" defer></script>
@else {{--En caso de que sea la primera vez que se cargue la página se setean los atributos en valores prederminados --}}
<script>
    //Ocultar espacio para los gráficos
    $("#seccion-graficos").hide();

</script>
@endif
{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>
@endsection
