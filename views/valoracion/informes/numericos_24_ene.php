<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<?php

//CARGAMOS LOS EVALUADORES
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
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Consolidados Numéricos <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right"> 
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

<div align="center" style="margin: 30px">
    <a href="?pg=valoracion/informes/numericos">
        <button type="button" id="sidebarCollapse" class="btn btn-warning" >
            <i class="fas fa-bell"></i> Consolidados
        </button>
    </a>
    <a href="?pg=valoracion/informes/numericos_competencias"> 
        <button type="button" id="sidebarCollapse" class="btn btn-primary" >
            <i class="fas fa-bell"></i> Competencias
        </button>
    </a>
    
    <a href="?pg=valoracion/informes/comportamientos">
        <button type="button" id="sidebarCollapse" class="btn btn-success" >
            <i class="fas fa-bell"></i> Comportamiento
        </button>
    </a>

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


<?php
/*
    $paginacion = $_GET["p"];
    if($_GET["p"] == ""){$paginacion = 0;}
    $filtro = " LIMIT 100 OFFSET ".$paginacion." ";
    //$filtro = "  ";

    $queryCount = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
    WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC "); 

    $cant_pagina = ceil($queryCount->num_rows/100);
*/
?>



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
          <a class="page-link" href="<?php echo $url.'/?pg=valoracion/informes/numericos&p='.$anterior; ?>">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        
        <?php 
        for ($i = 1; $i <= $cant_pagina; $i++) {
            if($pag_activa == $i){
                echo '
                    <li class="page-item active">
                        <a class="page-link" href="'.$url.'/?pg=valoracion/informes/numericos&p='.$i.'">'.$i.'</a>
                    </li>
                ';
            }
            else{
                echo '
                    <li class="page-item">
                        <a class="page-link" href="'.$url.'/?pg=valoracion/informes/numericos&p='.$i.'">'.$i.'</a>
                    </li>
                ';
            }
        }
        ?>

        <li class="page-item">
          <a class="page-link" href="<?php echo $url.'/?pg=valoracion/informes/numericos&p='.$siguiente; ?>" >
            <span aria-hidden="true">&raquo;</span>
          </a>
    </li>

  </ul>
</nav>


<table class="table table-sm table-bordered" >
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Evaluado</th>
        <th scope="col" style="width: 80px;">Cargo</th>
        <th scope="col">Area</th>
        <th scope="col">Tipo</th>
        <th scope="col">Evaluador</th>
        <th scope="col">Promedio</th>
        <th scope="col">Promedio general</th>
        <th scope="col">Promedio general %</th>
    </tr>
    </thead>
    <tbody>
        
    <?php
        include("views/valoracion/informes/metodo_ponderacion.php");
        
        $count = $posicion+1;
        //CONSULTAMOS A TODOS LOS EMPLEADOS DE ESTA EMPRESA
        $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
        WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ".$filtro." ");  
        while($data = mysqli_fetch_array($query)){ 
            
            //VALIDAMOS SI TIENE TODAS LAS EVALUACIONES Y EVALUADORES
            $validar = ValidarEvaluacionesCompletas($arrayEvaluadores, $arrayCompetencias_Evaluaciones, $data["id"]);
            $permitir = $validar["permitir"];
            $no_evaluadores = $validar["no_evaluadores"];

            if($permitir == false){
                $bt_acciones = 'Evaluaciones pendientes';
                $txt_promedio = 0;
            }
            
            $id_area = 0;
            $text_cargo = '';
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
            print_r($ponderacion_empleado);
            break;
            */
            
            
            if($completo == false){
                $txt_promedio = 'Incompleto';
            }
            
            echo '
            <tr>
                <td>'.$count.'</td>
                <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                <td>'.$text_cargo.'</td>
                <td>'.$txt_area.'</td> 
                <td>'.$lista_tipos.'</td>
                <td>'.$lista_evaluadores.'</td>
                <td>'.$lista_promedio.'</td>
                
                <td title="'.$txt_tipo.'">
                    <b>'.$txt_promedio.'</b>
                </td>
                <td>
                    <b>'.(($txt_promedio*100)/4).'%</b>
                </td>
            </tr>
            ';
            $count++;
    
        }
        
    ?>
        
        
        <?php
        
        
        
        
 /*
        include("views/valoracion/informes/metodo_ponderacion.php");
        
        $count = 1;
        //CONSULTAMOS A TODOS LO EMPLEADOS
        $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ");  
        while($data = mysqli_fetch_array($query)){ 
            
            //DATOS DEL CARGO
            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
            $dataCargo = mysqli_fetch_array($queryCargo);
            
            //DATOS DEL AREA
            $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
            $dataArea = mysqli_fetch_array($queryArea);
            
            //METODO PARA OBTENER LA PONDERACION POR EMPLEADO
            $ponderacion_empleado = PonderacionNumericaEmpleado( $connect_valoracion, $connect_valentina, $data["id"]  );
            
            $tabla = '';
            $lista_tipos = '';
            $lista_evaluadores = '';
            $lista_promedios = '';
            
            
            foreach( $ponderacion_empleado["tabla"] as $fila ){
                
                $tipo_txt = '';
                foreach($array_Tipo_Colaborador as $tipo){
                    if($tipo[0] == $fila[0]){ 
                            $tipo_txt = $tipo[1];
                    }
                }
                
                
                
                $lista_tipos .= $tipo_txt.' <br>';
                $lista_evaluadores .= $fila[1]."<br>";
                $lista_promedios .= $fila[2]."<br>";
                
            }

            echo '
                <tr>
                    <td>'.$count.'</td>
                    <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                    <td>'.$dataCargo["nombre"].'</td>
                    <td>'.$dataArea["nombre"].'</td>      
                    <td>'.$lista_tipos.'</td>
                    <td>'.$lista_evaluadores.'</td>
                    <td>'.$lista_promedios.'</td>
                    <td title="'.$ponderacion_empleado["datos"]["tipo"].'">
                        <b>'.$ponderacion_empleado["datos"]["total"].'</b>
                    </td>
                    <td>
                        <b>'.(($ponderacion_empleado["datos"]["total"]*100)/4).'%</b>
                    </td>
                </tr>
            ';
        
            //echo $tabla;
            $count++;

        }
        */
      
      ?>
      
    
    
  </tbody>
</table>















<script>
  
    $("#bt_val_informes").addClass("active_item");
    
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
    
    function Reactivar_Evaluacion(id){
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de reactivar este formulario, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Reactivar_Evaluacion('+id+')"> Reactivar Formulario </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"reactivar_formulario.php",
                type:'post',
                data: {id: id, url:"?pg=valoracion/formularios"},
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
    
    
    function Elinar_Evaluacion(id, id_evaluado, id_evaluador, tipo){
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de borrar este formulario, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elinar_Evaluacion('+id+', '+id_evaluado+', '+id_evaluador+', '+tipo+', )"> Eliminar Formulario </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_formulario.php",
                type:'post',
                data: {id: id, id_evaluado: id_evaluado, id_evaluador: id_evaluador,  id_tipo: tipo, url:"?pg=valoracion/formularios"},
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



