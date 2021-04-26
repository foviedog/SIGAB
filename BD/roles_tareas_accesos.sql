use sigab;
select * from roles;
select * from tareas;
select * from accesos;
select * from personas;
select * from users;
select * from notifications;

update users set rol = '7' where persona_id = '5678';

insert into roles(nombre) values("Dirección");
insert into roles(nombre) values("Subdirección");
insert into roles(nombre) values("Académica responsable de Aseguramiento de la Calidad de la Carrera");
insert into roles(nombre) values("Académica responsable de SIGAB");
insert into roles(nombre) values("Asistente administrativa");
insert into roles(nombre) values("Secretaria");
insert into roles(nombre) values("Estudiante asistente académica");

						
insert into tareas(nombre) values("Realizar búsquedas de actividades");
insert into tareas(nombre) values("Visualizar información detallada de actividad");
insert into tareas(nombre) values("Visualizar lista de participantes (asistencia) en actividades");
insert into tareas(nombre) values("Verificar listado de actividades registradas");
insert into tareas(nombre) values("Visualizar cargas académicas");
insert into tareas(nombre) values("Listar cargas académicas del personal");
insert into tareas(nombre) values("Listar personal");
insert into tareas(nombre) values("Realizar búsquedas del personal");
insert into tareas(nombre) values("Visualizar información del personal");
insert into tareas(nombre) values("Listar estudiantes");
insert into tareas(nombre) values("Visualizar información laboral de estudiantes");
insert into tareas(nombre) values("Visualizar lista de trabajos de estudiantes");
insert into tareas(nombre) values("Visualizar listado de titulaciones");
insert into tareas(nombre) values("Realizar búsquedas de estudiantes");
insert into tareas(nombre) values("Visualizar información detallada de estudiantes");
insert into tareas(nombre) values("Listar estudiantes graduados");
insert into tareas(nombre) values("Realizar búsquedas de estudiantes graduados");
insert into tareas(nombre) values("Visualizar guías académicas");
insert into tareas(nombre) values("Descargar documentos");
insert into tareas(nombre) values("Registrar una nueva actividad");
insert into tareas(nombre) values("Autorizar una actividad");
insert into tareas(nombre) values("Modificar información de actividades");
insert into tareas(nombre) values("Agregar participantes en actividades");
insert into tareas(nombre) values("Agregar documentos (evidencias) de actividades");
insert into tareas(nombre) values("Registrar personal");
insert into tareas(nombre) values("Modificar información del personal");
insert into tareas(nombre) values("Generar informes y estadísticas");
insert into tareas(nombre) values("Eliminar documentos");
insert into tareas(nombre) values("Registrar estudiantes");
insert into tareas(nombre) values("Registrar información laboral de estudiantes");
insert into tareas(nombre) values("Modificar información laboral de estudiantes");
insert into tareas(nombre) values("Registrar titulaciones de estudiantes");
insert into tareas(nombre) values("Modificar titulaciones de estudiantes");
insert into tareas(nombre) values("Modificar información de estudiantes");
insert into tareas(nombre) values("Agregar guías académicas");
insert into tareas(nombre) values("Adjuntar evidencias a guías académicas");
insert into tareas(nombre) values("Agregar cargas académicas");
insert into tareas(nombre) values("Modificar cargas académicas");

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

call INSERTAR_TODAS_LAS_TAREAS(1);

-- SECRETARIA
insert into accesos(rol_id, tarea_id) values (7, 3);
insert into accesos(rol_id, tarea_id) values (7, 5);
insert into accesos(rol_id, tarea_id) values (7, 7);
insert into accesos(rol_id, tarea_id) values (7, 9);
insert into accesos(rol_id, tarea_id) values (7, 10);
insert into accesos(rol_id, tarea_id) values (7, 13);
insert into accesos(rol_id, tarea_id) values (7, 14);
insert into accesos(rol_id, tarea_id) values (7, 16);
insert into accesos(rol_id, tarea_id) values (7, 17);
insert into accesos(rol_id, tarea_id) values (7, 19);
-- insert into accesos(rol_id, tarea_id) values (7, 21);
insert into accesos(rol_id, tarea_id) values (7, 24);
insert into accesos(rol_id, tarea_id) values (7, 25);
insert into accesos(rol_id, tarea_id) values (7, 28);
insert into accesos(rol_id, tarea_id) values (7, 30);
insert into accesos(rol_id, tarea_id) values (7, 31);
insert into accesos(rol_id, tarea_id) values (7, 32);
insert into accesos(rol_id, tarea_id) values (7, 33);
insert into accesos(rol_id, tarea_id) values (7, 35);
insert into accesos(rol_id, tarea_id) values (7, 38);

