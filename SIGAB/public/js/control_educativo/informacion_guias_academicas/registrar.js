/*Contador de caracteres de residencias*/
function contarCarMotivo(val) {
    var len = val.value.length;
    if (len >= 44) {
        val.value = val.value.substring(0, 44);
    } else {
        $("#mostrar_cant_motivo").text(44 - len);
    }
}

/*Contador de caracteres de residencias*/
function contarCarCicloLectivo(val) {
    var len = val.value.length;
    if (len >= 44) {
        val.value = val.value.substring(0, 44);
    } else {
        $("#mostrar_cant_ciclo_lectivo").text(44 - len);
    }
}

/*Contador de caracteres de residencias*/
function contarCarLugarAtencion(val) {
    var len = val.value.length;
    if (len >= 44) {
        val.value = val.value.substring(0, 44);
    } else {
        $("#mostrar_cant_lugar_atencion").text(44 - len);
    }
}
