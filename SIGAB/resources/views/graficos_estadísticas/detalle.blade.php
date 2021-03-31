@extends('layouts.app')

@section('titulo')
{{ $actividad->tema }}
@endsection

@section('css')
{{-- No hay --}}
@endsection


@section('contenido')



{{-- Arreglos de opciones de los select utilizados --}}
@php


$tiposActividad = ['Ferias','Participación en congresos nacionales e internacionales','Puertas abiertas',
'Promoción por redes sociales','Visitas a comunidades','Visitas a colegios',
'Envío de paquetes promocionales por correo electrónico','Charlas','Otro'];

$estados = ['Para ejecución','En progreso','Ejecutada','Cancelada'];



@endphp

{{-- Formulario general de actualización de datos de actividad --}}
<form action="{{ route('actividad-promocion.update', $actividad->id) }}" method="POST" role="form" enctype="multipart/form-data" id="actividad-form">
    {{-- Metodo invocado para realizar la modificacion correctamente del estudiante --}}
    @method('PATCH')
    {{-- Seguridad de envío de datos --}}
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                {{-- Título  --}}
                <div class=" d-flex justify-content-start align-items-center">
                    <h3>Reportes y estadísticass</h3>&nbsp;&nbsp;&nbsp; <span class="border-left border-info texto-rojo-oscuro pl-2 p-0 font-weight-bold ">codigo de actividad: {{ $actividad->id }}</span>
                </div>n::has('error'))
                <div class="alert alert-danger text-center font-weight-bold" role="alert">
                    {{ "¡Oops! Algo ocurrió mal"  }}
                </div>
                @endif
                {{-- Barra de navegación entre información genereal y bloques de texto  --}}
                <ul class="nav nav-tabs" id="opciones_tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="info-gen-tab" href="#info-gen">Actividades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="info-esp-tab" href="#">Involucramiento del personal</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="info-gen" role="tabpanel" aria-labelledby="info-gen-tab">
                        <div class="card shadow-sm my-3 rounded pb-2">
                            <div class="card-header py-3">

                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</form>


@endsection


@section('scripts')
<script>
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

</script>
<script src="{{ asset('js/control_educativo/informacion_estudiante/editar.js') }}" defer></script>
<script src="{{ asset('js/control_actividades_promocion/detalle_editar.js') }}" defer></script>
{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>
<script>
    $("input[type='number']").inputSpinner();

</script>
@endsection



@section('pie')
Copyright
@endsection
