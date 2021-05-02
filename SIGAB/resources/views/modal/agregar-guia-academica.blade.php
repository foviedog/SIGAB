<div class="modal fade" id="agregar-guia-modal" tabindex="-1" aria-labelledby="agregar-guia-modal" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregar-guia-modal"><strong>Añadir Guía Académica</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="alert alert-danger" role="alert" id="no-existe-estudiante">
                    El estudiante ingresado no existe.
                </div>
                <div class="form-group">
                    <label for="id-estudiante" class="col-form-label">Cédula del estudiante:</label>
                    <input type="text" class="form-control" name="cedula" id="id-estudiante" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gris" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-rojo" id="crear-guia-modal">Crear Guía Académica</button>
            </div>
        </div>
    </div>
</div>