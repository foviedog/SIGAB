/* Desaparece el mensaje de éxito */
$("#mensaje-exito").fadeTo(2000, 500).slideUp(500, function () {
    $("#mensaje-exito").slideUp(500);
});

/*Contador de caracteres de Grado Académico */
function contarCarGradoAcademico(val) {
    var len = val.value.length;
    if (len >= 120) {
        val.value = val.value.substring(0, 120);
    } else {
        $("#mostrar_cant_grado_academico").text(120 - len);
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
    if (len >= 4) {
        val.value = val.value.substring(0, 4);
    } else {
        $("#mostrar_cant_anio_graduacion").text(4 - len);
    }
}
