/* Desaparece el mensaje de éxito */
$("#mensaje-exito")
    .fadeTo(2000, 500)
    .slideUp(500, function() {
        $("#mensaje-exito").slideUp(500);
    });

function mostrarMensaje() {
    $("#mensaje-info").addClass("d-flex");
    $("#mensaje-info").show();
    $("#mensaje-info").css("animation-name", "mostrar-mensaje");

    setTimeout(function() { 
        $("#mensaje-info").css("animation-name", "esconder-mensaje");
    }, 4000);
    setTimeout(function() {
        $("#mensaje-info").removeClass("d-flex");
        $("#mensaje-info").hide();
        window.history.replaceState(
            {},
            "/" + window.location.href.split("?")[0]
        );
    }, 4790);
}

function activarLoader(mensaje) {
    $("#btn-cancelar-agregar").trigger("click");
    $(".loader-text").html(mensaje);
    $("#loader-full").show();
    $("#form-evidencia").trigger("submit");
}

function ocultarLoader() {
    $("#loader-full").hide();
}

function mostrarMensajePersonalizado(mensajeId, textoMensaje) {
    $("#" + mensajeId).html(textoMensaje);
    $("#" + mensajeId)
        .fadeTo(2000, 1000)
        .slideUp(1000, function() {
            $("#" + mensajeId).slideUp(1000);
        });
}
