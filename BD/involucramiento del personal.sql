use sigab;

select
  `actividades`.`id`,
    `actividades`.`tema`,
  `lista_asistencias`.`persona_id`,
  `actividades`.`responsable_coordinar`,
  `actividades_internas`.`tipo_actividad`,
  `actividades`.`estado`,
  year(`actividades`.`fecha_final_actividad`) ANIO
from
  `lista_asistencias`
  inner join `actividades` on `actividades`.`id` = `lista_asistencias`.`actividad_id`
  inner join `actividades_internas` on `actividades_internas`.`actividad_id` = `lista_asistencias`.`actividad_id`
  where lista_asistencias.persona_id != actividades.responsable_coordinar;

select
  `lista_asistencias`.`actividad_id` as aggregate,
  `lista_asistencias`.`persona_id` LI,
  `actividades`.`responsable_coordinar` RS
from
  `lista_asistencias`
  inner join `actividades` on `actividades`.`id` = `lista_asistencias`.`actividad_id`
  inner join `actividades_internas` on `actividades_internas`.`actividad_id` = `lista_asistencias`.`actividad_id`
where
  (
    `lista_asistencias`.`persona_id` = '110770945'
    or `actividades`.`responsable_coordinar` = '110770945 '
  )
  and lista_asistencias.persona_id != actividades.responsable_coordinar
  and `actividades_internas`.`tipo_actividad` like '%Simposio%'
  and (
    `actividades`.`estado` = 'Ejecutada'
    or `actividades`.`estado` = 'En progreso'
  )
  and year(`actividades`.`fecha_final_actividad`) = '2021';


select al.id asistente, ap.id responsable, per.persona_id  from personal per
	inner join `lista_asistencias` on `lista_asistencias`.`persona_id` = per.`persona_id`
	inner join `actividades` al on al.`id` = `lista_asistencias`.`actividad_id`
	inner join `actividades` ap on ap.`responsable_coordinar` = per.`persona_id`
	inner join `actividades_internas` aiAsitencia on aiAsitencia.`actividad_id` = al.`id`
	inner join `actividades_internas` aiResponsable on aiResponsable.`actividad_id` = ap.`id`
    where al.id != ap.id
    and lista_asistencias.persona_id =  '110770945 ';
  
select lista_asistencias.actividad_id 
from lista_asistencias
where lista_asistencias.persona_id =  '110770945 ';

select actividades.id
from actividades
where actividades.responsable_coordinar =  '110770945 ';

select  actividades.id responsable, lista_asistencias.actividad_id asistente
from actividades a,lista_asistencias li
where a.responsable_coordinar =  '110770945 '
and li.persona_id =  '110770945 '
and actividades.id != lista_asistencias.actividad_id;


select a.id
from personal p
inner join actividades a on a.responsable_coordinar =  p.persona_id
where p.persona_id = '110770945';

select distinct a.id as aggregate
from actividades a
inner join lista_asistencias li on li.actividad_id=  a.id
inner join actividades_internas ai on ai.actividad_id =  a.id
where a.responsable_coordinar = '110770945'
or li.persona_id = '110770945'
and ai.`tipo_actividad` like '%Simposio%'
  and (
   a.`estado` = 'Ejecutada'
    or a.`estado` = 'En progreso'
  )
  and year(a.`fecha_final_actividad`) = '2021';


select * from actividades;


select distinct
   `actividades`.`id` id,  `actividades_internas`.`tipo_actividad`,`actividades`.`tema`, `actividades`.`fecha_inicio_actividad`, `actividades`.`fecha_final_actividad`
from
  `actividades`
  left join `lista_asistencias` on `lista_asistencias`.`actividad_id` = `actividades`.`id`
  inner join `actividades_internas` on `actividades_internas`.`actividad_id` = `actividades`.`id`
where
  (
    `actividades`.`responsable_coordinar` = 'asdasd'
     or `lista_asistencias`.`persona_id` = 'asdasd'
  )
  and (
    `actividades`.`estado` = 'Ejecutada'
    or `actividades`.`estado` = 'En progreso'
  )
  and year(`actividades`.`fecha_inicio_actividad`) = '2021'
  and (month(`actividades`.`fecha_inicio_actividad`) between '01'and '06')
