function confirmar() {

    verificarContrasenna($("#password").val());
/*
    if ($("#password").val() != "" && $("#password-confirm").val() != "") {
        if ($("#password").val() === $("#password-confirm").val()) {
            $("#envio_registro").submit();
        } else {
            $("#error_contrasenna").html("<strong>Las contraseñas no coinciden</strong>");
        }
    } else {
        $("#error_contrasenna").html("<strong>Los campos no pueden ser vacíos</strong>");
    }
*/
}

function verificarContrasenna(password) {
    let caracteresEspeciales = "/[\'^£$%&*()}{@#~?><>,|=_+!-]/";
    if (password.match(caracteresEspeciales)) {
        console.log("Todo bien");
    } else {
        console.log("Todo mal");
    }

}
