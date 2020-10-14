$("#mensaje-alerta").hide();

function submit() {
    if ($("#responsable_coordinar").val() !== "none") {
        $("#actividad-interna").submit();
    } else {
        alert("Debe ingresar el responsable de coordinar");
    }
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
                $("#responsable_coordinar").val(response.persona_id);
                //console.log($("#responsable_coordinar").val());
                $("#informacion-responsable").html(
                    "Nombre del responsable: " +
                        response.nombre +
                        " " +
                        response.apellido
                );
            },
            statusCode: {
                404: function() {
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
