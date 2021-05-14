

function mostrarBusquedaAvanzada(checkbox) {
    if (checkbox.checked == true) {
        $("#busqAvanzada").show();
        $("#rango_fechas").val("");
    } else if (checkbox.checked == false) {
        $("#busqAvanzada").hide();
    }
}




if($("#checkAvanzada").is(':checked')){
    $("#busqAvanzada").show(); 
}


