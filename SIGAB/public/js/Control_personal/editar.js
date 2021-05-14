
    document.addEventListener("DOMContentLoaded", cargaInicial);//Se agrega el evento carga inicial al momento de cargar el documento


// ===============================================================================================
//Función encargada de hacer elllamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
    function cargaInicial(event) {
        ocultarElementos();
        eventosEditar();
    }

// =================================================================
// Función que se encarga de ocultar elementos al cargar la página
// =================================================================
    function ocultarElementos() {
        $("#cancelar-edi").hide();
        $("#guardar-cambios").hide();
        $("#cambiar-foto").hide();
        $("#agregar-btn").hide();
        $(".eliminar-idioma-btn").hide();
    }

// =================================================================
// Función que carga todos los eventos de la página
// =================================================================
    function eventosEditar() {
        evtHabilitarEdicion();
        evtCancelarEdicion();
        evtEliminarIdiomas();
        evtSubmitForm();
    }


// =================================================================
// Función que carga todos los eventos de la página
// =================================================================
    function evtHabilitarEdicion() {
        $("#editar-personal").on("click", function () { //El evento se acciona al hacer clcick en el botón de editar
           // Elimina el atributo de disabled en todos los campos excepto en botones
            $("input").removeAttr("disabled");
            $("select").removeAttr("disabled");
            $("textarea").removeAttr("disabled");
            //Muestra los elementos que se encontraban ocultados en el modo de visualizar
            $("#agregar-btn").show();
            $("#cancelar-edi").show();
            $("#guardar-cambios").show();
            $("#cambiar-foto").show();
            $(".eliminar-idioma-btn").show();
            //Oculta el botón de editar
            $("#editar-personal").hide();

        });
    }
// =======================================================================
// Evento para cancelar la edición de datos
// =======================================================================
    function evtCancelarEdicion() {
        $("#cancelar-edi").on("click", function () {
            location.reload(); // Recarga la página inicial para eliminar todos los cambios hechos y volver a bloquer todos los cambios
        });
    }

// =======================================================================
// Evento al momento de realizar un submit del form de editar personal
// =======================================================================
    function evtSubmitForm() {
        $("#personal-form").on("submit", function () { //La función ocurren en el momento en el que se hace submit
            coleccionIdiomas = obtenerIdiomas(); // Se llama al método para llenar el arreglo de idiomas que se ha digitado
            idiomas = JSON.stringify(coleccionIdiomas); // Se transforma el array de JavaScript a JSON para que sea posible enviar el array en el request
            $("#idiomasJSON").val(idiomas); // Se coloca el valor del JSON dentro de un input de tipo "hiden" que se envía en conjunto con el request.
        });
    }


// =======================================================================
// Evento que habilita el botón si se está de acuerdo con las condiciones
// =======================================================================

    $(function () {
        $('.check-list').on('click', function () {
            if($('#checkIdiomas:checked').length > 0 
                && $('#checkParticipaciones:checked').length > 0 
                && $('#checkCargas:checked').length > 0){
                $("#button-submit-eliminar").prop("disabled", false);
            } else {
                $("#button-submit-eliminar").prop("disabled", true);
            }
        });
    });





