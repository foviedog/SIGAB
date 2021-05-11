function confirmar() {

    if ($("#password").val() != "" && $("#password-confirm").val() != "") {
        if ($("#password").val() === $("#password-confirm").val()) {
            if (verificarContrasenna($("#password").val())){
                $("#envio_registro").submit();
            } else {
                $("#error_contrasenna").html("<strong>Formato inválido</strong>");
            }
        } else {
            $("#error_contrasenna").html("<strong>Las contraseñas no coinciden</strong>");
        }
    } else {
        $("#error_contrasenna").html("<strong>Los campos no pueden estar vacíos</strong>");
    }

}

function verificarContrasenna(password) {

    if (password.length < 6) return false;

    if (!contieneMayuscula(password)) return false;

    if (!contieneNumero(password)) return false;

    let caracteresEspeciales = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    if (!caracteresEspeciales.test(password)) return false;

    return true;

}

function contieneMayuscula(password) {

    let contieneMayuscula = false;
    for (var i = 0; i < password.length && !contieneMayuscula; i++){
        if (!esCaracterEspecial(password[i])
            && isNaN(password[i])
            && password[i] == password[i].toUpperCase()) {
            contieneMayuscula = true;
        }
    }
    return contieneMayuscula;
}

function contieneNumero(password) {
    let contieneNumero = false;
    for (var i = 0; i < password.length && !contieneNumero; i++){
        if (!isNaN(password[i])) contieneNumero = true;
    }
    return contieneNumero;
}

function esCaracterEspecial(letra) {
    let caracteresEspeciales = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-=";

    for(i = 0; i < caracteresEspeciales.length;i++){
        if(caracteresEspeciales[i] == letra) return true;
    }

    return false;
}
