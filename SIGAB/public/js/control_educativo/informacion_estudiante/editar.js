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
