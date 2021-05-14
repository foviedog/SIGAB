@extends('layouts.app')

@section('titulo')
Involucramiento Anual
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@php
$anios = array();
for ($anio = 2000; $anio <= date("Y"); $anio++) { array_push($anios, $anio); } @endphp {{-- @if ($anio==$estado) selected @endif --}} @section('contenido') <div class="card pb-5">

    <div class="card-body pb-5">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Reportes y estadísticas de involucramiento anual del personal</span>
            </div>
        </div>
        <hr>
        <div id="cartas-actividad my-4" class="row d-flex justify-content-between px-3 mt-4">
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
        <div class="container mt-5">
            <div class="card shadow-sm mb-4 rounded">
                <div class="card-header ">
                    <h6 class="texto-rojo-medio font-weight-bold m-0 texto-rojo" style="font-size: 18px;"> Datos anuales del involucramiento del personal </h6>
                </div>
                <div class="card-body pb-5 row">
                    <div class="col-4 border-right d-flex justify-content-center" id="img-actividad">
                        <img src="{{ asset('img/logoEBDI.png') }}" id="logo-EBDI" alt="logo_ebdi" style="max-width: 40%">
                    </div>
                    <div class="col-8 d-flex flex-column justify-content-center align-items-center">
                        <div class="w-100 mb-3"><span class="texto-azul-una" style="font-size: 18px">Rango de años</span> </div>
                        <form action="{{ route('involucramiento-anual.show') }}" method="GET" class="w-100" enctype="multipart/form-data" id="rango-anios">
                            <div class="w-100 d-flex justify-content-center align-items-center">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text texto-rojo-medio" id="">Año inicial: </span>
                                    </div>
                                    <select class="form-control" id="estado" name="anio_inicio" class="form-control" required>
                                        @foreach($anios as $anio)
                                        <option value='{{ $anio }}' @if ($anio==$anioInicio) selected @endif>{{ $anio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <i class="fas fa-arrow-right mx-4 fa-2x texto-azul-una"></i>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text texto-rojo-medio" id="">Año final: </span>
                                    </div>
                                    <select class="form-control" id="estado" name="anio_final" class="form-control" required>
                                        @foreach($anios as $anio)
                                        <option value='{{ $anio }}' @if ($anio==$anioFinal) selected @endif>{{ $anio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <button class="btn btn-rojo mt-4" type="submit" id="boton-enviar" onclick="activarLoader('Generando datos');"><i class="fas fa-chart-line"></i> Generar estadísticas</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            @if(!is_null($actividadesXAnio))
            <div class="w-100 d-flex justify-content-end mb-3">
                <form action="{{ route('involucramiento-anual.reporte') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="actividadesXAnio" id="actividadesXAnio" value='@json($actividadesXAnio)''>
                    <input type="hidden" name="graficosInvolucramiento" id="graficosInvolucramiento" value='{{ $graficosInvolucramiento }}'>
                    <input type="hidden" name="personal" id="personal" value='@json($personal)'>
                    <input type="hidden" name="anioInicio" id="anioInicio" value='@json($anioInicio)'>
                    <input type="hidden" name="anioFinal" id="anioFinal" value='@json($anioFinal)'>
                    <button type="submit" class="btn btn-contorno-rojo text-end">
                        <i class="far fa-file-pdf" style="font-size: 20px;"></i> Crear Reporte
                    </button>
                </form>
            </div>

            <div class="accordion resultado-reporte-anio" id="accordionExample">
                @foreach ($actividadesXAnio as $anio => $actividades )
                <div class="card">
                    <div class="card-header" id="heading{{ $anio }}">
                        <h2 class="mb-0">
                            <button class="btn btn-block resultado-anio" type="button" data-toggle="collapse" data-target="#collapse{{ $anio }}" aria-expanded="true" aria-controls="collapse{{ $anio }}">
                                <div>Involucramiento del personal en {{ $anio }}</div>
                                <div>
                                    <i class="fas fa-chevron-down "></i>
                                </div>
                            </button>
                        </h2>
                    </div>

                    <div id="collapse{{ $anio }}" class="collapse " aria-labelledby="heading{{ $anio }}" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="grafico-container w-75 mt-3 ">
                                    <div id="grafico_{{ $anio }}">
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-hover tabla-reporte-anual">
                                <thead class="">
                                    <tr>
                                        <th rowspan="8" style="text-align: center">Personal</th>
                                        <th>Tipo Actividad</th>
                                        <th>Participaciones</th>
                                        <th>Tipo Actividad</th>
                                        <th>Participaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($actividades as $persona_id => $nombre_actividad)
                                    <tr data-toggle="tooltip" data-placement="top" title="{{ $personal[$persona_id]->nombre . " " . $personal[$persona_id]->apellido . " (".  $anio . ")"}}">
                                        <td class="personal-col border-left separador-fila" rowspan="8">
                                            <img class="img-personal" src="{{URL::asset('img/fotos/'.$personal[$persona_id]->imagen_perfil)  }}" alt="">
                                            <div class="nombre-personal">{{ $personal[$persona_id]->nombre . " " . $personal[$persona_id]->apellido }}</div>
                                            <div class="jornada-personal">{{ $personal[$persona_id]->cargo}}</div>
                                            <div class="jornada-personal">{{ $personal[$persona_id]->tipo_puesto_1}}</div>
                                            <div class="jornada-personal">{{ $personal[$persona_id]->jornada}}</div>
                                        </td>
                                        <td scope="col" class="thead-reporte ">Curso</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Curso"] }}</td>
                                        <td scope="col" class="thead-reporte ">Conferencia</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Conferencia"] }}</td>
                                    <tr>
                                        <td scope="col" class="thead-reporte ">Taller</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Taller"] }}</td>
                                        <td scope="col" class="thead-reporte ">Seminario</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Seminario"] }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="col" class="thead-reporte ">Conversatorio</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Conversatorio"] }}</td>
                                        <td scope="col" class="thead-reporte ">Órgano colegiado</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Órgano colegiado"] }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="col" class="thead-reporte ">Tutorías</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Tutorías"] }}</td>
                                        <td scope="col" class="thead-reporte ">Lectorías</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Lectorías"] }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="col" class="thead-reporte ">Simposio</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Simposio"] }}</td>
                                        <td scope="col" class="thead-reporte ">Charla</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Charla"] }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="col" class="thead-reporte ">Actividad cocurricular</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Actividad cocurricular"] }}</td>
                                        <td scope="col" class="thead-reporte ">Órgano colegiado</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Órgano colegiado"] }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="col" class="thead-reporte ">Comisiones de trabajo</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Comisiones de trabajo"] }}</td>
                                        <td scope="col" class="thead-reporte ">Externa</td>
                                        <td class="cant-participaciones">{{ $nombre_actividad["Externa"] }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="col" class="thead-reporte separador-fila">Otro</td>
                                        <td class="cant-participaciones separador-fila">{{ $nombre_actividad["Otro"] }}</td>
                                        <td class="cant-participaciones separador-fila" colspan="2"></td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>

    @endsection


    @section('scripts')
    <script>
        var fotosURL = "{{ URL::asset('img/fotos/') }}";
        let graficosInvolucramiento = JSON.parse('{!! $graficosInvolucramiento !!}');

    </script>

    <script src="{{ asset('js/global/variablesGraficos.js') }}" defer=""></script>
    <script src="{{ asset('js/reportes/involucramiento/involucramientoAnual.js') }}" defer=""></script>
    @endsection
