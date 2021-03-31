@extends('layouts.app')

@section('titulo')
Reportes y estadísticas
@endsection

@section('css')
{{-- No hay --}}
@endsection


@section('contenido')



{{-- Arreglos de opciones de los select utilizados --}}
@php






@endphp

{{-- Formulario general de actualización de datos de actividad --}}
{{-- Metodo invocado para realizar la modificacion correctamente del estudiante --}}
@method('PATCH')
{{-- Seguridad de envío de datos --}}
@csrf

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Reportes y estadísticas</span>
            </div>
        </div>
        <hr>
        {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
        @if(Session::has('mensaje'))
        <div class="alert alert-success text-center font-weight-bold" role="alert" id="mensaje_exito">
            {!! \Session::get('mensaje') !!}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger text-center font-weight-bold" role="alert">
            {{ "¡Oops! Algo ocurrió mal"  }}
        </div>
        @endif
        {{-- Barra de navegación entre información genereal y bloques de texto  --}}
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#contact">Contact</a>
            </li>
        </ul>

        <div class="container-fluid">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="home">
                    <div class="alert alert-info">Home</div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="contact">
                    <div class="alert alert-info">Contact</div>
                </div>
            </div>
        </div>



        {{--Grafico --}}
        Grafico
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    </div>
</div>


@endsection


@section('scripts')
<script>
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<script src="{{ asset('js/reportes/reportes.js') }}" defer></script>


{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>

<script>
    $("input[type='number']").inputSpinner();

</script>


@endsection



@section('pie')
Copyright
@endsection
