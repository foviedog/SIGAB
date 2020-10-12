// jQuery(function () {
$("#cancelar-edi").hide();
$("#guardar-cambios").hide();
$("#cambiar-foto").hide();
$("#agregar-btn").hide();
$(".eliminar-idioma-btn").hide();


$("#editar-personal").on("click", function() {
    $("input").removeAttr("disabled");
    $("select").removeAttr("disabled");
    $("textarea").removeAttr("disabled");
    $("#agregar-btn").show();
    $("#editar-personal").hide();
    $("#cancelar-edi").show();
    $("#guardar-cambios").show();
    $("#cambiar-foto").show();
    $(".eliminar-idioma-btn").show();

});

$("#cancelar-edi").on("click", function() {
    $("input").attr("disabled", "disabled");
    $("select").attr("disabled", "disabled");
    $("textarea").attr("disabled", "disabled");
    $("#editar-personal").show();
    $("#agregar-btn").hide();
    $(".eliminar-idioma-btn").hide();

    $("#cancelar-edi").hide();
    $("#guardar-cambios").hide();
    $("#cambiar-foto").hide();
});

    $("#personal-form").on("submit", function () {
        coleccionIdiomas = obtenerIdiomas();
        idiomas = JSON.stringify(coleccionIdiomas);
        $("#idiomasJSON").val(idiomas);
    });




// });
