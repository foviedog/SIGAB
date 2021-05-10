<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Título de la página  --}}
    <title>Cambiar contraseña</title>

    {{-- Css  --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/login.css') }}" rel="stylesheet">

    {{-- Scripts  --}}
    <script src="https://kit.fontawesome.com/39f4ebbbea.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div class="container p-5">
        <div class="row justify-content-center pt-5">
            <div class="col-md-10 col-xs-10">
                <div class="card shadow-lg o-hidden border-0 my-5">

                    <div class="card-header bg-rojo-oscuro">
                        <div class="text-lext font-weight-bold text-white bg-rojo-oscuro">
                            Cambiar mi contraseña
                        </div>
                    </div>

                    <div class="card-body p-0">

                        {{-- Botón para regresar a la página principal o el perfil --}}
                        <div class="p-3 d-flex d-flex justify-content-between">
                            <div></div>
                            <div>
                                <a href="{{ route('home') }}" class="btn btn-contorno-rojo"><i class="fas fa-home"></i> &nbsp; Página Principal </a>
                                <a href="{{ route('perfil.show') }}" class="btn btn-contorno-rojo"><i class="fas fa-user"></i> &nbsp; Mi Perfil </a>
                            </div>
                        </div>
                        

                        <div class="p-3">
                            <div class="text-center">
                                <img class="mb-4" src="/img/logoSIGAB.png">
                            </div>

                            <form method="POST" action="{{ route('perfil.actualizar-contrasenna') }}" id="envio_actualizar">
                                @csrf
                                @method('PATCH')

                                {{-- Alerts --}}
                                @include('layouts.messages.alerts')

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña actual:') }}</label>
                                    <div class="col-md-6">
                                        <input id="old-password" type="password" class="form-control @error('password') is-invalid @enderror" name="old_password" required>

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña nueva:') }}</label>

                                    <div class="col-md-6">
                                        <input id="new-password" type="password" class="form-control @error('password') is-invalid @enderror" name="new_password" required>

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña nueva:') }}</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="col-md-6 offset-md-4 mb-3"><strong>La contraseña debe contener mínimo 6 carácteres, tener una mayúscula, contener un número y algún carácter especial.</strong></div>

                                <div class="col-md-6 offset-md-4 mb-3 text-danger" id="error_contrasenna"></div>

                                <div class="form-group row mb-2">
                                    <div class="col-md-6 offset-md-4">
                                        <a onclick="confirmar()" class="btn btn-rojo">
                                            {{ __('Actualizar contraseña') }}
                                        </a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script src="{{ asset('js/login/Tooltip.js') }}" defer></script>
    <script src="{{ asset('js/control_perfil/contrasenna.js') }}" defer></script>
    <script src="{{ asset('js/global/mensajes.js') }}" defer></script>

</body>
</html>
