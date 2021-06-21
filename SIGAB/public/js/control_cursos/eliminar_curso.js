// =======================================================================
// Evento que habilita el botón si se está de acuerdo con las condiciones
// =======================================================================

$(function () {
    $('.check-list').on('click', function () {
        if($('#checkDatosCurso1:checked').length > 0 
            && $('#checkDatosCurso2:checked').length > 0){
            $("#button-submit-eliminar").prop("disabled", false);
        } else {
            $("#button-submit-eliminar").prop("disabled", true);
        }
    });
});