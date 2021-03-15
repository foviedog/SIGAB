@extends('layouts.app')

@section('titulo')
Registrar actividad de promocion
@endsection

@section('css')
<style>
    input[type=time]::-webkit-datetime-edit-ampm-field {
        display: none;
    }

</style>
@endsection



@section('contenido')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h3>Registrar una actividad de promocion de la carrera</h3>
            <div>
                <a href="{{ route('actividad-promocion.listado' ) }}" class="btn btn-contorno-rojo"><i class="fas fa-chevron-left "></i> &nbsp; Listado de actividades </a>
            </div>
        </div>
        <hr>
        {{-- Formulario para registrar informacion de la actividad --}}
        <form action="/actividad-promocion" method="POST" enctype="multipart/form-data" id="actividad-promocion">
            @csrf


            {{-- Mensaje de exito (solo se muestra si ha sido exitoso el registro) --}}
            @if(Session::has('mensaje'))
            <div class="alert alert-success" role="alert">
                {!! \Session::get('mensaje') !!}
            </div>
            @endif

            {{-- Mensaje de error (solo se muestra si ha sido ocurrio algun error en la insercion) --}}
            @php
            $error = Session::get('error');
            @endphp

            @if(Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ "¡Oops! Algo ocurrió. ".$error }}
            </div>
            @endif

            {{-- Mensaje de que muestra el objeto insertado
                    (solo se muestra si ha sido exitoso el registro)  --}}
            @if(Session::has('actividad_promocion_insertada'))
            <div class="alert alert-dark" role="alert">

                @php
                //Se obtiene la actividad
                $actividad_insertada = Session::get('actividad_insertada');
                //Se obtiene actividad promocion
                $actividad_promocion_insertada = Session::get('actividad_promocion_insertada');
                @endphp
                {{-- //Datos ingresados de la actividad a mostrar en el mensaje de exito --}}
                Se registró la actividad de promocion de la carrera con lo siguientes datos: <br> <br>
                <div class="row">
                    <div class="col-6 text-justify">
                        <b>ID de actividad: </b> {{$actividad_insertada->id}} <br>
                        <b>Tema: </b> {{$actividad_insertada->tema}} <br>
                        <b>Lugar: </b> {{$actividad_insertada->lugar ?? "No se digitó"}} <br>
                        <b>Estado: </b> {{$actividad_insertada->estado}} <br>
                        <b>Fecha de inicio actividad: </b> {{$actividad_insertada->fecha_inicio_actividad}} <br>
                        <b>Fecha de cierre actividad: </b> {{$actividad_insertada->fecha_final_actividad}} <br>
                        <b>Descripción: </b> {{$actividad_insertada->descripcion ?? "No se digitó"}} <br>
                        <b>Evaluación: </b> {{$actividad_insertada->evaluacion ?? "No se digitó"}} <br>
                        <b>Objetivos: </b> {{$actividad_insertada->objetivos ?? "No se digitó" }} <br>
                        <b>Responsable de coordinar: </b> {{$actividad_insertada->responsable_coordinar}} <br>

                        {{-- Link directo al detalle de la actividad recien agregada --}}
                        <br>
                        <a clas="btn btn-rojo" href="{{ route('actividad-promocion.show',$actividad_insertada->id) }}">
                            <input type="button" value="Editar" class="btn btn-rojo">
                        </a>
                        <br>
                    </div>

                    <div class="col-6 text-justify">
                        <b>Tipo de actividad: </b> {{$actividad_promocion_insertada->tipo_actividad}} <br>
                        <b>Instituciones Patrocinadoras: </b> {{$actividad_promocion_insertada->instituciones_patrocinadoras ?? "No se digitó"}} <br>
                        <b>Recursos: </b> {{$actividad_promocion_insertada->recursos ?? "No se digitó"}} <br>
                    </div>
                </div>
            </div>

            <div class="h3 mb-5 mt-4 mx-3">Agregar una nueva actividad de promocion de la carrera:</div>

            @endif

            <div class="container-fluid w-100">
                <div class="py-3 my-4 border-bottom">
                    <div class="row">
                        {{-- Campos de la izquierda --}}
                        <div class="col">
                            {{-- Campo: Tema --}}
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-75">
                                    <div class="d-flex justify-content-between w-100">
                                        <div>
                                            <label for="tema">Tema <i class="text-danger">*</i></label>
                                            <span data-toggle="tooltip" data-placement="right" title="Tema o nombre de la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                        <span class="text-muted " id="mostrar_tema"></span>
                                    </div>
                                    <div class="d-flex">
                                        <input type='text' class="form-control w-100" id="tema" name="tema" onkeyup="contarCaracteres(this,100)" required>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            {{-- Campo: Lugar --}}
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-75">
                                    <div class="d-flex justify-content-between w-100">

                                        <div>
                                            <label for="lugar">Lugar </label>
                                            <span data-toggle="tooltip" data-placement="right" title="Lugar a realizar la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                        {{-- espacio donde se muestran los caracteres restantes  --}}
                                        <span class="text-muted" id="mostrar_lugar"></span>
                                    </div>
                                    <div class="d-flex">
                                        <input type='text' class="form-control w-100" id="lugar" name="lugar" onkeyup="contarCaracteres(this,60)">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Campo: Tipo de Actividad  --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-75">
                                    <div class="d-flex justify-content-between w-75">
                                        <label for="tipo_actividad">Tipo de actividad<i class="text-danger">*</i></label>
                                    </div>
                                    <div class="d-flex">
                                        <select class="form-control w-100" id="tipo_actividad" name="tipo_actividad" required>
                                            <option value="">Seleccione</option>
                                            <option value="Curso">Curso</option>
                                            <option value="Conferencia">Conferencia</option>
                                            <option value="Taller">Taller</option>
                                            <option value="Seminario">Seminario</option>
                                            <option value="Conversatorio">Conversatorio</option>
                                            <option value="Órgano colegiado">Órgano colegiado</option>
                                            <option value="Tutorías">Tutorías</option>
                                            <option value="Lectorías">Lectorías</option>
                                            <option value="Simposio">Simposio</option>
                                            <option value="Charla">Charla</option>
                                            <option value="Actividad cocurricular">Actividad co curricular</option>
                                            <option value="Tribunales de prueba de grado">Tribunales de prueba de grado</option>
                                            <option value="Tribunales de defensas públicas">Tribunales de defensas públicas</option>
                                            <option value="Comisiones de trabajo">Comisiones de trabajo</option>
                                            <option value="Externa">Externa</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            {{-- Campo: Fecha de actividad--}}
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-75">
                                    <div class="d-flex justify-content-between w-100">
                                        <div>
                                            <label for="fecha_actividad">Fecha de inicio<i class="text-danger">*</i>
                                            </label>
                                            <span data-toggle="tooltip" data-placement="right" title="Se selecciona la fecha de inicio de actividad, también se puede escribir siguiendo el formato determinado" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <input type='date' class="form-control w-100" id="fecha_inicio_actividad" name="fecha_inicio_actividad" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Campo: Fecha de actividad--}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-75">
                                    <div class="d-flex justify-content-between w-100">
                                        <div>
                                            <label for="fecha_actividad">Fecha final<i class="text-danger">*</i>
                                            </label>
                                            <span data-toggle="tooltip" data-placement="right" title="Se selecciona la fecha a finalizar la actividad, también se puede escribir siguiendo el formato determinado" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>

                                    </div>
                                    <div class="d-flex">
                                        <input type='date' class="form-control w-100" id="fecha_final_actividad" name="fecha_final_actividad" required>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Campo: Duracion --}}
                        <div class="col">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-75">
                                    <div class="d-flex justify-content-between w-100">
                                        <div>
                                            <label for="duracion">Duración Total</label>
                                            <span data-toggle="tooltip" data-placement="right" title="Se ingresa el número de horas totales de la duración de la actividad" class="mx-2"> <i class="far fa-question-circle fa-lg"></i></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-center">
                                        <div class="col d-flex justify-content-center">
                                            <div class="w-50  d-flex ">
                                                <input type="number" value="0" min="0" step="1" name="duracion" id="duracion" />
                                                <span class="d-flex align-items-center ml-2 font-weight-bold"> h</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    {{-- Campo: Proposito  --}}
                    <div class="row">


                        {{-- Campo: Poblacion a la que va dirigida la actividad   --}}


                    </div>
                    {{-- Campo: Estado de actividad  --}}
                    <div class="row d-felx justify-content-center">


                        
                        <div class="col-4">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="w-75">
                                    <div class="d-flex justify-content-between w-75">
                                        <label for="estado">Estado <i class="text-danger">*</i></label>
                                    </div>
                                    <div class="d-flex">
                                        <select class="form-control w-100" id="estado" name="estado" required>
                                            <option value="">Seleccione</option>
                                            <option value="Para ejecución">Para ejecución</option>
                                            <option value="En progreso">En progreso</option>
                                            <option value="Ejecutada">Ejecutada</option>
                                            <option value="Cancelada">Cancelada</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>            
                    </div>

                </div>
                <div class="row">
                    {{-- Campo: Objetivos --}}
                    <div class="col">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="w-100">
                                <div class="d-flex justify-content-between w-75">
                                    <div>
                                        <label for="objetivos">Objetivos</label>
                                        <span data-toggle="tooltip" data-placement="right" title="Se describen los objetivos de la actividad"> <i class="far fa-question-circle fa-lg"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <textarea type='text' class="form-control w-100" id="objetivos" name="objetivos" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Campo: Agenda --}}


                </div>

                <div class="row">
                    {{-- Campo: Descripción --}}
                    <div class="col">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="w-100">
                                <div class="d-flex justify-content-between w-75">
                                    <div>
                                        <label for="descripcion">Descripción </label>
                                        <span data-toggle="tooltip" data-placement="right" title="Descripción y detalles de la actividad"> <i class="far fa-question-circle fa-lg"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <textarea type='text' class="form-control w-100" id="descripcion" name="descripcion" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Campo: Evaluacion --}}
                    <div class="col">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="w-100">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <label for="evaluacion">Evaluación</label>
                                        <span data-toggle="tooltip" data-placement="right" title="Se ingresa una evaluación o comentario sobre la actividad"> <i class="far fa-question-circle fa-lg"></i></span>
                                    </div>
                                    <div>
                                        <span class="text-muted" id="mostrar_evaluacion"></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <textarea type='text' class="form-control w-100" id="evaluacion" name="evaluacion" rows="4" onkeyup="contarCaracteres(this,500)"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Campo: Recursos --}}
                    <div class="col">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="w-100">
                                <div class="d-flex justify-content-between w-75">
                                    <div>
                                        <label for="recursos">Recursos </label>
                                        <span data-toggle="tooltip" data-placement="right" title="Recursos necesarios para desarrollar la actividad "> <i class="far fa-question-circle fa-lg"></i></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <textarea type='text' class="form-control w-100" id="recursos" name="recursos" rows="4" onkeyup="contarCaracteres(this,200)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Campo: Instituciones patrocinadoras --}}
                    <div class="col">
                        <div class="d-flex justify-content-center mb-3">
                            <div class="w-100">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <label for="instituciones_patrocinadoras">Instituciones patrocinadoras</label>
                                        <span data-toggle="tooltip" data-placement="right" title="Se ingresa el nombre de las instituciones o entidades patrocinadoras de la actividad si existen"> <i class="far fa-question-circle fa-lg"></i></span>
                                    </div>
                                    <div>
                                        <span class="text-muted" id="mostrar_instituciones_patrocinadoras"></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <textarea type='text' class="form-control w-100" id="instituciones_patrocinadoras" name="instituciones_patrocinadoras" rows="4" onkeyup="contarCaracteres(this,200)"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center my-4">
                    {{-- Campo: Responsable de coordinar --}}
                    <div class="col-3 d-flex justify-content-end">
                        <label for="responsable_coordinar">
                            Responsable de coordinar<i class="text-danger">*</i>
                        </label>
                    </div>

                    <div class="col-6 ">
                        <div class="input-group w-50">
                            <input type='text' id="cedula-responsable" name="responsable_coordinar" class="form-control " required>
                            <div class="input-group-append">
                                <button type="button" id="buscar" class="btn btn-contorno-rojo">Buscar</button>
                                <span data-toggle="tooltip" data-placement="right" title="Ingrese sin espacio y sin guiones el número de cédula del responsable de coordinar la actividad y presione buscar" class="ml-2"> <i class="far fa-question-circle fa-lg mr-2"></i></span>
                            </div>
                        </div>
                    </div>
                    <input class="form-control" type='hidden' id="responsable-encontrado" name="responsable-encontrado" value="false">
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="alert alert-danger w-50 text-center" role="alert" id="mensaje-alerta"></div>
                </div>

                <div class="row justify-content-center pb-3" id="targeta-responsable">
                    <div class="p-3 w-50 d-flex border-top border-secondary  justify-content-center">
                        <div class="col-3">
                            <div class="d-flex justify-content-center mb-2">
                                <div class="overflow-hidden rounded " style="max-width: 160px; max-height: 160px; ">
                                    <img class="rounded mb-3" id="imagen-responsable" style="max-width: 100%;  " />
                                </div>
                            </div>
                        </div>
                        <div class="col-5  d-flex justify-content-start align-items-center ">
                            <div class="d-flex justify-content-start align-items-center ">
                                <div class="text-start mb-3">
                                    <strong>Persona id:</strong> &nbsp;&nbsp;<span id="cedula-responsable-card"> </span> <br>
                                    <strong>Nombre: </strong>&nbsp;&nbsp; <span id="nombre-responsable"> </span> <br>
                                    <strong>Correo institucional: </strong> &nbsp;&nbsp;<span id="correo-responsable"> </span> <br>
                                    <strong>Número de teléfono: </strong> &nbsp;&nbsp;<span id="num-telefono-responsable"></span> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    {{-- Boton para agregar informacion de la actividad --}}
                    <button type="submit" class="btn btn-rojo btn-lg" id="agregar-actividad">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>



</div>
</div>

@endsection

@section('scripts')
<script>
    // "global" vars, built using blade
    var fotosURL = "{{ URL::asset('img/fotos/') }}";

</script>
{{-- Link al script de registro de actividades promocion --}}
<script src="{{ asset('js/global/contarCaracteres.js') }}" defer></script>
<script src="{{ asset('js/control_actividades_internas/registrar.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>

<script>
    $("input[type='number']").inputSpinner();

</script>

@endsection

@section('pie')
Copyright
@endsection
