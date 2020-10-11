$("#cancelar-edi").hide();
$("#guardar-cambios").hide();
$("#cambiar-foto").hide();

$("#editar-personal").on("click", function() {
    $("input").removeAttr("disabled");
    $("select").removeAttr("disabled");
    $("textarea").removeAttr("disabled");
    $("#editar-personal").hide();
    $("#cancelar-edi").show();
    $("#guardar-cambios").show();
    $("#cambiar-foto").show();
});

$("#cancelar-edi").on("click", function() {
    $("input").attr("disabled", "disabled");
    $("select").attr("disabled", "disabled");
    $("textarea").attr("disabled", "disabled");
    $("#editar-personal").show();
    $("#cancelar-edi").hide();
    $("#guardar-cambios").hide();
    $("#cambiar-foto").hide();
});
