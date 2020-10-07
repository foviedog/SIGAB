@extends('layouts.app')

@section('titulo')
Registrar Actividad Interna
@endsection

@section('css')

@endsection

@section('scripts')
{{-- Link al script de registro de actividades internas --}}
<script src="{{ asset('js/control_actividades_internas/informacion_actividad/registrar.js') }}" defer></script>
@endsection

@section('contenido')

<div class="card">
    <div class="card-body">
        <h2>Registrar una actividad de tipo interna</h2>
        <hr>
        {{-- Formulario para registrar informacion del estudiante --}}
        <form action="/actividad-interna" method="POST" enctype="multipart/form-data" id="actividad-interna">
            @csrf
            <div class="row">
                {{-- Campos de la izquierda --}}
                <div class="col">
                    {{-- Campo: Tema --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tema">Tema <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="tema" name="tema" required>
                        </div>
                    </div>

                    {{-- Campo: Lugar --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="lugar">Lugar </label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="lugar" name="lugar">
                        </div>
                    </div>

                    {{-- Campo: Fecha de actividad--}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="fecha_actividad">Fecha de actividad <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='date' value="2020-08-15" class="form-control w-100" id="fecha_actividad" name="fecha_actividad" required>
                        </div>
                    </div>

                    {{-- Campo: Estado --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="estado">Estado <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="estado" name="estado" required>
                                <option value="Para ejecución">Para ejecución</option>
                                <option value="En progreso">En progreso</option>
                                <option value="Ejecutada">Ejecutada</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Descripción --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="descripcion">Descripción <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <textarea type='text' class="form-control w-100" id="descripcion" name="descripcion" required></textarea>
                        </div>
                    </div>

                    {{-- Campo: Objetivos --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="objetivos">Objetivos</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="objetivos" name="objetivos">
                        </div>
                    </div>

                    {{-- Campo: Responsable de coordinar --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="responsable_coordinar">Responsable de coordinar<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="responsable_coordinar" name="responsable_coordinar" required>
                        </div>
                    </div>

                    {{-- Campo: Evaluacion --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="evaluacion">Evaluación</label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="evaluacion" name="evaluacion">
                        </div>
                    </div>
                </div>

                {{-- Campos de la derecha --}}
                <div class="col">
                    {{-- Campo: Proposito--}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="proposito">Propósito <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="proposito" name="proposito" required>
                                <option value="Inducción">Inducción</option>
                                <option value="Capacitación">Capacitación</option>
                                <option value="Actualización">Actualización</option>
                                <option value="involucramiento del personal">Involucramiento del personal</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Tipo de publico al que se dirige --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="publico_dirigido">Dirigido a <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="publico_dirigido" name="publico_dirigido" required>
                                <option value="Estudiantes">Estudiantes</option>
                                <option value="Graduados">Graduados</option>
                                <option value="Académicos">Académicos</option>
                                <option value="Docentes">Docentes</option>
                                <option value="Personal Administrativo">Personal Administrativo</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campo: Facilitador de actividad --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="facilitador_actividad">Facilitador de actividad </label>
                        </div>
                        <div class="col-6">
                            <input type='text' class="form-control w-100" id="facilitador_actividad" name="facilitador_actividad">
                        </div>
                    </div>

                    {{-- Campo: Agenda --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="agenda">Agenda </label>
                        </div>
                        <div class="col-6">
                            <textarea class="form-control w-100" id="agenda" name="agenda"></textarea>
                        </div>
                    </div>

                    {{-- Campo: Duracion --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="duracion">Duración </label>
                        </div>
                        <div class="col-6">
                            <input type='number' min="0" class="form-control w-100" id="duracion" name="duracion">
                        </div>
                    </div>
                    {{-- Campo: Tipo de actividad --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="tipo_actividad">Tipo de actividad <i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="tipo_actividad" name="tipo_actividad" required>
                                <option value="0">Curso</option>
                                <option value="1">Conferencia</option>
                                <option value="2">Taller</option>
                                <option value="3">Seminario</option>
                                <option value="4">Conversatorio</option>
                                <option value="5">Órgano colegiado</option>
                                <option value="6">Tutorías</option>
                                <option value="7">Lectorías</option>
                                <option value="8">Tribunales de prueba de grado</option>
                                <option value="9">Tribunales de defensas públicas</option>
                                <option value="10">Comisiones de trabajo</option>
                                <option value="11">Externa</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Ambito --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="ambito">Ámbito<i class="text-danger">*</i></label>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" id="ambito" name="ambito" required>
                                <option value="Nacional">Nacional</option>
                                <option value="Internacional">Internacional</option>
                            </select>
                        </div>
                    </div>
                    {{-- Campo: Certificacion --}}
                    <div class="d-flex justify-content-start mb-3">
                        <div class="col-4">
                            <label for="certificacion">Certificación</label>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input " type="radio" name="certificacion" id="certificacion1" value="0">
                                <label class="form-check-label pr-5" for="certificacion1"> No </label>
                                <input class="form-check-input" type="radio" name="certificacion" id="certificacion2" value="1">
                                <label class="form-check-label" for="certificacion2"> Sí </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-center">
                {{-- Boton para agregar informacion de la actividad --}}
                <input type="submit" value="Agregar" class="btn btn-rojo btn-lg">
            </div>

        </form>
    </div>
</div>

@endsection

@section('pie')
Copyright
@endsection
