--cambio de iconos y unificación de modulo consultas #43


--Se eliminó el grupo reportes y también el item reportes estadísticos.
DELETE FROM grupos_menu WHERE nombre_grupo = 'reportes';


-- se agregó el ítem reportes estadísticos al grupo consulta.
INSERT INTO items_interno (nombre_item, url, id_grupo) VALUES ('Reportes', 'reportes.php', (select id_grupo from grupos_menu where nombre_grupo='reportes'));

-- Se cambio el icono de grupo consultas

UPDATE grupos_menu SET icono = 'fa fa-line-chart' WHERE nombre_grupo = 'consultas';

