
document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

let editarActivido = false;

// ===============================================================================================
//Función encargada de hacer el llamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    ocultarElementos();
    eventos();
    mostrarMensajeSticky();
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
    var idBtn =  boton.id;
    var id = boton.id.split("mostrar2-")[1];
    var idActividad = $("#"+idBtn).data("idactividad");
    $.ajax({
        url: "/lista-asistencia-promocion/participante/" + id +"?actividadId="+idActividad,
        method: "GET",
        success: function(participante) {
            llenarModalParticipante(participante);
            console.log(participante);
            $("#informacion-participante").modal("show");
        },
        statusCode: {
            404: function() {
                console.log(error);
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
        $("#nuevoParticipante").hide();////
        $("#loader").show();      
        $("#submitStore").trigger("click");
    });
}
