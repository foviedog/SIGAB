<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Error</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    ¡Lo sentimos! Ha ocurrido un error inesperado.
                </div>
                @if(!empty($error))
                        <div class="alert alert-danger text-center font-weight-bold" role="alert" id="alert"> 
                            {{ $error }}
                        </div>
                @endif
                <div class="mt-3">
                    <a class="btn btn-contorno-rojo" onclick="history.back();"><i class="fas fa-chevron-left"></i> &nbsp; Regresar </a>
                    <a href="{{ route('home') }}" class="btn btn-contorno-rojo"><i class="fas fa-home"></i> &nbsp; Página Principal </a>
                </div>
            </div>
        </div>
    </body>

    <script src="https://kit.fontawesome.com/39f4ebbbea.js" crossorigin="anonymous"></script>
</html>
