<script>  
$(document).ready(function(){
    $("#bt_val_seguimiento").addClass("active_item");
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

<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<?php
	include("app/models/Collaborators.php");
	$ClassCollaborators = new Collaborators();
	$colaboradores = $ClassCollaborators->lista_colaboradores($connect_valentina, 1);

	$sentencia = "
		SELECT 
		Empleados.id AS id, 
		Empleados.estado AS estado, 
		Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2, 
		Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2, 
		Empleados.correo AS correo, 
		Empleados.role AS role, 
		Empleados.documento AS documento, 
		Empleados.foto_formal AS foto_formal, 
		Cargos.nombre AS cargo_nombre, 
		Areas.nombre AS area_nombre, 
		Gerencias.nombre AS gerencia_nombre,
        ad.preferencia
		FROM Empleados 
		LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
		LEFT JOIN Areas ON Areas.id = Empleados.id_area 
		LEFT JOIN Gerencias ON Gerencias.id = Empleados.id_departamento 
        RIGHT JOIN Empleados_Adicionales  as ad ON ad.id_empleado = Empleados.id
		WHERE Empleados.estado = 1 
	";
                    
	$array_colaboradores = array();
	$query = mysqli_query($connect_valentina, $sentencia);  
	while($data = mysqli_fetch_array($query)){ 
		$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' " );  
		$dataAdd = mysqli_fetch_array($queryAdd);
		$nombre_completoj = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"].' '.$data["apellidos_2"]);
		if($dataAdd["preferencia"]){
			$nombre_completoj = $dataAdd["preferencia"]." ".$data["apellidos"].' '.$data["apellidos_2"];
		}
		$data["nombre_completo"] = $nombre_completoj;
		array_push($array_colaboradores, $data );
	}
	foreach ($array_colaboradores as $key => $row) {
		$aux[$key] = $row['nombre'];
	}
	array_multisort($aux, SORT_ASC, $array_colaboradores);
?>

<?php 
    $terminadas = 0;
    $en_proceso = 0;
    $pendientes = 0;
    $TABLA_GENERAL = "";

    $count = 1;
	foreach($colaboradores as $data){
		
		$queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data["id_area"]."' ");  
		$dataArea = mysqli_fetch_array($queryArea);
            
		$lista_reportes = '';
		$queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
		WHERE id_empleado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
		while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
                
                $queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  
                anio = '".$dataCicloVal["anio"]."' AND id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  
                tipo_evaluacion = '".$dataEvaluadores["tipo"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
                $dataEvaluacion = mysqli_fetch_array($queryEvaluaciones);
			
				
			
				
                
			/*
                $queryEvaluador = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_evaluador"]."' ");  
                $dataEvaluador = mysqli_fetch_array($queryEvaluador);
				
				//PARA VALIDAR EL NOMBRE DE PREFERENCIA
				$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataEvaluador["id_evaluador"]."' " );  
				$dataAdd = mysqli_fetch_array($queryAdd);
				$nombre_completo = strtoupper($dataEvaluador["nombre"]." ".$dataEvaluador["nombre_2"]." ".$dataEvaluador["apellidos"]." ".$dataEvaluador["apellidos_2"]);
				if($dataAdd["preferencia"]){
					$nombre_completo = strtoupper($dataAdd["preferencia"]." ".$dataEvaluador["apellidos"]." ".$dataEvaluador["apellidos_2"]);
				}
				*/
                
                $tipo_txt = '';
                foreach($array_Tipo_Colaborador as $tipo){
                    if($tipo[0] == $dataEvaluadores["tipo"]){
                        $tipo_txt =  $tipo[1];
                    }
                }
                
                $color_estado = "";
                $txt_estado = "Sin iniciar";
                if($queryEvaluaciones->num_rows > 0){
                    if($dataEvaluacion["estado"] == 1){
                        $txt_estado = 'En Proceso ';
                        $color_estado = '#00bcd4 ';
                        $en_proceso++;
                    }

                    if($dataEvaluacion["estado"] == 2){
                        $txt_estado = 'Terminada';
                        $color_estado = '#3ce663 ';
                        $terminadas++;
                    }  
                }
                else{
                    $pendientes++;
                }
			
				$Evaluador = $ClassCollaborators->colaborador($connect_valentina, $dataEvaluadores["id_evaluador"]);

                $lista_reportes .= '
                <tr>
                    <td colspan="4" style="border-color: #fafafa;"></td>
                    <td style="border-color: #fafafa;">'.$tipo_txt.'</td>
                    <td style="border-color: #fafafa;">'.$Evaluador[0]["nombre_completo"].'</td>
                    <td style="border-color: #fafafa;" align="center" bgcolor="'.$color_estado.'" >
                        '.$txt_estado.'
                    </td>
                </tr>
                ';
		}
            
		$TABLA_GENERAL .= '
            <tr>
                <td>'.$count.'</td>
                <td class="align-middle">'.$data["nombre_completo"].'</td>
                <td class="align-middle">'.$data["cargo_nombre"].'</td>
                <td class="align-middle">'.$data["area_nombre"].'</td>
                <td colspan="3">
                </td>        
            </tr>
		';
		$TABLA_GENERAL .= $lista_reportes;
            
		$count ++;
	}













	foreach($array_colaboradores__ as $data){
    //$query = mysqli_query($connect_valentina,"SELECT Empleados.id AS id, Empleados.nombre AS nombre, //Empleados.apellidos AS apellidos
    //FROM Empleados 
    
    //WHERE Empleados.estado = 1  ORDER BY Empleados.nombre ASC ");  
    //while($data = mysqli_fetch_array($query)){ 
            
            $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data["id_area"]."' ");  
            $dataArea = mysqli_fetch_array($queryArea);
            
            $lista_reportes = '';
            $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
            WHERE id_empleado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
            while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
                
                $queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  
                anio = '".$dataCicloVal["anio"]."' AND id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  
                tipo_evaluacion = '".$dataEvaluadores["tipo"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
                $dataEvaluacion = mysqli_fetch_array($queryEvaluaciones);
                
                $queryEvaluador = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_evaluador"]."' ");  
                $dataEvaluador = mysqli_fetch_array($queryEvaluador);
				
				//PARA VALIDAR EL NOMBRE DE PREFERENCIA
				$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataEvaluador["id_evaluador"]."' " );  
				$dataAdd = mysqli_fetch_array($queryAdd);
				$nombre_completo = strtoupper($dataEvaluador["nombre"]." ".$dataEvaluador["nombre_2"]." ".$dataEvaluador["apellidos"]." ".$dataEvaluador["apellidos_2"]);
				if($dataAdd["preferencia"]){
					$nombre_completo = strtoupper($dataAdd["preferencia"]." ".$dataEvaluador["apellidos"]." ".$dataEvaluador["apellidos_2"]);
				}
                
                $tipo_txt = '';
                foreach($array_Tipo_Colaborador as $tipo){
                    if($tipo[0] == $dataEvaluadores["tipo"]){
                        $tipo_txt =  $tipo[1];
                    }
                }
                
                $color_estado = "";
                $txt_estado = "Sin iniciar";
                if($queryEvaluaciones->num_rows > 0){
                    if($dataEvaluacion["estado"] == 1){
                        $txt_estado = 'En Proceso ';
                        $color_estado = '#00bcd4 ';
                        $en_proceso++;
                    }

                    if($dataEvaluacion["estado"] == 2){
                        $txt_estado = 'Terminada';
                        $color_estado = '#3ce663 ';
                        $terminadas++;
                    }  
                }
                else{
                    $pendientes++;
                }

                $lista_reportes .= '
                <tr>
                    <td colspan="4" style="border-color: #fafafa;"></td>
                    <td style="border-color: #fafafa;">'.$tipo_txt.'</td>
                    <td style="border-color: #fafafa;">'.$nombre_completo.'</td>
                    <td style="border-color: #fafafa;" align="center" bgcolor="'.$color_estado.'" >
                        '.$txt_estado.'
                    </td>
                </tr>
                ';
            }
            
            $TABLA_GENERAL .= '
            <tr>
                <td>'.$count.'</td>
                <td class="align-middle">'.$data["nombre_completo"].'</td>
                <td class="align-middle">'.$data["cargo_nombre"].'</td>
                <td class="align-middle">'.$data["area_nombre"].'</td>
                <td colspan="3">
                </td>        
            </tr>
            ';
            $TABLA_GENERAL .= $lista_reportes;
            
            
            $count ++;
    }
        
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






<div class="container-fluid"> 
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
                <div><?php echo $terminadas; ?></div>
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
                <div><?php echo $pendientes; ?></div>
            </div>
        </div>
    </div>
    
    <table class="table table-sm">
        <thead class="thead-dark">
        <tr>
            <th scope="col" width="15">#</th>
            <th scope="col">Colaborador</th>
            <th scope="col">Cargo</th>
            <th scope="col">Área/Proceso</th>
            <th scope="col">Tipo de Valoración</th>
            <th scope="col">Persona que lo evalúa</th>
            <th scope="col" width="30">Estado</th>
        </tr>
        </thead>

        <tbody>
            <?php echo $TABLA_GENERAL;?> 
        </tbody>
    </table>
    
</div>




