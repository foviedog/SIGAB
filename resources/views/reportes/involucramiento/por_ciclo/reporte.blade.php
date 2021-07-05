{{-- ESTE DOCUMENTO .BLADE SIRVE UNICAMENTE COMO FORMATO DE IMPRESIÓN PARA EL REPORTE DE ACTIVIDADES
    POR LO CUAL NO CUENTA CON NINGUNA IMPORTACIÓN DE BOOTSTRAP, JQUERY, O ALGUNA OTRA DEPENDENCIA EXTERNA
    ÚNICAMENTE CUENTA CON LOS ÍCONOS DE FONTAWESOME.
    --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte por ciclo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">
</head>

<style>
    a {
        color: #000 !important;
        text-decoration: none !important;
    }

    .logo1 {
        display: block;
        width: 160px;
        height: auto;
    }

    .logo2 {
        display: block;
        width: 110px;
        height: auto;
    }


    @media print {
        a:link {
            color: black;
            text-decoration: none !important;
        }

        a[href]:after {
            content: none !important;
        }

        #container-report {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .card {
            border: none !important;
        }

        .no-print,
        .no-print * {
            display: none !important;
        }

    }

</style>

<body>
    <header>

    </header>

    <div class="card pb-5">
        <div class="card-body pb-5">
            <div class="row d-flex justify-content-center">
                <div class="col-8" id="container-report">
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <img class="logo1" src="{{ URL::asset('img/logoUNA-Blanco.png') }}">
                        <img class="logo2" src="{{ URL::asset('img/logoEBDI.png') }}" style="">
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center mb-3 font-weight-bold" style="font-size: 18px;">
                        <div>UNIVERSIDAD NACIONAL</div>
                        <div>Facultad de Filosofía y Letras</div>
                        <div>Escuela de Bibliotecología, Documentación e Información</div>
                        <div>Programa Aseguramiento de la calidad y mejora continua de la carrera de Bibliotecología y</div>
                        <div>Gestión de la Información de la Universidad Nacional</div>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center" id="heading2021">
                            <h4 class="mb-0 font-weight-bold text-dark py-3">
                                <div>Involucramiento del personal por ciclo en {{ $anioReporte }}</div>
                            </h4>
                            <div>
                                <div class="btn btn-rojo no-print " onclick="window.print()">Descargar &nbsp;<i class="fas fa-file-download"></i></div>
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
                                        <tr data-toggle="tooltip" data-placement="top" title="{{ $persona->nombre . " " . $persona->apellido . "(" . $anioReporte .")"}}">
                                            <td>
                                                <div class="row flex-column d-flex justify-content-center align-items-center">
                                                    <img class="img-personal" src="{{URL::asset('img/fotos/'. $persona->imagen_perfil)}}" alt="">
                                                    <div class="nombre-personal ">{{ $persona->nombre . " " . $persona->apellido }}</div>
                                                    <div class="jornada-personal ">{{ $persona->cargo}}</div>
                                                    <div class="jornada-personal">{{ $persona->tipo_puesto_1}}</div>
                                                    <div class="jornada-personal">{{ $persona->jornada}}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col ciclo">
                                                            @if(count($actividadesPrimerCiclo[$persona->persona_id]) != 0)
                                                            @foreach ($actividadesPrimerCiclo[$persona->persona_id] as $actividad)
                                                            <a href="{{ route('actividad-interna.show',$actividad['id']) }}" class="row info-actividad " target="_blank">
                                                                <span class="font-weight-bold w-100">{{ $actividad["tipo_actividad"] }}:</span>
                                                                <span class="texto-azul-una" style="font-size: 16px;">{{ $actividad["tema"] }}</span>
                                                                <i class="text-muted w-100">{{ $actividad["fecha_inicio_actividad"]  . " al " . $actividad["fecha_final_actividad"]  }}</i>
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
                                                            <a href="{{ route('actividad-interna.show',$actividad['id']) }}" class="row info-actividad ciclo2" target="_blank">
                                                                <span class="font-weight-bold w-100">{{ $actividad["tipo_actividad"] }}:</span>
                                                                <span class="texto-azul-una" style="font-size: 16px;">{{ $actividad["tema"] }}</span>
                                                                <i class="text-muted w-100">{{ $actividad["fecha_inicio_actividad"]  . " al " . $actividad["fecha_final_actividad"]  }}</i>
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
                    <div class="d-flex-justify-content-center align-items-center text-center">
                        <div class="consultado text-muted font-weight-bold my-2" style="font-size: 13px">
                            {{ $consultado }}
                        </div>

                        <div class="fuente mt-2 font-italic">Fuente: Reporte generado desde el Sistema de información para la gestión administrativa,
                            docente y curricular de la EBDI (SIGAB), {{ date("Y") }}</div>

                    </div>

                </div>

            </div>

        </div>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/39f4ebbbea.js" crossorigin="anonymous"></script>
</body>

</html>
