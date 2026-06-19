

<div class="container-fluid"> 

    
            <table class="table table-borderd">
                
                <tbody id="tabla_lista">
                <?php
                    $hoy = date("Y-m-d H:i:s");
                    $count = 1;
                    $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador ");  
                    while($data = mysqli_fetch_array($query)){ 
                        
                        $partes = explode("/",$data["fecha_cumplimiento"]);
                        $nueva_fecha = $partes[2]."-".$partes[1]."-".$partes[0];
                        
                        $queryColaborador = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
                        WHERE id = '".$data['id_empleado']."' ");  
                        $dataColaborador = mysqli_fetch_array($queryColaborador);
                        
                        if($data["fecha_cumplimiento"]){
                            //mysqli_query($connect_desempenio,"UPDATE Objetivos_Colaborador SET fecha_cumplimiento__ = '".$nueva_fecha."' WHERE id = '".$data['id']."' "); 
                        }


                        echo '
                        <tr>
                            <td>'.$dataColaborador["nombre"].' '.$dataColaborador["apellidos"].'</td>
                            <td>'.$data["fecha_cumplimiento"].'</td>
                            <td>'.$nueva_fecha.'</td>
                            
                        </tr>
                        
                        ';
                        $count++;
                    }
                ?>
                </tbody>
            </table>
            
            
            
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



