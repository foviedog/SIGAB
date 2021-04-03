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
    $("#loader").hide();
    $("#mensaje-info").removeClass("d-flex");
    $("#mensaje-info").hide();
}

// =================================================================
//Función encargada de hacer llamar los metodos de eventos
// =================================================================
function eventos() {
    evtAgregarParticipante2();
    evtListarTodo();
}

// ******************************************
//   Declaración de eventos
// ******************************************

// Detalle del participante de la actividad

function llenarModalParticipante(participante) {
    console.log(5);
    $("#id-info").html(participante.cedula);
    $("#nombre-info").html(participante.nombre + " " + participante.apellidos);
    $("#correo-info").html(participante.correo);
    $("#celular-info").html(participante.numero_telefono);
    $("#procedencia-info").html(participante.procedencia); //revisar

    if (!participante.correo)
        $("#correo-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    if (!participante.numero_telefono)
        $("#celular-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
    if (!participante.procedencia)
        $("#procedencia-info").html(
            '<i class="font-weight-light"> No registrado</i>'
        );
}

function mostrar2Info(boton) {
    
    var id = boton.id.split("mostrar2-")[1];
    console.log(id);
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
function evtAgregarParticipante2() {
    console.log(5);
    $("#agregar-submit2").on("click", function(e) {
        if ($("#participante-encontrado2").val() === "") {
            errorNoEncontrado();
        } else {
            let participante = {
                participante_id: $("#participante-encontrado2").val(),
                actividad_id: $("#actividad-id").val()
            };

            $.ajax({
                method: "POST",
                url: "/lista-asistencia-promocion",
                dataType: "json",
                data: {
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
