<script>  
$(document).ready(function(){
    $("#bt_retro_individual").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>



<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Seguimiento Retroalimentación</h2>
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
                    <th scope="col">Colaborador</th>
                    <th scope="col">Area / Proceso</th>
                    <th scope="col">Jefe Asignado</th>
                    <th scope="col">Retroalimentación</th>
                    <th scope="col"># Retroalimentaciones</th>
                </tr>
                </thead>

                <tbody id="tabla_lista">
                <?php
                    $count = 1;
                    //$queryJefes = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_jefe = '".$_SESSION['id_user_valentina']."' ");  
                    
                    
                    $queryEmp = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 "); 
                    while( $dataEmp = mysqli_fetch_array($queryEmp) ){
                        
                        
                        $lista_jefes = '';
                        $queryJefes = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_empleado = '".$dataEmp["id"]."' ");  
                        while($dataJefes = mysqli_fetch_array($queryJefes)){
                            $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataJefes["id_jefe"]."' ");  
                            $dataEm = mysqli_fetch_array($queryEm);

                                                    
                            $queryAd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataEm['id']."' " );  
                            $dataAd = mysqli_fetch_array($queryAd);
                            
                            $colaborado = "";
                            if($dataAd["preferencia"] !== ""){
                                $colaborado = strtoupper($dataAd["preferencia"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"]);
                            }else{
                                $colaborado = strtoupper($dataEm["nombre"].' '.$dataEm["nombre_2"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"]);
                            }

                            
                            $queryCro = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEm["id_cargo"]."' ");  
                            $dataCro = mysqli_fetch_array($queryCro);
                            
                            $lista_jefes .= '
                                <div style="margin-bottom: 10px;">
                                    '.$colaborado.' - '.$dataCro["nombre"].'
                                </div>
                            ';
                        }
                        
                        
                        
                        
                        
                        
                        
                        $queryJefe = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_empleado = '".$dataEmp['id']."' ");  
                        $dataJefe = mysqli_fetch_array($queryJefe);                                               
                        
                        $queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataEmp['id']."' " );  
		                $dataAdd = mysqli_fetch_array($queryAdd);
                        
                        $colaborador = "";
                        if($dataAdd["preferencia"] !== ""){
                            $colaborador = strtoupper($dataAdd["preferencia"]." ".$dataEmp["apellidos"]." ".$dataEmp["apellidos_2"]);
                        }else{
                            $colaborador = strtoupper($dataEmp["nombre"].' '.$dataEmp["nombre_2"]." ".$dataEmp["apellidos"]." ".$dataEmp["apellidos_2"]);
                        }

                        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEmp["id_cargo"]."' ");  
                        $dataCargo = mysqli_fetch_array($queryCargo);
                        
                        $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
                        $dataArea = mysqli_fetch_array($queryArea);
                        
                        $queryEncurso = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion WHERE id_empleado = '".$dataEmp['id']."' ");  
                        
                        $text_boton = 'Sin retroalimentación';
                        if($queryEncurso->num_rows > 0){
                            $text_boton = '
                                <a href="?pg=valoracion/retroalimentacion/seguimiento_general&e='.$dataEmp["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm">
                                    Seguimiento
                                </button>
                                </a>
                            ';
                        }
                        
                        $queryCount = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion WHERE id_empleado = '".$dataEmp['id']."' ");
                    
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$colaborador.'</td>
                            <td>'.$dataArea["nombre"].'</td>
                            <td>'.$lista_jefes.'</td>
                            
                            
                            <td>
                                '.$text_boton.'
                            </td>
                            
                            <td align="center">
                                <b>'.$queryCount->num_rows.'</b>
                            </td>
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
    
    $("#bt_retro_individual").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();

    
    
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



