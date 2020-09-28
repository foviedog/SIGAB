/*Contador de caracteres de Cedula */
function contarCarCed(val) {
    var len = val.value.length;
    if (len >= 15) {
        val.value = val.value.substring(0, 15);
    } else {
        $("#mostrar_cant_ced").text(15 - len);
    }
}

/*Contador de caracteres de Nombre */
function contarCarNombre(val) {
    var len = val.value.length;
    if (len >= 50) {
        val.value = val.value.substring(0, 50);
    } else {
        $("#mostrar_cant_nombre").text(50 - len);
    }
}

/*Contador de caracteres de Apellido */
function contarCarApellido(val) {
    var len = val.value.length;
    if (len >= 50) {
        val.value = val.value.substring(0, 50);
    } else {
        $("#mostrar_cant_apellido").text(50 - len);
    }
}

/*Contador de caracteres de telefono fijo */
function contarCarTelefonoFijo(val) {
    var len = val.value.length;
    if (len >= 30) {
        val.value = val.value.substring(0, 30);
    } else {
        $("#mostrar_cant_telefono_fijo").text(30 - len);
    }
}

/*Contador de caracteres de telefono celular*/
function contarCarTelefonoCelular(val) {
    var len = val.value.length;
    if (len >= 30) {
        val.value = val.value.substring(0, 30);
    } else {
        $("#mostrar_cant_telefono_celular").text(30 - len);
    }
}

/*Contador de caracteres de correo personal*/
function contarCarCorreoPersonal(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_correo_personal").text(45 - len);
    }
}

/*Contador de caracteres de correo institucional*/
function contarCarCorreoInstitucional(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_correo_institucional").text(45 - len);
    }
}

/*Contador de caracteres de estado civil*/
function contarCarEstadoCivil(val) {
    var len = val.value.length;
    if (len >= 44) {
        val.value = val.value.substring(0, 44);
    } else {
        $("#mostrar_cant_estado_civil").text(44 - len);
    }
}

/*Contador de caracteres de direccion residencia*/
function contarCarDireccionResidencia(val) {
    var len = val.value.length;
    if (len >= 250) {
        val.value = val.value.substring(0, 250);
    } else {
        $("#mostrar_cant_direccion_residencia").text(250 - len);
    }
}

/*Contador de caracteres de genero*/
function contarCarGenero(val) {
    var len = val.value.length;
    if (len >= 4) {
        val.value = val.value.substring(0, 4);
    } else {
        $("#mostrar_cant_genero").text(4 - len);
    }
}

/*Contador de caracteres de direccion lectivo*/
function contarCarDireccionLectivo(val) {
    var len = val.value.length;
    if (len >= 80) {
        val.value = val.value.substring(0, 80);
    } else {
        $("#mostrar_cant_direccion_lectivo").text(80 - len);
    }
}

/*Contador de caracteres de Cantidad de Hijos */
function contarCarCantidadHijos(val) {
    var len = val.value.length;
    if (len >= 2) {
        val.value = val.value.substring(0, 2);
    } else {
        $("#mostrar_cant_cantidad_hijos").text(2 - len);
    }
}

/*Contador de caracteres de colegio procedencia*/
function contarCarTipoColegioProcedencia(val) {
    var len = val.value.length;
    if (len >= 13) {
        val.value = val.value.substring(0, 13);
    } else {
        $("#mostrar_cant_tipo_colegio_procedencia").text(13 - len);
    }
}

/*Contador de caracteres de condicion discapacidad*/
function contarCarCondicionDiscapacidad(val) {
    var len = val.value.length;
    if (len >= 250) {
        val.value = val.value.substring(0, 250);
    } else {
        $("#mostrar_cant_condicion_discapacidad").text(250 - len);
    }
}

/*Contador de caracteres de Año de desercion  */
function contarCarAnioDesercion(val) {
    var len = val.value.length;
    if (len >= 4) {
        val.value = val.value.substring(0, 4);
    } else {
        $("#mostrar_cant_anio_desercion").text(4 - len);
    }
}

/*Contador de caracteres de carrera matriculada 1*/
function contarCarCarreraMatriculada1(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_carrera_matriculada1").text(45 - len);
    }
}

/*Contador de caracteres de carrera matriculada 2*/
function contarCarMateriaMatriculada2(val) {
    var len = val.value.length;
    if (len >= 44) {
        val.value = val.value.substring(0, 44);
    } else {
        $("#mostrar_cant_carrera_matriculada2").text(44 - len);
    }
}

/*Contador de caracteres de Año de graduacion estimado 1*/
function contarCarAnioGraduacionEstimado1(val) {
    var len = val.value.length;
    if (len >= 4) {
        val.value = val.value.substring(0, 4);
    } else {
        $("#mostrar_cant_anio_graduacion_estimado_1").text(4 - len);
    }
}

/*Contador de caracteres de Año de graduacion estimado 2*/
function contarCarAnioGraduacionEstimado2(val) {
    var len = val.value.length;
    if (len >= 4) {
        val.value = val.value.substring(0, 4);
    } else {
        $("#mostrar_cant_anio_graduacion_estimado_2").text(4 - len);
    }
}

/*Contador de caracteres de tipo beca*/
function contarCarTipoBeca(val) {
    var len = val.value.length;
    if (len >= 70) {
        val.value = val.value.substring(0, 70);
    } else {
        $("#mostrar_cant_tipo_beca").text(70 - len);
    }
}

/*Contador de caracteres de apoyo educativo*/
function contarCarApoyoEducativo(val) {
    var len = val.value.length;
    if (len >= 500) {
        val.value = val.value.substring(0, 500);
    } else {
        $("#mostrar_cant_apoyo_educativo").text(500 - len);
    }
}

/*Contador de caracteres de residencias*/
function contarCarResidencias(val) {
    var len = val.value.length;
    if (len >= 9) {
        val.value = val.value.substring(0, 9);
    } else {
        $("#mostrar_cant_residencias").text(9 - len);
    }
}

/*Contador de caracteres de nota admision*/
function contarCarNotaAdmision(val) {
    var len = val.value.length;
    if (len >= 6) {
        val.value = val.value.substring(0, 6);
    } else {
        $("#mostrar_cant_anio_admision").text(6 - len);
    }
}
