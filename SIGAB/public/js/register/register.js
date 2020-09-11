function confirmar() {

    if ($("#password").val() != "" && $("#password-confirm").val() != "") {
        if ($("#password").val() === $("#password-confirm").val()) {
            $("#envio_registro").submit();
        } else {
            $("#error_contrasenna").html("<strong>Las contraseñas no coinciden</strong>");
        }
    } else {
        $("#error_contrasenna").html("<strong>Los campos no pueden ser vacíos</strong>");
    }

}
