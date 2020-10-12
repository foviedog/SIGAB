$('#solicitud').val(est);
//console.log($('#solicitud').val());
$(function () {
    $("input[type='radio']").on("click", function () {
            var radioValue = $("input[name='radio']:checked").val();
            if (radioValue == "docen") {
                $('#lista_docentes').collapse('show');
                console.log($('#solicitud').val());
            } else {
                $('#lista_docentes').collapse('hide');
                $('#solicitud').val(est);
                $("#docente").val("");
                //console.log($('#solicitud').val());
            }
    });
});

$("#docente").on("change", function () {
    $('#solicitud').val($("#docente").val().split(" ")[0]);
    //console.log($('#solicitud').val());
});

function quitarArchivo() {
    $("#adjuntar-archivo").val(null);
}

