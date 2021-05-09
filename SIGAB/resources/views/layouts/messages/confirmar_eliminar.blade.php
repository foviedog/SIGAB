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

    @endif


@endif