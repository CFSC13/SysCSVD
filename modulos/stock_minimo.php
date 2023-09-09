<?php
session_start();

if($_SESSION[user]==0)
{
    echo "<script>window.location='index.php';</script>";
}
?>


  <div class="tab-content" id="nav-tabContent">
                           

               
               <?php
                        $showform="";
                        $showtable="show";
                        if($_GET[ver]!=0)
                 
                    ?>
                        <div id="collapseNuevo" class="collapse <?php echo $showform; ?> m-1" aria-labelledby="headingOne" data-parent="#accordion">    
                            <div class="card-body" >
               
                            <form action="<?php echo $url; ?>" method="POST" enctype="multipart/form-data">
                                <!--Fila 1-->
                                <div class="form-group">
                                    <label for="nombre">Código de Barras</label>
                                    <input type="text" class="form-control" id="codigo_barra" name="codigo_barra" value="<?php echo $r['codigo_barra']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $r['nombre']; ?>" required>
                                </div>
                               
                                <div class="form-group">
                                    <label for="nombre">Descripción</label>
                                    <textarea  class="form-control" type="text" name="descripcion" placeholder="descripción"  id="descripcion" rows="2"><?php if(!empty($r['descripcion'])) echo $r['descripcion'];?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio" value="<?php echo $r['precio'];?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="nombre">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $r['stock']; ?>" required>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="nombre">Stock Mínimo</label>
                                    <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" value="<?php echo $r['stock_minimo']; ?>" required>
                                </div>
                                <br>

                                <div class="form-group">
                                    <label for="nombre">Foto</label>
                                    <input type="file" name="foto" id="foto" >
                                    <input type="hidden" name="foto_actual" id="foto_actual" value="<?php echo $r['foto'];?>">
                                </div>
                                <br>

                                <div class="form-group">
                                    <label for="nombre">Categoría</label>
                                    <select name="id_categoria" id="id_categoria" class="form-control bg-light border-0 small" placeholder="Grupo"  aria-label="Grupo" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select * from categorias order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {// el value es el id_categoria que paso por post al submitir ///////si id_categoria en categoria == id_categoria en productio entonces selecciono //////y muestro nombre de la categoria
                                                ?>
                                                <option value="<?php echo $r_g['id_categoria'];?>" <?php if($r_g['id_categoria']==$r['id_categoria']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>  
                                <br>

                                <div class="form-group">
                                    <label for="nombre">Marca</label>
                                    <select name="id_marca" id="id_marca" class="form-control bg-light border-0 small" placeholder="Grupo"  aria-label="Grupo" aria-describedby="basic-addon2" style="margin-right: 1%;" required>
                                        <option value="">Seleccione...</option>
                                        <?php
                                        $sql_g=mysqli_query($con,"select * from marcas order by nombre");
                                        if(mysqli_num_rows($sql_g)!=0)
                                        {
                                            while($r_g=mysqli_fetch_array($sql_g))
                                            {// el value es el id_categoria que paso por post al submitir ///////si id_categoria en categoria == id_categoria en productio entonces selecciono //////y muestro nombre de la categoria
                                                ?>
                                                <option value="<?php echo $r_g['id_marca'];?>" <?php if($r_g['id_marca']==$r['id_marca']){?> selected <?php }?>><?php echo $r_g['nombre'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>  
                                <br>
                                
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="libreria" name="libreria" <?php if ($r['libreria']) echo 'checked'; ?>>
                                        <label class="form-check-label" for="libreria">Es de Librería</label>
                                    </div>
                                </div>

                            
                                <input type="hidden" name="id_producto" id="id_producto" value="<?php echo $r['id_producto']; ?>"> 
                                <button type="submit" class="btn btn-primary" style="float:right;">Guardar</button>
                            </form>
                            
                            </div>
                        </div>
                    </div>
            

           
            
         <!-- Page Heading -->
         <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Productos coon Stock Mínimo</h6>
                        </div>
                        <div id="collapseListado" class="collapse <?php echo $showtable; ?>" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body" >
                             <div class="table-responsive" style="padding-right: 1% !important;">
                                    <table class="table table-bordered display nowrap" id="dataTable-mensajes" width="100%" cellspacing="0">
                                    <thead>
                                    
                                    <tr>                                       
                                        <th>Nombre</th>
                                        <th>Stock</th>
                                        <th>Stock Mínimo</th>
                                        <th>Codigo de Barras</th>
                                        <th>Precio</th>                                       
                                        <th>Categoria</th>
                                        <th>Marca</th>
                                        <th>Librería</th>

                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Stock</th>
                                        <th>Stock Mínimo</th>
                                        <th>Codigo de Barras</th>
                                        <th>Precio</th>                                        
                                        <th>Categoria</th>
                                        <th>Marca</th>
                                        <th>Librería</th>

                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $q = mysqli_query($con, "SELECT id_producto, foto, descripcion, stock_minimo, P.Nombre as 'NombreP', P.Precio as 'PrecioP', P.stock as 'StockP', P.codigo_barra as 'codigo_barraP',
                                    C.Nombre as 'NonbreC', M.nombre as 'marca', libreria
                                    FROM productos P 
                                    JOIN categorias C 
                                    ON P.id_categoria = C.id_categoria
                                    JOIN marcas M 
                                    ON P.id_marca = M.id_marca
                                    WHERE P.stock <= P.stock_minimo
                                    ORDER BY P.nombre;");

                                            if(mysqli_num_rows($q)!=0){
                                                while($r=mysqli_fetch_array($q)){?>
                                                 <tr>
                                                     <td><?php echo $r['NombreP']; ?></td>
                                                     <td><?php echo number_format($r['StockP'],0,',','.'); ?></td>
                                                     <td><?php echo number_format($r['stock_minimo'],0,',','.'); ?></td>
                                                     <td><?php echo $r['codigo_barraP']; ?></td>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    
    


<script src="vendor/ckeditor/ckeditor.js"></script> 
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
