<?php

namespace App\Helper;
use App\Helper\GlobalFunctions;

class Accesos
{
    public static function ACCESO_LISTAR_ESTUDIANTES() { 
        return GlobalFunctions::verificarAcceso(1);
    }

    public static function ACCESO_VISUALIZAR_ESTUDIANTES() { 
        return GlobalFunctions::verificarAcceso(2);
    }

    public static function ACCESO_BUSCAR_ESTUDIANTES() { 
        return GlobalFunctions::verificarAcceso(3);
    }

    public static function ACCESO_LISTAR_TRABAJOS() { 
        return GlobalFunctions::verificarAcceso(4);
    }

    public static function ACCESO_VISUALIZAR_TRABAJOS() { 
        return GlobalFunctions::verificarAcceso(5);
    }

    public static function ACCESO_LISTAR_TITULACIONES() { 
        return GlobalFunctions::verificarAcceso(6);
    }

    public static function ACCESO_LISTAR_GRADUADOS() { 
        return GlobalFunctions::verificarAcceso(7);
    }

    public static function ACCESO_BUSCAR_GRADUADOS() { 
        return GlobalFunctions::verificarAcceso(8);
    }

    public static function ACCESO_VISUALIZAR_GUIAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(9);
    }
    
    public static function ACCESO_LISTAR_PERSONAL() { 
        return GlobalFunctions::verificarAcceso(10);
    }

    public static function ACCESO_VISUALIZAR_PERSONAL() { 
        return GlobalFunctions::verificarAcceso(11);
    }

    public static function ACCESO_BUSCAR_PERSONAL() { 
        return GlobalFunctions::verificarAcceso(12);
    }

    public static function ACCESO_VISUALIZAR_CARGAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(13);
    }

    public static function ACCESO_LISTAR_CARGAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(14);
    }

    public static function ACCESO_LISTAR_ACTIVIDADES() { 
        return GlobalFunctions::verificarAcceso(15);
    }

    public static function ACCESO_BUSCAR_ACTIVIDADES() { 
        return GlobalFunctions::verificarAcceso(16);
    }

    public static function ACCESO_VISUALIZAR_ACTIVIDADES() { 
        return GlobalFunctions::verificarAcceso(17);
    }

    public static function ACCESO_VISUALIZAR_LISTA_PARTICIPACION() { 
        return GlobalFunctions::verificarAcceso(18);
    }

    public static function ACCESO_VISUALIZAR_EVIDENCIAS() { 
        return GlobalFunctions::verificarAcceso(19);
    }

    public static function ACCESO_REGISTRAR_ESTUDIANTES() { 
        return GlobalFunctions::verificarAcceso(20);
    }

    public static function ACCESO_REGISTRAR_TRABAJOS() { 
        return GlobalFunctions::verificarAcceso(21);
    }

    public static function ACCESO_REGISTRAR_TITULACIONES() { 
        return GlobalFunctions::verificarAcceso(22);
    }

    public static function ACCESO_REGISTRAR_PERSONAL() { 
        return GlobalFunctions::verificarAcceso(23);
    }

    public static function ACCESO_REGISTRAR_ACTIVIDADES() { 
        return GlobalFunctions::verificarAcceso(24);
    }

    public static function ACCESO_REGISTRAR_EVIDENCIA() { 
        return GlobalFunctions::verificarAcceso(25);
    }

    public static function ACCESO_REGISTRAR_PARTICIPANTES() { 
        return GlobalFunctions::verificarAcceso(26);
    }

    public static function ACCESO_REGISTRAR_GUIAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(27);
    }

    public static function ACCESO_REGISTRAR_CARGAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(28);
    }

    public static function ACCESO_MODIFICAR_ESTUDIANTES() { 
        return GlobalFunctions::verificarAcceso(29);
    }

    public static function ACCESO_MODIFICAR_TRABAJOS() { 
        return GlobalFunctions::verificarAcceso(30);
    }

    public static function ACCESO_MODIFICAR_TITULACIONES() { 
        return GlobalFunctions::verificarAcceso(31);
    }

    public static function ACCESO_MODIFICAR_GUIAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(32);
    }

    public static function ACCESO_ADJUNTAR_EVIDENCIAS() { 
        return GlobalFunctions::verificarAcceso(33);
    }

    public static function ACCESO_MODIFICAR_PERSONAL() { 
        return GlobalFunctions::verificarAcceso(34);
    }

    public static function ACCESO_MODIFICAR_CARGAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(35);
    }
    
    public static function ACCESO_MODIFICAR_ACTIVIDADES() { 
        return GlobalFunctions::verificarAcceso(36);
    }
    
    public static function ACCESO_AUTORIZAR_ACTIVIDAD() { 
        return GlobalFunctions::verificarAcceso(37);
    }

    public static function ACCESO_GENERAR_INFORMES_ESTADISTICOS() { 
        return GlobalFunctions::verificarAcceso(38);
    }

    public static function ACCESO_ELIMINAR_ESTUDIANTE() { 
        return GlobalFunctions::verificarAcceso(39);
    }

    public static function ACCESO_ELIMINAR_TRABAJOS() { 
        return GlobalFunctions::verificarAcceso(40);
    }

    public static function ACCESO_ELIMINAR_TITULACIONES() { 
        return GlobalFunctions::verificarAcceso(41);
    }

    public static function ACCESO_ELIMINAR_GUIAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(42);
    }

    public static function ACCESO_ELIMINAR_EVIDENCIAS_GUIAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(43);
    }

    public static function ACCESO_ELIMINAR_PERSONAL() { 
        return GlobalFunctions::verificarAcceso(44);
    }

    public static function ACCESO_ELIMINAR_CARGAS_ACADEMICAS() { 
        return GlobalFunctions::verificarAcceso(45);
    }

    public static function ACCESO_ELIMINAR_ACTIVIDADES() { 
        return GlobalFunctions::verificarAcceso(46);
    }

    public static function ACCESO_ELIMINAR_EVIDENCIAS_ACTIVIDADES() { 
        return GlobalFunctions::verificarAcceso(47);
    }

    public static function ACCESO_ELIMINAR_PARTICIPANTE() { 
        return GlobalFunctions::verificarAcceso(48);
    }
}