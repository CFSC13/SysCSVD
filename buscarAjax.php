
<?php
include("includes/conexion.php");
conectar()

// comprobar si tenemos los parametros w1 y w2 en la URL
if (isset($_GET["w1"])) {
      // asignar w1 a la variable $codigo
      $codigo=addslashes($_GET["w1"]);
      $codigo=intval($codigo);                                     
      // Obtener el código de barras escaneado
      // Realizar la consulta a la base de datos para obtener el nombre del producto
      $query = "SELECT * FROM syscsvd_productos WHERE codigo_barra = '$codigo'";
      $result = mysqli_query($con,$query);
      $json = [];
      while ($row = mysqli_fetch_array($result)) {
                $json[] = [
                  'name' => $row['nombre'],
                  'price' => $row['precio'],
                  'id' => $row['id_producto']                  
                  
                  ];
                }
            $jsonstring = json_encode($json);
            echo $jsonstring;
            }                                        
?>


                                            