document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

let editarActivido = false;

// ===============================================================================================
//Función encargada de hacer el llamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    ocultarElementos();
    eventos();
}

function ocultarElementos() {
    $("#mensaje-alerta").hide();
    $("#campo-buscar").removeClass("d-flex");
    $("#campo-buscar").hide();
    $("#info-responsable").removeClass("border-top");
    $("#card-footer").hide();
    $("#cancelar-edi").hide();
    $("#agregar-participante-card").hide();
    $("#loader").hide();
    $("#mensaje-info").removeClass("d-flex");
    $("#mensaje-info").hide();
    ocultarParticipanteInfo();
}

// =================================================================
//Función encargada de hacer llamar los metodos de eventos
// =================================================================
function eventos() {
    evtAgregarParticipante();
    evtAgregarParticipanteShow();
    evtCancelarAgregarPart();
    evtBuscarParticipante();
    mostrarMensaje();
    evtListarTodo();
}

// ******************************************
//   Declaración de eventos
// ******************************************











function llenarModalParticipante(participante) {
    let src = fotosURL + "/" + participante.imagen_perfil;
    $("#imagen-perfil-modal").css("background-image", "url(" + src + ")");

    $("#id-info").html(participante.persona_id);
    $("#nombre-info").html(participante.nombre + " " + participante.apellido);
    $("#correo-info").html(participante.correo_institucional);
    $("#correo-personal-info").html(participante.correo_personal);
    $("#telefono-info").html(participante.telefono_fijo);
    $("#celular-info").html(participante.telefono_celular);
    $("#estado-civil-info").html(participante.estado_civil);

    if (!participante.correo_institucional)
        $("#correo-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    if (!participante.telefono_celular)
        $("#celular-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    if (!participante.correo_personal)
        $("#correo-personal-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    if (!participante.telefono_fijo)
        $("#telefono-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    if (!participante.estado_civil)
        $("#estado-civil-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
}


function evtListarTodo() {
    $("#btn-listar-todo").on("click", function(e) {
        $("#mensaje").val("");
        $("#form-reload").trigger("submit");
    });
}

// =================================================================
//Función encargada de enviar los datos del participante a agregar
// =================================================================
function evtAgregarParticipante() {
    $("#agregar-submit").on("click", function(e) {
        if ($("#participante-encontrado").val() === "") {
            errorNoEncontrado();
        } else {
            let participante = {
                participante_id: $("#participante-encontrado").val(),
                actividad_id: $("#actividad-id").val()
            };

            $.ajax({
                method: "POST",
                url: "/lista-asistencia",
                dataType: "json",
                data: {
                    participante_id: $("#participante-encontrado").val(),
                    actividad_id: $("#actividad-id").val()
                },
                beforeSend: function() {
                    $("#loader").show();
                    $("#cancelar-agregar-part").trigger("click");
                },
                success: function(datos) {
                    $("#mensaje").val("success");
                    $("#form-reload").trigger("submit");
                },
                statusCode: {
                    404: function() {
                        $("#loader").hide();
                        $("#mensaje").val("error");
                        $("#form-reload").trigger("submit");
                    }
                }
            });
        }
    });
}