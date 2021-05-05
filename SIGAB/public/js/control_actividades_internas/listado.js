function mostrarBusquedaAvanzada(checkbox) {
    if (checkbox.checked == true) {
        $("#busqAvanzada").show();
    } else {
        $("#busqAvanzada").hide();
    }
}

function eliminarFechas(input) {
    $("#rango_fechas").val("");
}

if($("#checkAvanzada").is(':checked')){
mostrarBusquedaAvanzada(this);   
}

