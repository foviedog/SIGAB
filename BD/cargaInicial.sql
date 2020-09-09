use sigab;
select * from users;
select * from `users` where `persona_id` = '1234' limit 1;

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
select * from personas;


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
select * from estudiantes;