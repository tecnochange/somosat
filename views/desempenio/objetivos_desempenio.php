<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_objetivos").addClass("active_item");
    
    $('.custom-scrollbar').animate({ scrollTop: $('#bt_desempenio_administrar').offset().top - 500 }, 1000);
});
</script>

<?php

    $hoy = date("Y-m-d H:i:s");

    if( $_POST["solicitar_aprobacion"] != "" ){
    
        if( $_POST["id_registro"] != "" ){
            /*
            mysqli_query($connect_desempenio,"UPDATE Aprobaciones_Objetivos SET 
            objetivo = '".$_POST["objetivo"]."', indicador = '".$_POST["indicador"]."', formula = '".$_POST["formula"]."', fuente = '".$_POST["fuente"]."', 
            meta = '".$_POST["meta"]."', fecha_cumplimiento = '".$_POST["fecha_cumplimiento"]."' WHERE id = '".$_POST["id_registro"]."' ");

            echo '<script> window.location.href = "?pg=desempenio/objetivos_colaborador&id='.$_POST["id_registro"].'";</script>';
            */
        }
        else{
            mysqli_query($connect_desempenio,"INSERT INTO Aprobaciones_Objetivos ( anio, id_empleado , id_jefe, estado, created_at) 
            VALUES ( '".$_SESSION['anio']."',  '".$_SESSION['id_user']."', '".$_POST['id_jefe']."', 1, '".$hoy."' )");

            $id_temp = mysqli_insert_id($connect_desempenio);
            //echo '<script> window.location.href = "?pg=desempenio/objetivos_colaborador&id='.$id_temp.'";</script>';
        }
    }

    $queryVal = mysqli_query($connect_desempenio,"SELECT * FROM Aprobaciones_Objetivos WHERE id_empleado = '".$_SESSION['id_user']."' AND anio = '".$_SESSION['anio']."' ");
    $dataVal = mysqli_fetch_array($queryVal);

?>

<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Objetivos de Desempeño para el <?php echo $_SESSION["anio"]; ?></h2>
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
                    <th scope="col">Objetivo</th>
                    <th scope="col">Indicador</th>
					<th scope="col">Meta</th>
                    <th scope="col">Fecha Cumplimiento</th>
                    <th scope="col">Avance</th>
                    <th scope="col">
                        <a href="<?php echo $url; ?>/?pg=desempenio/objetivo/detalle">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" >
                            Nuevo
                        </button>
                        </a>
                    </th>
                </tr>
                </thead>

                <tbody id="tabla_lista">
                <?php
                    $count = 1;
                    $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
                    WHERE anio = '".$_SESSION['anio']."' 
                    AND id_empleado = '".$_SESSION['id_user']."' ORDER BY id ASC ");  
                    while($data = mysqli_fetch_array($query)){ 

                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["objetivo"].'</td>
                            <td>'.$data["indicador"].'</td>
							<td>'.$data["meta"].'</td>
                            <td>'.$data["fecha_cumplimiento"].'</td>
                            <td>'.$avance.'</td>
                            <td>
                                <a href="'.$url.'/?pg=desempenio/objetivo/detalle&id='.$data["id"].'">
                                    <button type="button" class="btn btn-success btn-sm" title="Editar" >
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                        
                        ';
                        $count++;
                    }
                ?>
                </tbody>
            </table>
            
            <?php if($query->num_rows > 0 && $queryVal->num_rows == 0 ){ ?>
 
            <form action="" method="post">
                
                <input type="hidden" name="solicitar_aprobacion" value="true">
                <input type="hidden" name="id_jefe" value="1">

                <button type="submit" class="btn btn-danger btn-block" title="Editar"  style="margin-top: 20px">
                    Enviar para Aprobación
                </button>
                
            </form>
            <?php } ?>
            
        </div>
        
    
    </div>
</div>



<script>
    
    $("#bt_desempenio_informes").addClass("active_item");
    
    $("#desempenio_menu").addClass("active");
    $('#desempenio_menu .collapse').collapse();

    
    
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



