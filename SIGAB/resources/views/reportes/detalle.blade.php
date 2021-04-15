@extends('layouts.app')

@section('titulo')
Reportes actividades
@endsection


@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection

@section('contenido')



{{-- Arreglos de opciones de los select utilizados --}}
@php


$estados = ["Para ejecución","En progreso","Ejecutada","Cancelada"];

@endphp

{{-- Formulario general de actualización de datos de actividad --}}
{{-- Metodo invocado para realizar la modificacion correctamente del estudiante --}}
@method('PATCH')
{{-- Seguridad de envío de datos --}}
@csrf

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
                        <div class="card-info">
                            <div class="icon-info">
                                <div class="icon-inner">
                                    <i class="fas fa-school fa-3x"></i>
                                </div>
                            </div>
                            <div class="content-info">
                                <div>
                                    <div class="texto-info">Internas</div>
                                    <div class="numero-info">{{ $datosCuantitativos[0] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="icon-info">
                                <div class="icon-inner">
                                    <i class="fas fa-bullhorn fa-3x"></i>
                                </div>
                            </div>
                            <div class="content-info">
                                <div>
                                    <div class="texto-info">Promoción</div>
                                    <div class="numero-info"> {{ $datosCuantitativos[1] ?? 0 }} </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="icon-info">
                                <div class="icon-inner">
                                    <i class="fas fa-calculator fa-3x"></i>
                                </div>
                            </div>
                            <div class="content-info">
                                <div>
                                    <div class="texto-info"> Total </div>
                                    <div class="numero-info"> {{ $datosCuantitativos[0] + $datosCuantitativos[2] ?? 0 }} </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="icon-info">
                                <div class="icon-inner">
                                    <i class="fas fa-briefcase fa-3x"></i>
                                </div>
                            </div>
                            <div class="content-info">
                                <div>
                                    <div class="texto-info"> Responsables </div>
                                    <div class="numero-info">{{ $datosCuantitativos[2] ?? 0 }} </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-5 pt-2 graficos-especificos">
                        <div class="row ">
                            <div class="col d-flex flex-column justify-content-center align-items-center">
                                <div class="header-grafico w-100 texto-rojo-medio">
                                    <h3>Propósitos de actividades 2021</h3>
                                </div>
                                <div class=" grafico-container w-100">
                                    <div id="grafico_proposito">

                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex flex-column justify-content-start align-items-center">
                                <div class="display-5 w-75 texto-rojo-medio">
                                    <h3>Estados de actividades 2021</h3>
                                </div>
                                <div class="grafico-container w-75">
                                    <div id="grafico_estados">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Grafico --}}
                    <div class="row d-flex justify-content-center pt-5 pb-5 border-top">
                        <div class="display-5 w-75 texto-rojo-medio" id="graficoGenerado">
                            <h2>Generación de gráficos y reportes</h2>
                        </div>
                        <div class="w-75">
                            <div id="chart"></div>
                        </div>
                    </div>

                    <form action="/reportes/resultado" method="GET" enctype="multipart/form-data" id="formulario-reporte">
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
                                        <option value="line" {{ $chart == "line" ? 'selected' : '' }}>Líneas</option>
                                        <option value="area" {{ $chart == "area" ? 'selected' : '' }}>Área</option>
                                        <option value="donut" {{ $chart == "donut" ? 'selected' : '' }}>Dona</option>
                                        <option value="pie" {{ $chart == "pie" ? 'selected' : '' }}>Pie</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row  d-flex justify-content-center align-items-center py-4 pb-4 pt-4">
                            <div class="btn btn-lg btn-rojo" onclick="enviar()"><i class="fas fa-chart-line"></i> Generar gráfico</div>
                        </div>

                    </form>

                    <div class="row  d-flex justify-content-center align-items-center">
                        <div class="bs-example w-100">
                            <div class="accordion " id="accordionExample">
                                <div class="card ">
                                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne">
                                        <div class="mb-0 display-5 texto-azul-una d-flex justify-content-between align-items-center">
                                            <h5>Actividades relacionadas</h5>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="table-responsive table mt-2 table-hover" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                                <table class="table my-0" id="dataTable">
                                                    {{-- Nombre de las columnas en la parte de arriba de la tabla --}}
                                                    <thead>
                                                        <tr>
                                                            <th>ID Actividad</th>
                                                            <th>Tema</th>
                                                            <th>ID Coordinador</th>
                                                            <th>Fecha de inicio</th>
                                                            <th>Estado</th>
                                                            <th>Tipo de actividad</th>
                                                            <td><strong>Ver detalle<br /></strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Inserción iterativa de las actividades a la tabla --}}
                                                        <tr id="promocion" class="cursor-pointer">
                                                            <td>200</td>
                                                            <td>Un tema de actividad</td>
                                                            <td>117380366 </td>
                                                            <td>20 / 03 / 2021 </td>
                                                            <td>En progreso</td>
                                                            <td>Simposio</td>
                                                            <td>
                                                                {{-- Botón para ver el detalle de la actividad --}}
                                                                <strong>
                                                                    <a href="{{ route('actividad-promocion.show',1) }}" class="btn btn-contorno-rojo"> Detalle </a>
                                                                </strong><br />
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    {{-- Nombre de las columnas en la parte de abajode la tabla --}}
                                                    <tfoot>
                                                        <tr>
                                                            <th>ID Actividad</th>
                                                            <th>Tema</th>
                                                            <th>ID Coordinador</th>
                                                            <th>Fecha de inicio</th>
                                                            <th>Estado</th>
                                                            <th>Tipo de actividad</th>
                                                            <td><strong>Ver detalle<br /></strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>
</div>
@endsection


@section('scripts')
@if(!is_null($datos))
//Datos que se renderisan en caso de que se haya realizado una búsqueda para generar el gráfico dinámico
<script>
    let dataSet = JSON.parse('{!! $datos !!}');
    console.log(dataSet[1]);
    let x = [];
    let y = [];
    let naturalezaActividad = '{{ $naturalezaAct }}';

    // Ciclo que recorre cada uno de los resultados de la búsqueda y los coloca en posiciones
    //'X' y 'Y' para que se pueda renderizar el gráfico correspondiente
    var total = 0;
    for (const atributo in dataSet) {
        if (dataSet[atributo] != 0) {
            x.push(atributo);
            y.push(dataSet[atributo]);
            total++;
        }
    }
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";
    var url = window.location.href;
    window.location.href = url + "#graficoGenerado";

</script>
@else //En caso de que sea la primera vez que se cargue la página se setean los atributos en valores prederminados
<script>
    let dataSet = [];
    let naturalezaActividad = "Actividad interna";
    let total = 0;

</script>

@endif
<script src="{{ asset('js/reportes/reportes.js') }}" defer></script>
<script src="{{ asset('js/reportes/graficos_predeterminados.js') }}" defer></script>

<script src="{{ asset('js/reportes/'.$chart.'.js') }}" defer></script>


{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('js/global/inputs.js') }}"></script>


<script>
    $("input[type='number']").inputSpinner();

</script>


@endsection



@section('pie')
Copyright
@endsection
