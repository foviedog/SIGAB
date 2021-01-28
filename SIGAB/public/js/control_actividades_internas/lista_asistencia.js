
document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

let editarActivido = false;
// ===============================================================================================
//Función encargada de hacer el llamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    ocultarElementos();
    eventos();
    AparecerMensajeExito();
}

function ocultarElementos() {
    $("#mensaje-alerta").hide();
    $("#campo-buscar").removeClass('d-flex');
    $("#campo-buscar").hide();
    $("#cancelar-edi").hide();
    $("#info-responsable").removeClass('border-top');
    $("#card-footer").hide();
    $("#avatar").hide();
    $("#agregar-participante-card").hide();
    ocultarParticipanteInfo();
}


// =================================================================
//Función encargada de hacer llamar los metodos de eventos
// =================================================================
function eventos() {
    evtSubmit();
    evtAgregarParticipanteShow();
    evtCancelarAgregarPart();
    evtBuscarParticipante();
}

// ******************************************
//   Declaración de eventos
// ******************************************

function evtCancelarAgregarPart() {
    $("#cancelar-agregar-part").on("click", function () {
        $("#btn-agregar-part").show();
        $("#agregar-participante-card").hide();
        $("participante-encontrado").val("false");
        $("#cedula-participante").val("");
        ocultarParticipanteInfo();
        reducirTamanioInfo();
    });
}

function evtAgregarParticipanteShow() {
    $("#btn-agregar-part").on("click", function (e) {
        $("#btn-agregar-part").hide();
        $("#agregar-submit").hide();
        $("#agregar-participante-card").show();
    });
}


function evtBuscarParticipante() {
    $("#buscar").on("click", function() {
        if ($("#cedula-participante").val() === "") {
            errorNoEncontrado();
        } else {
            $.ajax({
                url: "/lista-asistencia/participante/" + $("#cedula-participante").val(),
                dataType: "json",
                method: "GET",
                success: function (participante) {
                    llenarTarjetaParticipante(participante);
                },
                statusCode: {
                    404: function () {
                        errorNoEncontrado();
                    }
                }
            });
        }
    });
}

// ===============================================================
//Función encargada de validar que se haya ingresado un personal
// ===============================================================
function evtSubmit() {
    $("#guardar-cambios").on("click", function (e) {
        if (editarActivido === true && $("#responsable-encontrado").val() === "false") {
            e.preventDefault();
            $("#cedula-responsable").val("");
            $("#mensaje-alerta").html(
                "Debe de designar un responsable"
            );
            $("#mensaje-alerta")
                .fadeTo(2000, 1000)
                .slideUp(1000, function() {
                    $("#mensaje-alerta").slideUp(1000);
                });
        }
    });
}

// ******************************************
//   Declaración de funciones
// ******************************************


function ocultarParticipanteInfo() {
    $("#tarjeta-participante").hide();
    $("#input-buscar-agregar").addClass('my-2');
    $("#info-parti").css("opacity", "0");
}
function mostrarParticipanteInfo() {
    $("#tarjeta-participante").show("slow");
    $("#input-buscar-agregar").removeClass('my-2');
    $("#info-parti").css("opacity", "1");
}

function llenarTarjetaParticipante(participante) {
    mostrarParticipanteInfo();
    aumentarTamanioInfo();
    $("#agregar-submit").show();
    $("#participante-encontrado").val('true');
    let src = fotosURL + "/" + participante.imagen_perfil;
    $("#imagen-participante").attr("src", src);
    $("#nombre-participante").html(
        participante.nombre + " " + participante.apellido
    );
    $("#cedula-participante-card").html(participante.persona_id);
    $("#correo-participante").html(participante.correo_institucional);
    // En caso de que no se encuentre registrado el correo se muestra un mensaje
    if (!participante.correo_institucional) {
        $("#correo-participante").html('<i class="font-weight-light"> No registrado</i>' );
    }

    $("#num-telefono-participante").html(participante.telefono_celular);
    // En caso de que no se encuentre registrado el teléfono se muestra un mensaje
    if (!participante.telefono_celular) {
        $("#num-telefono-participante").html('<i class="font-weight-light"> No registrado</i>' );
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



function AparecerMensajeExito() {
    $("#mensaje_exito")
        .fadeTo(3000, 500)
        .slideUp(500, function() {
            $("#mensaje_exito").slideUp(800);
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
    $('#img-actividad').removeAttr('style');
    $('#info-actividad').removeAttr('style');
}

function errorNoEncontrado() {
    reducirTamanioInfo();
    ocultarParticipanteInfo();
    $("#participante-encontrado").val("false");
    desplegarAlerta("La cédula digitada no existe");
    $("#agregar-submit").hide();
}
