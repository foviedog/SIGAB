@extends('layouts.app')

@section('titulo')
Notificaciones
@endsection

@section('css')
{{-- No hay --}}
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
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Nombre Organizacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($notifiaciones as $notifiacion)
                            <tr>
                                <th>{{ $notifiacion->data['nombre_organizacion'] }}</th>
                            <tr>
                            @endforeach
                        </tbody>
                        </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection
