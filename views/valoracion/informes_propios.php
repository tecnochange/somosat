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

    include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();

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

<ul class="nav nav-tabs">  
    
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/informes_propios">Informes Propios</a>
    </li>
    <?php if($_SESSION['role_plataforma'] == 1 || $_SESSION['role_plataforma'] == 2 ){ ?>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes_equipo">Informes Equipo</a>
    </li>
    <?php } ?>
    
</ul>

<?php include("comp_escala.php"); ?>


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
    $posicion = ($pag_activa-1)*$limite;

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


<table class="table " style="font-size: 12px; display: none" id="tabla_contenido" >
  <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Evaluado</th>
        <th scope="col">Cédula</th>
        <th scope="col" style="width: 80px;">Cargo</th>
        <th scope="col">Area</th>
        <th scope="col" ># Evaluadores</th>
        <th scope="col" ># Evaluaciones</th>
        <th scope="col">Acciones</th>
    </tr>
  </thead>
    <tbody id="listado">
    <?php
        include("views/valoracion/informes/funciones.php");
									
									
        
        $count = $posicion+1;
        //CONSULTAMOS A TODOS LOS EMPLEADOS DE ESTA EMPRESA
        $query = mysqli_query($connect_valentina,"SELECT Empleados.id AS id, Empleados.documento AS cedula, Empleados.nombre AS nombre, Empleados.apellidos AS apellidos, 
        Empleados.id_cargo AS id_cargo, Cargos.nombre AS nombre_cargo, Cargos.id_area AS id_area  
        FROM Empleados 
        LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
        WHERE Empleados.estado = 1 AND Empleados.id = '".$user_log['id']."' ORDER BY Empleados.nombre ASC ".$filtro." ");  
        while($data = mysqli_fetch_array($query)){ 

            $colaborador = $ClassColaboradores->colaborador( $connect_valentina, $data["id"] );
            
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
                <td>'.$colaborador[0]["nombre_completo"].'</td>
                <td>'.$data["cedula"].'</td>
                <td>'.$dataCargo["nombre"].'</td>
                <td>'.$txt_area.'</td>   
                <td align="center">'.$VALIDACION["no_evaluadores"].'</td>
                <td align="center">'.$VALIDACION["no_evaluadores_evaluacion"].'</td>
                <td>'.$bt_acciones.'</td>
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






















































