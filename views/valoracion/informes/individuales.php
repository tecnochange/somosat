<script>  
$(document).ready(function(){
    $("#bt_val_informes").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);

    $arrayEvaluadores = array();
	$queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
	while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
		array_push($arrayEvaluadores, $dataEvaluadores );
	}

    //CARGAMOS COMPETENCIAS EVALUACIONES
	$arrayCompetencias_Evaluaciones = array();
	$queryCompetencias_Evaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
	while($dataCompetencias_Evaluaciones = mysqli_fetch_array($queryCompetencias_Evaluaciones)){
		array_push($arrayCompetencias_Evaluaciones, $dataCompetencias_Evaluaciones );
	}

    //CARGAMOS CARGOS
	$arrayCargos = array();
	$queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empresa = '".$_SESSION['id_empresa']."' ");
	while($dataCargos = mysqli_fetch_array($queryCargos)){
		array_push($arrayCargos, $dataCargos );
	}

    //CARGAMOS AREAS
	$arrayAreas = array();
	$queryAreas = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id_empresa = '".$_SESSION['id_empresa']."' ");
	while($dataAreas = mysqli_fetch_array($queryAreas)){
		array_push($arrayAreas, $dataAreas );
	}

?>

<?php
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
    $nombres = "";
	while($data = mysqli_fetch_array($query)){ 
		$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' " );  
		$dataAdd = mysqli_fetch_array($queryAdd);
		//$nombre = $data["nombre"].' '.$data["nombre_2"].' '.$data["apellidos"].' '.$data["apellidos_2"];
		if($dataAdd["preferencia"]){
			$nombres = $dataAdd["preferencia"];
		}else{
            $nombres = $data["nombre"].' '.$data["nombre_2"];
        }
		$data["nombres_completo"] = $nombres;
		array_push($array_colaboradores, $data );
	}
	foreach ($array_colaboradores as $key => $row) {
		$aux[$key] = $row['nombre'];
	}
	array_multisort($aux, SORT_ASC, $array_colaboradores);
?>



<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Informes Individuales<b> <?php echo $dataCicloVal["anio"]." - ".$dataCicloVal["nombre"]; ?></b> </h2>
                    </td>
                    <td align="right">
                        <input type="text" class="form-control form-control-sm" id="buscar" placeholder="Buscar...">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php include("comp_escala.php"); ?>

<!--
<ul class="nav nav-tabs">   
    <li class="nav-item">
        <a class="nav-link active " href="?pg=valoracion/informes/individuales">Individuales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/areas">Area / Procesos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/informes/niveles">Niveles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/informes/organizacion">Organización</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/numericos">Numéricos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/estadisticas">Estadísticas</a>
    </li>
</ul>
-->

<!-- VALIDAMOS SI EXISTE UN CICLO SELECCIONADO -->
<!-- VALIDAMOS SI EXISTE UN CICLO SELECCIONADO -->
<!-- VALIDAMOS SI EXISTE UN CICLO SELECCIONADO -->
<?php if( $_SESSION['ciclo'] != ""){ ?>

<div class="alert alert-success" role="alert" align="center" id="alert_carga" style="margin-top: 15px">
    Estamos cargado la información. este proceso puede tardes unos segundos
    <img src="<?php echo $url; ?>/img/spinner.gif" width="100">
</div>

<div class="container-fluid">
<table class="table table-sm" style="font-size: 12px; display: none" id="tabla_contenido" >
  <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Evaluado</th>
        <th scope="col">Cédula</th>
        <th scope="col" style="width: 80px;">Cargo</th>
        <th scope="col">Area</th>
        <th scope="col" ># Evaluadores</th>
        <th scope="col" ># Evaluaciones</th>
        <th scope="col" >Promedio Ponderado</th>
        <th scope="col" >Tipo Ponderación</th>
        <th scope="col">Acciones</th>
    </tr>
  </thead>
    <tbody id="listado">
    <?php
        include("views/valoracion/informes/funciones.php");
        
        $count = 1;
		foreach($array_colaboradores as $data){							
        //CONSULTAMOS A TODOS LOS EMPLEADOS DE ESTA EMPRESA
        /*
			$query = mysqli_query($connect_valentina,"SELECT Empleados.id AS id, Empleados.cedula AS cedula, Empleados.nombre AS nombre, Empleados.apellidos AS apellidos, 
        Empleados.id_cargo AS id_cargo, Cargos.nombre AS nombre_cargo, Cargos.id_area AS id_area  
        FROM Empleados 
        LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
        WHERE Empleados.estado = 1 ORDER BY Empleados.nombre ASC ".$filtro." ");  
        while($data = mysqli_fetch_array($query)){ 
		*/
            
            //VALIDAMOS SI TIENE TODAS LAS EVALUACIONES Y EVALUADORES
            $VALIDACION = PromedioGeneralEvaluado( $data["id"], $connect_valoracion, $connect_valentina);
            $id_cargo = $VALIDACION["id_cargo"];
            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$id_cargo."' ");
	        $dataCargo = mysqli_fetch_array($queryCargo);

            $bt_acciones = '
            <a href="?pg=valoracion/informes/informe_consolidado&e='.$data["id"].'" target="_blank">
                <button type="button" class="btn btn-success btn-sm" style="border-radius: 30px; margin: 3px; ">
                    Consolidado
                </button>
            </a>
                    
            <a href="?pg=valoracion/informes/informe_evaluadores&e='.$data["id"].'" target="_blank">
                <button type="button" class="btn btn-warning btn-sm" style="border-radius: 30px; margin: 3px; ">
                    Evaluadores
                </button>
            </a>
            ';
            
            if($VALIDACION["no_evaluadores_evaluacion"]  == 0){
                $bt_acciones = 'Evaluaciones pendientes';
            }

            $txt_area = '';
            foreach($arrayAreas as $area){
                if( $area["id"] == $dataCargo["id_area"] ){
                    $txt_area = $area["nombre"];
                }
            }

            echo '
            <tr>
                <td>'.$count.'</td>
                <td class="align-middle">'.$data["nombres_completo"].' '.$data["apellidos"].' '.$data["apellidos_2"].'</td>
				<td class="align-middle">'.$data["documento"].'</td>
                <td class="align-middle">'.$data["cargo_nombre"].'</td>
                <td class="align-middle">'.$data["area_nombre"].'</td>   
                <td align="center">'.$VALIDACION["no_evaluadores"].'</td>
                <td align="center">'.$VALIDACION["no_evaluadores_evaluacion"].'</td>
                <td align="center">'.round( $VALIDACION["promedio"],1).'</td>
                <td>'.$VALIDACION["tipo_ponderacion"].'</td>
                <td>'.$bt_acciones.'</td>
            </tr>
            ';
            $count++;
        }
    ?>
    </tbody>
</table>
</div>
	
<?php } else{ ?>
<div class="col-md-12">
    <div class="alert alert-success" role="alert">
        Para realizar este proceso primero debe seleccionar un Ciclo.
    </div>
</div>
<?php } ?>



<script>
    $(window).on('load', function() {
        $("#alert_carga").fadeOut();
        $("#tabla_contenido").fadeIn();     
    });
    
    $("#buscar").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#listado tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
    
</script>



