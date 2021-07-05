<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- titulo de la página  --}}
    <title>Bienvenida</title>

    {{-- css  --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/login.css') }}" rel="stylesheet">

    {{-- Script  --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div class="container p-5">
        <div class="row justify-content-center pt-5">
            <div class="col-md-8 col-xs-8">
                <div class="card shadow-lg o-hidden border-0 my-5">

                    <div class="card-header bg-rojo-oscuro">
                        <div class="text-lext font-weight-bold text-white bg-azul-una">
                            Inicio de sesión
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="container">



                            <div class="row d-flex justify-content-between px-4">
                                <img src="{{ asset('img/login/logo.jpg') }}" alt="" class="logo">
                                <img src="{{ asset('img/login/UNA.png') }}" alt="" class="logo">
                            </div>

                            <div class="row d-flex justify-content-center pb-5 ">
                                <div class="col-6">
                                    <div class="text-center pb-3">
                                        <h1 class="ml1">
                                            <span class="text-wrapper">
                                                <span class="line line1"></span>
                                                <span data-tooltip title="Sistema de información para la gestión administrativa,
                                                académica y curricular de la Escuela de Bibliotecología,
                                                Documentación e Información.">
                                                    <span class="letters" id='letras'>SIGAB</span>
                                                </span>
                                                <span class="line line2"></span>
                                            </span>
                                        </h1>
                                    </div>

                                    {{-- Alerts --}}
                                    @include('layouts.messages.alerts')

                                    <form method="POST" autocomplete="off" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group">
                                            {{-- <label for="persona_id"class="col-md-4col-form-labeltext-md-right">__('Cédula')</label> --}}

                                            <input id="persona_id" autocomplete="off" type="text" class="form-control @error('persona_id') is-invalid @enderror" name="persona_id" value="{{ old('persona_id') }}" placeholder="Cédula" required autocomplete="cedula_iniciar_sesion" autofocus>

                                            @error('persona_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>--}}
                                            
                                            <div class="input-group" id="password_campo">
                                                <input id="password" autocomplete="off" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Contraseña" required autocomplete="current-password" autofocus>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><a href="#"><i class="fa fa-eye-slash password-eye" aria-hidden="true"></i></a></div>
                                                </div>
                                            </div>

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn btn-rojo">
                                                    {{ __('Iniciar Sesión') }}
                                                </button>

                                                @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script src="{{ asset('js/login/login.js') }}" defer></script>
    <script src="{{ asset('js/login/Tooltip.js') }}" defer></script>
    <script src="{{ asset('js/global/inputs.js') }}" defer></script>


</body>

</html>
