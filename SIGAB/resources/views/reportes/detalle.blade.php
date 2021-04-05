@extends('layouts.app')

@section('titulo')
Reportes y estadísticas
@endsection


@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection

@section('contenido')



{{-- Arreglos de opciones de los select utilizados --}}
@php






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
                <h3>Reportes y estadísticas</span>
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

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#involucramiento-tab">Involucramiento</a>
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
                                    <div class="numero-info">288</div>
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
                                    <div class="numero-info"> 150 </div>
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
                                    <div class="numero-info"> 438 </div>
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
                                    <div class="numero-info"> 14 </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--Grafico --}}
                    <div class="row d-flex justify-content-center pt-5 pb-5">
                        <div class="w-50">
                            <div id="chart"></div>
                        </div>
                    </div>

                    <form action="/reportes/resultado" method="GET" enctype="multipart/form-data" id="formulario-reporte">

                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="w-75 d-flex justify-content-between">
                                <select class="custom-select mr-3" id="actividad" name="actividad" class="form-control">
                                    <option value="Seleccionar">Seleccionar actividad</option>
                                    <option value="Actividad interna">Actividad interna</option>
                                    <option value="Actividad de promoción">Actividad de promoción</option>
                                </select>

                                <select class="custom-select mr-3" id="tipo-actividad" name="tipo_actividad" class="form-control">
                                    <option selected>Seleccionar tipo actividad</option>
                                </select>

                                <div class="input-group mr-3">
                                    <div class="input-group-prepend">
                                        <span class="btn btn-contorno-rojo" data-toggle="tooltip" data-placement="top" title="Vaciar el campo de fecha" onclick="eliminarFechas(this);"><i class="fas fa-calendar-times fa-lg"></i></span>
                                    </div>
                                    <input type="text" class="form-control datetimepicker" name="rango-fechas" id="rango-fechas" placeholder="DD/MM/YYYY - DD/MM/YYYY" value="{{ $rango_fechas ?? null }}">
                                </div>
                                <select class="custom-select mr-3" id="tipo-grafico" name="tipo_grafico" class="form-control">
                                    <option value="bar" {{ $chart == "bar" ? 'selected' : '' }}>Barras</option>
                                    <option value="line" {{ $chart == "line" ? 'selected' : '' }}>Líneas</option>
                                    <option value="area" {{ $chart == "area" ? 'selected' : '' }}>Área</option>
                                    <option value="donut" {{ $chart == "donut" ? 'selected' : '' }}>Dona</option>
                                    <option value="pie" {{ $chart == "pie" ? 'selected' : '' }}>Pie</option>
                                </select>
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

                <div role="tabpanel" class="tab-pane fade" id="involucramiento-tab">
                    <div class="alert alert-info">involucramiento-tab</div>
                </div>
            </div>
        </div>





    </div>
</div>


@endsection


@section('scripts')
<script>
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

    let x = ['Noviembre', 'Diciembre', 'Enero'];
    let y = [50, 17, 26];
    let total = 93;

</script>

<script src="{{ asset('js/reportes/reportes.js') }}" defer></script>
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
