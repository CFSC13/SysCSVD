<?php
 session_start();
 if($_SESSION[user]==0)
 {
     echo "<script>window.location='index.php';</script>";
 }
?>
 
<!---------------------------------GRAFICO BARRAS--------------------------------------->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<!------------------------------------------------------------------------------------------>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 id="titulo" class="h3 mb-0 text-gray-800">Informes</h1>
    </div>

    <style>
        #titulo{
            font-size: 35px;
            float: left;
            width: 100%;
            text-align: center;
        }
    </style>

    <!-- Content Row -->
    <div class="row">
        <?php $s=mysqli_query($con,"SELECT * FROM syscsvd_ventas WHERE YEAR(fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(fecha_de_venta)  = MONTH(CURRENT_DATE());") ?> 
        <!--SQL FECHA ACTUAL: SELECT * FROM syscsvd_ventas WHERE YEAR(fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(fecha_de_venta)  = MONTH(CURRENT_DATE())-->
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Ventas del Mes</div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo mysqli_num_rows($s) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>   <!--UTILIZAR ESTE GRAFICO-->

        
        <!-- Ganacias del mes actual -->
        <?php 
            $precio_venta= mysqli_query($con,"SELECT sum(d.subtotal) as SubtotalVentas from syscsvd_ventas v join syscsvd_detalle_ventas d on v.id_venta = d.id_venta WHERE YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(v.fecha_de_venta)  = MONTH(CURRENT_DATE());"); 
            $r_precio_venta=mysqli_fetch_array($precio_venta);

            $precio_compra= mysqli_query($con,"SELECT sum(d.subtotal) as SubtotalCompras from syscsvd_compras c join syscsvd_detalles_compras d on c.id_compra = d.id_compra WHERE YEAR(c.fecha_compra) = YEAR(CURRENT_DATE()) AND MONTH(c.fecha_compra)  = MONTH(CURRENT_DATE());");
            $r_precio_compra=mysqli_fetch_array($precio_compra);

            $ganancia_mes= $r_precio_venta['SubtotalVentas'] - $r_precio_compra['SubtotalCompras'];
        ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ganacias del mes actual</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo number_format($ganancia_mes, 2, '.', ','); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Productos en Inventario -->
        <?php
            $cantidad_productos= mysqli_query($con,"SELECT count(id_producto) as CantidadProductos from syscsvd_productos;");
            $r_cantidad_productos=mysqli_fetch_array($cantidad_productos);
        ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Productos en Inventario
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $r_cantidad_productos['CantidadProductos']; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Productos de libreria en inventario -->
        <?php
            $cantidad_productos_libreria= mysqli_query($con,"SELECT count(id_producto) as CantidadLibreria from syscsvd_productos where libreria=1;");
            $r_cantidad_productos_libreria=mysqli_fetch_array($cantidad_productos_libreria);
        ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Productos de libreria en Inventario</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $r_cantidad_productos_libreria['CantidadLibreria']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

<div id="contgraficos">
    <div class="divgraficos">
        <figure class="highcharts-figure-barras">
            <div id="container_barras"></div>

            <table hidden id="datatable-barras">
                <?php
                    $etiquetas_barras=mysqli_query($con,"SELECT p.id_producto, p.nombre as Producto,  SUM(d.cantidad) as Cantidad from syscsvd_detalle_ventas d join syscsvd_productos p on d.id_producto = p.id_producto group by p.nombre;") //agrupar datos con GROUP BY por year, month, wekk?>
                            <thead>
                                <tr> 
                                    <th></th>  <!--DEBE QUEDAR VACIO, SI SE CREAN MAS VACIOS SE ROMPE-->
                                    <?php  while($r_etiquetas_barras=mysqli_fetch_array($etiquetas_barras)){ ?>
                                    <th><?php echo $r_etiquetas_barras['Producto']; ?></th> <!--Producto 1--> 
                                    <?php } ?> 
                                </tr>
                            </thead>
                            <?php $anios_barras=mysqli_query($con,"SELECT YEAR(v.fecha_de_venta) as Anio,  SUM(d.cantidad) as Cantidad from syscsvd_ventas v join syscsvd_detalle_ventas d on v.id_venta = d.id_venta group by Anio;"); ?>       
                            <tbody>
                                <?php if(mysqli_num_rows($anios_barras)!=0){ ?>
                                            <?php  while($r_anios_barras=mysqli_fetch_array($anios_barras)){ ?>
                                <tr>
                                    <th> <?php echo $r_anios_barras['Anio']; ?></th> <!--Año-->
                                    <?php //bucle de productos/etiquetas
                                            mysqli_data_seek($etiquetas_barras, 0);
                                            while($r_etiquetas_barras=mysqli_fetch_array($etiquetas_barras))
                                            { 
                                                $ganancias_anios_barras=mysqli_query($con,"SELECT p.nombre as Producto, YEAR(v.fecha_de_venta) as Anio, SUM(d.cantidad) as Cantidad, d.precio_unitario as PrecioDeVenta, d.precio_unitario*SUM(d.cantidad) as Subtotal, c.precio_compra*SUM(d.cantidad) as Costo, ROUND(((d.precio_unitario*SUM(d.cantidad))-(c.precio_compra*SUM(d.cantidad)))) as Ganancias from syscsvd_ventas v join syscsvd_detalle_ventas d on v.id_venta = d.id_venta join syscsvd_productos p on d.id_producto = p.id_producto join syscsvd_detalles_compras c on c.id_producto = d.id_producto where YEAR(v.fecha_de_venta)=".$r_anios_barras['Anio']." and p.id_producto = ".$r_etiquetas_barras['id_producto']." group by p.nombre, YEAR(v.fecha_de_venta);") ?>
                                    <?php if(mysqli_num_rows($ganancias_anios_barras)!=0){ ?>
                                        <?php  while($r_ganancias_anios_barras=mysqli_fetch_array($ganancias_anios_barras)){ ?>
                                            <td> <?php echo $r_ganancias_anios_barras['Ganancias']; ?> </td> 
                                        <?php } ?>
                                    <?php } 
                                    else{
                                        ?>
                                        <td>0</td>
                                        <?php
                                    } ?>
                                    <?php 
                                        }//fin while productos/etiquetas
                                        ?>
                                </tr>
                                <?php
                                    }//fin while etiquetas_areas
                                }//fin if mes_area ?>
                            </tbody>
            </table>
        </figure>


        <script> 
        Highcharts.chart('container_barras', {
            data: {
                table: 'datatable-barras'
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Ganancias por año'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Ganancias'
                }
            }
        });
        </script>

        <style>
        #container_barras {
            height: 400px;
        }

        .highcharts-figure-barras,
        .highcharts-data-table table {
            min-width: 250px;
            max-width: 800px;
            margin: 1em auto;
        }

        #datatable-barras {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        #datatable-barras caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        #datatable-barras th {
            font-weight: 600;
            padding: 0.5em;
        }

        #datatable-barras td,
        #datatable-barras th,
        #datatable-barras caption {
            padding: 0.5em;
        }

        #datatable-barras thead tr,
        #datatable-barras tr:nth-child(even) {
            background: #f8f8f8;
        }

        #datatable-barras tr:hover {
            background: #f1f7ff;
        }
        </style>
    </div>

    <!--------------------GRAFICO PIE <?php ?>-------------------------->
    <div class="divgraficos">
        <figure class="highcharts-figure-pie">
            <div id="container-pie"></div>

            <table hidden id="datatable-pie">
                <?php $etiqueta_mes_actual_pie=mysqli_query($con,"SELECT MONTH(v.fecha_de_venta) as Mes,  SUM(d.cantidad) as Cantidad from syscsvd_ventas v join syscsvd_detalle_ventas d on v.id_venta = d.id_venta where YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(v.fecha_de_venta) = MONTH(CURRENT_DATE());");?>
                <thead>
                    <tr>
                        <th></th>
                        <?php  while($r_etiqueta_mes_actual_pie=mysqli_fetch_array($etiqueta_mes_actual_pie)){ ?>
                                    <th><?php echo "Mes ".$r_etiqueta_mes_actual_pie['Mes']; ?></th> <!--Producto 1--> 
                        <?php } ?> 
                    </tr>
                </thead>
                <?php $etiqueta_producto_pie=mysqli_query($con,"SELECT p.id_producto, p.nombre as Producto,  SUM(d.cantidad) as Cantidad from syscsvd_detalle_ventas d join syscsvd_productos p on d.id_producto = p.id_producto group by p.nombre;");?>
                <tbody>
                    <?php if(mysqli_num_rows($etiqueta_producto_pie)!=0){ ?>
                                                <?php  while($r_etiqueta_producto_pie=mysqli_fetch_array($etiqueta_producto_pie)){ ?>

                                                    <?php $cantidad_ventasmes_pie=mysqli_query($con,"SELECT p.nombre as Producto, MONTH(v.fecha_de_venta) as Mes, SUM(d.cantidad) as Cantidad from syscsvd_ventas v join syscsvd_detalle_ventas d on v.id_venta = d.id_venta join syscsvd_productos p on d.id_producto = p.id_producto where p.nombre='".$r_etiqueta_producto_pie['Producto']."' AND p.id_producto = ".$r_etiqueta_producto_pie['id_producto']."  group by p.nombre;"); ?>

        <?php if(mysqli_num_rows($cantidad_ventasmes_pie)!=0){ ?>
            <?php  while($r_cantidad_ventasmes_pie=mysqli_fetch_array($cantidad_ventasmes_pie)){ ?>

                    <tr>
                        <th> <?php echo $r_etiqueta_producto_pie['Producto']; ?></th>
                                <td> <?php echo $r_cantidad_ventasmes_pie['Cantidad']; ?> </td>
                            <?php } ?>
                        <?php }
                         else{
                            ?>
                            <td>0</td>
                            <?php
                        } ?>
                    </tr>
                    <?php } ?>
                                    <?php } ?>
                </tbody>
            </table>
        </figure>

        <script>
            Highcharts.chart('container-pie', {
                data: {
                    table: 'datatable-pie'
                },
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Ventas totales en el mes'
                },
                xAxis: {
                    type: 'category'
                },
            });
        </script>

        <style>
            #container-pie {
                height: 400px;
            }

            .highcharts-figure-pie,
            .highcharts-data-table table {
                min-width: 250px;
                max-width: 800px;
                margin: 1em auto;
            }

            #datatable-pie {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #ebebeb;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
            }

            #datatable-pie caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }

            #datatable-pie th {
                font-weight: 600;
                padding: 0.5em;
            }

            #datatable-pie td,
            #datatable-pie th,
            #datatable-pie caption {
                padding: 0.5em;
            }

            #datatable-pie thead tr,
            #datatable-pie tr:nth-child(even) {
                background: #f8f8f8;
            }

            #datatable-pie tr:hover {
                background: #f1f7ff;
            }
        </style>
    </div>

        <!------------------------------------GRAFICO AREA---------------------------------------->
    <div class="divgraficos">
        <figure class="highcharts-figure-area">
            <div id="container_area"></div>

            <table hidden id="datatable-area">
                <?php
                    $etiquetas_area=mysqli_query($con,"SELECT p.id_producto, p.nombre as Producto,  SUM(d.cantidad) as Cantidad from syscsvd_detalle_ventas d join syscsvd_productos p on d.id_producto = p.id_producto group by p.nombre;") //agrupar datos con GROUP BY por year, month, wekk?>
                            <thead>
                                <tr> 
                                    <th></th>  <!--DEBE QUEDAR VACIO, SI SE CREAN MAS VACIOS SE ROMPE-->
                                    <?php  while($r_etiquetas_area=mysqli_fetch_array($etiquetas_area)){ ?>
                                    <th><?php echo $r_etiquetas_area['Producto']; ?></th> <!--Producto 1--> 
                                    <?php } ?> 
                                </tr>
                            </thead>
                            <?php $mes_area=mysqli_query($con,"SELECT YEAR(v.fecha_de_venta) as Anio, MONTH(v.fecha_de_venta) as Mes,  SUM(d.cantidad) as Cantidad from syscsvd_ventas v join syscsvd_detalle_ventas d on v.id_venta = d.id_venta where YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) group by Mes;"); ?>       
                            <tbody>
                                <?php 
                                if(mysqli_num_rows($mes_area)!=0)
                                { 
                                    while($r_mes_area=mysqli_fetch_array($mes_area))
                                    { 
                                        ?>
                                        <tr>
                                            <th> <?php echo "Mes ".$r_mes_area['Mes']; ?></th> <!--Año-->
                                            <?php
                                            //bucle de productos/etiquetas
                                            mysqli_data_seek($etiquetas_area, 0);
                                            while($r_etiquetas_area=mysqli_fetch_array($etiquetas_area))
                                            { 
                                             $ventas_mes_area=mysqli_query($con,"SELECT p.nombre as Producto, MONTH(v.fecha_de_venta) as Mes, SUM(d.cantidad) as Cantidad from syscsvd_ventas v join syscsvd_detalle_ventas d on v.id_venta = d.id_venta join syscsvd_productos p on d.id_producto = p.id_producto where YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(v.fecha_de_venta)=".$r_mes_area['Mes']." and p.id_producto = ".$r_etiquetas_area['id_producto']." group by MONTH(v.fecha_de_venta), p.nombre;") ?>
                                            <?php   if(mysqli_num_rows($ventas_mes_area)!=0)
                                                    { ?>
                                                <?php  while($r_ventas_mes_area=mysqli_fetch_array($ventas_mes_area))
                                                        { ?>
                                                        <td> <?php echo $r_ventas_mes_area['Cantidad']; ?> </td> 
                                                    <?php } ?>
                                                <?php }
                                                else{
                                                    ?>
                                                    <td>0</td>
                                                    <?php
                                                } ?>
                                       
                                        <?php 
                                        }//fin while productos/etiquetas
                                        ?>
                                    </tr>
                                        <?php
                                    }//fin while etiquetas_areas
                                }//fin if mes_area ?>
                            </tbody>
            </table>
        </figure>


        <script> 
        Highcharts.chart('container_area', {
            data: {
                table: 'datatable-area'
            },
            chart: {
                type: 'area'
            },
            title: {
                text: 'Ventas por mes'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Cantidad'
                }
            }
        });
        </script>

        <style>
        #container_area {
            height: 400px;
        }

        .highcharts-figure-area,
        .highcharts-data-table table {
            min-width: 250px;
            max-width: 800px;
            margin: 1em auto;
        }

        #datatable-area {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        #datatable-area caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        #datatable-area th {
            font-weight: 600;
            padding: 0.5em;
        }

        #datatable-area td,
        #datatable-area th,
        #datatable-area caption {
            padding: 0.5em;
        }

        #datatable-area thead tr,
        #datatable-area tr:nth-child(even) {
            background: #f8f8f8;
        }

        #datatable-area tr:hover {
            background: #f1f7ff;
        }
        </style>
    </div>

    <!------------------------------------GRAFICO LINE---------------------------------------->
    <div class="divgraficos">
        <figure class="highcharts-figure-line">
            <div id="container_line"></div>

            <table hidden id="datatable-line">
                <?php
                    $etiquetas_line=mysqli_query($con,"SELECT p.id_producto, p.nombre as Producto,  SUM(d.cantidad) as Cantidad from syscsvd_detalles_compras d join syscsvd_productos p on d.id_producto = p.id_producto group by p.nombre;") //agrupar datos con GROUP BY por year, month, wekk?>
                            <thead>
                                <tr> 
                                    <th></th>  <!--DEBE QUEDAR VACIO, SI SE CREAN MAS VACIOS SE ROMPE-->
                                    <?php  while($r_etiquetas_line=mysqli_fetch_array($etiquetas_line)){ ?>
                                    <th><?php echo $r_etiquetas_line['Producto']; ?></th> <!--Producto 1--> 
                                    <?php } ?> 
                                </tr>
                            </thead>
                            <?php $semana_line=mysqli_query($con,"SELECT month(c.fecha_compra) as Mes, week(c.fecha_compra) as Semana,  SUM(d.cantidad) as Cantidad from syscsvd_compras c join syscsvd_detalles_compras d on c.id_compra = d.id_compra where month(c.fecha_compra) = month(CURRENT_DATE()) group by Semana; "); ?>       
                            <tbody>
                                <?php 
                                if(mysqli_num_rows($semana_line)!=0)
                                { 
                                    while($r_semana_line=mysqli_fetch_array($semana_line))
                                    { 
                                        ?>
                                        <tr>
                                            <th> <?php echo "Semana ".$r_semana_line['Semana']; ?></th> <!--Año-->
                                            <?php
                                            //bucle de productos/etiquetas
                                            mysqli_data_seek($etiquetas_line, 0);
                                            while($r_etiquetas_line=mysqli_fetch_array($etiquetas_line))
                                            { 
                                             $precio_semana_line=mysqli_query($con,"SELECT d.id_producto, p.nombre as Producto,  max(d.precio_compra) as PrecioUnidad from syscsvd_compras c join syscsvd_detalles_compras d on c.id_compra=d.id_compra join syscsvd_productos p on d.id_producto = p.id_producto where month(c.fecha_compra) = month(CURRENT_DATE()) AND week(c.fecha_compra)=".$r_semana_line['Semana']." and p.id_producto = ".$r_etiquetas_line['id_producto']." group by d.id_producto;") ?>
                                            <?php   if(mysqli_num_rows($precio_semana_line)!=0)
                                                    { ?>
                                                <?php  while($r_precio_semana_line=mysqli_fetch_array($precio_semana_line))
                                                        { ?>
                                                        <td> <?php echo $r_precio_semana_line['PrecioUnidad']; ?> </td> 
                                                    <?php } ?>
                                                <?php }
                                                else{
                                                    ?>
                                                    <td>0</td>
                                                    <?php
                                                } ?>
                                       
                                        <?php 
                                        }//fin while productos/etiquetas
                                        ?>
                                    </tr>
                                        <?php
                                    }//fin while etiquetas_areas
                                }//fin if mes_area ?>
                            </tbody>
            </table>
        </figure>


        <script> 
        Highcharts.chart('container_line', {
            data: {
                table: 'datatable-line'
            },
            chart: {
                type: 'line'
            },
            title: {
                text: 'Precio de compras'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Precio'
                }
            }
        });
        </script>

        <style>
        #container_line {
            height: 400px;
        }

        .highcharts-figure-line,
        .highcharts-data-table table {
            min-width: 250px;
            max-width: 800px;
            margin: 1em auto;
        }

        #datatable-line {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        #datatable-line caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        #datatable-line th {
            font-weight: 600;
            padding: 0.5em;
        }

        #datatable-line td,
        #datatable-line th,
        #datatable-line caption {
            padding: 0.5em;
        }

        #datatable-line thead tr,
        #datatable-line tr:nth-child(even) {
            background: #f8f8f8;
        }

        #datatable-line tr:hover {
            background: #f1f7ff;
        }
        </style>
    </div>
</div>
    <style>
        #contgraficos{
            float: left;
            width: 100%;
        }
        .divgraficos{
            float: left;
            background-color: white;
            width: 49.8%;
            margin: 0.1%;
            height: 450px;
            border: 1px solid #D5DBDB;
            border-radius: 4px;
        }
        @media screen and (max-width:768px){
            .divgraficos{
                width:100%;
                height: 27em;
            }
            #container-barras {
                height: 200px !important;
            }
            #container-pie {
                height: 200px !important;
            }
            #container-area {
                height: 200px !important;
            }
            #container-line {
                height: 200px !important;
            }
        }
    </style>
</div>