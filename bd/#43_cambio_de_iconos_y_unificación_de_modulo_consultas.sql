--cambio de iconos y unificación de modulo consultas #43

--agregar un atributo a una tabla
ALTER TABLE productos
ADD COLUMN id_test integer;

--agregar un grupo del menu
INSERT INTO grupos_menu (id_grupo, nombre_grupo, icono) VALUES (NULL, 'consultas', 'as fa-cart-plus');

--agregar un item del menu (para este grupo creado)
INSERT INTO items_interno (nombre_item, url, id_grupo) VALUES ('catálogo', 'consulta_catalogo.php', (select id_grupo from grupos_menu where nombre_grupo='consultas'));

--agrego el permiso para ver el item al usuario admin (el id del usuario es siempre 1 -para este caso-)
INSERT INTO items_x_usuario (id_item, id_usuario) VALUES ((select id_item from items_interno where nombre_item='catálogo'),1);


--Se eliminó el grupo reportes y también el item reportes estadísticos.
DELETE FROM grupos_menu WHERE nombre_grupo = 'reportes';


-- se agregó el ítem reportes estadísticos al grupo consulta.
INSERT INTO items_interno (nombre_item, url, id_grupo) VALUES ('Reportes', 'reportes.php', (select id_grupo from grupos_menu where nombre_grupo='reportes'));

-- Se cambio el icono de grupo consultas
