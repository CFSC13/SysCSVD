    <audio id="beep" src="beep.mp3"></audio>


<?php
session_start();

if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>

<?php
if($_GET['add']=="ok")
{
    if($_POST['cod_prod']!="" && $_POST['can_prod']!="")
    {
       // echo "insert into facturacion (fecha, id_cliente, id_forma_pago, fecha_vencimiento,cerrado,total) values(now(), $_POST['clientes'], $_POST['condicion_venta'], '$_POST[fecha_vencimiento]', 0, '$_POST[total]') RETURNING *;";
        $sql=mysqli_query($con,"insert into ventas (importe_total, fecha_venta, id_usuario) values('$_POST[total]', now(), $_POST[id_usuario])");
        //echo "'$_POST[total]', now(), '$_POST[id_usuario]'";

        if(!mysqli_error($con))
        {
            $r=mysqli_fetch_array(mysqli_query($con,"select MAX(id_venta) as id from ventas"));
            $cant_articulos=count($_POST['cod_prod']);
            $n=0;
            $error=0;
            //echo "$r[0]";
            //echo "<hr>CANTIDAD DE PRODUCTOS: <h1>".$cant_articulos."</h1>";
            while($n<=$cant_articulos){
                if($_POST['cod_prod'][$n]!="" && $_POST['can_prod'][$n]){
                    $cod=$_POST['cod_prod'][$n];
                    $can=$_POST['can_prod'][$n];
                    $rp=$_POST['precio'];
                    $subtotal=$rp*$can;
                    
                    $sql2.="insert into syscsvd_detalle_ventas (id_producto,id_venta,precio_unitario,cantidad,subtotal) values('".$cod."', $r[id], '".$rp."', $can, '$subtotal');";
                    //echo "<hr><h1>".$n.")-".$sql2."</h1>";
                    //se actualiza el stock
                    $sql_update = "UPDATE productos SET stock = stock + $can WHERE id_producto = $cod";
                    mysqli_query($con, $sql_update);
                }
                $n++;
            }

            $sql3=mysqli_multi_query($con,$sql2);

            if(!mysqli_error($con))
            {
                echo "<script>alert('Registro Insertado Correctamente.');</script>";
                //preguntar al profe porque no imprime
                echo "<script>window.open('presupuesto_pdf.php?id=".$r[id]."');window.location='home.php?pagina=ventas';</script>";
            
            }
            else{
                 echo "<script>alert('Error: para crear los detalles');</script>";
            }
        }
            else
            {
                echo "<script>alert('Error: No se pudo insertar el registro.');</script>";
            }
    }
        else
        {
            echo "<script>alert('Complete los Campos Obligatorios (*).');</script>";
        }
}

if($_GET['del']!="")
{

        $sql=mysqli_query($con,"delete from factura where id_factura=".$_GET['del']);
        
        if(!mysqli_error($con))
        {
            echo "<script>alert('Registro Eliminado Correctamente.');</script>";
            echo "<script>window.location='home.php?pagina=facturacion';</script>";
        }
            else
            {
                echo "<script>alert('Error: No se pudo Eliminar el registro.');</script>";
            }

}
?>

<script src="https://unpkg.com/html5-qrcode"></script>

<style>
  
@media only screen and (max-width: 600px) {
  table {
    font-size: 12px;
  }
  th:nth-child(3),
  td:nth-child(3) {
    display: none;
  }
  #totalMostrado {
        text-align: center;
    }
}

/* Para pantallas medianas, mostrar todas las columnas y ajustar el tamaño de fuente */
@media only screen and (min-width: 601px) and (max-width: 1024px) {
  table {
    font-size: 14px;
  }
}
.input-qty {
  display: inline-block;
  width: 50px;
  padding: 0.1rem 0.2rem;
  font-size: 0.9rem;
  line-height: 1.5;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
}

.btn-qty {
  display: inline-block;
  width: 30px;
  padding: 0.2rem 0.4rem;
  font-size: 0.9rem;
  font-weight: 400;
  line-height: 1.5;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  cursor: pointer;
  user-select: none;
  background-color: #fff;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn-qty:hover {
  border-color: #a7aeb5;
}

.btn-qty:focus {
  border-color: #86b7fe;
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn-qty:active {
  background-color: #e9ecef;
  border-color: #e9ecef;
}

 
</style>
  <div class="tab-content" id="nav-tabContent">                         
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
               <div id="accordion">
                     <!-- Page Heading -->
                        <div class="card shadow mb-4" id="headingOne">
                            <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse show" data-target="#collapseNuevo" aria-expanded="true" aria-controls="collapseNuevo">Nombre - Código de barras</h6>
                            </div>
               
               <?php
                        $showform="";
                        $showtable="";
                        if($_GET[ver]!=0)
                        {
                            $sql=mysqli_query($con,"select *from ventas where id_venta=$_GET[ver]");
                                if(mysqli_num_rows($sql)!=0)
                                {   
                                    $r=mysqli_fetch_array($sql);
                                }
                                $url="home.php?pagina=ventas&mod=ok";
                                $showform="show";
                        }
                            else
                            {
                                $url="home.php?pagina=ventas&add=ok";
                                $showtable="show";
                            }
                    ?>
                        <div id="collapseNuevo" class="<?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
                              
                            <form action="<?php echo $url; ?>" method="POST">
                        <!-- Fila 1 -->
                        

                           
                            <br>                          
                                <fieldset class="border p-2">
                            <div class="form-group">
                                <div class="form-group">
                                    <select name="productos" id="productos" class="form-control small" placeholder="Producto" aria-label="Producto" aria-describedby="basic-addon2" style="margin-right: 1%; width: 100%;" onchange="updatePrice()">
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g = mysqli_query($con, "select * from productos");
                                        if (mysqli_num_rows($sql_g) != 0) {
                                            while ($r_g = mysqli_fetch_array($sql_g)) {
                                                ?>
                                                <option data-precio="<?php echo $r_g['precio']; ?>" data-cod="<?php echo $r_g['codigo_barra']; ?>" value="<?php echo $r_g['id_producto']; ?>"><?php echo $r_g['nombre']." - ".$r_g['codigo_barra']; ?></option>
                                                <?php echo $r_g['precio']; ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="precio">Precio:</label>
                                    <input type="number" class="form-control" id="precio" name="precio" value="" disabled>
                                </div>
                            </div>

                                <div class="form-group">
                                    <label for="Cantidad">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="" >                               
                                </div>                              
                               
                                <br>                   
                              
                                <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['user']; ?>">

                                <p style="text-align: left; float: left;"><button type="button" onclick="AddProductos()" class="btn btn-primary" style="float:right;">Agregar</button></p>
                                <br><br>
                                <div class="table-responsive">
                                    <table class="table table-sm text-dark" id="prod-presu">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Producto</th>                                                 
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Sub Total</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-prod-presu">
                                        </tbody>
                                        <tfoot id="tfoot-prod-presu" class="text-right">
                                        </tfoot>
                                    </table>
                                </div>
                                </fieldset>    
                                <p style="width: 100%; text-align: center;">
                                    <br>
                                    <button type="submit" class="btn btn-secondary">Registrar Venta </button>
                                </p>
                                <br><br>
                                </form>
                            </div>
                        </div>
                    </div>          

     
            
                    
<script type="text/javascript">
    var total=0;
    var tr=0;
    function AddProductos(){
        if($("#productos option:selected").val()!="" && $("#cantidad").val()!=0 && $("#cantidad").val()!=""){
            let precio=$("#precio").val();
            let cod=$("#productos option:selected").data("cod");
            let pro=$("#productos option:selected").text();
            let can=$("#cantidad").val();

            let subtotal=(precio*can);
            total=total+subtotal;
            var numberFormat = new Intl.NumberFormat();
            tr=tr+1;
            $("#tbody-prod-presu").append("<tr class='tr_"+tr+"'><th scope='row'>"+cod+"</th><td>"+pro+"</td><td>"+can+"</td><td>$"+numberFormat.format(parseFloat(precio).toFixed(2))+"</td><td>$"+numberFormat.format(parseFloat(subtotal).toFixed(2))+"</td><td><a title='Eliminar' alt='Eliminar' href='javascript:deltr("+tr+","+subtotal+")'><i class='fas fa-eraser icono_borrar'></i></a></td></tr><input type='hidden' id='cod_prod' name='cod_prod[]' value='"+cod+"'/><input type='hidden' id='can_prod' name='can_prod[]' value='"+can+"'/>");

            $("#tfoot-prod-presu").html("<tr><td colspan='5' class='h4'>Total: $"+numberFormat.format(total.toFixed(2))+"</td></tr><input type='hidden' id='total' name='total' value='"+total+"'/>");

            //limpio el formulario para el próximo producto
            $("#cantidad").val('');
            $('#productos').val(null).trigger('change');
            $("#productos").focus();
        }
            else
            {
                alert('No deje los campos vacios');//mensaje de campos vacios
            }
    }

function updatePrice() {
        var select = document.getElementById('productos');
        var price = select.options[select.selectedIndex].getAttribute('data-precio');
        document.getElementById('precio').value = price;
            }

function updateSubtotal(n, precio) {
    let can=$("#cantidad_"+n).val();
    let subtotal=(precio*can);
    $("#subtotal_"+n).html("$"+new Intl.NumberFormat().format(parseFloat(subtotal).toFixed(2)));
    $("#can_prod_"+n).val(can);
    total=0;
    $(".input-qty").each(function(){
        let subtotal=parseFloat($(this).val())*parseFloat($("#precioInput").val());
        total+=subtotal;
        $("#totalMostrado").html("Total: $"+new Intl.NumberFormat().format(parseFloat(total).toFixed(2)));
        $("#total").val(total);
    });
}

function incrementQty(n) {
    let qty=$("#cantidad_"+n).val();
    $("#cantidad_"+n).val(parseInt(qty)+1);
    updateSubtotal(n, $("#precioInput").val());
}

function decrementQty(n) {
    let qty=$("#cantidad_"+n).val();
    if (qty > 1) {
        $("#cantidad_"+n).val(parseInt(qty)-1);
        updateSubtotal(n, $("#precioInput").val());
    }
}

function deltr(n,sub){
    $(".tr_"+n).remove();
    tr=tr-1;
    total=total-sub;
    var numberFormat = new Intl.NumberFormat('es-ES');
      $("#tfoot-prod-presu").html("<tr><td colspan='5' class='h4'>Total: $"+numberFormat.format(total.toFixed(2))+"</td></tr>");
      updateSubtotal();
}
</script>    
<script src="vendor/ckeditor/ckeditor.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
 //inicio editor
    CKEDITOR.replace('descripcion',
      {
        height  : '500px',
        width   : '100%',

        toolbar : [
        { name: 'document', items : [ 'Undo','Redo','-','NewPage','DocProps','Preview','Print'] },
        { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-' ] },
        { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },'/',
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','-','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
        '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
        { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
        { name: 'insert', items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
        '/',
        { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
        { name: 'colors', items : [ 'TextColor','BGColor' ] },
        { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','Source'] },

        ],
        filebrowserUploadUrl: "upload.php",
        allowedContent: true
      });
    //fin editor
</script>

<script>
$(document).ready( function () {
    //combo de productos
    $('#productos').select2();
    $("#productos").focus();
    //combo de clientes
    $('#clientes').select2();
    $("#clientes").focus();

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
  });
    //inicio datatable
    $('#dataTable-mensajes').DataTable({
        sort: true, 
        order : [[0,"desc"]],
        responsive: true,
        language: {
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sProcessing":     "Procesando...",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
        "sInfo":           "Mostrando del _START_ al _END_ - total: _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando del 0 al 0 - total: de 0 registros",
        "sInfoFiltered":   "(filtrado de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        }
      }
    });

    //inicializar datatable
    $('#dataTable-mensajes').DataTable();
} );    


</script>

<script>
    var html5QrcodeScanner = new Html5QrcodeScanner(
	"reader", { fps: 1, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);


function onScanSuccess(decodedText, decodedResult) {
  // Handle on success condition with the decoded text or result.
  var scanInput = $("#codigo");
  
  scanInput.val(decodedText);


  // Para enviar el codigo por get
  var scanInputValue = decodedText;

  $.ajax({
    //url: "https://c0b6-138-186-162-59.ngrok-free.app/facturacionsimplephp/buscarAjax.php",
    url: "http://localhost/facturacionsimplephp/buscarAjax.php",
    data: { w1: scanInputValue },
    type: "GET",
    //especifica que se recibe en formato JSON y no hace falta usar el parse
    //dataType: "json",
    success: function (response) {
        if (!response.error) {
            // Emite un sonido al escanear un código si se recibe un response
            var beepSound = document.getElementById("beep");
            beepSound.play();
            //aca se convirte el string en JSON
            let tasks = JSON.parse(response);           
            $('#nombre_escaner').val(tasks[0].name);
            $('#precio_escaner').val(tasks[0].price);
            $('#id_escaner').val(tasks[0].id);
              // Llama a la función AddProductos() después de actualizar los campos
            //AddProductos();        
                
                }
                } ,
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejar errores aquí
                }
            });
            }

  
</script>



