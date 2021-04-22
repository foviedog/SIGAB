<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <title>@yield('titulo')</title>

    <!-- Hojas de estilo individuales -->
    @yield('css')

    <!-- Hojas de estilo globales -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/global.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plantilla/layout.css') }}" rel="stylesheet">

    <!-- Scripts globales -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</head>

<body>
    <div class="loader-full-page" id="loader-full" style="display: none;">
        <div class="loader-wrapper d-flex justify-content-center align-items-center">
            <div class="loader-container ">
                <div class="loader-text" id="loader-text">
                    Texto
                </div>
                <div class="loader1"></div>
                <div class="loader2"> </div>
            </div>
        </div>
    </div>
    <div class="wrapper bg-gris-claro">
        <!-- Sidebar  -->
        <nav id="sidebar" class="bg-rojo-oscuro">
            <div class="sidebar-header bg-rojo-oscuro">
                <a href="{{ route('home') }}" class="d-flex justify-content-center">
                    <img src="{{ asset('img/login/logo_EBDI_Blanco.png') }}" alt="SIGAB" class="logo">
                </a>


            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="#controlEstudiantil" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle link-drop-sidebar">

                        <i class="fas fa-graduation-cap"></i>
                        Control Estudiantil
                    </a>
                    <ul class="collapse list-unstyled" id="controlEstudiantil">

                        {{--
                        <li>
                            <a href="{{ route('estudiante.create' ) }}">Añadir estudiante</a>
                </li>
                --}}
                <li>
                    <a href="{{ route('listado-estudiantil' ) }}">Estudiantes</a>
                </li>
                <li>
                    <a href="{{ route('graduados.listar' ) }}">Estudiantes Graduados</a>
                </li>
                <li>
                    <a href="{{ route('guia-academica.listar' ) }}">Guías académicas</a>
                </li>
            </ul>
            </li>

            <li>
                <a href="#controlPersonal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle link-drop-sidebar">

                    <i class="far fa-address-book"></i>
                    Control de personal
                </a>
                <ul class="collapse list-unstyled" id="controlPersonal">
                    <li>
                        <a href="{{ route('personal.listar' ) }}">Personal de la EBDI</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#controlActividades" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle link-drop-sidebar">

                    <i class="fas fa-chalkboard-teacher"></i>
                    Control Actividades

                </a>
                <ul class="collapse list-unstyled" id="controlActividades">
                    <li>
                        <a href="{{ route('actividad-interna.listado' ) }}">Actividades internas</a>
                    </li>
                    <li>
                        <a href="{{ route('actividad-promocion.listado' ) }}">Actividades de promoción</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#controlReportes" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle link-drop-sidebar">
                    <i class="fas fa-chart-line"></i>
                    Reportes
                </a>
                <ul class="collapse list-unstyled" id="controlReportes">
                    <li>
                        <a href="{{ route('reportes-actividades.show' ) }}">Actividades </a>
                    </li>
                    <li>
                        <a href="{{ route('reportes-involucramiento.show' ) }}">Involucramiento </a>
                    </li>
                </ul>
            </li>
            </ul>

        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-rojo">
                        <i class="fas fa-align-left"></i>
                        <span>Menú</span>
                    </button>

                    <img src="{{ asset('img/login/UNA_horizontal.png') }}" alt="logo_universidad" class="logo-una-horizontal border-left border-secondary mx-3" id="img-UNA">


                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto ">

                            <li class="nav-item active">
                                <span class="texto-SIGAB pr-3" id="letras-SIGAB">SIGAB</span>
                            </li>
                            <li class="nav-item dropdown" style="max-width: 120px;">
                                <a class="nav-link dropdown-toggle border-left border-secondary px-4" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="border rounded-circle mr-2" src="{{ asset('img/fotos/'.Session::get('persona')->imagen_perfil) }}" width="30px" height="30px" />
                                    <span> {{ Auth::user()->persona_id }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('perfil.show', Auth::user()->persona_id) }}">
                                        <i class="fas fa-user"></i> &nbsp; Mi perfil
                                    </a>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-in-alt"></i> &nbsp; Salir
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="">
                <div class="card-body">
                    @yield('contenido')
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
    <script src="{{ asset('js/global/mensajes.js') }}" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/39f4ebbbea.js" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script> --}}
    <script src="{{ asset('js/plantilla/ebdi.js') }}"></script>


</body>

</html>
