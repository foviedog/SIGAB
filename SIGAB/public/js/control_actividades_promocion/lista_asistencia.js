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
}

// =================================================================
//Función encargada de hacer llamar los metodos de eventos
// =================================================================
function eventos() {
    evtAgregarParticipante();
    evtListarTodo();
}

// ******************************************
//   Declaración de eventos
// ******************************************

// Detalle del participante de la actividad

function llenarModalParticipante(participante) {
    let src = fotosURL + "/" + participante.imagen_perfil;
    $("#imagen-perfil-modal").css("background-image", "url(" + src + ")");

    $("#id-info").html(participante.persona_id);
    $("#nombre-info").html(participante.nombre + " " + participante.apellido);
    $("#correo-info").html(participante.correo_institucional);
    $("#telefono-info").html(participante.telefono_fijo);
    $("#procedencia-info").html(participante.telefono_celular); //revisar

    if (!participante.correo_institucional)
        $("#correo-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    if (!participante.telefono_celular)
        $("#celular-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    if (!participante.correo_personal)
        $("#procedencia-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
}
function mostrarInfo(boton) {
    var id = boton.id.split("mostrar-")[1];
    $.ajax({
        url: "/lista-asistencia-promocion/participante/" + id,
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

//-------------------------------------

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
                url: "/lista-asistencia-promocion",
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
<<<<<<< Updated upstream




function recargarTabla(personas) {
    $("#lista-participantes").html(" ");
    personas.forEach(persona => {
        var fila = $("<tr>");
        var cedula = $("<td>").text(persona.persona_id);
        var nombre = $("<td>").text(persona.apellido + ", " + persona.nombre);
        var telefono = $("<td>").text(persona.telefono_celular);
        var correo = $("<td>").text(persona.correo_institucional);
        fila.append(cedula);
        fila.append(nombre);
        fila.append(telefono);
        fila.append(correo);
        $("#lista-participantes").append(fila);
    });
}
=======
>>>>>>> Stashed changes
