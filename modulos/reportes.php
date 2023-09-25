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

<div id="contgraficos">
    <div class="divgraficos">
        <figure class="highcharts-figure-barras">
            <div id="container_barras"></div>

            <table id="datatable-barras">
                <?php
                    $etiquetas_barras=mysqli_query($con,"SELECT p.nombre as Producto,  SUM(d.cantidad) as Cantidad from detalle_ventas d join productos p on d.id_producto = p.id_producto group by p.nombre;") //agrupar datos con GROUP BY por year, month, wekk?>
                            <thead>
                                <tr> 
                                    <th></th>  <!--DEBE QUEDAR VACIO, SI SE CREAN MAS VACIOS SE ROMPE-->
                                    <?php  while($r_etiquetas_barras=mysqli_fetch_array($etiquetas_barras)){ ?>
                                    <th><?php echo $r_etiquetas_barras['Producto']; ?></th> <!--Producto 1--> 
                                    <?php } ?> 
                                </tr>
                            </thead>
                            <?php $anios_barras=mysqli_query($con,"SELECT YEAR(v.fecha_de_venta) as Anio,  SUM(d.cantidad) as Cantidad from ventas v join detalle_ventas d on v.id_venta = d.id_venta group by Anio;"); ?>       
                            <tbody>
                                <?php if(mysqli_num_rows($anios_barras)!=0){ ?>
                                            <?php  while($r_anios_barras=mysqli_fetch_array($anios_barras)){ ?>
                                <tr>
                                    <th> <?php echo $r_anios_barras['Anio']; ?></th> <!--Año-->
                                    <?php $ganancias_anios_barras=mysqli_query($con,"SELECT p.nombre as Producto, YEAR(v.fecha_de_venta) as Anio, SUM(d.cantidad) as Cantidad, d.precio_unitario as PrecioDeVenta, d.precio_unitario*SUM(d.cantidad) as Subtotal, c.precio_compra*SUM(d.cantidad) as Costo, ROUND(((d.precio_unitario*SUM(d.cantidad))-(c.precio_compra*SUM(d.cantidad)))) as Ganancias from ventas v join detalle_ventas d on v.id_venta = d.id_venta join productos p on d.id_producto = p.id_producto join detalles_compras c on c.id_producto = d.id_producto where YEAR(v.fecha_de_venta)=".$r_anios_barras['Anio']." group by p.nombre, YEAR(v.fecha_de_venta);") ?>
                                    <?php if(mysqli_num_rows($ganancias_anios_barras)!=0){ ?>
                                        <?php  while($r_ganancias_anios_barras=mysqli_fetch_array($ganancias_anios_barras)){ ?>
                                            <td> <?php echo $r_ganancias_anios_barras['Ganancias']; ?> </td> 
                                        <?php } ?>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                                <?php } ?>
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

            <table id="datatable-pie">
                <?php $etiqueta_mes_actual_pie=mysqli_query($con,"SELECT MONTH(v.fecha_de_venta) as Mes,  SUM(d.cantidad) as Cantidad from ventas v join detalle_ventas d on v.id_venta = d.id_venta where YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(v.fecha_de_venta) = MONTH(CURRENT_DATE());");?>
                <thead>
                    <tr>
                        <th></th>
                        <?php  while($r_etiqueta_mes_actual_pie=mysqli_fetch_array($etiqueta_mes_actual_pie)){ ?>
                                    <th><?php echo "Mes ".$r_etiqueta_mes_actual_pie['Mes']; ?></th> <!--Producto 1--> 
                        <?php } ?> 
                    </tr>
                </thead>
                <?php $etiqueta_producto_pie=mysqli_query($con,"SELECT p.nombre as Producto,  SUM(d.cantidad) as Cantidad from detalle_ventas d join productos p on d.id_producto = p.id_producto group by p.nombre;");?>
                <tbody>
                    <?php if(mysqli_num_rows($etiqueta_producto_pie)!=0){ ?>
                                                <?php  while($r_etiqueta_producto_pie=mysqli_fetch_array($etiqueta_producto_pie)){ ?>

                                                    <?php $cantidad_ventasmes_pie=mysqli_query($con,"SELECT p.nombre as Producto, MONTH(v.fecha_de_venta) as Mes, SUM(d.cantidad) as Cantidad from ventas v join detalle_ventas d on v.id_venta = d.id_venta join productos p on d.id_producto = p.id_producto where p.nombre='".$r_etiqueta_producto_pie['Producto']."' group by p.nombre;"); ?>

        <?php if(mysqli_num_rows($cantidad_ventasmes_pie)!=0){ ?>
            <?php  while($r_cantidad_ventasmes_pie=mysqli_fetch_array($cantidad_ventasmes_pie)){ ?>

                    <tr>
                        <th> <?php echo $r_etiqueta_producto_pie['Producto']; ?></th>
                                <td> <?php echo $r_cantidad_ventasmes_pie['Cantidad']; ?> </td>
                            <?php } ?>
                        <?php } ?>
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
                    text: 'Live births in Norway'
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

            <table id="datatable-area">
                <?php
                    $etiquetas_area=mysqli_query($con,"SELECT p.nombre as Producto,  SUM(d.cantidad) as Cantidad from detalle_ventas d join productos p on d.id_producto = p.id_producto group by p.nombre;") //agrupar datos con GROUP BY por year, month, wekk?>
                            <thead>
                                <tr> 
                                    <th></th>  <!--DEBE QUEDAR VACIO, SI SE CREAN MAS VACIOS SE ROMPE-->
                                    <?php  while($r_etiquetas_area=mysqli_fetch_array($etiquetas_area)){ ?>
                                    <th><?php echo $r_etiquetas_area['Producto']; ?></th> <!--Producto 1--> 
                                    <?php } ?> 
                                </tr>
                            </thead>
                            <?php $mes_area=mysqli_query($con,"SELECT YEAR(v.fecha_de_venta) as Anio, MONTH(v.fecha_de_venta) as Mes,  SUM(d.cantidad) as Cantidad from ventas v join detalle_ventas d on v.id_venta = d.id_venta where YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) group by Mes;"); ?>       
                            <tbody>
                                <?php if(mysqli_num_rows($mes_area)!=0){ ?>
                                            <?php  while($r_mes_area=mysqli_fetch_array($mes_area)){ ?>
                                <tr>
                                    <th> <?php echo $r_mes_area['Mes']; ?></th> <!--Año-->
                                    <?php $ventas_mes_area=mysqli_query($con,"SELECT p.nombre as Producto, MONTH(v.fecha_de_venta) as Mes, SUM(d.cantidad) as Cantidad from ventas v join detalle_ventas d on v.id_venta = d.id_venta join productos p on d.id_producto = p.id_producto where YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(v.fecha_de_venta)=".$r_mes_area['Mes']." group by MONTH(v.fecha_de_venta), p.nombre;") ?>
                                    <?php if(mysqli_num_rows($ventas_mes_area)!=0){ ?>
                                        <?php  while($r_ventas_mes_area=mysqli_fetch_array($ventas_mes_area)){ ?>
                                            <td> <?php echo $r_ventas_mes_area['Cantidad']; ?> </td> 
                                        <?php } ?>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                                <?php } ?>
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

            <table id="datatable-line">
                <?php
                    $etiquetas_area=mysqli_query($con,"SELECT p.nombre as Producto,  SUM(d.cantidad) as Cantidad from detalle_ventas d join productos p on d.id_producto = p.id_producto group by p.nombre;") //agrupar datos con GROUP BY por year, month, wekk?>
                            <thead>
                                <tr> 
                                    <th></th>  <!--DEBE QUEDAR VACIO, SI SE CREAN MAS VACIOS SE ROMPE-->
                                    <?php  while($r_etiquetas_area=mysqli_fetch_array($etiquetas_area)){ ?>
                                    <th><?php echo $r_etiquetas_area['Producto']; ?></th> <!--Producto 1--> 
                                    <?php } ?> 
                                </tr>
                            </thead>
                            <?php $mes_area=mysqli_query($con,"SELECT YEAR(v.fecha_de_venta) as Anio, MONTH(v.fecha_de_venta) as Mes,  SUM(d.cantidad) as Cantidad from ventas v join detalle_ventas d on v.id_venta = d.id_venta where YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) group by Mes;"); ?>       
                            <tbody>
                                <?php if(mysqli_num_rows($mes_area)!=0){ ?>
                                            <?php  while($r_mes_area=mysqli_fetch_array($mes_area)){ ?>
                                <tr>
                                    <th> <?php echo $r_mes_area['Mes']; ?></th> <!--Año-->
                                    <?php $ventas_mes_area=mysqli_query($con,"SELECT p.nombre as Producto, MONTH(v.fecha_de_venta) as Mes, SUM(d.cantidad) as Cantidad from ventas v join detalle_ventas d on v.id_venta = d.id_venta join productos p on d.id_producto = p.id_producto where YEAR(v.fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(v.fecha_de_venta)=".$r_mes_area['Mes']." group by MONTH(v.fecha_de_venta), p.nombre;") ?>
                                    <?php if(mysqli_num_rows($ventas_mes_area)!=0){ ?>
                                        <?php  while($r_ventas_mes_area=mysqli_fetch_array($ventas_mes_area)){ ?>
                                            <td> <?php echo $r_ventas_mes_area['Cantidad']; ?> </td> 
                                        <?php } ?>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                                <?php } ?>
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
        width: 49.8%;
        margin: 0.1%;
        height: 750px;
        border: 1px solid #D5DBDB;
        border-radius: 4px;
    }
    @media screen and (max-width:768px){
        .divgraficos{
            width:100%;
            height: 400px;
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

    


<!------------------------------------------------------------------------------------------>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Informe</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <?php $s=mysqli_query($con,"SELECT * FROM ventas WHERE YEAR(fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(fecha_de_venta)  = MONTH(CURRENT_DATE());") ?> 
        <!--SQL FECHA ACTUAL: SELECT * FROM ventas WHERE YEAR(fecha_de_venta) = YEAR(CURRENT_DATE()) AND MONTH(fecha_de_venta)  = MONTH(CURRENT_DATE())-->
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

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ganacia del mes actual</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
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

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Dropdown Header:</div>
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="myAreaChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Dropdown Header:</div>
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-pie pt-4 pb-2">
                                            <canvas id="myPieChart"></canvas>
                                        </div>
                                        <div class="mt-4 text-center small">
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-primary"></i> Direct
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-success"></i> Social
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-info"></i> Referral
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <!-- Content Column -->
                            <div class="col-lg-6 mb-4">

                                <!-- Project Card Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="small font-weight-bold">Server Migration <span
                                                class="float-right">20%</span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small font-weight-bold">Sales Tracking <span
                                                class="float-right">40%</span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small font-weight-bold">Customer Database <span
                                                class="float-right">60%</span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar" role="progressbar" style="width: 60%"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small font-weight-bold">Payout Details <span
                                                class="float-right">80%</span></h4>
                                        <div class="progress mb-4">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h4 class="small font-weight-bold">Account Setup <span
                                                class="float-right">Complete!</span></h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Color System -->
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <div class="card bg-primary text-white shadow">
                                            <div class="card-body">
                                                Primary
                                                <div class="text-white-50 small">#4e73df</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card bg-success text-white shadow">
                                            <div class="card-body">
                                                Success
                                                <div class="text-white-50 small">#1cc88a</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card bg-info text-white shadow">
                                            <div class="card-body">
                                                Info
                                                <div class="text-white-50 small">#36b9cc</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card bg-warning text-white shadow">
                                            <div class="card-body">
                                                Warning
                                                <div class="text-white-50 small">#f6c23e</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card bg-danger text-white shadow">
                                            <div class="card-body">
                                                Danger
                                                <div class="text-white-50 small">#e74a3b</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card bg-secondary text-white shadow">
                                            <div class="card-body">
                                                Secondary
                                                <div class="text-white-50 small">#858796</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card bg-light text-black shadow">
                                            <div class="card-body">
                                                Light
                                                <div class="text-black-50 small">#f8f9fc</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <div class="card bg-dark text-white shadow">
                                            <div class="card-body">
                                                Dark
                                                <div class="text-white-50 small">#5a5c69</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    <!-- /.container-fluid -->

</div>
            <!-- End of Main Content -->
             <!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>