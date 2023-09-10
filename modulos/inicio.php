<?php
 session_start();
 if($_SESSION[user]==0)
 {
     echo "<script>window.location='index.php';</script>";
 }
?>

<div id="hero">
    <h1 id="letra_hero">Te damos la bienvenida a SysCSVD.<br>¡Comienza a administrar tu empresa!</h1> 
</div>
<style>
    #hero{
        display: flex;
        align-items:center;
        justify-content: center;
        text-align: center;
        flex-direction: column;
        height: 30vh;
        color:white;
        background-image: linear-gradient(
            0deg,
            rgba(17, 81, 193,0.5),
            rgba(17, 81, 193,0.5)
        )
        ,url("img/fondo_syscsvd.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        border-radius: 40px;
        margin-bottom: 3%;
    }
    #letra_hero{
        font-size:25px;
    }
</style>


<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
    <div class="container-fluid">

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Administrar</div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800"> Podrá dar de alta y modificar la informacion personal de los usuarios que hagan uso del sistema. </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    

    
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Productos</div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800"> Permitirá dar de alta y gestionar los productos que ingresen al inventario. </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-cart-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Compras</div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800"> Módulo donde se registrarán las compras que se realicen al renovar inventario. </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-shopping-basket fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Ventas</div>

                            <div class="h5 mb-0 font-weight-bold text-gray-800"> Sitio donde se llevarán a cabo las operaciones de ventas, mediante el ingreso manual o a traves de scannear códigos de barra. </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-money fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

    </div>
    
</div>