<?php

namespace App\Exports;

use App\Persona;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonalExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return Persona::query()->join('personal', 'personas.persona_id', '=', 'personal.persona_id');
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
            "cargo",
            "grado_academico",
            "tipo_nombramiento",
            "tipo_puesto_1",
            "tipo_puesto_2",
            "jornada",
            "lugar_trabajo_externo",
            "anio_propiedad",
            "experiencia_profesional",
            "experiencia_academica",
            "regimen_administrativo",
            "regimen_docente",
            "area_especializacion_1",
            "area_especializacion_2",
            "publicaciones",
            "reconocimientos"
        ];
    }
}