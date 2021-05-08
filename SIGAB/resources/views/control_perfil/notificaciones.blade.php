@extends('layouts.app')

@section('titulo')
Notificaciones
@endsection

@section('css')
<style>
    .header-collapse{
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
    <div class="row">
        <div class="col">
            <div class="card shadow pb-2">

                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="texto-rojo-medio font-weight-light m-0 texto-rojo">Notificaciones</h3>
                        </div>
                        <div>
                            {{-- Botón para regresar a la vista principal --}}
                            <a href="{{ route('home') }}" class="btn btn-contorno-rojo"><i class="fas fa-home"></i> &nbsp; Página Principal </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    
                    <div class="py-3" style="text-align: center;">
                        <h4>Notificaciones nuevas</h4>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Información</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Ver</th>
                            <th scope="col">Marcar como leído</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- En caso de que no existan registros --}}
                            @if(count($notificacionesNoLeidas) == 0)
                            <tr class="cursor-pointer">
                                <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg">
                                    </i> &nbsp; No existen registros</td>
                            </tr>
                            @endif
                            @foreach($notificacionesNoLeidas as $notifiacion)
                            <tr>
                                <td>{{ $notifiacion->data['mensaje'] }}</td>
                                <td>{{ $notifiacion->created_at }}</td>
                                @if($notifiacion->data['id'])
                                    <td><a href="{{ route('actividad-interna.show', $notifiacion->data['id']) }}">Detalle</a></td>
                                @endif
                                <td>Marcar como leído</td>
                            <tr>
                            @endforeach
                            
                        </tbody>
                    </table>

                    <div class="header-collapse" id="accordion" data-toggle="collapse" data-target="#collapseNotificaciones" aria-expanded="false" aria-controls="collapseNotificaciones">
                        <div class="card">
                            <div class="card-header" id="collapse-notificaciones">
                                <h4 class="mb-0">
                                    Ver notificaciones leídas
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div id="collapseNotificaciones" class="collapse" aria-labelledby="collapse-notificaciones" data-parent="#accordion">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">Información</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Ver</th>
                                    <th scope="col">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- En caso de que no existan registros --}}
                                    @if(count($notificacionesLeidas) == 0)
                                    <tr class="cursor-pointer">
                                        <td colspan="7"> <i class="text-danger fas fa-exclamation-circle fa-lg">
                                            </i> &nbsp; No existen registros</td>
                                    </tr>
                                    @endif
                                    @foreach($notificacionesLeidas as $notifiacion)
                                    <tr>
                                        <td>{{ $notifiacion->data['mensaje'] }}</td>
                                        <td>{{ $notifiacion->created_at }}</td>
                                        @if($notifiacion->data['id'])
                                            <td>{{ $notifiacion->data['id'] }}</td>
                                        @endif
                                        <td>Eliminar</td>
                                    <tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    



                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- Ningún script por el momento --}}
@endsection
