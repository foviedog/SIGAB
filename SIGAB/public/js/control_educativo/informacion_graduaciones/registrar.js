/*Contador de caracteres de Grado Académico */
function contarCarGradoAcademico(val) {
    var len = val.value.length;
    if (len >= 15) {
        val.value = val.value.substring(0, 15);
    } else {
        $("#mostrar_cant_grado_academico").text(15 - len);
    }
}

/*Contador de caracteres de Carrera Cursada */
function contarCarCarrCursada(val) {
    var len = val.value.length;
    if (len >= 80) {
        val.value = val.value.substring(0, 80);
    } else {
        $("#mostrar_cant_carrera_cursada").text(80 - len);
    }
}

/*Contador de caracteres de Año de graduación */
function contarCarAnioGraduacion(val) {
    var len = val.value.length;
    if (len >= 11) {
        val.value = val.value.substring(0, 11);
    } else {
        $("#mostrar_cant_anio_graduacion").text(11 - len);
    }
}
