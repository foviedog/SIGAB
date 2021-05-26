@if(!empty($confirmarEliminar))

    @if($confirmarEliminar == 'simple')
    
    <form id="form-eliminar" method="post">
        @method('DELETE')
        @csrf
        
        <div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-eliminarTitle" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro que desea eliminar este elemento?
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-rojo" id="button-submit-eliminar" onclick="activarLoader('Generando datos');"  ><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @elseif($confirmarEliminar == 'personal')

        @if(empty($elementosBorrar[0]) && empty($elementosBorrar[1]) && empty($elementosBorrar[2]))

        <form action={{ route('personal.destroy', \Route::current()->parameter('id_personal')) }} id="form-eliminar" method="post">
        @method('DELETE')
        @csrf
        
            <div class="modal fade" id="modal-confirmacion" tabindex="-1" role="dialog" aria-labelledby="modal-eliminarTitle" aria-hidden="true" >
                <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-check">

                                <input class="form-check-input check-list" type="checkbox" id="checkIdiomas">
                                <label class="form-check-label" for="checkIdiomas">
                                    Estoy de acuerdo en que se eliminarán los idiomas del personal
                                </label>
                                <br>
                                <input class="form-check-input check-list" type="checkbox" id="checkParticipaciones">
                                <label class="form-check-label" for="checkParticipaciones">
                                    Estoy de acuerdo en que se eliminarán las participaciones del personal
                                </label>
                                <br>
                                <input class="form-check-input check-list" type="checkbox" id="checkCargas">
                                <label class="form-check-label" for="checkCargas">
                                    Estoy de acuerdo en que se eliminarán las cargas académicas del personal
                                </label>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                            <button class="btn btn-rojo" id="button-submit-eliminar" disabled onclick="activarLoader('Generando datos');"  ><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        @else

        <div class="modal fade" id="modal-confirmacion" tabindex="-1" role="dialog" aria-labelledby="modal-eliminarTitle" aria-hidden="true" >
            <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Eliminar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        Para poder eliminar el personal por favor cambie los siguientes datos: <br>

                        @if(!empty($elementosBorrar[0])) Es participante en las siguientes listas de asistencia: <br> @endif
                        @foreach ($elementosBorrar[0] as $lista)
                            <a href="{{ $lista->url }}" target="_blank">{{ $lista->tema }}</a> <br>
                        @endforeach

                        @if(!empty($elementosBorrar[1])) Es coordinador de las siguientes actividades: <br> @endif
                        @foreach ($elementosBorrar[1] as $coordinacion)
                            <a href="{{ $coordinacion->url }}" target="_blank">{{ $coordinacion->tema }}</a> <br>
                        @endforeach

                        @if(!empty($elementosBorrar[2])) Es facilitador de las siguientes actividades: <br> @endif
                        @foreach ($elementosBorrar[2] as $facilitador)
                            <a href="{{ $facilitador->url }}" target="_blank">{{ $facilitador->tema }}</a> <br>
                        @endforeach

                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-rojo disabled" id="button-submit-eliminar" onclick="activarLoader('Generando datos');"  ><i class="fas fa-times-circle"></i>&nbsp; Eliminar</a>
                    </div>
                </div>
            </div>
        </div>

    @endif

    @elseif($confirmarEliminar == 'estudiante')

        <form action={{ route('estudiante.destroy', \Route::current()->parameter('id_estudiante')) }} id="form-eliminar" method="post">
            @method('DELETE')
            @csrf
            
                <div class="modal fade" id="modal-confirmacion" tabindex="-1" role="dialog" aria-labelledby="modal-eliminarTitle" aria-hidden="true" >
                    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Eliminar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
    
                                <div class="form-check">
    
                                    <input class="form-check-input check-list" type="checkbox" id="checkTrabajos">
                                    <label class="form-check-label" for="checkTrabajos">
                                        Estoy de acuerdo en que se eliminará la información laboral del estudiante
                                    </label>
                                    <br>
                                    <input class="form-check-input check-list" type="checkbox" id="checkTitulaciones">
                                    <label class="form-check-label" for="checkTitulaciones">
                                        Estoy de acuerdo en que se eliminarán las titulaciones del estudiante
                                    </label>
                                    <br>
                                    <input class="form-check-input check-list" type="checkbox" id="checkGuias">
                                    <label class="form-check-label" for="checkGuias">
                                        Estoy de acuerdo en que se eliminarán las guías académicas del estudiante
                                    </label>
                                    <br>
                                    <input class="form-check-input check-list" type="checkbox" id="checkListas">
                                    <label class="form-check-label" for="checkListas">
                                        Estoy de acuerdo en que se eliminará al estudiante de las listas de asistencia donde aparezca
                                    </label>
                                </div>
    
                            </div>
                            <div class="modal-footer">
                                <button type="button"  class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                                <button class="btn btn-rojo" id="button-submit-eliminar" disabled><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
    
            </form>

    @elseif($confirmarEliminar == 'Actividades_internas')

        <form action={{ route('actividad-interna.destroy', \Route::current()->parameter('id_actividad')) }} id="form-eliminar" method="post">
        @method('DELETE')
        @csrf
        
            <div class="modal fade" id="modal-confirmacion" tabindex="-1" role="dialog" aria-labelledby="modal-eliminarTitle" aria-hidden="true" >
                <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-check">

                                <input class="form-check-input check-list" type="checkbox" id="checkListasAsistencia">
                                <label class="form-check-label" for="checkListasAsistencia">
                                    Estoy de acuerdo en que se eliminarán las listas de asistencia de la actividad
                                </label>
                                <br>
                                <input class="form-check-input check-list" type="checkbox" id="checkEvidencias">
                                <label class="form-check-label" for="checkEvidencias">
                                    Estoy de acuerdo en que se eliminarán las evidencias de la actividad
                                </label>
                                <br>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                            <button class="btn btn-rojo" id="button-submit-eliminar" disabled onclick="activarLoader('Generando datos');"  ><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    @elseif($confirmarEliminar == 'Actividades_promocion')

        <form action={{ route('actividad-promocion.destroy', \Route::current()->parameter('id_actividad')) }} id="form-eliminar" method="post">
        @method('DELETE')
        @csrf
        
            <div class="modal fade" id="modal-confirmacion" tabindex="-1" role="dialog" aria-labelledby="modal-eliminarTitle" aria-hidden="true" >
                <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-check">

                                <input class="form-check-input check-list" type="checkbox" id="checkListasAsistencia">
                                <label class="form-check-label" for="checkListasAsistencia">
                                    Estoy de acuerdo en que se eliminarán las listas de asistencia de la actividad
                                </label>
                                <br>
                                <input class="form-check-input check-list" type="checkbox" id="checkEvidencias">
                                <label class="form-check-label" for="checkEvidencias">
                                    Estoy de acuerdo en que se eliminarán las evidencias de la actividad
                                </label>
                                <br>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button"  class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                            <button class="btn btn-rojo" id="button-submit-eliminar" disabled onclick="activarLoader('Generando datos');"  ><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    @endif

@endif