<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
    
    $ciclo_cerrado = false;
    if($dataCicloVal["fecha_termina"] < date("Y-m-d") ){
        $ciclo_cerrado = true;
    }
?>

<?php
	$hoy = date("Y-m-d H:i:s");

	//CARGAMOS LOS NIVELES
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos  ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//CARGAMOS LOS NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}
?>

<?php echo $respuesta; ?>

<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Realizar Valoración</li>
  </ol>
</nav>

<div align="left" style="padding: 10px 0px;">
	<table width="100%">
    	<tr>
        	<td><h5 style="margin-top: 8px;"></i> Realizar Valoración <b><?php echo $dataCicloVal["nombre"]; ?></b></h5></td>
            <td align="right">
            	
            </td>
        </tr>
    </table>
    
    <?php if($ciclo_cerrado == true){ ?>
    <div class="alert alert-success" role="alert" align="center">
        Este ciclo ha finalizado, seleccione el siguiente ciclo y realice las evaluaciones programas para el mismo
    </div>
    <?php } ?>
    
</div>



<table class="table table-bordered table-sm">
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
        WHERE id_evaluador = '".$_SESSION['id_user_valentina']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
        while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
            
            $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_empleado"]."' ");  
            $dataEm = mysqli_fetch_array($queryEm);
            
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
            <a href="'.$url.'?pg=valoracion/evaluacion_competencia&eval='.$dataEvaluadores["id"].'">
                <button type="button" id="sidebarCollapse" class="btn btn-secondary btn-sm" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
            </a>';
            
            $update_at = 'En Proceso';
            $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND
            id_ciclo = '".$_SESSION['ciclo']."' AND 
            id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND  
            id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  
            anio = '".$_SESSION["anio"]."' AND  
            tipo = '".$dataEvaluadores["tipo"]."' ");
            
            if($queryEval->num_rows > 0){
                $dataEval = mysqli_fetch_array($queryEval);
                
                if($dataEval["estado"] == 1){
                    $bt_editar = '
                    En Proceso 
                    <a href="'.$url.'?pg=valoracion/evaluacion_competencia&e='.$dataEval["id"].'">
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
                    <td>'.$dataEm["nombre"].' '.$dataEm["apellidos"].'</td>
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

