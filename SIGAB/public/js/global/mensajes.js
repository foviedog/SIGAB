$("#alert")
    .fadeTo(5000, 500)
    .slideUp(500, function() {
        $("#alert").slideUp(500);
});

function mostrarMensajeSticky() {
    $("#mensaje-sticky").addClass("d-flex");
    $("#mensaje-sticky").show();
    $("#mensaje-sticky").css("animation-name", "mostrar-mensaje");

    setTimeout(function() { 
        $("#mensaje-sticky").css("animation-name", "esconder-mensaje");
    }, 4000);
    setTimeout(function() {
        $("#mensaje-sticky").removeClass("d-flex");
        $("#mensaje-sticky").hide();
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
