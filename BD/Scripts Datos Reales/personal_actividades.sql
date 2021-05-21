-- SELECTS NECESARIOS
use sigab;
select * from roles;
select * from tareas;
select * from accesos;

-- SCRIPT GENERAL DE ACCESOS DE USUARIO

-- ROLES
insert into roles(nombre) values("Dirección");
insert into roles(nombre) values("Subdirección");
insert into roles(nombre) values("Académica responsable de Aseguramiento de la Calidad de la Carrera");
insert into roles(nombre) values("Académica responsable de SIGAB");
insert into roles(nombre) values("Asistente administrativa");
insert into roles(nombre) values("Secretaria");
insert into roles(nombre) values("Estudiante asistente académica");

-- TAREAS
insert into tareas(nombre) values("Listar estudiantes");
insert into tareas(nombre) values("Visualizar información detallada de estudiantes");
insert into tareas(nombre) values("Realizar búsquedas de estudiantes");
insert into tareas(nombre) values("Visualizar lista de trabajos de estudiantes");
insert into tareas(nombre) values("Visualizar información laboral de estudiantes");
insert into tareas(nombre) values("Visualizar listado de titulaciones");
insert into tareas(nombre) values("Listar estudiantes graduados");
insert into tareas(nombre) values("Realizar búsquedas de estudiantes graduados");
insert into tareas(nombre) values("Visualizar guías académicas");
insert into tareas(nombre) values("Listar personal");
insert into tareas(nombre) values("Visualizar información del personal");
insert into tareas(nombre) values("Realizar búsquedas del personal");
insert into tareas(nombre) values("Visualizar cargas académicas");
insert into tareas(nombre) values("Listar cargas académicas del personal");
insert into tareas(nombre) values("Verificar listado de actividades registradas");
insert into tareas(nombre) values("Realizar búsquedas de actividades");
insert into tareas(nombre) values("Visualizar información detallada de actividad");
insert into tareas(nombre) values("Visualizar lista de participantes (asistencia) en actividades");
insert into tareas(nombre) values("Visualizar documentos (evidencias) de actividades");
insert into tareas(nombre) values("Registrar estudiantes");
insert into tareas(nombre) values("Registrar información laboral de estudiantes");
insert into tareas(nombre) values("Registrar titulaciones de estudiantes");
insert into tareas(nombre) values("Registrar personal");
insert into tareas(nombre) values("Registrar una nueva actividad");
insert into tareas(nombre) values("Agregar documentos (evidencias) de actividades");
insert into tareas(nombre) values("Agregar participantes en actividades");
insert into tareas(nombre) values("Agregar guías académicas");
insert into tareas(nombre) values("Agregar cargas académicas");
insert into tareas(nombre) values("Modificar información de estudiantes");
insert into tareas(nombre) values("Modificar información laboral de estudiantes");
insert into tareas(nombre) values("Modificar titulaciones de estudiantes");
insert into tareas(nombre) values("Modificar información de guías académicas");
insert into tareas(nombre) values("Adjuntar evidencias a guías académicas");
insert into tareas(nombre) values("Modificar información del personal");
insert into tareas(nombre) values("Modificar cargas académicas");
insert into tareas(nombre) values("Modificar información de actividades");
insert into tareas(nombre) values("Autorizar una actividad");
insert into tareas(nombre) values("Generar informes y estadísticas");
insert into tareas(nombre) values("Eliminar estudiantes");
insert into tareas(nombre) values("Eliminar trabajos de estudiantes");
insert into tareas(nombre) values("Eliminar titulaciones a estudiantes");
insert into tareas(nombre) values("Eliminar guías académicas");
insert into tareas(nombre) values("Eliminar evidencias a guía académicas");
insert into tareas(nombre) values("Eliminar miembros del personal");
insert into tareas(nombre) values("Eliminar cargas académicas");
insert into tareas(nombre) values("Eliminar actividades");
insert into tareas(nombre) values("Eliminar evidencias a actividades");
insert into tareas(nombre) values("Eliminar participantes de actividades");

-- ACCESOS

-- DIRECCION
insert into accesos(rol_id, tarea_id) values (1, 1);
insert into accesos(rol_id, tarea_id) values (1, 2);
insert into accesos(rol_id, tarea_id) values (1, 3);
insert into accesos(rol_id, tarea_id) values (1, 4);
insert into accesos(rol_id, tarea_id) values (1, 5);
insert into accesos(rol_id, tarea_id) values (1, 6);
insert into accesos(rol_id, tarea_id) values (1, 7);
insert into accesos(rol_id, tarea_id) values (1, 8);
insert into accesos(rol_id, tarea_id) values (1, 9);
insert into accesos(rol_id, tarea_id) values (1, 10);
insert into accesos(rol_id, tarea_id) values (1, 11);
insert into accesos(rol_id, tarea_id) values (1, 12);
insert into accesos(rol_id, tarea_id) values (1, 13);
insert into accesos(rol_id, tarea_id) values (1, 14);
insert into accesos(rol_id, tarea_id) values (1, 15);
insert into accesos(rol_id, tarea_id) values (1, 16);
insert into accesos(rol_id, tarea_id) values (1, 17);
insert into accesos(rol_id, tarea_id) values (1, 18);
insert into accesos(rol_id, tarea_id) values (1, 19);
insert into accesos(rol_id, tarea_id) values (1, 23);
insert into accesos(rol_id, tarea_id) values (1, 24);
insert into accesos(rol_id, tarea_id) values (1, 25);
insert into accesos(rol_id, tarea_id) values (1, 26);
insert into accesos(rol_id, tarea_id) values (1, 28);
insert into accesos(rol_id, tarea_id) values (1, 34);
insert into accesos(rol_id, tarea_id) values (1, 35);
insert into accesos(rol_id, tarea_id) values (1, 36);
insert into accesos(rol_id, tarea_id) values (1, 37);
insert into accesos(rol_id, tarea_id) values (1, 38);
insert into accesos(rol_id, tarea_id) values (1, 44);
insert into accesos(rol_id, tarea_id) values (1, 45);
insert into accesos(rol_id, tarea_id) values (1, 46);
insert into accesos(rol_id, tarea_id) values (1, 47);
insert into accesos(rol_id, tarea_id) values (1, 48);

-- SUBDIRECCION
insert into accesos(rol_id, tarea_id) values (2, 1);
insert into accesos(rol_id, tarea_id) values (2, 2);
insert into accesos(rol_id, tarea_id) values (2, 3);
insert into accesos(rol_id, tarea_id) values (2, 4);
insert into accesos(rol_id, tarea_id) values (2, 5);
insert into accesos(rol_id, tarea_id) values (2, 6);
insert into accesos(rol_id, tarea_id) values (2, 7);
insert into accesos(rol_id, tarea_id) values (2, 8);
insert into accesos(rol_id, tarea_id) values (2, 9);
insert into accesos(rol_id, tarea_id) values (2, 10);
insert into accesos(rol_id, tarea_id) values (2, 11);
insert into accesos(rol_id, tarea_id) values (2, 12);
insert into accesos(rol_id, tarea_id) values (2, 13);
insert into accesos(rol_id, tarea_id) values (2, 14);
insert into accesos(rol_id, tarea_id) values (2, 15);
insert into accesos(rol_id, tarea_id) values (2, 16);
insert into accesos(rol_id, tarea_id) values (2, 17);
insert into accesos(rol_id, tarea_id) values (2, 18);
insert into accesos(rol_id, tarea_id) values (2, 19);
insert into accesos(rol_id, tarea_id) values (2, 20);
insert into accesos(rol_id, tarea_id) values (2, 21);
insert into accesos(rol_id, tarea_id) values (2, 22);
insert into accesos(rol_id, tarea_id) values (2, 23);
insert into accesos(rol_id, tarea_id) values (2, 24);
insert into accesos(rol_id, tarea_id) values (2, 25);
insert into accesos(rol_id, tarea_id) values (2, 26);
insert into accesos(rol_id, tarea_id) values (2, 27);
insert into accesos(rol_id, tarea_id) values (2, 29);
insert into accesos(rol_id, tarea_id) values (2, 30);
insert into accesos(rol_id, tarea_id) values (2, 31);
insert into accesos(rol_id, tarea_id) values (2, 32);
insert into accesos(rol_id, tarea_id) values (2, 33);
insert into accesos(rol_id, tarea_id) values (2, 34);
insert into accesos(rol_id, tarea_id) values (2, 36);
insert into accesos(rol_id, tarea_id) values (2, 37);
insert into accesos(rol_id, tarea_id) values (2, 38);
insert into accesos(rol_id, tarea_id) values (2, 39);
insert into accesos(rol_id, tarea_id) values (2, 40);
insert into accesos(rol_id, tarea_id) values (2, 41);
insert into accesos(rol_id, tarea_id) values (2, 42);
insert into accesos(rol_id, tarea_id) values (2, 43);
insert into accesos(rol_id, tarea_id) values (2, 44);
insert into accesos(rol_id, tarea_id) values (2, 46);
insert into accesos(rol_id, tarea_id) values (2, 47);
insert into accesos(rol_id, tarea_id) values (2, 48);

-- ACADÉMICA RESPONSABLE DE ASEGURAMIENTO DE LA CALIDAD DE LA CARRERA
insert into accesos(rol_id, tarea_id) values (3, 1);
insert into accesos(rol_id, tarea_id) values (3, 2);
insert into accesos(rol_id, tarea_id) values (3, 3);
insert into accesos(rol_id, tarea_id) values (3, 4);
insert into accesos(rol_id, tarea_id) values (3, 5);
insert into accesos(rol_id, tarea_id) values (3, 6);
insert into accesos(rol_id, tarea_id) values (3, 7);
insert into accesos(rol_id, tarea_id) values (3, 8);
insert into accesos(rol_id, tarea_id) values (3, 9);
insert into accesos(rol_id, tarea_id) values (3, 10);
insert into accesos(rol_id, tarea_id) values (3, 11);
insert into accesos(rol_id, tarea_id) values (3, 12);
insert into accesos(rol_id, tarea_id) values (3, 13);
insert into accesos(rol_id, tarea_id) values (3, 14);
insert into accesos(rol_id, tarea_id) values (3, 15);
insert into accesos(rol_id, tarea_id) values (3, 16);
insert into accesos(rol_id, tarea_id) values (3, 17);
insert into accesos(rol_id, tarea_id) values (3, 18);
insert into accesos(rol_id, tarea_id) values (3, 19);
insert into accesos(rol_id, tarea_id) values (3, 20);
insert into accesos(rol_id, tarea_id) values (3, 21);
insert into accesos(rol_id, tarea_id) values (3, 22);
insert into accesos(rol_id, tarea_id) values (3, 23);
insert into accesos(rol_id, tarea_id) values (3, 24);
insert into accesos(rol_id, tarea_id) values (3, 25);
insert into accesos(rol_id, tarea_id) values (3, 26);
insert into accesos(rol_id, tarea_id) values (3, 29);
insert into accesos(rol_id, tarea_id) values (3, 30);
insert into accesos(rol_id, tarea_id) values (3, 31);
insert into accesos(rol_id, tarea_id) values (3, 34);
insert into accesos(rol_id, tarea_id) values (3, 36);
insert into accesos(rol_id, tarea_id) values (3, 37);
insert into accesos(rol_id, tarea_id) values (3, 38);
insert into accesos(rol_id, tarea_id) values (3, 39);
insert into accesos(rol_id, tarea_id) values (3, 40);
insert into accesos(rol_id, tarea_id) values (3, 41);
insert into accesos(rol_id, tarea_id) values (3, 44);
insert into accesos(rol_id, tarea_id) values (3, 46);
insert into accesos(rol_id, tarea_id) values (3, 47);
insert into accesos(rol_id, tarea_id) values (3, 48);

-- ASISTENTE ADMINISTRATIVA
insert into accesos(rol_id, tarea_id) values (5, 1);
insert into accesos(rol_id, tarea_id) values (5, 2);
insert into accesos(rol_id, tarea_id) values (5, 3);
insert into accesos(rol_id, tarea_id) values (5, 4);
insert into accesos(rol_id, tarea_id) values (5, 5);
insert into accesos(rol_id, tarea_id) values (5, 6);
insert into accesos(rol_id, tarea_id) values (5, 7);
insert into accesos(rol_id, tarea_id) values (5, 8);
insert into accesos(rol_id, tarea_id) values (5, 9);
insert into accesos(rol_id, tarea_id) values (5, 10);
insert into accesos(rol_id, tarea_id) values (5, 11);
insert into accesos(rol_id, tarea_id) values (5, 12);
insert into accesos(rol_id, tarea_id) values (5, 13);
insert into accesos(rol_id, tarea_id) values (5, 14);
insert into accesos(rol_id, tarea_id) values (5, 15);
insert into accesos(rol_id, tarea_id) values (5, 16);
insert into accesos(rol_id, tarea_id) values (5, 17);
insert into accesos(rol_id, tarea_id) values (5, 18);
insert into accesos(rol_id, tarea_id) values (5, 19);

-- SECRETARIA
insert into accesos(rol_id, tarea_id) values (6, 1);
insert into accesos(rol_id, tarea_id) values (6, 2);
insert into accesos(rol_id, tarea_id) values (6, 3);
insert into accesos(rol_id, tarea_id) values (6, 4);
insert into accesos(rol_id, tarea_id) values (6, 5);
insert into accesos(rol_id, tarea_id) values (6, 6);
insert into accesos(rol_id, tarea_id) values (6, 7);
insert into accesos(rol_id, tarea_id) values (6, 8);
insert into accesos(rol_id, tarea_id) values (6, 9);
insert into accesos(rol_id, tarea_id) values (6, 10);
insert into accesos(rol_id, tarea_id) values (6, 11);
insert into accesos(rol_id, tarea_id) values (6, 12);
insert into accesos(rol_id, tarea_id) values (6, 13);
insert into accesos(rol_id, tarea_id) values (6, 14);
insert into accesos(rol_id, tarea_id) values (6, 15);
insert into accesos(rol_id, tarea_id) values (6, 16);
insert into accesos(rol_id, tarea_id) values (6, 17);
insert into accesos(rol_id, tarea_id) values (6, 18);
insert into accesos(rol_id, tarea_id) values (6, 19);

-- ESTUDIANTE ASISTENTE ACADÉMICA
insert into accesos(rol_id, tarea_id) values (7, 1);
insert into accesos(rol_id, tarea_id) values (7, 2);
insert into accesos(rol_id, tarea_id) values (7, 3);
insert into accesos(rol_id, tarea_id) values (7, 4);
insert into accesos(rol_id, tarea_id) values (7, 5);
insert into accesos(rol_id, tarea_id) values (7, 6);
insert into accesos(rol_id, tarea_id) values (7, 7);
insert into accesos(rol_id, tarea_id) values (7, 8);
insert into accesos(rol_id, tarea_id) values (7, 9);
insert into accesos(rol_id, tarea_id) values (7, 10);
insert into accesos(rol_id, tarea_id) values (7, 11);
insert into accesos(rol_id, tarea_id) values (7, 12);
insert into accesos(rol_id, tarea_id) values (7, 13);
insert into accesos(rol_id, tarea_id) values (7, 14);
insert into accesos(rol_id, tarea_id) values (7, 15);
insert into accesos(rol_id, tarea_id) values (7, 16);
insert into accesos(rol_id, tarea_id) values (7, 17);
insert into accesos(rol_id, tarea_id) values (7, 18);
insert into accesos(rol_id, tarea_id) values (7, 19);
insert into accesos(rol_id, tarea_id) values (7, 20);
insert into accesos(rol_id, tarea_id) values (7, 21);
insert into accesos(rol_id, tarea_id) values (7, 22);
insert into accesos(rol_id, tarea_id) values (7, 23);
insert into accesos(rol_id, tarea_id) values (7, 24);
insert into accesos(rol_id, tarea_id) values (7, 25);
insert into accesos(rol_id, tarea_id) values (7, 26);
insert into accesos(rol_id, tarea_id) values (7, 27);
insert into accesos(rol_id, tarea_id) values (7, 28);
insert into accesos(rol_id, tarea_id) values (7, 29);
insert into accesos(rol_id, tarea_id) values (7, 30);
insert into accesos(rol_id, tarea_id) values (7, 31);
insert into accesos(rol_id, tarea_id) values (7, 32);
insert into accesos(rol_id, tarea_id) values (7, 33);
insert into accesos(rol_id, tarea_id) values (7, 34);
insert into accesos(rol_id, tarea_id) values (7, 35);
insert into accesos(rol_id, tarea_id) values (7, 36);
insert into accesos(rol_id, tarea_id) values (7, 39);
insert into accesos(rol_id, tarea_id) values (7, 40);
insert into accesos(rol_id, tarea_id) values (7, 41);
insert into accesos(rol_id, tarea_id) values (7, 42);
insert into accesos(rol_id, tarea_id) values (7, 43);
insert into accesos(rol_id, tarea_id) values (7, 44);
insert into accesos(rol_id, tarea_id) values (7, 45);
insert into accesos(rol_id, tarea_id) values (7, 46);
insert into accesos(rol_id, tarea_id) values (7, 47);
insert into accesos(rol_id, tarea_id) values (7, 48);

-- PROCEDIMIENTO PARA INGRESAR TODOS LOS ACCESOS A UN ROL

DROP PROCEDURE IF EXISTS sigab.GET_TAREAS;
DELIMITER //
create procedure INSERTAR_TODAS_LAS_TAREAS(ArgId INT)
BEGIN
	DECLARE done BOOLEAN DEFAULT 0;
	DECLARE tarea_id INT;
	DECLARE tareas CURSOR FOR select id from tareas;
	DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done=1;
	OPEN tareas;
	REPEAT
		FETCH tareas INTO tarea_id;
        insert into accesos(rol_id,tarea_id) values (ArgId, tarea_id);
	UNTIL done END REPEAT;
    CLOSE tareas;
END;
 //
DELIMITER ;

-- ACADÉMICA RESPONSABLE DE SIGAB
call INSERTAR_TODAS_LAS_TAREAS(4);



insert into personas (persona_id, nombre, apellido, fecha_nacimiento, telefono_fijo, telefono_celular, correo_personal, correo_institucional, estado_civil, direccion_residencia, genero, imagen_perfil)
values ("401500844", "Jenny", "Ulate Montero", '1969-02-11', "22372096", "89986757", "jmontero692010@hotmail.com", "jenny.ulate.montero@una.ac.cr", "Soltera", "San Pedro de Barva, Heredia, 600 m este de la Iglesia Católica", "F" , "default.jpg");

insert into personas (persona_id, nombre, apellido, fecha_nacimiento, telefono_fijo, telefono_celular, correo_personal, correo_institucional, estado_civil, direccion_residencia, genero, imagen_perfil)
values ("107090236", "Lucrecia", "Barboza Jiménez", '1967-10-25', "", "83666946", "lucreciabj@hotmail.com", "lucrecia.barboza.jimenez@una.ac.cr", "Soltera", "Aserrí centro, 50 m sur del Banco Nacional, carretera a Cinco Esquinas", "F" , "default.jpg");

insert into personas (persona_id, nombre, apellido, fecha_nacimiento, telefono_fijo, telefono_celular, correo_personal, correo_institucional, estado_civil, direccion_residencia, genero, imagen_perfil)
values ("204770946", "Loireth", "Calvo Sánchez", '1971-12-06', "22393615", "83624159", "loirethc@gmail.com", "loirette.calvo.sanchez@una.ac.cr", "Casada", "San Antonio de Belén, Urbanización Veredas del Río. Casa número 30 ", "F" , "default.jpg");

insert into personas (persona_id, nombre, apellido, fecha_nacimiento, telefono_fijo, telefono_celular, correo_personal, correo_institucional, estado_civil, direccion_residencia, genero, imagen_perfil)
values ("110770945", "Freddy ", "Oviedo González", '1980-08-27', "25624243", "88110706", "foviedog@gmail.com", "foviedo@una.ac.cr", "Casado", "Santa Lucía de Barva, Heredia. Del consultorio del Dr.Naranjo 200 metros Este y 25 metros Sur.", "F" , "default.jpg");

insert into personas (persona_id, nombre, apellido, fecha_nacimiento, telefono_fijo, telefono_celular, correo_personal, correo_institucional, estado_civil, direccion_residencia, genero, imagen_perfil)
values ("108450068", "Ana Magally", "Campos Méndez", '1973-01-21', "22628427", "83420020", "magally.campos.mendez@una.cr", "magally.campos.mendez@una.cr", "Casada", "Heredia. Urbanización Monte Rosa. Casa 176 E", "F" , "default.jpg");



insert into personal (persona_id, cargo, grado_academico, tipo_nombramiento, tipo_puesto_1, tipo_puesto_2, jornada, lugar_trabajo_externo, anio_propiedad, experiencia_profesional, experiencia_academica, regimen_administrativo, regimen_docente, area_especializacion_1, area_especializacion_2)
values ("401500844", "Académico", "Maestría", 'Propietaria', "Docente", "Participante de PPAA", "Tiempo completo", "", "2019", "Asistente del Área de Circulación y Préstamo;Encargada de la Biblioteca Municipal Rafael A. Calderon Guardia;Encargada Centro Catalográfico (Bibliotecas Municipales)", 
"Tutora en la UNED;Docente en el 2010 de Escuela de Bibliotecología de la Universidad de Costa Rica;Docente de la Escuela de Bibliotecología de la Universidad Nacional", 
"", "Categoría 88 (Profesor Instructor Licenciado)", 
"Tratamiento de la Información", "" );

insert into personal (persona_id, cargo, grado_academico, tipo_nombramiento, tipo_puesto_1, tipo_puesto_2, jornada, lugar_trabajo_externo, anio_propiedad, experiencia_profesional, experiencia_academica, regimen_administrativo, regimen_docente, area_especializacion_1, area_especializacion_2)
values ("107090236", "Académico", "Maestría", 'Propietaria', "Docente", "Responsable de PPAA", "Tiempo completo", "", "2015", "Asistente en la Biblioteca de Ciencias Sociales (UCR);Asistente en la Biblioteca Asociación de Colegios del Medio Oeste (ACM);Asistente en la Biblioteca del Centro de Investigaciones en Tecnología de Alimentos (UCR);Bibliotecóloga de la Asociación Demográfica Costarricense;Encargada de biblioteca del Instituto Dr. Jaim Weizman;Encargada de Biblioteca del Colegio Internacional SOS Hermann Gmeiner;Bibliotecóloga del Proyecto Automatización del Centro de Documentación del Instituto Costarricense de Acueductos y Alcantarillados (AyA);Técnico asistente de la Biblioteca José Figueres Ferrer (ITCR);Encargada de biblioteca Escuela Libre de Derecho;Contrato laboral con la Biblioteca de Ciencias Sociales (UCR)", 
"Académica de la Escuela dee Bibliotecología, Documentación e Información de la Universidad Nacional desde el 2006", 
"", "Categoría 90 (Profesor II)", 
"Investigación", "Conservación y preservación de materiales");

insert into personal (persona_id, cargo, grado_academico, tipo_nombramiento, tipo_puesto_1, tipo_puesto_2, jornada, lugar_trabajo_externo, anio_propiedad, experiencia_profesional, experiencia_academica, regimen_administrativo, regimen_docente, area_especializacion_1, area_especializacion_2)
values ("204770946", "Académico", "Maestría", 'Propietaria', "Docente", "Responsable de PPA", "Tiempo completo", "", "2016", "Asistente en la Biblioteca de Ciencias Sociales (UCR);Asistente en la Biblioteca Asociación de Colegios del Medio Oeste (ACM);Asistente en la Biblioteca del Centro de Investigaciones en Tecnología de Alimentos (UCR);Bibliotecóloga de la Asociación Demográfica Costarricense;Encargada de biblioteca del Instituto Dr. Jaim Weizman;Encargada de Biblioteca del Colegio Internacional SOS Hermann Gmeiner;Bibliotecóloga del Proyecto Automatización del Centro de Documentación del Instituto Costarricense de Acueductos y Alcantarillados (AyA);Técnico asistente de la Biblioteca José Figueres Ferrer (ITCR);Encargada de biblioteca Escuela Libre de Derecho;Contrato laboral con la Biblioteca de Ciencias Sociales (UCR)",
 "Académica de Escuela de Bibliotecología de la Universidad Nacional; Docente Escuela de Bibliotecología Universidad de Costa Rica",
 "", "Categoría 90 (Profesor II)", 
 "Tratamiento de la Información", "");

insert into personal (persona_id, cargo, grado_academico, tipo_nombramiento, tipo_puesto_1, tipo_puesto_2, jornada, lugar_trabajo_externo, anio_propiedad, experiencia_profesional, experiencia_academica, regimen_administrativo, regimen_docente, area_especializacion_1, area_especializacion_2)
values ("110770945", "Administrativo ", "Maestría", 'Propietario', "Profesional Asistencial en Desarrollo Tecnológico", "", "Tiempo completo", "", "2015", "Instituto de Capacitación y Asesoría en Informática (ICAI) de la Universidad Nacional, Cargo Instructor de cursos de capacitación Diseño de páginas Web nivel principiante, 2004-2005, Paquete completo Web (Nivel I, II y III) 2007; Universidad Nacional, Decanato de la Facultad de Filosofía y Letras, 2004 al 2008, cargo: Profesor Instructor Bachiller; Participación en el proyecto de la Colección Bibliográfica Electrónica de la Escuela de Filosofía de la Universidad Nacional; Apoyo Informático y administrativo a las Unidades Académicas de la Facultad de Filosofía y Letras, soporte técnico, mantenimiento de equipos, Instalación y desarrollo de software; Profesional Asistencial en Desarrollo Tecnológico Del 2008 a la fecha.",
 "Periodo laborado: 2006 al 2014 Cursos impartidos en la Escuela de Bibliotecología, Documentación e Información, de la Universidad Nacional: Gestión de Recursos Tecnológicos;        Proyectos Tecnológicos; Teoría de Sistemas; Metodologías y Prácticas de Tecnologías de la Información y la Comunicación; Gestión de Tecnología de la Información y Comunicación; Sistemas Colaborativos para educación (Licenciatura en Bibliotecología pedagógica); Unidades de Información Documental Virtuales; Sistemas Colaborativos (Bachillerato en Bibliotecología y Documentación).",
 "Categoria 32", "", 
 "Tecnología e Innovación educativa", "");

insert into personal (persona_id, cargo, grado_academico, tipo_nombramiento, tipo_puesto_1, tipo_puesto_2, jornada, lugar_trabajo_externo, anio_propiedad, experiencia_profesional, experiencia_academica, regimen_administrativo, regimen_docente, area_especializacion_1, area_especializacion_2)
values ("108450068", "Administrativo", "Maestría", 'Propietaria', "Profesional Asistencial en Desarrollo Tecnológico", "", "Tiempo completo", "", "2005", "Operadora de Computadoras. Universidad Nacional Períodos de Matrícula Departamento de Registro;Operadora de Computadoras. Constructora Edificadora Roma Departamento de Contabilidad;Asistente Académico 1.Laboratorio de Oceanografía y Manejo Costero (LAOCOS). Universidad Nacional Procesamiento de Imágenes;Administradora de Novell 3.11. Laboratorio de Informática. Soporte de la Red Novell. Universidad Nacional;Administradora de Novell 4.10. Laboratorio de Informática. Soporte de la Red Novell. Universidad Nacional. Instalación y Mantenimiento de la Red Administración General (Usuarios, Seguridad etc.);Asistente Académico. Laboratorio Informática/Matemática. Soporte, mantenimiento de máquinas e instalación de programas. Universidad Nacional;Técnico2 en Informática. Centro de Cómputo. Capacitación Developer/2000 (Form Builder y Report Builder), Capacitación en Oracle9i Designer, Administradora de los Servidores de Imágenes y Archivos Proceso de Digitalización Universidad Nacional;Profesional Asistencial en Desarrollo Tecnológico. Escuela de Bibliotecología, Documentación e Información.",
 "Académica Curso de Teoría de Sistemas. BGE418. Escuela de Bibliotecología, Documentación e Información;Académica Curso Sistemas Colaborativos. BGE421. Escuela de Bibliotecología, Documentación e Información;Académica Curso Teoría de Sistemas BGE418 IV Nivel Tutoría. Escuela de Bibliotecología, Documentación e Información;Académica Curso Sistemas de Información. Nivel Licenciatura. Escuela de Bibliotecología, Documentación e Información;Lectora de la tesis denominada “Repositorio de las publicaciones técnico científicas en la comunidad de práctica sobre el enfoque ecosistémico en salud humana –América latina y el Caribe, Instituto Regional de Estudios en Sustancias Tóxicas, Universidad Nacional”;Lectora de la Tesis denominada “Repositorio de trabajos finales de graduación de la Universidad Central aprobados durante los años comprendidos del 2014 al 2016, Universidad Nacional." ,
 "Categoria 32", "", 
 "Administración de Proyectos Informáticos", "");




insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  1, "Estudio de la realidad nacional",  "Sesión sincrónica mediante Zoom", "Ejecutada", 2, '2019-05-20', '2019-05-20', 
"Los estudiantes abordaron temas tales como: aborto terapéutico, niñez, las cárceles, el alcoholismo discriminación social y cultural. A partir de estos temas se logra una toma de conciencia entre la comunidad estudiantil y la necesidad de contribuir desde la bibliotecología. Participación de 25 estudiantes",
"", "Concientizar a los estudiantes para que reflexionen acerca de temas como el aborto terapéutico, niños, alcoholismo y discriminación social y cultural",
"401500844","107090236");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  2, "Proceso de inducción a estudiantes de primer ingreso",  "Facultad de Filosofía y Letras", "Ejecutada", 3, '2019-02-19', '2019-02-19', 
"","", "","204770946","110770945");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  3, "Curso/taller sobre Microsoft Teams",  "Sesión sincrónica mediante Zoom", "Ejecutada", 6, '2020-09-07', '2020-09-09', 
"Capacitación al personal docente de la EBDI. Participación de 11 docentes.","", "","108450068","401500844");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  4, "Taller: uso de herramientas tecnológicas para la docencia",  "Sesión sincrónica mediante Zoom", "Ejecutada", 10, '2020-02-19', '2020-02-26', 
"Capacitación al personal docente de la EBDI. Participación de 11 docentes.","", "","401500844","107090236");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  5, "Curso Classroom para docentes",  "Sesión sincrónica mediante Zoom", "Ejecutada", 3, '2020-09-02', '2020-09-02', 
"Capacitación al personal docente de la EBDI. Participación de 10 docentes.",
"", "Contribuir al formatalecimiento de las competencias académicas con respecto al manejo de herramientas para mediar pedagogicamente con las TIC","107090236","204770946");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  6, "Escritura académica con énfasis en artículos científicos",  "Aula tecnológiga (Facultad de Filosofía y Letras)", "Ejecutada", 16, '2020-09-30', '2020-10-01', 
"Capacitación al personal docente de la EBDI. Participación de 11 docentes.", "", "","110770945","108450068");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  7, "Capacitación sobre las bases de datos del SIDUNA, el OPAC, libros y revistas electrónicos",  "Facultad de Filosofía y Letras", "Ejecutada", 2, '2019-04-17', '2019-04-17', 
"Curso/taller a estudiantes regulares, egresados y graduados de la EBDI. Participación 25 estudiantes",
"", "Cumplir con la directriz institucional para el uso de los recursos del SIDUNA y fortalecer las habilidades del estudiantado.",
"107090236","401500844");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  8, "Charla sobre el Centro Regional de Información sobre Desastres para América Latina y el Caribe",  "Facultad de Filosofía y Letras", "Ejecutada", 2, '2019-04-16', '2019-04-18', 
"Charla sobre el Centro Regional de Información sobre Desastres para América Latina y el Caribe",
"", "Fortalecer las habilidades del estudiantado.",
"110770945","204770946");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  9, "Feria informativa Puertas Abiertas para estudiantes de undécimo año de todo el país",  "CIDE-UNA", "Ejecutada", 2, '2020-11-15', '2020-11-15', 
"Informar al estudiantado de undécimo año de la oferta académica de la EBDI",
"", "",
"204770946","204770946");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  10, "Visita a colegios",  "Colegios públicos y privados", "En ejecución", 2, '2020-03-16', '2019-11-15', 
"Promocionar la carrera de Bibliotecología y Gestión de la Información en los colegios de secundaria",
"", "",
"401500844","107090236");

insert into actividades ( id, tema, lugar, estado, duracion, fecha_inicio_actividad, fecha_final_actividad, descripcion, evaluacion, objetivos, responsable_coordinar, creada_por)
values (  11, "Uso de redes sociales",  "Plataformas de: Facebook, Instangram y Sitio Web de la EBDI", "En ejecución", 2, '2020-03-15', '2020-11-15', 
"Propiciar una efectiva comunicación con los diferentes actores que conforman la comunidad EBDI (estudiantes, personal docente, personal administrativo, población graduada, empleadores y público en general) mediante el uso de las redes sociales para el fortalecimiento de los vínculos entre estas poblaciones y la Escuela",
"", "",
"108450068","110770945");




insert into actividades_internas ( actividad_id, tipo_actividad, proposito, agenda, ambito, certificacion_actividad, publico_dirigido, recursos)
values ( 1, "Actividad cocurricular", "Otro",  
"Saludo y bienvenida; Instrucciones para participar de la actividad: Entrega de protocolo para participar en foro en el aula virtual; Espacio para preguntas y comentarios; Cierre", 
"Nacional", "No Aplica", "Estudiantes regulares", "Computadora; conexión a Internet; plataforma Zoom; Lecturas; Aula virtual institucional");

insert into actividades_internas ( actividad_id, tipo_actividad, proposito, agenda, ambito, certificacion_actividad, publico_dirigido, recursos)
values ( 2, "Curso", "Otro",  "", "Nacional", "No Aplica", "Estudiantes de primer ingreso", "");

insert into actividades_internas ( actividad_id, tipo_actividad, proposito, agenda, ambito, certificacion_actividad, publico_dirigido, recursos)
values ( 3, "Curso", "Otro",  "Tareas; Chat; Llamadas; Equipos", "Nacional", "No Aplica", "Personal docente de la EBDI", 
"Invitación; instructivo; computadora; plataforma Microsoft Teams; conexión a internet");

insert into actividades_internas ( actividad_id, tipo_actividad, proposito, agenda, ambito, certificacion_actividad, publico_dirigido, recursos)
values ( 4, "Curso", "Otro",  "Herramientas del aula virtual (Asistencia, Grupos, Wiki, Glosario, lección, taller, cuestionario, insertar audio y url)", 
"Nacional", "No Aplica", "Personal docente de la EBDI", "");

insert into actividades_internas ( actividad_id, tipo_actividad, proposito, agenda, ambito, certificacion_actividad, publico_dirigido, recursos)
values ( 5, "Curso", "Otro",  "Google Classroom", "Nacional", "No Aplica", "Personal docente de la EBDI", 
"Invitación; instructivo; computadora; plataforma Zoom; conexión a internet");

insert into actividades_internas ( actividad_id, tipo_actividad, proposito, agenda, ambito, certificacion_actividad, publico_dirigido, recursos)
values ( 6, "Taller", "Otro",  "Módulo 1: Aspectos introducctorios Módulo 2: Sistemas de citación y elementos para evaluar artículos científicos", 
"Nacional", "No Aplica", "Personal docente de la EBDI", "Invitación; Presentaciones PowerPoint; computadora; conexión a internet; proyección multimedia");

insert into actividades_internas ( actividad_id, tipo_actividad, proposito, agenda, ambito, certificacion_actividad, publico_dirigido, recursos)
values ( 7, "Charlar", "Otro",  "",  "Nacional", "No Aplica", "Estudiantes regulares, egresados y graduados", 
"Invitación; Presentaciones PowerPoint; computadora; conexión a internet; proyección multimedia");

insert into actividades_internas ( actividad_id, tipo_actividad, proposito, agenda, ambito, certificacion_actividad, publico_dirigido, recursos)
values ( 8, "Charla", "Otro",  "", "Nacional", "No Aplica", "Estudiantes regulares", "");




insert into actividades_promocion ( actividad_id, tipo_actividad, recursos, instituciones_patrocinadoras)
values ( 9, "Promoción de la carrera", "Desplegables con el plan de estudios; banner de la carrera; vídeo sobre la carrera; proyector multimedia; computadora",  
 "Universidad Nacional");

insert into actividades_promocion ( actividad_id, tipo_actividad, recursos, instituciones_patrocinadoras)
values ( 10, "Promoción de la carrera", "Desplegables con el plan de estudios; banner de la carrera; vídeo sobre la carrera; infografía, presentación Power Point; presentación Prezi; proyector multimedia; computadora", 
  "Escuela de Bibliotecología, Documentación e Información");

insert into actividades_promocion ( actividad_id, tipo_actividad, recursos, instituciones_patrocinadoras)
values ( 11, "Promoción de la carrera", "Videos; imágenes; frases, articulos; comunicaciones oficiales; manuales; bolsa de empleo; foros digitales; documentos de pruebas de grado", 
  "Escuela de Bibliotecología, Documentación e Información");
