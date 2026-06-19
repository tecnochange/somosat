<?php
    $hoy = date("Y-m-d H:i:s");

    if($_POST["guardar_replicar"] != ""){
        $queryEvalTmp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Acciones WHERE id_ciclo = '".$_POST["id_ciclo_anterior"]."' ");  
        while($dataEvalTmp = mysqli_fetch_array($queryEvalTmp)){
            
            //ANTERIORES
            $queryTipoAnt = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id = '".$dataEvalTmp["id_tipo"]."' ");  
            $dataTipoAnt = mysqli_fetch_array($queryTipoAnt);
            
            $queryTipoNew = mysqli_query($connect_valoracion,"SELECT * FROM Tipos 
            WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND nombre = '".$dataTipoAnt["nombre"]."' ");  
            $dataTipoNew = mysqli_fetch_array($queryTipoNew);
            
            
            
            
            
            $queryNivelAnt = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id = '".$dataEvalTmp["id_nivel"]."' ");  
            $dataNivelAnt = mysqli_fetch_array($queryNivelAnt);
            
            $queryCompetenciasAnt = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataEvalTmp["id_competencia"]."' ");  
            $dataCompetenciasAnt = mysqli_fetch_array($queryCompetenciasAnt);
            
            
            
            
            
            $queryNivelAnt = mysqli_query($connect_valoracion,"SELECT * FROM Niveles 
            WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio =  '".$_SESSION['anio']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND nombre = '".$dataNivelAnt["nombre"]."' ");
            $dataNivelAnt = mysqli_fetch_array($queryNivelAnt);
            
            $queryCompetenciasAnt = mysqli_query($connect_valoracion,"SELECT * FROM Competencias 
            WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio =  '".$_SESSION['anio']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND nombre = '".$dataCompetenciasAnt["nombre"]."' "); 
            $dataCompetenciasAnt = mysqli_fetch_array($queryCompetenciasAnt);

            mysqli_query($connect_valoracion,"INSERT INTO Competencias_Acciones (id_empresa, anio, id_ciclo, id_tipo, id_nivel, id_competencia, accion, created_at) 
            VALUES 
            ('".$_SESSION['id_empresa']."', '".$_SESSION['anio']."', '".$_SESSION['ciclo']."', '".$dataTipoNew["id"]."', '".$dataNivelAnt["id"]."', '".$dataCompetenciasAnt["id"]."', '".$dataEvalTmp["accion"]."', '".$hoy."' ) "); 
			
        }

        echo '<script> window.location = "'.$url.'?pg=valoracion/competencias_acciones"; </script>';
    }
 

    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);

    $queryCicloAnterior = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id != '".$_SESSION['ciclo']."' AND id < '".$_SESSION['ciclo']."'  AND id_empresa = '".$_SESSION['id_empresa']."'  ORDER BY id DESC ");
    $dataCicloAnterior = mysqli_fetch_array($queryCicloAnterior);

    //TIPOS
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$dataCicloAnterior['anio']."' ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$dataCicloAnterior['anio']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}

?>

<script>
    $("#bt_val_competencias").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>


<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%" style="margin-bottom: 10px">
                <tr>
                    <td>
                        <h2>Replicar Acciones de desarrollo para el año <b><?php echo $_SESSION["anio"]; ?></b> de Ciclo: <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right">
                        <a href="<?php echo $url; ?>?pg=valoracion/competencias_acciones">
                        <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </button>
                        </a>
                    </td>
                    
                </tr>
            </table>
        </div>
        
        <?php if( $_SESSION['anio'] != "" ){ ?>
        
        <?php if($queryCicloAnterior->num_rows > 0){ ?>
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-body">
                    <h1>Ciclo Anterior: <b><?php echo $dataCicloAnterior["nombre"]; ?></b></h1>
                    
                    <div>
                        <div style="color: #DD0003; font-size: 18px; margin-bottom: 15px">
                            Procure utilizar este proceso con moderadación.<br>una vez completado deberá realizar los borrados de forma manual en caso de errores humanos como dobles replicas.
                        </div>
                        <form action="" method="post">
                        <input type="hidden" name="guardar_replicar" value="true">
                        <input type="hidden" name="id_ciclo_anterior" value="<?php echo $dataCicloAnterior["id"]; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">
                            Confirmar Replicar Ciclo Anterior
                        </button>
                        </form>
                    </div>
                    
                    <table class="table table-bordered table-sm" style="margin-top: 15px">
                        <thead class="thead-success">
                        <tr>
                            <th scope="col" style="width:50px">#</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Nivel</th>
                            <th scope="col">Competencia</th>
                            <th scope="col">Accion desarrollo</th>
                        </tr>
                        </thead>

                        <tbody id="tabla_lista">
                        <?php
                            $count = 1;
                            $query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Acciones WHERE id_empresa = '".$dtEmpleado['id_empresa']."' 
                            AND anio = '".$dataCicloAnterior['anio']."' ORDER BY id ASC ");
                            while($data = mysqli_fetch_array($query)){

                                $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$data["id_competencia"]."' ");
                                $dataComp = mysqli_fetch_array($queryComp);

                                $text_tipo = '';
                                foreach ($arrayTipos as &$tipo) {
                                    if( $data["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
                                }

                                $text_nivel = '';
                                foreach ($arrayNiveles as &$tipo) {
                                    if( $data["id_nivel"] == $tipo["0"] ){ $text_nivel = $tipo["1"]; }
                                }

                                echo '
                                <tr>
                                    <th scope="row">'.$count.'</th>
                                    <td>'.$text_tipo.'</td>
                                    <td>'.$text_nivel.'</td>
                                    <td>'.$dataComp["nombre"].'</td>
                                    <td>'.$data["accion"].'</td>
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
        <?php } else{ echo '<div align="center" style="width: 100%;">No hay ciclo anterior</div>'; } ?>
        
        <?php } ?>
    </div>



<script>
  
    
    var api = '<?php echo $url; ?>api/valoracion/';
    
    var activar = false;
    function Elimimar_Evaluador(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un evaluador, ESTO ELIMINARÁ LAS EVALUACIONES QUE REALIZÓ EL EVALUADOR. esta acción es irreversible ¿está seguro?<br><br>');
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



