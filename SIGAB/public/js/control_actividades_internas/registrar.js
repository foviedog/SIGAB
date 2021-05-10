document.addEventListener("DOMContentLoaded", cargaInicial); //Se agrega el evento carga inicial al momento de cargar el documento

// ===============================================================================================
//Función encargada de hacer el llamado  de todos los métodos utilizados en el registro.
// ===============================================================================================
function cargaInicial(event) {
    ocultarElementos();
    eventos();
}
function ocultarElementos() {
    $("#alerta-facilitador").hide();
    $("#facilitador-info").hide();
    $("#alerta-responsable").hide();
    $("#responsable-info").hide();
}
// ===============================================================================================
//Función encargada de hacer llamar los metodos de eventos
// ===============================================================================================
function eventos() {
    evtSubmit();
    evtBuscarFacilitador();
    evtBuscarResponsable();
    evtFacilitadorExterno();
}
// ===============================================================================================
//Función encargada de validar que se haya ingresado un personal
// ===============================================================================================
function evtSubmit() {
    $("#actividad-interna").on("submit", function (e) {
        if ($("#responsable-encontrado").val() === "false") {
            e.preventDefault();
            $("#cedula-responsable").val("");
            $("#mensaje-alerta").html(
                "Por favor busque un personal que exista"
            );
            $("#mensaje-alerta")
                .fadeTo(2000, 1000)
                .slideUp(1000, function () {
                    $("#mensaje-alerta").slideUp(1000);
                });
        }
    });
}

function evtBuscarFacilitador() {
    $("#buscarFacilitador").on("click", function () {
        if ($("#cedula-facilitador").val() === "") {
            $("#facilitador-encontrado").val("false");
            esconderTarjetaInfo("alerta-facilitador");
            desplegarAlerta("alerta-facilitador", "facilitador-info", "La cédula digitada no existe");
        } else {
            $.ajax({
                url:
                    rutas['personal.edit'] + $("#cedula-facilitador").val(),
                type: "GET",
                success: function (personal) {
                    $("#facilitador-encontrado").val(personal.persona_id);
                    var infoTarjeta = {
                        imageID: "imagen-facilitador",
                        nombreID: "nombre-facilitador",
                        cedulaID: "cedula-facilitador-card",
                        correoID: "correo-facilitador",
                        telefonoID: "num-telefono-facilitador",
                    };
                    llenarTarjetaInfo("facilitador-info", personal, infoTarjeta);
                },
                statusCode: {
                    404: function () {
                        $("#facilitador-encontrado").val("false");
                        esconderTarjetaInfo("alerta-facilitador");
                        desplegarAlerta("facilitador-info", "No se encontró el personal");
                    }
                }
            });
        }
    });
}

function evtBuscarResponsable() {
    $("#buscarCoordinador").on("click", function () {
        if ($("#cedula-responsable").val() === "") {
            $("#responsable-encontrado").val("false");
            esconderTarjetaInfo("alerta-responsable");
            desplegarAlerta("responsable-info", "La cédula digitada no existe");
        } else {
            $.ajax({
                url:
                    rutas['personal.edit'] + $("#cedula-responsable").val(),
                type: "GET",
                success: function (personal) {
                    $("#responsable-encontrado").val(personal.persona_id);
                    var infoTarjeta = {
                        imageID: "imagen-responsable",
                        nombreID: "nombre-responsable",
                        cedulaID: "cedula-responsable-card",
                        correoID: "correo-responsable",
                        telefonoID: "num-telefono-responsable",
                    };
                    llenarTarjetaInfo("responsable-info", personal, infoTarjeta);
                },
                statusCode: {
                    404: function () {
                        $("#responsable-encontrado").val("false");
                        esconderTarjetaInfo("alerta-responsable");
                        desplegarAlerta("responsable-info", "No se encontró el personal");
                    }
                }
            });
        }
    });
}

function llenarTarjetaInfo(idTarjeta, personal, infoTarjeta) {
    $("#" + idTarjeta).addClass("d-flex");
    let src = fotosURL + "/" + personal.imagen_perfil;
    $("#" + infoTarjeta.imageID).attr("src", src);
    $("#" + infoTarjeta.nombreID).html(
        personal.nombre + " " + personal.apellido
    );
    $("#" + infoTarjeta.cedulaID).html(personal.persona_id);
    $("#" + infoTarjeta.correoID).html(personal.correo_institucional);
    $("#" + infoTarjeta.telefonoID).html(personal.telefono_celular);

    $("#" + idTarjeta).show("d-flex");
}

function desplegarAlerta(idAlerta, contenido) {
    $("#" + idAlerta).html(contenido);
    $("#" + idAlerta)
        .fadeTo(3000, 1000)
        .slideUp(500, function () {
            $("#" + idAlerta).slideUp(5000);
        });
}

function esconderTarjetaInfo(idTarjeta) {
    $("#" + idTarjeta).removeClass("d-flex");
    $("#" + idTarjeta).hide();
}

function evtFacilitadorExterno() {
    $("#externo-check").on("change", function (event) {
        if(this.checked) {
            $("#cedula-facilitador").val("");
            esconderTarjetaInfo("facilitador-info");
            $("#buscarFacilitador").hide();
        }else{
            $("#buscarFacilitador").show();
        }
    })
}
