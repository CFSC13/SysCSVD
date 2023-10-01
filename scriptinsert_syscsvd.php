<?php
set_time_limit(0);
include("includes/conexion.php");
conectar();

if(empty($id_venta)){
	$id_venta=0;
}

for($venta=1;$venta<400;$venta++)
{
	$id_venta=$id_venta+1;
	$importe_total= rand(2500,4000); 
    $sql_venta="insert into syscsvd_ventas (id_venta, fecha_de_venta, importe_total, id_usuario) values (".$id_venta.",'".fecha_aleatoria()."','".$importe_total."', 1)";
    echo $sql_venta;
    $sql_v=mysqli_query($con, $sql_venta);

	$cantidad= rand(1,3);
	$sql_detalle="insert into syscsvd_detalle_ventas (cantidad, precio_unitario, subtotal, id_producto, id_venta) values (".$cantidad.",'".$importe_total/$cantidad."','".$importe_total."','".rand(16,18)."',".$id_venta.")";
	echo $sql_detalle;
	$sql_d=mysqli_query($con, $sql_detalle);
}

function fecha_aleatoria($formato = "Y-m-d", $limiteInferior = "2020-01-01", $limiteSuperior = "2023-10-27"){
	// Convertimos la fecha como cadena a milisegundos
	$milisegundosLimiteInferior = strtotime($limiteInferior);
	$milisegundosLimiteSuperior = strtotime($limiteSuperior);

	// Buscamos un número aleatorio entre esas dos fechas
	$milisegundosAleatorios = mt_rand($milisegundosLimiteInferior, $milisegundosLimiteSuperior);

	// Regresamos la fecha con el formato especificado y los milisegundos aleatorios
    return date($formato, $milisegundosAleatorios);
}