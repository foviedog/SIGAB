<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- titulo de la página  --}}
    <title>Registrar usuario</title>

    {{-- css  --}}
    <link href="{{ asset('css/plantilla/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/login.css') }}" rel="stylesheet">

    {{-- Script  --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="bg-rojo-oscuro">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="p-5 mt-5">
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
                            <form method="POST" action="/registro">
                                @csrf
                                <div class="form-group row">
                                    <label for="persona_id" class="col-md-4 col-form-label text-md-right">{{ __('Cedula') }}</label>

                                    <div class="col-md-6">
                                        <input id="persona_id" type="text" class="form-control @error('persona_id') is-invalid @enderror" name="persona_id" value="{{ old('persona_id') }}" required autocomplete="persona_id" autofocus>

                                        @error('persona_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="rol" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>

                                    <div class="col-md-6">
                                        <input id="rol" type="text" class="form-control @error('rol') is-invalid @enderror" name="rol" value="{{ old('rol') }}" required autocomplete="rol">

                                        @error('rol')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
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
    <script src="{{ asset('js/login/login.js') }}" defer></script>
    <script src="{{ asset('js/login/Tooltip.js') }}" defer></script>


</body>
</html>
