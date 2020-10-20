document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

// ===============================================================================================
//Función encargada de hacer elllamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    ocultarElementos();
    eventos();
}
function ocultarElementos() {
    $("#mensaje-alerta").hide();
    $("#targeta-responsable").hide();
}
function eventos() {
    evtSubmit();
    evtBuscarResponsable();
}
    function evtSubmit() {
        $("#actividad-interna").on("submit", function(e) {
            if ($("#responsable-encontrado").val() === "false") {
                e.preventDefault();
                $("#cedula-responsable").val("");
                $("#mensaje-alerta").html(
                    "Por favor busque un personal que exista"
                );
                $("#mensaje-alerta")
                    .fadeTo(2000, 1000)
                    .slideUp(1000, function() {
                        $("#mensaje-alerta").slideUp(1000);
                    });
            }
        });
    }

        function evtBuscarResponsable() {
            $("#buscar").on("click", function() {
                if ($("#cedula-responsable").val() === "") {

                    desplegarAlerta("La cédula digitada no existe");
                } else {
                    $("#responsable-encontrado").val("true");
                    $.ajax({
                        url: "/personal/obtener/" + $("#cedula-responsable").val(),
                        type: "GET",
                        success: function(responsable) {
                            llenarTargetaResponsable(responsable);
                        },
                        statusCode: {
                            404: function () {
                                desplegarAlerta("La persona no existe");
                            }
                        }
                    });
                }
            });
        }

        function llenarTargetaResponsable(responsable) {
            $("#targeta-responsable").addClass("d-flex");
            let src = fotosURL + "/" + responsable.imagen_perfil;
            $('#imagen-responsable').attr('src', src);
            $("#nombre-responsable").html(responsable.nombre +" " +responsable.apellido );
            $("#cedula-responsable-card").html(responsable.persona_id);
            $("#correo-responsable").html(responsable.correo_institucional);
            $("#num-telefono-responsable").html(responsable.telefono_fijo);

            $("#targeta-responsable").show("d-flex");
        }


        function desplegarAlerta(contenido) {
            $("#targeta-responsable").removeClass("d-flex");
            $("#targeta-responsable").hide();
            $("#mensaje-alerta").html(contenido);
            $("#mensaje-alerta").fadeTo(2000, 500).slideUp(500, function() {
                    $("#mensaje-alerta").slideUp(500);
                });
            }
