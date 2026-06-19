<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Seguimiento Valoración <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right">
                        
                        
                    </td>
                </tr>
            </table>
            
        </div>
    </div>
</div>


<ul class="nav nav-tabs">  
  
    <li class="nav-item">
        <a class="nav-link active " href="?pg=valoracion/seguimiento">Seguimiento Valoración</a>
    </li>
  
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/formularios">Formularios Valoración</a>
    </li>

</ul>




<div class="row">
    <div class="col-md-4">
        <div style="background-color: #3ce663; font-size: 20px; padding: 10px;" align="center">
            <div>Evaluaciones terminadas</div>
            <div><?php echo $terminado; ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background-color: #00bcd4; font-size: 20px; padding: 10px;" align="center">
            <div>Evaluaciones en proceso</div>
            <div><?php echo $en_proceso; ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background-color: #ffbeba; font-size: 20px; padding: 10px;" align="center">
            <div>Evaluaciones Pendientes</div>
            <div><?php echo $pendiente; ?></div>
        </div>
    </div>
</div>



<table class="table table-hover table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" width="15">#</th>
        <th scope="col">Nombre Colaborador</th>
        <th scope="col">Tipo de Valoración</th>
        <th scope="col">Persona que lo evalúa</th>
        <th scope="col" width="30">Estado</th>
        <th scope="col" width="30">Promedio</th>
	</tr>
	</thead>
    
	<tbody>
        
        <?php 
        $count = 1;
        //$queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  id_ciclo = '".$_SESSION['ciclo']."' ORDER BY id_evaluado ASC LIMIT 0, 20 ");
        //$queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones LIMIT 5999, 1000 ");
        $queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id = 1327 ");
        while($dataEvaluacion = mysqli_fetch_array($queryEvaluaciones)){ 
            
            $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluacion["id_evaluado"]."' ");  
            $dataEm = mysqli_fetch_array($queryEm);
            
            $queryEvaluador = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluacion["id_evaluador"]."' ");  
            $dataEvaluador = mysqli_fetch_array($queryEvaluador);

            $queryRespuestas = mysqli_query($connect_valoracion,"SELECT SUM(calificacion), COUNT(id) FROM Competencias_Respuestas_Comportamientos WHERE 
            id_empresa = '".$dataEvaluacion['id_empresa']."' AND  
            id_ciclo = '".$dataEvaluacion['id_ciclo']."' AND 
            id_evaluado = '".$dataEvaluacion["id_evaluado"]."' AND  
            id_evaluador = '".$dataEvaluacion["id_evaluador"]."' 
            ORDER BY id_evaluado ASC ");
            $dataRespuestas = mysqli_fetch_array($queryRespuestas);
            
            $promedio_general = 0;
            if($dataRespuestas["SUM(calificacion)"]){
                $promedio_general = round(( $dataRespuestas["SUM(calificacion)"] / $dataRespuestas["COUNT(id)"]),2);
                //linea para actualizar
                if($dataEvaluacion["promedio"] > 0){
                    
                }
                else{
                    //mysqli_query($connect_valoracion,"UPDATE Competencias_Evaluaciones SET promedio = '".$promedio_general."'  
                   // WHERE id = '".$dataEvaluacion["id"]."' ");
                }
                
                
            }

            $txt_estado = 'Pendiente';
            $color_estado = '#ffbeba';
            
            if($dataEvaluacion["estado"] == 1){
                $txt_estado = 'En Proceso ';
                $color_estado = '#00bcd4 ';
                $en_proceso++;
            }
                
            if($dataEvaluacion["estado"] == 2){
                $txt_estado = 'Terminada';
                $color_estado = '#3ce663 ';
                $terminado++;
            }
            
            $tipo_txt = '';
            foreach($array_Tipo_Colaborador as $tipo){
                if($tipo[0] == $dataEvaluacion["tipo"]){
                    $tipo_txt =  $tipo[1];
                }
            }
            
            
            
            echo '
            <tr>
                <td>'.$count.'</td>
                <td>'.$dataEm["nombre"].' '.$dataEm["apellidos"].'</td>
                <td>'.$tipo_txt.'</td>
                <td>'.$dataEvaluador["nombre"].' '.$dataEvaluador["apellidos"].'</td>
                <td bgcolor="'.$color_estado.'">'.$txt_estado.'</td>
                <td>'.$promedio_general.' / '.$dataEvaluacion["promedio"].'</td>
                       
            </tr>
            ';
            
            
            $count++;
        
        }

        ?>

	</tbody>
</table>












<script>
  
    $("#bt_val_seguimiento").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();


    
    
    
    var api = '<?php echo $url; ?>api/valoracion/';
    
    var activar = false;
    function Elimimar_Evaluador(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un evaluador, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Evaluador('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_evaluador.php",
                type:'post',
                data: {id: id, url:"?pg=valoracion/arbol"},
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



