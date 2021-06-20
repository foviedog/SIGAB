$("#cancelar-edi").hide();
$("#guardar-cambios").hide();
$("#cambiar-foto").hide();

$("#editar-estudiante").on("click", function() {
    $("input").removeAttr("disabled");
    $("select").removeAttr("disabled");
    $("textarea").removeAttr("disabled");
    $("#editar-estudiante").hide();
    $("#cancelar-edi").show();
    $("#guardar-cambios").show();
    $("#cambiar-foto").show();
});

$("#cancelar-edi").on("click", function () {
    location.reload(); // Recarga la página inicial para eliminar todos los cambios hechos y volver a bloquer todos los cambios
});

// =======================================================================
// Evento que habilita el botón si se está de acuerdo con las condiciones
// =======================================================================

$(function () {
    $('.check-list').on('click', function () {
        if($('#checkTrabajos:checked').length > 0 
            && $('#checkTitulaciones:checked').length > 0 
            && $('#checkGuias:checked').length > 0
            && $('#checkListas:checked').length > 0){
            $("#button-submit-eliminar").prop("disabled", false);
        } else {
            $("#button-submit-eliminar").prop("disabled", true);
        }
    });
});
