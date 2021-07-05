{{-- ESTE DOCUMENTO .BLADE SIRVE UNICAMENTE COMO FORMATO DE IMPRESIÓN PARA EL REPORTE DE ACTIVIDADES
    POR LO CUAL NO CUENTA CON NINGUNA IMPORTACIÓN DE BOOTSTRAP, JQUERY, O ALGUNA OTRA DEPENDENCIA EXTERNA
    ÚNICAMENTE CUENTA CON LOS ÍCONOS DE FONTAWESOME.
    --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte por rango de años</title>
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

        .chart-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
        }
        .anio-info-card {
            page-break-before: always;
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
                    <div class="d-flex justify-content-center my-5  no-print">
                        <div class="btn btn-rojo no-print " onclick="print()">Descargar &nbsp;<i class="fas fa-file-download"></i></div>
                    </div>

                    <div class="accordion resultado-reporte-anio" id="accordionExample">
                        @foreach ($actividadesXAnio as $anio => $actividades )
                        <div class="card @if($anio != $anioInicio) anio-info-card @endif">
                            <div class="card-header" id="heading{{ $anio }}">
                                <h4 class="my-3 font-weight-bold text-dark">
                                    <div>Involucramiento del personal en {{ $anio }}</div>
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="grafico-container w-75 mt-3 chart-center">
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
                                        <tr data-toggle="tooltip" data-placement="top" title="{{ $personal[$persona_id]["nombre"] . " " . $personal[$persona_id]["apellido"] . " (".  $anio . ")"}}">
                                            <td class="personal-col border-left separador-fila" rowspan="8">
                                                <img class="img-personal" src="{{URL::asset('img/fotos/'.$personal[$persona_id]["imagen_perfil"])  }}" alt="">
                                                <div class="nombre-personal">{{ $personal[$persona_id]["nombre"] . " " . $personal[$persona_id]["apellido"] }}</div>
                                                <div class="jornada-personal">{{ $personal[$persona_id]["cargo"]}}</div>
                                                <div class="jornada-personal">{{ $personal[$persona_id]["tipo_puesto_1"]}}</div>
                                                <div class="jornada-personal">{{ $personal[$persona_id]["jornada"] }}</div>
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
                                        {{-- --}}
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
                        @endforeach
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
    <script>
        let graficosInvolucramiento = JSON.parse('{!! $graficosInvolucramiento !!}');
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/39f4ebbbea.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/global/variablesGraficos.js') }}" defer=""></script>
    <script src="{{ asset('js/reportes/involucramiento/involucramientoAnual.js') }}" defer=""></script>


</body>

</html>
