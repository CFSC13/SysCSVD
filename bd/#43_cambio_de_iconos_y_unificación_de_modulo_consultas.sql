# cambio de iconos y unificación de modulo consultas #43

#Se eliminó el grupo reportes y también el item reportes estadísticos.
DELETE FROM syscsvd_grupos_menu WHERE nombre_grupo = 'reportes';

DELETE FROM syscsvd_items_interno WHERE url = 'stock_minimo.php';

#se agregó el ítem reportes estadísticos al grupo consulta.
INSERT INTO syscsvd_items_interno (nombre_item, url, id_grupo) VALUES ('Reportes', 'reportes.php', (select id_grupo from syscsvd_grupos_menu where nombre_grupo='consultas'))

#Se cambio el icono de grupo consultas
UPDATE syscsvd_grupos_menu SET icono = 'fa fa-line-chart' WHERE nombre_grupo = 'consultas'


#se agregó el ítem reportes estadísticos al grupo consulta.
INSERT INTO syscsvd_items_interno (nombre_item, url, id_grupo) VALUES ('Atencion al cliente', 'attecliente_catalogo.php', (select id_grupo from syscsvd_grupos_menu where nombre_grupo='consultas'))


