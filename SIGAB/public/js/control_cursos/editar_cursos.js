//Se agrega el evento carga inicial al momento de cargar el documento
document.addEventListener("DOMContentLoaded", cargaInicial);
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
        $("#nombre").removeAttr("disabled");
        $("#nrc").removeAttr("disabled");
        $('#editar').hide()//Oculta el botón de editar
        $('#cancelar-edit').show()//Muestra el botón de cancelar
        $('#guardar-btn').show()//Muestra el botón de cancelar
    });
}

// =================================================================
// Función que se encarga de ocultar elementos al cargar la página
// =================================================================
function cancelarEdicion() {
    $('#cancelar-edit').on('click', function () {
        // Recarga la página inicial para eliminar todos los cambios hechos y
        // volver a bloquear todos los cambios
        location.reload();
    });
}



