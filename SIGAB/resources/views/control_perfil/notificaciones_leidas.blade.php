@extends('layouts.app')

@section('titulo')
Notificaciones
@endsection

@section('css')
<style>
    .header-collapse {
        text-align: center;
        cursor: pointer;
    }

</style>
@endsection

@section('contenido')

<header class="page-header page-header-dark bg-red-polygon py-5 overflow-hidden">
    <div class="container py-3">
    </div>
</header>

<div class="container-fluid " style="margin-top: -4.4rem;">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card shadow pb-2">

                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="texto-rojo-medio font-weight-light m-0 texto-rojo">Notificaciones</h3>
                        </div>
                        <div>
                            {{-- Botón para regresar a la vista principal --}}
                            <a href="{{ route('home') }}" class="btn btn-contorno-rojo"><i class="fas fa-home"></i> &nbsp; Página Principal </a>
                            {{-- Botón para regresar mi perfil --}}
                            <a href="{{ route('perfil.show') }}" class="btn btn-contorno-rojo"><i class="fas fa-user"></i> &nbsp; Mi Perfil </a>
                        </div>
                    </div>
                </div>

                <div class="card-body notificaciones">
                    <ul class="nav nav-tabs mb-5" id="pills-tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link " id="sin-leer-tab" href="{{ route('perfil.notifications') }}" aria-selected="false">Sin leer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" href="{{ route('perfil.notificaciones.leidas') }}" aria-selected="true">Anteriores</a>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between mb-5 mr-5">
                        <div></div>
                        <a href="{{ route('perfil.notifications.deleteall') }}" class="btn btn-contorno-rojo btn-sm mr-2"><i class="fas fa-times-circle"></i> Eliminar todas las notificaciones</a>
                    </div>

                    @if(count($notificacionesLeidas) == 0)
                    <div class="row mt-2 mx-5 border-bottom pb-5 mb-5 d-flex justify-content-center align-items-center">
                        <i class="text-danger fas fa-exclamation-circle fa-lg">
                        </i> &nbsp; No existen registros
                    </div>
                    @endif
                    @foreach ($notificacionesLeidas as $notificacion)
                    <div class="row mt-2 mx-5 border-bottom pb-3 notificacion">
                        <div class="col-2 p-0 imagen-notificacion">
                            <div class="container-image">
                                <img class="imagen-perfil" src="{{ URL::asset('img/fotos/'.$notificacion->data["imagen_perfil"]) }}" alt="">
                            </div>
                            <div class="container-tipo {{ $notificacion->data["color"] }}">
                                {!! $notificacion->data["icono"] !!}
                            </div>
                        </div>
                        <div class="col-8 notificacion-info">
                            <div class="w-100 text-muted">
                                <b class="text-dark">{{ $notificacion->data["nombre"] }}</b> {{ $notificacion->data["informacion"] }}
                            </div>
                            <span class="mt-auto font-italic texto-rojo-medio ">{{ date("d/m/Y - H:i:s", strtotime($notificacion->created_at))  }}</span>
                        </div>
                        <div class="col-1 notificacion-detalle d-flex align-items-start justify-content-center">
                            <div class="btn btn-contorno-rojo">Detalle</div>
                        </div>
                        <div class="col-1">
                            <a href="{{ route('perfil.notifications.delete', $notificacion->id) }}" class="btn btn-contorno-rojo btn-sm"><i class="fas fa-times-circle"></i></a>
                        </div>
                    </div>
                    @endforeach
                    <div class="row justify-content-center mt-5">
                        {{ $notificacionesLeidas->withQueryString()->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection
