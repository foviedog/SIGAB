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

    .datoConsulta {
        font-size: 13px;
        font-weight: 500;
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .consultado {
        font-size: 10px;
        text-align: center;
        margin-top: 15px;
    }

    .img-container {
        widith: 100%;
    }

    .grafico {
        widith: 100%;
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

</style>

<body>
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

        <div class="datoConsulta">
            {{ $reporteTexto }}
        </div>

        <div class="img-container">
            <img class="grafico" src="{{ $imgUri }}">
        </div>

        <div class="consultado">
            {{ $consultado }}
        </div>

        <div class="fuente">Fuente: Reporte generado desde el Sistema de información para la gestión administrativa,
            docente y curricular de la EBDI (SIGAB), {{ $annioActual }}</div>
    </div>


    <script type="text/javascript">
        window.print();

    </script>
</body>

</html>
