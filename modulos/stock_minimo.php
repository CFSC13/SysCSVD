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
                                   
            
         <!-- Page Heading -->
         <div class="card shadow mb-4 mx-auto" >
                        <div class="card-header py-3" id="headingTwo">
                        <h6 class="m-0 font-weight-bold text-primary" data-toggle="collapse" data-target="#collapseListado" aria-expanded="true" aria-controls="collapseListado">Productos con Stock Mínimo</h6>
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
                                    FROM syscsvd_productos P 
                                    JOIN syscsvd_categorias C 
                                    ON P.id_categoria = C.id_categoria
                                    JOIN syscsvd_marcas M 
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
