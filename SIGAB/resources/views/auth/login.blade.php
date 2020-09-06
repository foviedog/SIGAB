<!DOCTYPE html>
<html class="rojo">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- titulo de la página  --}}
    <title>Bienvenida</title>

    {{-- css  --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

    {{-- Script  --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="bg-rojo-oscuro">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row mt-5">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(img/login/logo.jpg ); background-repeat: no-repeat; background-size: cover; "></div>
                            </div>
                            <div class="col-lg-6 pb-5">
                                <div class="p-5 mt-5">
                                    <div class="text-center"><span style="font-size: 60px;color:#414141;">SIGAB</span></div>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input id="cedula" type="cedula" class="form-control  form-control-user @error('cedula') is-invalid @enderror" placeholder="Cédula" name="cedula" value="{{ old('cedula') }}" required autocomplete="cedula" autofocus>
                                            @error('cedula')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input id="contrasenna" type="contrasenna" class="form-control @error('contrasenna') is-invalid @enderror" placeholder="Contraseña" name="contrasenna" required autocomplete="current-password">
                                            @error('contrasenna')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group d-flex justify-content-center py-3">
                                            <button type="submit" class="btn btn-rojo">
                                                {{ __('Iniciar Sesión') }} &nbsp; <i class="fas fa-sign-in-alt"></i>

                                            </button>
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>
