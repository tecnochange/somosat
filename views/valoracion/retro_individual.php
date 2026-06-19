<script>  
$(document).ready(function(){
    $("#bt_retro_individual").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>


<?php if( $_SESSION['role_plataforma'] == 1 || $_SESSION['role_plataforma'] == 2 ){ ?>
<ul class="nav nav-tabs">  
    
    <li class="nav-item">
        <a class="nav-link active " href="?pg=valoracion/retro_individual">Retroalimentacion Propia</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/retro_equipo">Retroalimentación equipos</a>
    </li>
    
</ul>
<?php } ?>


<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Retroalimentación propia</h2>
                    </td>
                    <td align="right">
                    </td>
                </tr>
            </table>
            
        </div>
        
        <div class="col-md-12">

            <table class="table table-bordered" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Comentarios</th>
                    <th scope="col">Estado</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody id="tabla_lista">
                <?php
                    $count = 1;
                    
                    $query = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion WHERE id_empleado = '".$_SESSION['id_user']."' ");  
                    while($data = mysqli_fetch_array($query)){
                        
                        $text_estado = '';
                        foreach($Array_estado_seguimiento_retro as $estado){
                            if( $estado[0] == $data["estado"] ){ $text_estado = $estado[1]; }
                        }
                        
                        $queryComen = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion_Comentarios  WHERE id_retroalimentacion = '".$data["id"]."' ");  

                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["created_at"].' </td>
                            <td>'.$queryComen->num_rows.'</td>
                            <td>'.$text_estado.'</td>
                            
                            <td>
                                <a href="?pg=valoracion/retroalimentacion/detalle_lectura&e='.$data['id_empleado'].'&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
                                    Ver
                                </button>
                                </a>
                                
                                <a href="?pg=valoracion/retroalimentacion/comentario&e='.$data['id_empleado'].'&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" >
                                    Hacer comentario
                                </button>
                                </a>

                                
                            </td>
                            
                            
                        </tr>
                        
                        ';
                        $count++;

                    }
                    
                    if($query->num_rows == 0){
                        echo '
                        <tr>
                            <td colspan="5" align="center"><h5>No tiene retroalimentaciones realizadas.</td></td>
                        </tr>
                        ';
                    }
                    
   
                ?>
                </tbody>
            </table>
            
            
            
        </div>
        
    
    </div>
</div>

<script>
    var api = '<?php echo $url; ?>api/administrar/';
    
    var activar = false;
    function Elimimar_Jefe(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un jefe, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Jefe('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_jefe.php",
                type:'post',
                data: {id: id, url:"?pg=administrar/jefes"},
                }).done(function (resp){
                    $("#xscript").html(resp);
                })
                .fail(function(resp) {
                    console.log(resp);
                })
                .always(function(resp){
                }
            );
            
        }
    }
    
</script>



