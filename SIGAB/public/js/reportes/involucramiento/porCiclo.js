
document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

let editarActivido = false;
// ===============================================================================================
//Función encargada de hacer el llamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    eventos();
}


// ===============================================================================================
//Función encargada de hacer llamar los metodos de eventos
// ===============================================================================================
function eventos() {

}

function AparecerMensajeExito() {
    $("#mensaje_exito")
        .fadeTo(3000, 500)
        .slideUp(500, function () {
            $("#mensaje_exito").slideUp(800);
        });
}
