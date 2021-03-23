@extends('layouts.app')

@section('titulo')
Manejo de la documentación
@endsection

@section('css')
<link href="{{ asset('css/manejo-documentacion/carousel.css') }}" rel="stylesheet">
@endsection

@section('contenido')
<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between">
            <h2>Manejo de la documentación</h2>
        </div>
        <hr>
        <div class="card shadow">
            <div class="card-body bg-color">
                

                <div class="card-header">
                    <h4>Categorías</h4>
                </div>
                

                <div class="my-3 text-center container">

                    <div class="row d-flex align-items-center">
                        <div class="col-1 d-flex align-items-center justify-content-center">
                            <!--Botón derecho-->
                            <a href="#categorias" role="button" data-slide="prev">
                                <div class="carousel-nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="m88.6,121.3c0.8,0.8 1.8,1.2 2.9,1.2s2.1-0.4 2.9-1.2c1.6-1.6 1.6-4.2 0-5.8l-51-51 51-51c1.6-1.6 1.6-4.2 0-5.8s-4.2-1.6-5.8,0l-54,53.9c-1.6,1.6-1.6,4.2 0,5.8l54,53.9z"/>
                                </svg>
                                </div>
                            </a>
                        </div>

                        <div class="col-9">
                            <!--Carousel de Categorías-->
                            <div id="categorias" class="carousel slide" data-ride="carousel" data-interval="false">
                                <div class="carousel-inner d-flex align-items-center">

                                    @foreach($categorias->chunk(4) as $categoria)
                                        <div class="carousel-item @if ($loop->first) active @endif">
                                            <div class="row">
                                                <span class="col-cm"></span>
                                                    @foreach($categoria as $cat)
                                                    <div class="categoria-contenedor col d-flex align-items-center inactivo-cat" id="cat{{ $cat->id }}" onclick="cargarSubCategoria({{ $cat->id }},'{{ $cat->nombre }}')">
                                                        <div class="icono">
                                                            <i class="fas fa-tag fa-2x texto-azul-una ml-1"></i>
                                                        </div>
                                                        <span class="texto">{{ $cat->nombre }}</span>
                                                    </div>
                                                    @endforeach
                                                <span class="col-cm"></span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <!--Fin del carousel-->
                            
                        </div>

                        <!--Botón izquierdo-->
                        <div class="col-1 d-flex align-items-center justify-content-center">
                            <a  href="#categorias" data-slide="next">
                                <div class="carousel-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"/>
                                    </svg>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card-header">
                            <h4>Carpetas asociadas a <span id="cat-titlulo"></span></h4>
                        </div>
                        <div class="card-body" id="subcategorias"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card-header" id="documentos-titulo"></div>
                        <div class="card-body" id="documentos"></div>
                    </div>
                </div>

            </div>
        </div>


    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('js/manejo_documentacion/index.js') }}" defer></script>
<script>
    let nom = '{{ $categorias->first()->nombre }}';
</script>
@endsection

@section('pie')
Copyright
@endsection