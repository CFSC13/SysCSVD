<?php
set_time_limit(0);
include("includes/conexion.php");
conectar();

for($compra=1;$compra<10;$compra++)
{
	$id_compra=$id_compra+1;
	$precio_compra= rand(200,600); 
    $cantidad= rand(5,10);
    $sql_compra="insert into syscsvd_detalles_compras (id_compra, id_producto, precio_compra, cantidad, subtotal) values (".$id_compra.",'".rand(16,18)."','".$precio_compra."', '".$cantidad."','".$precio_compra*$cantidad."')";
    echo $sql_compra;
    $sql_v=mysqli_query($con, $sql_compra);

	$sql_compras="insert into syscsvd_compras (id_compra, importe_total, fecha_compra, id_usuario) values (".$id_compra.",'".$precio_compra*$cantidad."','".fecha_aleatoria()."', 1)";
	echo $sql_compras;
	$sql_d=mysqli_query($con, $sql_compras);
}

function fecha_aleatoria($formato = "Y-m-d", $limiteInferior = "2023-09-01", $limiteSuperior = "2023-09-27"){
	// Convertimos la fecha como cadena a milisegundos
	$milisegundosLimiteInferior = strtotime($limiteInferior);
	$milisegundosLimiteSuperior = strtotime($limiteSuperior);

	// Buscamos un número aleatorio entre esas dos fechas
	$milisegundosAleatorios = mt_rand($milisegundosLimiteInferior, $milisegundosLimiteSuperior);

	// Regresamos la fecha con el formato especificado y los milisegundos aleatorios
    return date($formato, $milisegundosAleatorios);
}