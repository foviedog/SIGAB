<?php

namespace App\Exports;

use App\Persona;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EstudiantesExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return Persona::query()->join('estudiantes', 'personas.persona_id', '=', 'estudiantes.persona_id');
    }

    public function headings() :array
    {
        return [
            "persona_id",
            "nombre",
            "apellido",
            "fecha_nacimiento",
            "telefono_fijo",
            "telefono_celular",
            "correo_personal",
            "correo_institucional",
            "estado_civil",
            "direccion_residencia",
            "genero",
            "imagen_perfil",
            "created_at",
            "updated_at",
            "direccion_lectivo",
            "cant_hijos",
            "tipo_colegio_procedencia",
            "condicion_discapacida",
            "anio_ingreso_ebdi",
            "anio_ingreso_UNA",
            "carrera_matriculada_1",
            "carrera_matriculada_2",
            "anio_graduacion_estimado_1",
            "anio_graduacion_estimado_2",
            "anio_desercion",
            "tipo_beca",
            "nota_admision",
            "apoyo_educativo",
            "residencias_UNA"
        ];
    }
}