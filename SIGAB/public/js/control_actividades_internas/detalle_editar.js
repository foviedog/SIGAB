
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
    $("#campo-buscar").removeClass('d-flex');
    $("#campo-buscar").hide();
    $("#info-responsable").removeClass('border-top');
}

// ===============================================================================================
//Función encargada de hacer llamar los metodos de eventos
// ===============================================================================================
function eventos() {
    infoGeneralEvt();
    evtSubmit();
    evtBuscarResponsable();
    editar();
    validarInfo();
}
// ===============================================================================================
//Función encargada de validar que se haya ingresado un personal
// ===============================================================================================
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

function evtBuscarResponsable() {
    $("#buscar").on("click", function() {
        if ($("#cedula-responsable").val() === "") {
            $("#responsable-encontrado").val('false');
            ocultarInfoResponsable();
            desplegarAlerta("La cédula digitada no está registrada");
        } else {
            $("#responsable-encontrado").val("true");
            $.ajax({
                url: "/personal/obtener/" + $("#cedula-responsable").val(),
                type: "GET",
                success: function (responsable) {
                    llenarTarjetaResponsable(responsable);
                },
                statusCode: {
                    404: function () {
                    ocultarInfoResponsable();
                    $("#responsable-encontrado").val('false');
                        desplegarAlerta("No se encontró el personal");
                    }
                }
            });
        }
    });
}

function llenarTarjetaResponsable(responsable) {
    mostrarResponsable();
    $("#responsable-encontrado").val('true');
    let src = fotosURL + "/" + responsable.imagen_perfil;
    $("#imagen-responsable").attr("src", src);
    $("#nombre-responsable").html(
        responsable.nombre + " " + responsable.apellido
    );
    $("#cedula-responsable-card").html(responsable.persona_id);
    $("#correo-responsable").html(responsable.correo_institucional);
    // En caso de que no se encuentre registrado el correo se muestra un mensaje
    if (!responsable.correo_institucional) {
        $("#correo-responsable").html('<i class="font-weight-light"> No registrado</i>' );
    }

    $("#num-telefono-responsable").html(responsable.telefono_celular);
    // En caso de que no se encuentre registrado el teléfono se muestra un mensaje
    if (!responsable.telefono_celular) {
        $("#num-telefono-responsable").html('<i class="font-weight-light"> No registrado</i>' );
        }

    $("#targeta-responsable").show("d-flex");
}

$("#targeta-responsable").show("d-flex");

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

function editar() {
    $("#editar-actividad").on("click", function () {
        editarActivido = true;
        $("input").removeAttr("disabled");
        $("select").removeAttr("disabled");
        $("textarea").removeAttr("disabled");
        $("#editar-actividad").hide();
        $("#cancelar-edi").show();
        $("#guardar-cambios").show();
        $("#cambiar-foto").show();
        $("#campo-buscar").addClass('d-flex');
        $("#campo-buscar").show();
        $("#info-responsable").addClass('border-top');
    });
}

function ocultarInfoResponsable() {
    $("#info-responsable").removeClass('border-top');
    $("#info-responsable").removeClass('d-flex');
    $("#info-responsable").hide();
}
function mostrarResponsable() {
    $("#info-responsable").addClass('border-top');
    $("#info-responsable").addClass('d-flex');
    $("#info-responsable").show();
}

function infoGeneralEvt() {
    $("#info-gen-tab").on("click", function (e) {
        $("#info-gen-tab").addClass("active");// Desacitva la vista de información general
        $("#info-esp-tab").removeClass("active");// Desacitva la vista de información general
        $("#info-esp").removeClass('active'); // Desactiva la clase para el botón de volver a información general en la vista de participaciones.
        $("#info-gen").tab("show"); // Muestra la vista de informacion general.

    });
}
function validarInfo() {

    $("#info-esp-tab").on("click", function (e) {
        e.preventDefault();
        let $actividadForm = $("#actividad-form"); // Variable que contiene el form de información general del personal

        if (!$actividadForm[0].checkValidity() ||  $("#responsable-encontrado").val() === "false") { // Valida el form antes de que se proceda a la siguiente página para evitar que se envíen datos incorrectos
            $("#guardar-cambios").trigger("click"); // Fuerza el envío de datos en el form para que realice la validación automática de los campos
            $("#info-gen-tab").addClass('active');
            $("#info-esp-tab").removeClass('active');

        } else { // En caso de que se hayan completado los campos de manera correcta procede a mostrar la información de participaciones
            $("#info-esp-tab").addClass("active");// Desacitva la vista de información general
            $("#info-gen-tab").removeClass("active");// Desacitva la vista de información general
            $("#info-gen").removeClass('active'); // Desactiva la clase para el botón de volver a información general en la vista de participaciones.
            $("#info-esp").tab("show"); // Muestra la vista de participaciones.
        }

    });
}
