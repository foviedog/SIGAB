use sigab;
select * from users;
select * from `users` where `persona_id` = '1234' limit 1;
-- =======================================================
-- 							PERSONAS
-- =======================================================
-- <---------------------------------------->
-- 			Insert de personas 
-- <---------------------------------------->
insert into personas 
values (
'11121312',
'Andres',
'Aguilar Rojas',
sysdate(),
'22548891',
'88914892',
'andres@example.com',
'andres@una.ac.cr',
'soltero',
'Hatillo',
'masculino',
sysdate(),
sysdate()
);
-- <---------------------------------------->
insert into personas 
values (
'2312312312',
'Iván',
'Chinchilla Córdoba',
sysdate(),
'22548891',
'88914892',
'chinchilla@gmail.com',
'ivan.chichilla.córdoba@est.una.ac.cr',
'soltero',
'Heredia',
'Masculino',
sysdate(),
sysdate()
);
-- <---------------------------------------->
insert into personas 
values (
'31231241231',
'Oscar',
'Alvarado Gutiérrez',
sysdate(),
'22548891',
'88914892',
'osma9524@gmail.com',
'oscar.alvarado.gutierrez@est.una.ac.cr',
'soltero',
'Heredia',
'Masculino',
sysdate(),
sysdate()
);
-- <---------------------------------------->
insert into personas 
values (
'41231231231',
'Stacy',
'Gonzáles Santamaría',
sysdate(),
'22548891',
'88914892',
'stay98@gmail.com',
'stacy.gonzales.santamaria@est.una.ac.cr',
'soltera',
'Aserrí, Alajuela',
'Femenina',
sysdate(),
sysdate()
);
-- <---------------------------------------->
insert into personas 
values (
'123412312',
'HOLA',
'OTRO 2',
sysdate(),
'22548891',
'88914892',
'HOA@example.com',
'HOA@una.ac.cr',
'soltero',
'Hatillo',
'masculino',
sysdate(),
sysdate()
);
-- <---------------------------------------->
insert into personas 
values (
'ASD123123',
'HOLA',
'OTRO 2',
sysdate(),
'22548891',
'88914892',
'ASDA@example.com',
'ASDAS@una.ac.cr',
'soltero',
'Hatillo',
'masculino',
sysdate(),
sysdate()
);


-- <---------------------------------------->
-- 			Select de personas
-- <---------------------------------------->
select * from personas;

-- =======================================================
-- 							ESTUDIANTES
-- =======================================================
-- <---------------------------------------->
-- 			Insert de estudiantes 
-- <---------------------------------------->
insert into estudiantes 
values ('11121312', 
'A la par de CopyChalo Segundo piso.',
 0,
 'Privado',
 'Ninguna',
 sysdate(),
 sysdate(),
 'Bibliotecología',
 'Ciencias de la computación', 
2024,
2021,
2024,
'2',
713,
'sí',
0,
sysdate(),
sysdate());
-- <---------------------------------------->

insert into estudiantes 
values ('2312312312', 
'A la par de CopyChalo Segundo piso.',
 0,
 'Privado',
 'Ninguna',
 sysdate(),
 sysdate(),
 'Educación física',
 'Artes', 
2024,
2021,
2024,
'2',
713,
'sí',
0,
sysdate(),
sysdate());

-- <---------------------------------------->
insert into estudiantes 
values ('31231241231', 
'A la par de CopyChalo Segundo piso.',
 0,
 'Privado',
 'Ninguna',
 sysdate(),
 sysdate(),
 'Escultura',
 'Ciencias de la computación', 
2024,
2021,
2024,
'2',
713,
'sí',
0,
sysdate(),
sysdate());
-- <---------------------------------------->
insert into estudiantes 
values ('41231231231', 
'A la par de CopyChalo Segundo piso.',
 0,
 'Privado',
 'Ninguna',
 sysdate(),
 sysdate(),
 'Música',
 'Ciencias de la computación', 
2024,
2021,
2024,
'2',
713,
'sí',
0,
sysdate(),
sysdate());
-- <---------------------------------------->
insert into estudiantes 
values ('123412312', 
'A la par de CopyChalo Segundo piso.',
 0,
 'Privado',
 'Ninguna',
 sysdate(),
 sysdate(),
 'Bibliotecología',
 'Ciencias de la computación', 
2024,
2021,
2024,
'2',
713,
'sí',
0,
sysdate(),
sysdate());
-- <---------------------------------------->
insert into estudiantes 
values ('ASD123123', 
'A la par de CopyChalo Segundo piso.',
 0,
 'Privado',
 'Ninguna',
 sysdate(),
 sysdate(),
 'Bibliotecología',
 'Ciencias de la computación', 
2024,
2021,
2024,
'2',
713,
'sí',
0,
sysdate(),
sysdate());


-- <------------
-- <----------------FIN DE INGRESO DE ESTUDIANTES------------------------>

-- <---------------------------------------->
-- 			Select de estudiantes 
-- <---------------------------------------->
select * from estudiantes;