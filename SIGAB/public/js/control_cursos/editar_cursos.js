document.addEventListener("DOMContentLoaded", cargaInicial);//Se agrega el evento carga inicial al momento de cargar el documento
// ===============================================================================================
//Función encargada de hacer elllamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    habilitarEdicion();
    cancelarEdicion();
}

// =======================================================================
// Evento que habilita el botón si se está de acuerdo con las condiciones
// =======================================================================
function habilitarEdicion() {
    $('#editar').on('click', function () {
        $("input").removeAttr("disabled");
        $('#editar').hide()
        $('#cancelar-edit').show()
    });
}

// =================================================================
// Función que se encarga de ocultar elementos al cargar la página
// =================================================================
function cancelarEdicion() {
    $('#cancelar-edit').on('click', function () {
        location.reload(); // Recarga la página inicial para eliminar todos los cambios hechos y volver a bloquer todos los cambios
    });
}



