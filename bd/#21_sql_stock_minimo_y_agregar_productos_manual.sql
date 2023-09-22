--agregar un atributo a una tabla
ALTER TABLE productos
ADD COLUMN stock_minimo int(11);



--agregar un item del menu (para este grupo creado)
INSERT INTO items_interno (nombre_item, url, id_grupo) VALUES ('stock mínimo', 'stock_minimo.php', (select id_grupo from grupos_menu where nombre_grupo='consultas'));