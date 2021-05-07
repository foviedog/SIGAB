{{-- Menú lateral --}}

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

                @if (Accesos::ACCESO_LISTAR_ESTUDIANTES())
                    <li>
                        <a href="{{ route('listado-estudiantil' ) }}">Estudiantes</a>
                    </li>
                @endif

                @if (Accesos::ACCESO_LISTAR_GRADUADOS())
                <li>
                    <a href="{{ route('graduados.listar' ) }}">Estudiantes Graduados</a>
                </li>
                @endif

                @if (Accesos::ACCESO_VISUALIZAR_GUIAS_ACADEMICAS())
                <li>
                    <a href="{{ route('guia-academica.listar' ) }}">Guías académicas</a>
                </li>
                @endif
            </ul>
        </li>

        @if(Accesos::ACCESO_LISTAR_PERSONAL())
        <li>
            <a href="#controlPersonal" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle link-drop-sidebar">
                <i class="far fa-address-book"></i>
                Control del Personal
            </a>
            <ul class="collapse list-unstyled" id="controlPersonal">
                <li>
                    <a href="{{ route('personal.listar' ) }}">Personal de la EBDI</a>
                </li>
            </ul>
        </li>
        @endif

        @if(Accesos::ACCESO_LISTAR_ACTIVIDADES())
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
        @endif

        @if(Accesos::ACCESO_GENERAR_INFORMES_ESTADISTICOS())
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
                    <a href="{{ route('reportes-involucramiento.show' ) }}">Involucramiento general </a>
                </li>
                <li>
                    <a href="{{ route('reportes-involucramiento.anual' ) }}">Involucramiento anual </a>
                </li>
                <li >
                    <a href="{{ route('involucramiento-ciclo.show') }}" > Reporte por ciclo</a>
                </li>
            </ul>
        </li>
        @endif

    </ul>
</nav>
