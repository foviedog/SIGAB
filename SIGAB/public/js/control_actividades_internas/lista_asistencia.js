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

function evtCancelarAgregarPart() {
    $("#cancelar-agregar-part").on("click", function() {
        $("#btn-agregar-part").show();
        $("#agregar-participante-card").hide();
        $("participante-encontrado").val("false");
        $("#cedula-participante").val("");
        ocultarParticipanteInfo();
        reducirTamanioInfo();
    });
}

function evtAgregarParticipanteShow() {
    $("#btn-agregar-part").on("click", function(e) {
        $("#btn-agregar-part").hide();
        $("#agregar-submit").hide();
        $("#agregar-participante-card").show();
    });
}
function evtListarTodo() {
    $("#btn-listar-todo").on("click", function(e) {
        $("#mensaje").val("");
        $("#form-reload").trigger("submit");
    });
}

function evtBuscarParticipante() {
    $("#buscar").on("click", function() {
        if ($("#cedula-participante").val() === "") {
            errorNoEncontrado();
        } else {
            $.ajax({
                url:
                    "/lista-asistencia/participante/" +
                    $("#cedula-participante").val(),
                dataType: "json",
                method: "GET",
                success: function(participante) {
                    llenarTarjetaParticipante(participante);
                },
                statusCode: {
                    404: function() {
                        errorNoEncontrado();
                    }
                }
            });
        }
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

function mostrarInfo(boton) {
    var id = boton.id.split("mostrar-")[1];
    $.ajax({
        url: "/lista-asistencia/participante/" + id,
        dataType: "json",
        method: "GET",
        success: function(participante) {
            llenarModalParticipante(participante);
            $("#informacion-participante").modal("show");
        },
        statusCode: {
            404: function() {
                errorNoEncontrado();
            }
        }
    });
}
// ******************************************
//   Declaración de funciones
// ******************************************

function ocultarParticipanteInfo() {
    $("#tarjeta-participante").hide();
    $("#input-buscar-agregar").addClass("my-2");
    $("#info-parti").css("opacity", "0");
}
function mostrarParticipanteInfo() {
    $("#tarjeta-participante").show("slow");
    $("#input-buscar-agregar").removeClass("my-2");
    $("#info-parti").css("opacity", "1");
}
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

function llenarTarjetaParticipante(participante) {
    mostrarParticipanteInfo();
    aumentarTamanioInfo();
    $("#agregar-submit").show();
    $("#participante-encontrado").val(participante.persona_id);
    let src = fotosURL + "/" + participante.imagen_perfil;
    $("#imagen-participante").attr("src", src);
    $("#nombre-participante").html(
        participante.nombre + " " + participante.apellido
    );
    $("#cedula-participante-card").html(participante.persona_id);
    $("#correo-participante").html(participante.correo_institucional);
    // En caso de que no se encuentre registrado el correo se muestra un mensaje
    if (!participante.correo_institucional) {
        $("#correo-participante").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    }

    $("#num-telefono-participante").html(participante.telefono_celular);
    // En caso de que no se encuentre registrado el teléfono se muestra un mensaje
    if (!participante.telefono_celular) {
        $("#num-telefono-participante").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    }

    $("#targeta-participante").show("d-flex");
}

function desplegarAlerta(contenido) {
    $("#targeta-responsable").removeClass("d-flex");
    $("#targeta-responsable").hide();
    $("#mensaje-alerta").html(contenido);
    $("#mensaje-alerta")
        .fadeTo(2000, 500)
        .slideUp(500, function() {
            $("#mensaje-alerta").slideUp(500);
        });
}

function aumentarTamanioInfo() {
    $("#logo-EBDI").css("max-width", "141%");
    $("#img-actividad").css("padding-top", "8%");
    $("#img-actividad").css("padding-bottom", "4%");
    $("#info-actividad").css("padding-top", "11%");
    $("#info-actividad").css("padding-bottom", "5%");

    $("#info-actividad").css("margin-left", "3%");
}
function reducirTamanioInfo() {
    $("#logo-EBDI").css("max-width", "100%");
    $("#img-actividad").removeAttr("style");
    $("#info-actividad").removeAttr("style");
}

function errorNoEncontrado() {
    reducirTamanioInfo();
    ocultarParticipanteInfo();
    $("#participante-encontrado").val("false");
    desplegarAlerta("La cédula digitada no existe");
    $("#agregar-submit").hide();
}
