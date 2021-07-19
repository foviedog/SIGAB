<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Título de la página  --}}
    <title>Cambiar rol a usuario</title>

    {{-- Css  --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/login.css') }}" rel="stylesheet">

    {{-- Scripts  --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div class="container p-5">
        <div class="row justify-content-center pt-5">
            <div class="col-md-10 col-xs-10">
                <div class="card shadow-lg o-hidden border-0 my-5">

                    <div class="card-header bg-rojo-oscuro">
                        <div class="text-lext font-weight-bold text-white bg-rojo-oscuro">
                            Cambiar rol a usuario
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <a href="{{  route('home') }}"><img class="mb-4" src="/img/logoSIGAB.png"></a>
                            </div>

                            {{-- Esta sección se despliega si la persona que se desea cambiar rol
                                no tiene un usuario. Aquí se genera el formulario para
                                que se pueda cambiar rol. --}}
                            @if(Session::has('persona-seleccionada'))

                            <form method="POST" action="{{ route('cambiar-rol.update') }}" id="envio_registro">
                                @csrf
                                @method('PATCH')

                                @php
                                $persona = Session::get('persona-seleccionada');
                                $rolActual = Session::get('rolActual');
                                $roles = GlobalArrays::ROLES_USUARIO;
                                @endphp

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('Persona:') }}</label>

                                    <input id="persona_id" type="hidden" class="form-control @error('persona_id') is-invalid @enderror" name="persona_id" value="{{ $persona->persona_id }}">

                                    <div class="col-md-6">
                                        {{ $persona->persona_id." - ".$persona->apellido." ".$persona->nombre }}
                                    </div>

                                    @error('persona_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('Rol actual:') }}</label>

                                    <div class="col-md-6">
                                        {{ $rolActual }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="rol" class="col-md-4 col-form-label text-md-right">{{ __('Nuevo rol:') }}</label>

                                    <div class="col-md-6">
                                        <select id="rol" class="form-control @error('rol') is-invalid @enderror" name="rol" value="{{ old('rol') }}" required autocomplete="rol">
                                            @foreach ($roles as $rol)
                                                <option value="{{ $loop->index + 1 }}">{{ $rol }}</option>
                                            @endforeach
                                        </select>

                                        @error('rol')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-rojo">
                                            {{ __('Cambiar rol') }}
                                        </button>
                                        <a onclick="location.reload();" class="btn btn-rojo">
                                            {{ __('Cancelar') }}
                                        </a>
                                    </div>
                                </div>
                            </form>

                            {{-- De lo contrario se muestra una tabla
                                con todas las personas que tienen un usuario actualmente.
                                En esta sección se despliega un formulario para poder elegir
                                la persona que se desea cambiar rol. --}}
                            @else

                            <div class="text-center mb-2">
                                Seleccione la persona a la que desea cambiar el rol
                            </div>

                            {{-- Alerts --}}
                            @include('layouts.messages.alerts')

                            <form method="POST" autocomplete="off" action="{{ route('cambiar-rol.show') }}">
                                @csrf

                                {{-- Se muestran todas las personas con un usuario en el sistema --}}
                                <select class="form-control mb-3" id="personas" name="persona" size="15">
                                    @foreach($personas as $persona)
                                        {{-- Se le da el siguiente formato: 'XXX - YYY YYY' donde X
                                            representa la cédula y Y representa el nombre completo de la persona.
                                            El nombre se despliega en mayúsculas. --}}
                                        <option>{{ $persona->persona_id." - ".strtoupper(iconv( 'UTF-8', 'ASCII//TRANSLIT', $persona->apellido))." ".strtoupper(iconv( 'UTF-8', 'ASCII//TRANSLIT', $persona->nombre)) }}</option>
                                    @endforeach
                                </select>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-rojo">
                                            {{ __('Seleccionar persona') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script src="{{ asset('js/login/Tooltip.js') }}" defer></script>
    <script src="{{ asset('js/global/mensajes.js') }}" defer></script>

</body>
</html>
