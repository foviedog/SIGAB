@extends('layouts.app')

@section('titulo')
Reportes actividades
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

{{-- Arreglos de opciones de los select utilizados --}}
@php
$estados = GlobalArrays::ESTADOS_ACTIVIDAD;
@endphp

@section('contenido')

{{-- Modal para agregar el título de la imagen  --}}
<form id="reporteForm" method="post" action="{{ route('reportes-actividades.reporte') }}" target="_blank">
    @csrf
    <input type="hidden" name="image" id="image">
    <div class="modal fade" id="reporte-modal" tabindex="-1" aria-labelledby="reporte-modal" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title texto-rojo-medio" id="reporte-modal">Crear reporte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert" id="insertar-titulo" style="display:none;">
                        <strong>Digete un título</strong>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="titulo" id="titulo-grafico" placeholder="Título del gráfico" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rojo" id="crear-guia-modal" onclick="reporte()">Crear reporte</button>
                    <button type="button" class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>



<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Reportes y estadísticas de actividades</span>
            </div>
        </div>
        <hr>
        {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
        @if(Session::has('mensaje'))
        <div class="alert alert-success text-center font-weight-bold" role="alert" id="mensaje_exito">
            {!! \Session::get('mensaje') !!}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger text-center font-weight-bold" role="alert">
            {{ "¡Oops! Algo ocurrió mal"  }}
        </div>
        @endif
        {{-- Barra de navegación entre información genereal y bloques de texto  --}}
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#actividades-tab">Actividades</a>
            </li>
        </ul>

        <div class="container-fluid pb-5">
            <div class="tab-content pb-5">
                <div role="tabpanel" class="tab-pane fade in active show" id="actividades-tab">
                    <div id="cartas-activida" class="row d-flex justify-content-between px-3 mt-4">
                        {{-- Cantidad total de actividades internas registratas en el sistema --}}
                        <div class="col-lg-6 col-xl-3 py-3">
                            <div class="row card-info  ">
                                <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                    <i class="fas fa-school fa-3x texto-rojo-medio"></i>
                                </div>
                                <div class="col-8 p-0 ">
                                    <div class="border-left">
                                        <div class="ml-2 texto-info">Internas</div>
                                        <div class="ml-2 numero-info">{{ $datosCuantitativos[1] ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Cantidad total de actividades de promoción registratas en el sistema --}}

                        <div class="col-lg-6 col-xl-3 py-3">
                            <div class="row card-info  ">
                                <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                    <i class="fas fa-bullhorn fa-3x texto-rojo-medio"></i>
                                </div>
                                <div class="col-8 p-0 ">
                                    <div class="border-left">
                                        <div class="ml-2 texto-info">Promoción</div>
                                        <div class="ml-2 numero-info">{{ $datosCuantitativos[0] ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Cantidad total de actividades registratas en el sistema suma de actividades de promoción y actividades internas--}}
                        <div class="col-lg-6 col-xl-3 py-3">
                            <div class="row card-info  ">
                                <div class="col-3 py-4 px-0 d-flex justify-content-center">
                                    <i class="fas fa-calculator fa-3x texto-rojo-medio"></i>
                                </div>
                                <div class="col-8 p-0 ">
                                    <div class="border-left">
                                        <div class="ml-2 texto-info">Total</div>
                                        <div class="ml-2 numero-info">{{ $datosCuantitativos[0] + $datosCuantitativos[1] ?? 0 }} </div>
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
                                        <div class="ml-2 texto-info">Responsables</div>
                                        <div class="ml-2 numero-info">{{ $datosCuantitativos[2] ?? 0 }} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-5 pt-2 graficos-especificos">
                        <div class="row ">
                            <div class="col-lg-12 col-xl-6 d-flex flex-column justify-content-center align-items-center mb-lg-5">
                                <div class="header-grafico w-100 texto-rojo-medio d-flex ">
                                    <h3>Propósitos de actividades {{ date("Y") }}</h3>&nbsp;
                                    <i class="fas fa-question-circle " data-toggle="tooltip" data-placement="top" title="Gráfico que muestra la cantidad de actividades internas que finalizan en el 2021 según el propósito" style="font-size: 18px;"></i>
                                </div>
                                <div class=" grafico-container w-100">
                                    <div id="grafico_proposito">

                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex flex-column justify-content-start align-items-center">
                                <div class="display-5 w-75 texto-rojo-medio d-flex">
                                    <h3>Estados de actividades {{ date("Y") }}</h3>&nbsp;
                                    <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Gráfico que muestra cantidad total de actividades según los estados (Incluye actividades internas y actividades de promoción)" style="font-size: 18px;"></i>
                                </div>
                                <div class="grafico-container w-75">
                                    <div id="grafico_estados">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center pt-5 pb-5 border-top">
                        <div class="display-5 w-75 texto-rojo-medio" id="graficoGenerado">
                            <h2>Generación de gráficos y reportes</h2>
                        </div>
                        <div class="w-50 mt-3">
                            <div id="chart"></div>
                        </div>
                    </div>

                    <form action="{{ route('reportes-actividades.resultado') }}" method="GET" enctype="multipart/form-data" id="formulario-reporte">
                        <div class="row d-flex justify-content-center mb-3">
                            <div class="w-75">
                                <div class="row d-flex justify-content-center mb-3">
                                    <select class="col-4 custom-select mr-3" id="actividad" name="actividad_naturaleza" class="form-control">
                                        <option value="Actividad interna" @if ($naturalezaAct=="Actividad interna" ) selected @endif>Actividad interna</option>
                                        <option value="Actividad de promoción" @if ($naturalezaAct=="Actividad de promoción" ) selected @endif>Actividad de promoción</option>
                                    </select>

                                    <select class="col-4 custom-select mr-3" id="tipo-actividad-int" name="tipo_actividad_int" class="form-control">
                                        <option value="">Todos los tipos</option>
                                        @foreach($tip_act_int as $tipo)
                                        <option value='{{ $tipo }}' @if ($tipoAct==$tipo) selected @endif>{{ $tipo }}</option>
                                        @endforeach
                                    </select>

                                    <select class="col-4 custom-select mr-3" id="tipo-actividad-prom" name="tipo_actividad_prom" class="form-control">
                                        <option value="">Todos los tipos</option>
                                        @foreach($tip_act_prom as $tipo)
                                        <option value='{{ $tipo }}' @if ($tipoAct==$tipo) selected @endif>{{ $tipo }}</option>
                                        @endforeach
                                    </select>

                                    <select class="col-2 custom-select mr-3" id="estado" name="estado_actividad" class="form-control">
                                        <option value="">Todos los estados</option>
                                        @foreach($estados as $estado)
                                        <option value='{{ $estado }}' @if ($estadoActividad==$estado) selected @endif>{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row d-flex justify-content-center">

                                    <div class="col-7 input-group mr-3">
                                        <input type="month" name="mes_inicio" class="form-control" value='{{ $mesInicio ?? "" }}'>
                                        <input type="month" name="mes_final" class="form-control" value='{{ $mesFinal ?? "" }}'>
                                    </div>

                                    <select class="col-3 custom-select mr-3" id="tipo-grafico" name="tipo_grafico" class="form-control">
                                        <option value="bar" {{ $chart == "bar" ? 'selected' : '' }}>Barras</option>
                                        <option value="line" {{ $chart == "line" ? 'selected' : '' }}>Líneas de dispersión</option>
                                        <option value="area" {{ $chart == "area" ? 'selected' : '' }}>Área</option>
                                        <option value="donut" {{ $chart == "donut" ? 'selected' : '' }}>Anillo</option>
                                        <option value="pie" {{ $chart == "pie" ? 'selected' : '' }}>Circular</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row  d-flex justify-content-center align-items-center py-4 pb-4 pt-4">
                            <div class="btn btn-lg btn-rojo" onclick="enviar()"><i class="fas fa-chart-line"></i> Generar gráfico</div>
                            <div class="btn btn-lg btn-contorno-rojo ml-2" id="reporte-trigger" data-toggle="modal" data-target="#reporte-modal"><i class="far fa-file-pdf"></i> Generar reporte</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>



@endsection

@section('scripts')

@if(!is_null($datos))
<script>
    //Datos que se renderisan en caso de que se haya realizado una búsqueda para generar el gráfico dinámico
    let dataSet = JSON.parse('{!! $datos !!}');
    let x = [];
    let y = [];
    let naturalezaActividad = '{{ $naturalezaAct }}';

    //Meses para agregar al formateo
    let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio"
        , "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    , ];

    // Ciclo que recorre cada uno de los resultados de la búsqueda y los coloca en posiciones
    //'X' y 'Y' para que se pueda renderizar el gráfico correspondiente

    var total = 0;
    for (const atributo in dataSet) {
        if (dataSet[atributo] != 0) {
            let aux = new Date(atributo);
            x.push(meses[aux.getMonth()] + " del " + aux.getFullYear());
            y.push(dataSet[atributo]);
            total++;
        }
    }

    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";
    var url = window.location.href;
    var indexHref = url.indexOf("#graficoGenerado");
    url = url.substr(0, indexHref)
    window.location.href = url + "#graficoGenerado";
    $("#reporte-trigger").show();

</script>
@else {{-- En caso de que sea la primera vez que se cargue la página se setean los atributos en valores prederminados --}}
<script>
    let dataSet = [];
    let naturalezaActividad = "Actividad interna";
    let total = 0;
    $("#reporte-trigger").hide();

</script>
@endif

<script>
    let propositosDelAnio = JSON.parse('{!! $propositosDelAnio !!}');
    let xPropositos = [];
    let yPropositos = [];
    let totalPropositos = 0;
    for (const proposito in propositosDelAnio) {
        xPropositos.push(proposito); //Se inserta el nombre del pospósito en el eje X ("Para ejecución, en progreso, etc...")
        var cantProp = propositosDelAnio[proposito];
        yPropositos.push(cantProp); //Se inserta en el eje Y la cantidad de actividades con dicho propósito
        totalPropositos += cantProp;
    }
    let estadosDelAnio = JSON.parse('{!! $estadosDelAnio !!}');
    let xEstados = [];
    let yEstados = [];
    let totalEstados = 0;
    for (const estado in estadosDelAnio) {
        xEstados.push(estado); //Se inserta el nombre del pospósito en el eje X ("Para ejecución, en progreso, etc...")
        var cantEstados = estadosDelAnio[estado];
        yEstados.push(cantEstados); //Se inserta en el eje Y la cantidad de actividades con dicho propósito
        totalEstados += cantEstados;
    }

</script>

<script src="{{ asset('js/reportes/actividades/reportes.js') }}" defer></script>
<script src="{{ asset('js/reportes/actividades/graficosPredeterminados.js') }}" defer></script>

@if(!is_null($chart))
<script src="{{ asset('js/reportes/'.$chart.'.js') }}" defer></script>
@endif

{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>

<script>
    $("input[type='number']").inputSpinner();
</script>

@endsection
