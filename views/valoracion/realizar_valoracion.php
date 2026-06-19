<script>  
$(document).ready(function(){
    $("#bt_val_realizar").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
    
    $ciclo_cerrado = false;
    if($dataCicloVal["fecha_termina"] < date("Y-m-d") ){
        $ciclo_cerrado = true;
    }

    include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();
?>

<?php echo $respuesta; ?>

<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Realizar Valoración</li>
  </ol>
</nav>

<div align="left" style="padding: 5px 0px;">
	<h3 style="margin-top: 8px;"></i> Valoraciones para el <b><?php echo $dataCicloVal["nombre"]; ?></b> del año <b><?php echo $dataCicloVal["anio"]; ?></b></h3>
    
    <?php if($ciclo_cerrado == true){ ?>
    <div class="alert alert-success" role="alert" align="center">
        Este ciclo ha finalizado, seleccione el siguiente ciclo y realice las evaluaciones programas para el mismo
    </div>
    <?php } ?>
    
</div>



<table class="table table-bordered ">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
        <th scope="col">Persona Valorada</th>
        <th scope="col">Cargo</th>
        <th scope="col">Rol Valoración</th>
        <th scope="col">Estado Valoración</th>
        <th scope="col">Fecha Realización</th>
	</tr>
	</thead>
    
	<tbody>
	<?php
        $count = 1;
        
        $lista_evaluadores = '';
        $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
        WHERE id_evaluador = '".$_SESSION['id_user']."' AND anio = '".$_SESSION['anio']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
        while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){

            $colaborador = $ClassColaboradores->colaborador( $connect_valentina, $dataEvaluadores["id_empleado"] );
            
            $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados             
            WHERE Empleados.id = '".$dataEvaluadores["id_empleado"]."' ");  
            $dataEm = mysqli_fetch_array($queryEm);
			
			//PARA VALIDAR EL NOMBRE DE PREFERENCIA
			$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataEm["id"]."' " );  
			$dataAdd = mysqli_fetch_array($queryAdd);
			
			if($dataAdd["preferencia"]){
				$nombre_completo = strtoupper($dataAdd["preferencia"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"]);
			}else{
                $nombre_completo = strtoupper($dataEm["nombre"]." ".$dataEm["nombre_2"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"]);
            }
            
            $queryCar = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEm["id_cargo"]."' ");  
            $dataCar = mysqli_fetch_array($queryCar);
            
            $tipo_txt = '';
            foreach($array_Tipo_Colaborador as $tipo){
                if($tipo[0] == $dataEvaluadores["tipo"]){
                    $tipo_txt =  $tipo[1];
                }
            }
            
            $bt_editar = '
            Pendiente 
            <a href="'.$url.'?pg=valoracion/evaluacion&evaluado='.$dataEvaluadores["id_empleado"].'&t='.$dataEvaluadores["tipo"].'&cargo='.$dataEm["id_cargo"].'">
                <button type="button" id="sidebarCollapse" class="btn btn-secondary btn-sm" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
            </a>';
            
            $update_at = 'N/A';
            $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE id_empresa = '".$_SESSION['id_empresa']."' AND
            id_ciclo = '".$_SESSION['ciclo']."' AND 
            id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND  
            id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  
            anio = '".$_SESSION["anio"]."' AND  
            tipo_evaluacion = '".$dataEvaluadores["tipo"]."' ");
            
            if($queryEval->num_rows > 0){
                $dataEval = mysqli_fetch_array($queryEval);
                
                if($dataEval["estado"] == 1){
                    $bt_editar = '
                    En Proceso 
                    <a href="'.$url.'?pg=valoracion/evaluacion&id='.$dataEval["id"].'">
                        <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                    </a>';
                }
                
                if($dataEval["estado"] == 2){
                    $update_at = $dataEval["update_at"];
                    $bt_editar = 'Terminada';
                }
            }
            
            if($ciclo_cerrado == true){
                $bt_editar = 'Ciclo Finalizado';
            }

            echo '
                <tr>
                    <td title="'.$dataEval["id"].'">'.$count.'</td>
                    <td>'.$colaborador[0]["nombre_completo"].'</td>
                    <td>'.$dataCar["nombre"].'</td>
                    <td>'.$tipo_txt.'</td>
                    <td align="center">
                        '.$bt_editar.'
                    </td>
                    <td>
                        '.$update_at.'
                    </td>
                            
                           
                </tr>
                        
            ';
            $count++;
        }
 
	?>
	</tbody>
</table>


<script>
    $("#bt_val_realizar").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

