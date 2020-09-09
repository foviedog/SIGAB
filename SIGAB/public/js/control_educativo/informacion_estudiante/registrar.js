/*Contador de caracteres de Cedula */
function contarCarCed(val) {
    var len = val.value.length;
    if (len >= 15) {
        val.value = val.value.substring(0, 15);
    } else {
        $("#mostrar_cant_ced").text(15 - len);
    }
}

/*Contador de caracteres de Nombre de la Organizacion */
function contarCarNombre(val) {
    var len = val.value.length;
    if (len >= 50) {
        val.value = val.value.substring(0, 50);
    } else {
        $("#mostrar_cant_nombre").text(50 - len);
    }
}

/*Contador de caracteres de Nombre de la Organizacion */
function contarCarApellido(val) {
    var len = val.value.length;
    if (len >= 50) {
        val.value = val.value.substring(0, 50);
    } else {
        $("#mostrar_cant_apellido").text(50 - len);
    }
}

/*Contador de caracteres de Cargo actual */
function contarCarTelefonoFijo(val) {
    var len = val.value.length;
    if (len >= 30) {
        val.value = val.value.substring(0, 30);
    } else {
        $("#mostrar_cant_telefono_fijo").text(30 - len);
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
function contarCarTelefonoCelular(val) {
    var len = val.value.length;
    if (len >= 30) {
        val.value = val.value.substring(0, 30);
    } else {
        $("#mostrar_cant_telefono_celular").text(30 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarCorreoPersonal(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_correo_personal").text(45 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarCorreoInstitucional(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_correo_institucional").text(45 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarEstadoCivil(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_estado_civil").text(45 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarDireccionResidencia(val) {
    var len = val.value.length;
    if (len >= 250) {
        val.value = val.value.substring(0, 250);
    } else {
        $("#mostrar_cant_direccion_residencia").text(250 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarGenero(val) {
    var len = val.value.length;
    if (len >= 4) {
        val.value = val.value.substring(0, 4);
    } else {
        $("#mostrar_cant_genero").text(4 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarDireccionLectivo(val) {
    var len = val.value.length;
    if (len >= 80) {
        val.value = val.value.substring(0, 80);
    } else {
        $("#mostrar_cant_direccion_lectivo").text(80 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarTipoColegioProcedencia(val) {
    var len = val.value.length;
    if (len >= 13) {
        val.value = val.value.substring(0, 13);
    } else {
        $("#mostrar_cant_tipo_colegio_procedencia").text(13 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarTipoColegioProcedencia(val) {
    var len = val.value.length;
    if (len >= 250) {
        val.value = val.value.substring(0, 250);
    } else {
        $("#mostrar_cant_tipo_colegio_procedencia").text(250 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarCorrTrbj(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_corr_trbj").text(45 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarCarreraMatriculada1(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_carrera_matriculada1").text(45 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarMateriaMatriculada2(val) {
    var len = val.value.length;
    if (len >= 45) {
        val.value = val.value.substring(0, 45);
    } else {
        $("#mostrar_cant_anio_desercion").text(45 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarTipoBeca(val) {
    var len = val.value.length;
    if (len >= 70) {
        val.value = val.value.substring(0, 70);
    } else {
        $("#mostrar_cant_tipo_beca").text(70 - len);
    }
}

/*Contador de caracteres de Correo trabajo*/
function contarCarApoyoEducativo(val) {
    var len = val.value.length;
    if (len >= 150) {
        val.value = val.value.substring(0, 150);
    } else {
        $("#mostrar_cant_apoyo_educativo").text(150 - len);
    }
}
