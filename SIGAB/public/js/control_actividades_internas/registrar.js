document.addEventListener("DOMContentLoaded", cargaInicial);//Se agrega el evento carga inicial al momento de cargar el documento


// ===============================================================================================
//Función encargada de hacer elllamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
    function cargaInicial(event) {
        ocultarElementos();
        eventos();
    }
function ocultarElementos() {
    $("#mensaje-alerta").hide();
}
function eventos() {
    evtSubmit();

}
function evtSubmit() {
    $("#actividad-interna").on("submit", function (e) {

        if ($("#responsable-encontrado").val() === "false") {
            e.preventDefault();
            $("#cedula-responsable").val("");
            $("#mensaje-alerta").html("Por favor busque un personal que exista");
            $("#mensaje-alerta").fadeTo(2000, 1000).slideUp(1000, function() {
                $("#mensaje-alerta").slideUp(1000);
            });
        }
    });
}

function buscarResponsable() {

    if ($("#cedula-responsable").val() === "") {
        $("#mensaje-alerta").html("Campo vacio");
        $("#informacion-responsable").html("");
        $("#mensaje-alerta")
            .fadeTo(2000, 500)
            .slideUp(500, function() {
                $("#mensaje-alerta").slideUp(500);
            });
    } else {
        $.ajax({
            url: "/personal/obtener/" + $("#cedula-responsable").val(),
            type: "GET",
            success: function(response) {
                $("#responsable-encontrado").val(response.persona_id);
                $("#informacion-responsable").html(
                    "Nombre del responsable: " +
                        response.nombre +
                        " " +
                        response.apellido
                );
            },
            statusCode: {
                404: function () {
                    $("#informacion-responsable").html("");
                    $("#responsable-encontrado").val("false");
                    $("#mensaje-alerta").html("La persona no existe");
                    $("#mensaje-alerta")
                        .fadeTo(2000, 500)
                        .slideUp(500, function() {
                            $("#mensaje-alerta").slideUp(500);
                        });
                }
            }
        });
    }
}
