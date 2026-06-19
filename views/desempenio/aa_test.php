

<div class="container-fluid"> 

    
            <table class="table table-borderd">
                
                <tbody id="tabla_lista">
                <?php
                    $hoy = date("Y-m-d H:i:s");
                    $count = 1;
                    $query = mysqli_query($connect_desempenio,"SELECT * FROM aa_maestro ");  
                    while($data = mysqli_fetch_array($query)){ 
                        
                        $queryColaborador = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
                        WHERE documento = '".$data['c1']."' OR correo =  '".$data['c3']."' ");  
                        $dataColaborador = mysqli_fetch_array($queryColaborador);
                        
                        if($queryColaborador->num_rows > 0){
                            
                            
                            $obj = '[{"mes":1,"meta":"'.$data['c21'].'"},{"mes":2,"meta":"'.$data['c10'].'"},{"mes":3,"meta":"'.$data['c11'].'"},{"mes":4,"meta":"'.$data['c12'].'"},{"mes":5,"meta":"'.$data['c13'].'"},{"mes":6,"meta":"'.$data['c14'].'"},{"mes":7,"meta":"'.$data['c15'].'"},{"mes":8,"meta":"'.$data['c16'].'"},{"mes":9,"meta":"'.$data['c17'].'"},{"mes":10,"meta":"'.$data['c18'].'"},{"mes":11,"meta":"'.$data['c19'].'"},{"mes":12,"meta":"'.$data['c20'].'"}]';
                            
                            $obj_resultado = '[{"mes":1,"meta":"'.$data['c33'].'"},{"mes":2,"meta":"'.$data['c22'].'"},{"mes":3,"meta":"'.$data['c23'].'"},{"mes":4,"meta":"'.$data['c24'].'"},{"mes":5,"meta":"'.$data['c25'].'"},{"mes":6,"meta":"'.$data['c26'].'"},{"mes":7,"meta":"'.$data['c27'].'"},{"mes":8,"meta":"'.$data['c28'].'"},{"mes":9,"meta":"'.$data['c29'].'"},{"mes":10,"meta":"'.$data['c30'].'"},{"mes":11,"meta":"'.$data['c31'].'"},{"mes":12,"meta":"'.$data['c32'].'"}]';
                            
                            /*
                            mysqli_query($connect_desempenio,"INSERT INTO Objetivos_Colaborador (
                                id_empleado, anio, objetivo, indicador, formula, fuente, meta, obj_meses, obj_meses_resultados, fecha_cumplimiento, observaciones, 	
                                observaciones_puntaje, asunto_firma, asunto_firma_puntaje, cultura_organizacional, cultura_organizacional_puntaje, comentarios_generales, puntaje_guia_old, created_at ) 
                            VALUES (
                                '".$dataColaborador['id']."', '2020', '".$data['c4']."', '".$data['c5']."', '".$data['c6']."', '".$data['c7']."' , '".$data['c8']."', '".$obj."', 
                                '".$obj_resultado."', '".$data['c9']."', '".$data['c34']."', 
                                '".$data['c36']."', '".$data['c37']."', '".$data['c38']."', '".$data['c39']."', '".$data['c40']."', '".$data['c42']."',  '".$data['c35']."', '".$hoy."' 
                            ) 
                            ");
                            */
                            
                            
                            
                        }


                        echo '
                        <tr>
                            <td>'.$dataColaborador["nombre"].' '.$dataColaborador["apellidos"].'</td>
                            <td>'.$dataColaborador["documento"].'</td>
                            <td>'.$data["c1"].'</td>
                            <td>'.$data["c3"].'</td>
                            <td>'.$data["c35"].'</td>
                            <td>'.$data["c36"].'</td>
                            <td>'.$data["c37"].'</td>
                            <td>'.$data["c38"].'</td>
                            <td>'.$data["c39"].'</td>
                            <td>'.$data["c40"].'</td>
                            <td>'.$data["c41"].'</td>
                            <td>'.$data["c42"].'</td>
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



