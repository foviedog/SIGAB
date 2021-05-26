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

DROP PROCEDURE IF EXISTS sigab.INSERTAR_TODAS_LAS_TAREAS;
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