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
                        <button type="submit" class="btn btn-rojo" id="button-submit-eliminar"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    @elseif($confirmarEliminar == 'personal')

        @if(empty($elementosBorrar[0]) && empty($elementosBorrar[1]))
        
        
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-confirmacion">
            Launch demo modal
        </button>

        <form  id="form-eliminar" method="post">
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
                            <button class="btn btn-rojo" id="button-submit-eliminar" disabled><i class="fas fa-times-circle"></i>&nbsp; Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        @else

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-confirmacion">
            Launch demo modal
        </button>

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
                            <a href="{{ $lista->url }}">{{ $lista->tema }}</a> <br>
                        @endforeach

                        @if(!empty($elementosBorrar[1])) Es coordinador de las siguientes actividades: <br> @endif
                        @foreach ($elementosBorrar[1] as $coordinacion)
                            <a href="{{ $coordinacion->url }}">{{ $coordinacion->tema }}</a> <br>
                        @endforeach

                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-rojo disabled" id="button-submit-eliminar"><i class="fas fa-times-circle"></i>&nbsp; Eliminar</a>
                    </div>
                </div>
            </div>
        </div>

        @endif

    @endif


@endif