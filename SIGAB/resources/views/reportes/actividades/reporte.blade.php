{{-- ESTE DOCUMENTO .BLADE SIRVE UNICAMENTE COMO FORMATO DE IMPRESIÓN PARA EL REPORTE DE ACTIVIDADES
    POR LO CUAL NO CUENTA CON NINGUNA IMPORTACIÓN DE BOOTSTRAP, JQUERY, O ALGUNA OTRA DEPENDENCIA EXTERNA
    UNICAMENTE CUENTA CON LOS ÍCONOS DE FONTAWESOME.
    --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte</title>
</head>

<style>
    p {
        text-align: center;
        line-height: 5px;
    }

    .fuente {
        margin-top: 50px;
        text-align: right;
        font-style: italic;
    }

    .consultado {
        font-size: 10px;
        text-align: center;
        margin-top: 15px;
    }

    @page {
        margin: 10px 30px;
    }

    header {
        margin: auto;
        width: 100%;
        top: 10px;
        text-align: center;

    }

    .header-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .logo1 {
        display: block;
        width: 110px;
        height: auto;
    }

    .logo2 {
        display: block;
        width: 150px;
        height: auto;
    }

    .container-body {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
    }

    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }

        .sheet-format {
            width: 100% !important;
            padding: 0rem !important;
            box-shadow: 0px 0px 7px 0px #cfcfcf00 !important;
        }
    }

    .center {
        display: flex;
        justify-content: center;
        align-content: center;
    }

    .btn-rojo {
        margin-top: 3rem;
        margin-bottom: 3rem;
        padding: 0.5rem 1rem;
        font-size: 1.125rem;
        line-height: 1.5;
        border-radius: 0.3rem;
        background-color: #990000;
        border-color: #990000;
        color: #ffffff;
        cursor: pointer;
    }

    .img-container {
        width: 80%;
    }

    .grafico {
        width: 100%;
    }

    .sheet-format {
        width: 50%;
        margin: auto;
        padding: 2rem;
        box-shadow: 0px 0px 7px 0px #cfcfcf;
    }

    .titulo {
        font-size: 20px;
        width: 85%;
        margin-top: 2rem;
        font-weight: bold;
        text-align: center;
    }

</style>

<body>
    <div class="sheet-format" id="sheet-format">
        <header>
            <div class="header-wrapper">
                <img class="logo1" src="{{ $logoUNA }}">
                <img class="logo2" src="{{ $logoEBDI }}" style="">
            </div>
        </header>
        <div class="container-body">
            <div style="float: none;">
                <p>UNIVERSIDAD NACIONAL</p>
                <p>Facultad de Filosofía y Letras</p>
                <p>Escuela de Bibliotecología, Documentación e Información</p>
                <p>Programa Aseguramiento de la calidad y mejora continua de la carrera de Bibliotecología y</p>
                <p>Gestión de la Información de la Universidad Nacional</p>
            </div>
            <div class="titulo">
                {{ $titulo }}
            </div>
            <div class="img-container" id="chart">
                <img class="grafico" id="grafico">
            </div>

            <div class="consultado">
                {{ $consultado }}
            </div>

            <div class="fuente">Fuente: Reporte generado desde el Sistema de información para la gestión administrativa,
                docente y curricular de la EBDI (SIGAB), {{ $annioActual }}</div>
            <div class="center">
                <div class="btn btn-rojo no-print" onclick="print()">Descargar &nbsp;<i class="fas fa-file-download"></i></div>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        var image = "{{ $image }}"
        document.getElementById("grafico").src = image

    </script>
    <script src="https://kit.fontawesome.com/39f4ebbbea.js" crossorigin="anonymous"></script>

</body>

</html>
