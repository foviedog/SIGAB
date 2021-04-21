<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte</title>
</head>

<style>
    p{
        text-align: center;
        line-height : 5px;
    }
    .grafico{
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 40%;
    }
    .fuente{
        margin-top: 50px;
        text-align: right;
        font-style: italic;
    }
    .column {
        white-space: nowrap;
    }
    .logos{
        max-width: 70px;
        max-height: 70px
    }
    .datoConsulta{
        font-size: 13px;
        font-weight: 500;
        margin-top: 25px;
        margin-bottom: 15px;
    }
    .consultado{
        font-size: 10px;
        text-align: center;
        margin-top: 15px;
    }
</style>

<body>

    <div class="column">
        <img class="logos" src="{{ $logoUNA }}">
        <img class="logos" style="float: right;" src="{{ $logoEBDI }}">
    </div>

    
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
    <img  src="{{ $imgUri }}">
    <div class="consultado">
        {{ $consultado }}
    </div>
    
    <div class="fuente">Fuente: Reporte generado desde el Sistema de información para la gestión administrativa,
        docente y curricular de la EBDI (SIGAB), {{ $annioActual }}</div>
</body>

</html>