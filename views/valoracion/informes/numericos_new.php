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
	$queryCompetencias_Evaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
	while($dataCompetencias_Evaluaciones = mysqli_fetch_array($queryCompetencias_Evaluaciones)){
		array_push($arrayCompetencias_Evaluaciones, $dataCompetencias_Evaluaciones );
	}

    //CARGAMOS LOS EMPLEADOS
	$arrayEmpleados = array();
	$queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_empresa = '".$_SESSION['id_empresa']."' AND estado = 1 AND role > 1 ");
	while($dataEmpleados = mysqli_fetch_array($queryEmpleados)){
		array_push($arrayEmpleados, $dataEmpleados );
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

<script>
    $("#bt_val_informes").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Informes Numéricos <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
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

<ul class="nav nav-tabs">   
    <li class="nav-item">
        <a class="nav-link  " href="?pg=valoracion/informes/individuales">Individuales</a>
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
        <a class="nav-link active" href="?pg=valoracion/informes/numericos">Numéricos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/estadisticas">Estadísticas</a>
    </li>
</ul>

<!-- VALIDAMOS SI EXISTE UN CICLO SELECCIONADO -->
<!-- VALIDAMOS SI EXISTE UN CICLO SELECCIONADO -->
<!-- VALIDAMOS SI EXISTE UN CICLO SELECCIONADO -->
<?php if( $_SESSION['ciclo'] != ""){ ?>

<div class="alert alert-success" role="alert" align="center" id="alert_carga" style="margin-top: 15px">
    Estamos cargado la información. este proceso puede tardes unos segundos
    <img src="<?php echo $url; ?>/img/spinner.gif" width="100">
</div>

<?php
    $limite = 100;
    $pag_activa = $_GET["p"];
    if($_GET["p"] == ""){ $pag_activa = 1; }
    $posicion = ($pag_activa-1)*100;

    $filtro = " LIMIT ".$limite." OFFSET ".$posicion." ";

    $queryCount = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
    WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC "); 
    $cant_pagina = ceil($queryCount->num_rows/$limite);

    $anterior = $pag_activa-1;
    $siguiente = $pag_activa+1;

    if($anterior < 1){
        $anterior = 1;
    }
    if($siguiente > $cant_pagina){
        $siguiente = $cant_pagina;
    }

?>

<nav aria-label="Page navigation example" style="margin-top: 15px;">
    <ul class="pagination justify-content-center" >
        <li class="page-item">
          <a class="page-link" href="<?php echo $url.'/?pg=valoracion/informes/individuales&p='.$anterior; ?>">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        
        <?php 
        for ($i = 1; $i <= $cant_pagina; $i++) {
            if($pag_activa == $i){
                echo '
                    <li class="page-item active">
                        <a class="page-link" href="'.$url.'/?pg=valoracion/informes/individuales&p='.$i.'">'.$i.'</a>
                    </li>
                ';
            }
            else{
                echo '
                    <li class="page-item">
                        <a class="page-link" href="'.$url.'/?pg=valoracion/informes/individuales&p='.$i.'">'.$i.'</a>
                    </li>
                ';
            }
        }
        ?>

        <li class="page-item">
          <a class="page-link" href="<?php echo $url.'/?pg=valoracion/informes/individuales&p='.$siguiente; ?>" >
            <span aria-hidden="true">&raquo;</span>
          </a>
    </li>

  </ul>
</nav>

<table class="table table-sm" style="font-size: 12px; display: none" id="tabla_contenido" >
  <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Evaluado</th>
        <th scope="col" style="width: 80px;">Cargo</th>
        <th scope="col">Area</th>
        <th scope="col" >Tipo</th>
        <th scope="col" >Evaluador</th>
        <th scope="col" >Promedio</th>
        <th scope="col" >Promedio General</th>
        <th scope="col" >Promedio General %</th>
    </tr>
  </thead>
    <tbody id="listado">
    <?php
        include("views/valoracion/informes/metodo_ponderacion_empleados.php");
        
        $count = $posicion+1;
        //CONSULTAMOS A TODOS LOS EMPLEADOS DE ESTA EMPRESA
        $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
        WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ".$filtro." ");  
        while($data = mysqli_fetch_array($query)){ 

            $text_cargo = '';
            $id_area = 0;
            foreach($arrayCargos as $cargo){
                if($cargo["id"] == $data["id_cargo"]){
                    $text_cargo = $cargo["nombre"];
                    $id_area = $cargo["id_area"];
                }
            }
            
            $txt_area = '';
            foreach($arrayAreas as $area){
                if( $area["id"] == $id_area ){
                    $txt_area = $area["nombre"];
                }
            }
            
            //CARGAMOS TODAS LAS RESPUESTAS DEL EMPLEADO
            $arrayComRespuestas = array();
            $queryComRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE id_evaluado = '".$data["id"]."' ");
            while($dataComRespuestas = mysqli_fetch_array($queryComRespuestas)){
                array_push($arrayComRespuestas, $dataComRespuestas );
            }
            
            //CARGAMOS TODAS LAS RESPUESTAS DEL EMPLEADO
            $arrayRespuestas = array();
            $queryRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos WHERE id_evaluado = '".$data["id"]."' ");
            while($dataRespuestas = mysqli_fetch_array($queryRespuestas)){
                array_push($arrayRespuestas, $dataRespuestas );
            }
            
            //OBTENEMOS LA PONDERACION DE ESTE EMPLEADO
            $ponderacion_empleado = PonderacionPorEmpleado( $arrayEvaluadores, $arrayCompetencias_Evaluaciones, $arrayEmpleados, $data["id"], $arrayComRespuestas, $arrayRespuestas, $connect_valoracion );
            
            $txt_promedio = $ponderacion_empleado["datos"]["total"];
            $txt_tipo = $ponderacion_empleado["datos"]["tipo"];
            $completo = $ponderacion_empleado["completo"];
            $tabla = $ponderacion_empleado["tabla"];
            
            $lista_tipos = '';
            $lista_evaluadores = '';
            $lista_promedio = '';
            foreach($tabla as $item){
                
                
                $tipo_txt = '';
                foreach($array_Tipo_Colaborador as $tipo){
                    if($tipo[0] == $item[0]){ 
                            $tipo_txt = $tipo[1];
                    }
                }
                
                $lista_tipos .= $tipo_txt.'<br>';
                $lista_evaluadores .= $item[1].'<br>'; 
                $lista_promedio .= $item[2].'<br>';
            }
            
            
            
            /*
            //AQUI INICIAN LAS FILAS DE LOS CANDIDATOS
                if($filas == ''){
                    $filas .=  '
                        <td>'.$dataCand["nombre"].' '.$dataCand["nombre_2"].' '.$dataCand["apellidos"].' '.$dataCand["apellidos_2"].'</td>
                        <td>'.$txt_psicometroca.'</td>
                        <td>'.$txt_entrevista.'</td>
                        <td>'.$txt_tecnica.'</td>
                        <td>'.$txt_situacional.'</td>
                        <td>'.$txt_seguridad.'</td>
                        <td>'.$txt_medico.'</td>
                        <td>'.$bt_informe.'</td>
                    ';
                }
                else{
                    $nuevas_filas .=  '
                    <tr>
                        <td>'.$dataCand["nombre"].' '.$dataCand["nombre_2"].' '.$dataCand["apellidos"].' '.$dataCand["apellidos_2"].'</td>
                        <td>'.$txt_psicometroca.'</td>
                        <td>'.$txt_entrevista.'</td>
                        <td>'.$txt_tecnica.'</td>
                        <td>'.$txt_situacional.'</td>
                        <td>'.$txt_seguridad.'</td>
                        <td>'.$txt_medico.'</td>
                        <td>'.$bt_informe.'</td>
                    </tr>
                    ';  
                }
            
            echo  '
            <tr>
                <td rowspan="'.count($candidatos_array).'">'.$count.'</td>
                <td rowspan="'.count($candidatos_array).'"><b>'.$data["nombre"].'</b></td>
                <td rowspan="'.count($candidatos_array).'">'.$txt_seleccionador.'</td>
                <td rowspan="'.count($candidatos_array).'">'.$txt_cliente.'</td>
                <td rowspan="'.count($candidatos_array).'">'.$data["created_at"].'</td>
                '.$filas.'
            </tr>
            ';
            echo $nuevas_filas;
            $count++;
            */
            
            
            
            
            
            
            
            

            echo '
            <tr>
                <td>'.$count.'</td>
                <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                <td>'.$text_cargo.'</td>
                <td>'.$txt_area.'</td>   
                <td>'.$lista_tipos.'</td>
                <td>'.$lista_evaluadores.'</td>
                <td>'.$lista_promedio.'</td>
                <td>'.round($txt_promedio,2).'</td>
                <td> <b>'.round( (($txt_promedio*100)/4),1 ).'%</b> </td>
                
            </tr>
            ';
            $count++;
        }
    ?>
    </tbody>
</table>

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



