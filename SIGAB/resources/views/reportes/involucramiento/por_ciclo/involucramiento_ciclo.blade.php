@extends('layouts.app')

@section('titulo')
Involucramiento Anual
@endsection



{{-- --}}
@section('contenido')
<div class="card pb-5">
    <div class="card-body pb-5">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Reportes y estadísticas de involucramiento del personal por ciclo </span>
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
                        <div class="w-100 mb-3"><span class="texto-azul-una" style="font-size: 18px">Año del reporte</span> </div>
                        <form action="{{ route('involucramiento-ciclo.show') }}" method="GET" class="w-100" enctype="multipart/form-data" id="anio">
                            <div class="w-50 d-flex justify-content-center align-items-center">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text texto-rojo-medio" id="">Año: </span>
                                    </div>
                                    <select class="form-control" id="estado" name="anio" class="form-control" required>
                                        @foreach($anios as $anio)
                                        <option value='{{ $anio }}' @if ($anio==$anioReporte) selected @endif>{{ $anio }}</option>
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

            @if(!is_null($personal) )

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center" id="heading2021">
                    <h4 class="mb-0 texto-azul-una py-3">
                        <div>Involucramiento del personal por ciclo en {{ $anioReporte }}</div>
                    </h4>
                    <div>
                        <form action="{{ route('involucramiento-ciclo.reporte') }}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="personal" id="personal" value='@json($personal)''>
                            <input type="hidden" name="anio" id="anio" value=' {{ $anio }}'>
                            <input type="hidden" name="actividadesPrimerCiclo" id="actividadesPrimerCiclo" value='@json($actividadesPrimerCiclo)'>
                            <input type="hidden" name="actividadesSegundoCiclo" id="actividadesSegundoCiclo" value='@json($actividadesSegundoCiclo)'>
                            <button type="submit" class="btn btn-lg btn-contorno-rojo ml-2" id="reporte-trigger">
                                <i class="far fa-file-pdf"></i> Generar reporte
                            </button>
                        </form>
                    </div>
                </div>

                <div id="reporte">
                    <div class="card-body">
                        <table class="table  tabla-reporte-ciclo">
                            <thead class="sticky-header">
                                <tr>
                                    <th rowspan="8" style="text-align: center; width: 20%;">Personal</th>
                                    <th style="width: 40%;">Ciclo I</th>
                                    <th style="width: 40%;">Ciclo II</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personal as $persona)
                                <tr data-toggle="tooltip" data-placement="top" title="{{ $persona->nombre . " " . $persona->apellido . "(" . $anio .")"}}">
                                    <td>
                                        <div class="row flex-column d-flex justify-content-center align-items-center">
                                            <img class="img-personal" src="{{URL::asset('img/fotos/'. $persona->imagen_perfil)}}" alt="">
                                            <div class="nombre-personal ">{{ $persona->nombre . " " . $persona->apellido }}</div>
                                            <div class="jornada-personal">{{ $persona->jornada }} </div>
                                            <div class="jornada-personal">{{ $persona->cargo}}</div>
                                            <div class="jornada-personal">{{ $persona->tipo_puesto_1}}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col ciclo">
                                                    @if(count($actividadesPrimerCiclo[$persona->persona_id]) != 0)
                                                    @foreach ($actividadesPrimerCiclo[$persona->persona_id] as $actividad)
                                                    <a href="{{ route('actividad-interna.show',$actividad->id) }}" class="row info-actividad " target="_blank">
                                                        <span class="font-weight-bold w-100">{{ $actividad->tipo_actividad }}:</span>
                                                        <span class="texto-azul-una" style="font-size: 16px;">{{ $actividad->tema }}</span>
                                                        <i class="text-muted w-100">{{ $actividad->fecha_inicio_actividad  . " al " . $actividad->fecha_final_actividad  }}</i>
                                                    </a>
                                                    @endforeach
                                                    @else
                                                    <div class="row info-actividad no-data " target="_blank">
                                                        <span class="font-weight-bold w-100">No existen acitividades registradas</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col ciclo">
                                                    @if(count($actividadesSegundoCiclo[$persona->persona_id]) != 0)
                                                    @foreach ($actividadesSegundoCiclo[$persona->persona_id] as $actividad)
                                                    <a href="{{ route('actividad-interna.show',$actividad->id) }}" class="row info-actividad ciclo2" target="_blank">
                                                        <span class="font-weight-bold w-100">{{ $actividad->tipo_actividad }}:</span>
                                                        <span class="texto-azul-una" style="font-size: 16px;">{{ $actividad->tema }}</span>
                                                        <i class="text-muted w-100">{{ $actividad->fecha_inicio_actividad  . " al " . $actividad->fecha_final_actividad  }}</i>
                                                    </a>
                                                    @endforeach
                                                    @else
                                                    <div class="row  info-actividad no-data " target="_blank">
                                                        <span class="font-weight-bold  w-100">No existen acitividades registradas</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            @endif

        </div>

        @endsection


        @section('scripts')
        <script>
            var personal = @json($personal);
            var $anio = @json($anio);
            var actividadesCiclo = @json($actividadesPrimerCiclo);
            var actividadesSegundoCiclo = @json($actividadesSegundoCiclo);
            console.log(personal);

        </script>

        <script src="{{ asset('js/reportes/involucramiento/porCiclo.js') }}"></script>

        @endsection
