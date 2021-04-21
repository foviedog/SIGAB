@extends('layouts.app')

@section('titulo')
Reportes de involucramiento
@endsection


@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection

@section('contenido')

{{-- Arreglos de opciones de los select utilizados --}}
@php
$estados = ["Para ejecución","En progreso","Ejecutada","Cancelada"];
@endphp

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            {{-- Título  --}}
            <div class=" d-flex justify-content-start align-items-center">
                <h3>Reportes y estadísticas de involucramiento del personal</span>
            </div>
        </div>
        <hr>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab">Involucramiento</a>
            </li>
        </ul>

        <div class="container-fluid pb-5">
            <div class="tab-content pb-5">
                <div role="tabpanel" class="tab-pane fade in active show" id="actividades-tab">
                    <div id="cartas-activida" class="row d-flex justify-content-between px-3 mt-4">
                        <div class="card-info">
                            <div class="icon-info">
                                <div class="icon-inner">
                                    <i class="fas fa-chalkboard-teacher fa-3x"></i>
                                </div>
                            </div>
                            <div class="content-info">
                                <div>
                                    <div class="texto-info">Interinos</div>
                                    <div class="numero-info">{{ $datosCuantitativos[0] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="icon-info">
                                <div class="icon-inner">
                                    <i class="fas fa-university fa-3x"></i>
                                </div>
                            </div>
                            <div class="content-info">
                                <div>
                                    <div class="texto-info">Propietarios</div>
                                    <div class="numero-info">{{ $datosCuantitativos[1] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="icon-info">
                                <div class="icon-inner">
                                    <i class="fas fa-briefcase fa-3x"></i>
                                </div>
                            </div>
                            <div class="content-info">
                                <div>
                                    <div class="texto-info">Plazo fijo</div>
                                    <div class="numero-info">{{ $datosCuantitativos[2] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="icon-info">
                                <div class="icon-inner">
                                    <i class="fas fa-calculator fa-3x"></i>
                                </div>
                            </div>
                            <div class="content-info">
                                <div>
                                    <div class="texto-info">Total</div>
                                    <div class="numero-info">{{ $datosCuantitativos[3] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


@section('scripts')

{{-- @if(!is_null($datos)) --}}
<script>
    //Datos que se renderisan en caso de que se haya realizado una búsqueda para generar el gráfico dinámico
    //let dataSet =  {{-- JSON.parse('{!! $datos !!}'); --}}
    let x = [];
    let y = [];
    //let naturalezaActividad = '{{-- $naturalezaAct --}}';

    // Ciclo que recorre cada uno de los resultados de la búsqueda y los coloca en posiciones
    //'X' y 'Y' para que se pueda renderizar el gráfico correspondiente
    var total = 0;
    for (const atributo in dataSet) {
        if (dataSet[atributo] != 0) {
            x.push(atributo);
            y.push(dataSet[atributo]);
            total++;
        }
    }
    // Variable global utilizada para obtener el url de las imágenes con js.
    var fotosURL = "{{ URL::asset('img/fotos/') }}";
    var url = window.location.href;
    window.location.href = url + "#graficoGenerado";*/

</script>
 {{--@else En caso de que sea la primera vez que se cargue la página se setean los atributos en valores prederminados --}}
<script>
    let dataSet = [];
    let naturalezaActividad = "Actividad interna";
    let total = 0;

</script>
{{-- @endif --}}
<script>
    /*let propositosDelAnio = {{-- JSON.parse('{!! $propositosDelAnio !!}'); --}}
    let xPropositos = [];
    let yPropositos = [];
    let totalPropositos = 0;
    for (const proposito in propositosDelAnio) {
        xPropositos.push(proposito); //Se inserta el nombre del pospósito en el eje X ("Para ejecución, en progreso, etc...")
        var cantProp = propositosDelAnio[proposito];
        yPropositos.push(cantProp); //Se inserta en el eje Y la cantidad de actividades con dicho propósito
        totalPropositos += cantProp;
    }
    let estadosDelAnio = {{-- JSON.parse('{!! $estadosDelAnio !!}'); --}}
    let xEstados = [];
    let yEstados = [];
    let totalEstados = 0;
    for (const estado in estadosDelAnio) {
        xEstados.push(estado); //Se inserta el nombre del pospósito en el eje X ("Para ejecución, en progreso, etc...")
        var cantEstados = estadosDelAnio[estado];
        yEstados.push(cantEstados); //Se inserta en el eje Y la cantidad de actividades con dicho propósito
        totalEstados += cantEstados;
    }*/

</script>

<script src="{{ asset('js/reportes/reportes.js') }}" defer></script>
<script src="{{ asset('js/reportes/graficosPredeterminados.js') }}" defer></script>

{{-- 
    
    @if(!is_null($chart))
<script src="{{ asset('js/reportes/'.$chart.'.js') }}" defer></script>
@endif

    --}}



{{-- Scripts para modificar la forma en la que se ven los input de tipo number --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@1.13.5/src/bootstrap-input-spinner.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('js/global/inputs.js') }}"></script>


<script>
   // $("input[type='number']").inputSpinner();

</script>


@endsection



@section('pie')
Copyright
@endsection
