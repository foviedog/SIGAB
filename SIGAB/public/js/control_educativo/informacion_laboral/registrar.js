/*Contador de caracteres de Nombre de la Organizacion */
function contarCarNomOrg(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_nom_org").text(45 - len);
    }
}

/*Contador de caracteres de Tipo de Organizacion */
function contarCarTipOrg(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_tip_org").text(45 - len);
    }
}

/*Contador de caracteres de Nombre de la Organizacion */
function contarCarTiempDesempl(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_tiemp_desmp").text(45 - len);
    }
}

/*Contador de caracteres de Cargo actual */
function contarCarCargAct(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_carg_act").text(45 - len);
    }
}

/*Contador de caracteres de Jefe inmediato */
function contarCarJefInme(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_jef_inme").text(45 - len);
    }
}

/*Contador de caracteres de Telefono trabajo */
function contarCarTelfTrbj(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_tel_trbj").text(45 - len);
    }
}

/*Contador de caracteres de Jornada laboral*/
function contarCarJornLab(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_jorn_lab").text(45 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarCorrTrbj(val) {
    var len = val.value.length;
    if (len >= 80) {
        val.value = val.value.substring(0, 80);
    } else {
        $("#mostrar_cant_corr_trbj").text(80 - len);
    }
}
