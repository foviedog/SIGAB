

function mostrarBusquedaAvanzada(checkbox) {
    if (checkbox.checked == true) {
        $("#busqAvanzada").show();
        $("#rango_fechas").val("");
    } else if (checkbox.checked == false) {
        $("#busqAvanzada").hide();
    }
}


function eliminarFechas(input) {
    $("#rango_fechas").val("");
}


if($("#checkAvanzada").is(':checked')){
    $("#busqAvanzada").show(); 
}


