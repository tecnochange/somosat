<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>


<?php

    if($_POST["corte"] != "" && $_POST["id_nivel_cargo"] != "" ){
        mysqli_query($connect_valentina,"UPDATE Cargos SET corte = '".$_POST["corte"]."' WHERE nivel_cargo = '".$_POST["id_nivel_cargo"]."' 
        AND id_empresa = '".$_SESSION['id_empresa']."' ");
        
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

?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Informes Estadísticas <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                        <p>Al definir los puntos de corte, escribir punto (.) para separar decimales.</p>
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
        <a class="nav-link " href="?pg=valoracion/informes/numericos">Numéricos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/informes/estadisticas">Estadísticas</a>
    </li>
</ul>




<table class="table table-sm" >
  <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nivel Cargo</th>
        <th scope="col">Cargos</th>
        <th scope="col">Promedios</th>
        <th scope="col">Punto de Corte</th>
    </tr>
  </thead>
    <tbody>
    <?php
        
        include("views/valoracion/informes/controladores_informes.php");
        
        $count = 1;
        foreach($Array_Nivel_Cargo as $nivel){
            
            $lista_cargos = '';
            
            $promedio = 0;
            $cantidad = 0;
            $total = 0;
            
            $corte = 0;
            
            foreach($arrayCargos as $cargo){
                if( $cargo["nivel_cargo"] == $nivel[0] ){
                    $lista_cargos .= $cargo["nombre"]."<br>";
                    $corte = $cargo["corte"];
                    
                    foreach($arrayEmpleados as $empleado){
                        
                        if( $empleado["id_cargo"] == $cargo["id"] ){
                            
                            
                            //CARGAMOS TODAS LAS RESPUESTAS DEL EMPLEADO
                            $arrayComRespuestas = array();
                            $queryComRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE id_evaluado = '".$empleado["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
                            while($dataComRespuestas = mysqli_fetch_array($queryComRespuestas)){
                                array_push($arrayComRespuestas, $dataComRespuestas );
                            }

                            //CARGAMOS TODAS LAS RESPUESTAS DEL EMPLEADO
                            $arrayRespuestas = array();
                            $queryRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos WHERE id_evaluado = '".$empleado["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
                            while($dataRespuestas = mysqli_fetch_array($queryRespuestas)){
                                array_push($arrayRespuestas, $dataRespuestas );
                            }
                            
                            $EVALUACIONES = ValidarEvaluacionesCompletas( $empleado["id"], $connect_valoracion, $connect_valentina);
                            
                            //$ponderacion_empleado = PonderacionPorEmpleado( $arrayEvaluadores, $arrayCompetencias_Evaluaciones, $arrayEmpleados, $empleado["id"], $arrayComRespuestas, $arrayRespuestas, $connect_valoracion );
                            
                            if( $EVALUACIONES["promedio_general"] > 0){
                                $promedio += $EVALUACIONES["promedio_general"];
                                $cantidad++;
                            }
                            
                            
                        }
                    
                    }
                    
                    $total = round( ($promedio/$cantidad) , 2) ;
                    if( is_nan($total)) { $total = "Sin evaluaciones";}
                    
                    
                }
                
                
            }
            
            if($total > 0){
            
                echo '
                <tr>
                    <td>'.$count.'</td>
                    <td>'.$nivel[1].'</td>
                    <td>'.$lista_cargos.'</td>
                    <td>'.$total.'</td>
                    <td>
                        <form action="" method="post">
                            <input type="text" max="3" min="0" placeholder="Entre 1 y 4..." name="corte" style="width: 100px;" value="'.$corte.'"> 
                            <input type="hidden" name="id_nivel_cargo" value="'.$nivel[0].'">
                            <button type="submit" class="btn btn-success btn-sm" style="border-radius: 30px">
                                Guardar
                            </button>
                        </form>
                    </td>
                    
                </tr>
                ';
            }
        
            $count++;

        }


      
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



