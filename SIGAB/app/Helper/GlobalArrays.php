<?php

namespace App\Helper;

class GlobalArrays
{

    public const TIPOS_ACTIVIDAD_INTERNA = [
        'Curso',
        'Conferencia',
        'Taller',
        'Seminario',
        'Conversatorio',
        'Órgano colegiado',
        'Tutorías',
        'Lectorías',
        'Simposio',
        'Charla',
        'Actividad cocurricular',
        'Tribunales de prueba de grado',
        'Tribunales de defensas públicas',
        'Evaluacion interna ppaa',
        'Evaluacion externa ppaa',
        'Comisiones de trabajo',
        'Externa',
        'Otro'
    ];

    public const TIPOS_ACTIVIDAD_PROMOCION = [
        'Ferias',
        'Participación en congresos nacionales e internacionales',
        'Puertas abiertas',
        'Promoción por redes sociales',
        'Visitas a comunidades',
        'Visitas a colegios',
        'Envío de paquetes promocionales por correo electrónico',
        'Charlas',
        'Otro'
    ];

    public const TIPOS_GUIA_ACADEMICA = [
        'Constancia de estudio',
        'Trámite de Graduación',
        'Verificación de avance en el plan de estudio',
        'Referencias de atención solicitada por docentes',
        'Consejos de abordaje de alguna situación particular solicitada por docentes',
        'Atención solicitada por los estudiantes para atender su condición educativa',
        'Solicitud de mediación por conflictos entre docentes-estudiantes',
        'Solicitud de atención o seguimiento por conflictos entre estudiantes',
        'Atención de consultas sobre TFG',
        'Trámites de empadronamiento',
        'Cupos para cursos de Inglés integrado',
        'Proceso de pre matrícula',
        'Atención de consultas vía correo electrónico sobre información variada',
        'Atención de consultas del equipo de Mentorías',
        'Ayuda económica inmediata',
        'Proceso de Inducción a la vida universitaria',
    ];

    public const PROPOSITOS_ACTIVIDAD_INTERNA = [
        'Inducción',
        'Capacitación',
        'Actualización',
        'Involucramiento del personal',
        'Otro'
    ];

    public const POBLACION_DIRIGIDA = [
        'Estudiantes de primer ingreso',
        'Estudiantes regulares',
        'Personal Docente',
        'Personal Administrativo'
    ];

    public const ESTADOS_ACTIVIDAD = [
        'Para ejecución',
        'En progreso',
        'Ejecutada',
        'Cancelada'
    ];

    public const AMBITOS_ACTIVIDAD = [
        'Nacional',
        'Internacional'
    ];

    public const ESTADOS_CIVILES = [
        'Soltero(a)',
        'Casado(a)',
        'Viudo(a)',
        'Divorciado(a)',
        'Unión libre'
    ];

    public const GENEROS = [
        'Femenino',
        'Masculino',
        'Otro'
    ];

    public const COLEGIOS_PROCEDENCIA = [
        'Público',
        'Técnico',
        'Científico',
        'Bilingüe',
        'Nocturno',
        'Privado'
    ];

    public const TIPOS_BECA = [
        'No tiene',
        'Beca por condición socioeconómica',
        'Beca Omar Dengo (Residencia estudiantil)',
        'Becas de posgrado',
        'Beca por participación en actividades artísticas y deportivas',
        'Beca por participación en movimiento estudiantil',
        'Beca de Honor',
        'Estudiante Asistente Académico y Paracadémico',
        'Intercambio estudiantil',
        'Préstamos estudiantiles',
        'Giras'
    ];

    public const CARGOS_PERSONAL = [
        'Administrativo',
        'Académico'
    ];

    public const GRADOS_ACADEMICOS = [
        "Bachillerato",
        "Licenciatura",
        "Maestría",
        "Doctorado",
        "Posdoctorado"
    ];

    public const JORNADAS_PERSONAL = [
        "Tiempo completo (40 horas)",
        "Cuarto de tiempo (30 horas)",
        "Medio tiempo (30 horas)",
        "Un cuarto de tiempo (10 horas)"
    ];

    public const TIPOS_NOMBRAMIENTO_PERSONAL = [
        "Interino",
        "Propietario",
        "Plazo fijo"
    ];

    public const TIPOS_PUESTOS_PERSONAL = [
        'Secretaría',
        'Dirección',
        'Subdirección',
        'Docente',
        'Profesional Ejecutivo',
        'Participante de PPAA',
        'Responsable de PPAA',
        'Técnico Auxiliar',
        'Biblioteca infantil',
        'Asistente administrativo(a)',
        'Profesional Asistencial en Desarrollo Tecnológico',
        'Profesional Ejecutivo en Desarrollo Documental'
    ];

    public const REGIMENES_ADMINISTRATIVOS_PERSONAL = [
        'Categoría 21 (Técnico Auxiliar)',
        'Categoría 23 (Técnico General 1-2-3)',
        'Categoría 24 (Técnico Analista 1-2-3)',
        'Categoría 32 (Profesional Asistencial 1-2-3-4-5)',
        'Categoría 34 (Profesional Ejecutivo 1-2-3-4)',
        'Categoría 35 (Profesional Analista 1-2-3)',
        'Categoría 36 (Profesional Especialista)',
        'Categoría 37 (Profesional Asesor de Procesos 1-2)',
        'Categoría 38 (Profesional Asesor General)',
        'Categoría 42 (Director Ejecutivo)',
        'Categoría 43 (Director Especialista)',
        'Categoría 44 (Director Asesor)'
    ];

    public const REGIMENES_DOCENTES_PERSONAL = [
        "Categoría 87 (Profesor Instructor Bachiller)",
        "Categoría 88 (Profesor Instructor Licenciado)",
        "Categoría 89 (Profesor I)",
        "Categoría 90 (Profesor II)",
        "Categoría 91 (Catedrático)"
    ];

    public const CURSOS = [
        'BGC400 - Introducción a la Bibliotecología y Gestión de la Información',
        'BGC401 - Metodología de la investigación I',
        'BGC402 - Aplicaciones informáticas a la Bibliotecología',
        'BGC403 - Metodología de la Investigación II',
        'BGC404 - Organización de la información I',
        'BGC405 - Fundamentos pedagógicos aplicados a la Bibliotecología',
        'BGC406 - Usuarios de la información',
        'BGC407 - Diseño de Interfaces Gráficas',
        'BGC408 - Organización de la Información II',
        'BGC409 - Diseño de servicios de información',
        'BGC410 - Análisis de Sistemas Integrados de Información',
        'BGC411 - Gestión de Colecciones',
        'BGC412 - Taller de recursos y materiales didácticos',
        'BGC413 - Organización de recursos de información especiales',
        'BGC414 - Organización administrativa',
        'BGC415 - Alfabetización Informacional',
        'BGC416 - Indización y clasificación',
        'BGC417 - Dirección de unidades de información',
        'BGC418 - Evaluación de procesos administrativos',
        'BGC419 - Taller Gestión de Proyectos',
        'BGC420 - Gestión de la información y el conocimiento en las organizaciones',
        'BGC421 - Estudios Métricos de la Información',
        'BGC422 - Gestión de Documentos y Archivos',
        'BGC423 - Práctica Profesional Supervisada',
        'BGC424 - Seminario Realidad Nacional',
        'BGC425 - Auditoría de la información',
        'BGC500 - Taller de Investigación I',
        'BGC501 - Patrimonio documental y su preservación',
        'BGC502 - Arquitectura de la Información',
        'BGC503 - Mediación Cultural',
        'BGC504 - Taller de investigación II',
        'BGC505 - Implementación de Sistemas Integrados de Información',
        'BGC506 - Debates epistemológicos de la Bibliotecología',
        'BGC530O - Producción editorial en la era digital',
        'BGE210 - Organización de archivos',
        'BGE211 - Almacenamiento y recuperación de la información III',
        'BGE212 - Aplicación de los multimedios',
        'BGE205 - Documentación',
        'BGE214 - Metodología de la investigación',
        'BGE215 - Desarrollo de colecciones',
        'BGE216 - Procesamiento de materiales especiales',
        'BGE201 - Ética profesional',
        'BGE402 - Estudios métricos',
        'BGE219 - Práctica profesional',
        'BGE400 - Gestión para el conocimiento',
        'BGE401 - Indización y resúmenes en Documentación',
        'BGE218 - Control Documental nacional e internacional',
        'BGE403 - Gestión de Proyectos',
        'BGE404 - Gerencia de servicios de información',
        'BGE405 - Comportamiento organizacional',
        'BGE406 - Liderazgo y recursos humanos',
        'BGE407 - Planificación y evaluación de sistemas de información',
        'BGE408 - Auditoría de la información',
        'BGE409 - Evaluación de servicios y formación de usuarios',
        'BG508 - Investigación II'
    ];

    public const ROLES_USUARIO = [
        'Dirección',
        'Subdirección',
        'Académica responsable de Aseguramiento de la Calidad de la Carrera',
        'Académica responsable de SIGAB',
        'Asistente administrativa',
        'Secretaria',
        'Estudiante asistente académica'
    ];

}
