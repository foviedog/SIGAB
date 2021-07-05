@php
//Se incluye la biblioteca para los accesos
use App\Helper\Accesos;
@endphp

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    {{-- Título de la página --}}
    <title>@yield('titulo')</title>

    {{-- Hojas de estilo individuales --}}
    @yield('css')

    {{-- Hojas de estilo globales --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

</head>

<body>

    {{-- Loader --}}
    @include('layouts.messages.loader')

    <div class="wrapper bg-gris-claro">

        {{-- Menú --}}
        @include('layouts.menu')

        <div id="content">

            {{-- Encabezado de la página --}}
            @include('layouts.head')

            {{-- Contenido de la página --}}
            <div class="card-body" style="min-height: 100vh; padding: 1rem 0rem 0rem 0rem;">
                @yield('contenido')
            </div>

            {{-- Pie de la página --}}
            @include('layouts.footer')

        </div>
    </div>
    {{-- JQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>

    {{-- Audio para notificaciones --}}
    <audio id="notification-sound" src="{{ asset('sounds/notification.mp3') }}" muted="muted"></audio>
    {{-- Scripts globales --}}
    <script src="{{route('script.global')}}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/plantilla/ebdi.js') }}" defer> </script>
    <script src="{{ asset('js/global/notificaciones.js') }}"defer> </script>
    <script src="{{ asset('js/global/mensajes.js') }}" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/39f4ebbbea.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/global/inputs.js') }}" defer></script>

    @yield('scripts')
</body>

</html>
