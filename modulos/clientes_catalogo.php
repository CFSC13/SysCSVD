<?php
include("../includes/conexion.php");
conectar();

error_reporting(E_ALL);
ini_set('display_errors', '0');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SysCSVD - Sistema de Gestión">
    <meta name="author" content="ADM">
    <title>SysCSVD - Catalogo de Productos</title>
</head>
<body>
    <h1 id="titulo">Catálogo de Productos</h1> 
    <table style="width: 100%; ">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoria</th>
                <th>Marca</th>
                <th>Libreria</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoria</th>
                <th>Marca</th>
                <th>Libreria</th>

            </tr>
        </tfoot>
        <tbody>
        <?php $q=mysqli_query($con,"SELECT P.id_producto, P.foto, P.Nombre as 'NombreP', P.Precio as 'PrecioP', P.stock as 'StockP', P.codigo_barra as 'codigo_barraP',
                                    C.Nombre as 'NonbreC', M.nombre as 'marca', libreria
                                    FROM syscsvd_productos P 
                                    JOIN syscsvd_categorias C 
                                    ON P.id_categoria = C.id_categoria
                                    JOIN syscsvd_marcas M 
                                    ON P.id_marca = M.id_marca
                                    order by P.nombre;");  
            if(mysqli_num_rows($q)!=0){
                while($r=mysqli_fetch_array($q)){?>
                    <tr>
                        <td><?php echo $r['NombreP']; ?></td>
                        <td>$ <?php echo number_format($r['PrecioP'],2,',','.'); ?></td>
                        <td><?php echo $r['NonbreC']; ?></td>
                        <td><?php echo $r['marca']; ?></td>
                        <td><?php 
                            if($r['libreria']==1){
                                echo "Si";
                            } else{
                                echo "No";
                            } ?>
                        </td>
                    </tr>                                                   
                <?php }
                }?>       
                                            
        </tbody>
    </table>
</body>

<style>
    *{
        font-family: sans-serif;
        color: #292E49;
    }
    table, th, td{
        font-size: 12px;
    }
    th, td{
        padding: 1%;
    }
    td{
        background: #D6EAF8 ;
        font-weight: bold;
    }
    th{
        background: linear-gradient(#4286f4,#6DD5FA);
        border-radius: 5px; 
        color: #E5E7E9 ;
    }
    body{
        text-align: center;
        align-items: center;
        min-height: 100vh;
        background: #EAEDED ;
    }
    #titulo{
        font-family: arial;
        padding-top:2%;
        padding-bottom:1%;
        border-bottom: 1px solid #CCD1D1 ;
    }
</style>