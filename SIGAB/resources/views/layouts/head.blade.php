<nav class="navbar navbar-expand-lg">
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
                    <a class="nav-link dropdown-toggle border-left border-secondary px-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-bell"></i> <span class="numero-notificaciones" id="numero-notificaciones">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" id="espacio-notificaciones">
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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