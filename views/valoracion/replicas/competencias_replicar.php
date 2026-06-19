<?php
    $hoy = date("Y-m-d H:i:s");

    if($_POST["guardar_replicar"] != ""){
        
        $queryTmp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias 
        WHERE anio = '".$_POST["anio_anterior"]."' AND id_ciclo = '".$_POST["id_ciclo_anterior"]."' AND id_empresa = '".$_SESSION['id_empresa']."' ORDER BY id ASC ");  
        while($dataTmp = mysqli_fetch_array($queryTmp)){ 
            
            //BUSCAMOS EL TIPO DE COMPETENCIA ANTERIOR
            $queryAntTipo = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id = '".$dataTmp["id_tipo"]."' ");  
            $dataAntTipo = mysqli_fetch_array($queryAntTipo);
            
            //BUSCAMOS EL TIPO DE COMPETENCIA QUE COINCIDE
            $queryNewTipo = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION["anio"]."' 
            AND nombre = '".$dataAntTipo["nombre"]."' ");  
            $dataNewTipo = mysqli_fetch_array($queryNewTipo);
            
            mysqli_query($connect_valoracion,"INSERT INTO Competencias (id_empresa, anio, id_ciclo, nombre, definicion, id_tipo, created_at, update_at) 
            VALUES 
            ('".$_SESSION['id_empresa']."', '".$_SESSION['anio']."', '".$_SESSION['ciclo']."', '".$dataTmp["nombre"]."', '".$dataTmp["definicion"]."', 
            '".$dataNewTipo["id"]."', '".$hoy."', '".$hoy."' ) ");
            
            $id_temp = mysqli_insert_id($connect_valoracion);
            
            //echo $dataTmp["nombre"]."<hr>";
                                
            $queryNiveles = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id_competencia = '".$dataTmp["id"]."' 
            AND id_ciclo = '".$_POST["id_ciclo_anterior"]."'  ORDER BY id DESC ");
            while($dataNiveles = mysqli_fetch_array($queryNiveles)){
                
                //BUSCAMOS EL NIVEL DE COMPETENCIA ANTERIOR
                $queryAntNivel = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id = '".$dataNiveles["id_nivel"]."' ");  
                $dataAntNivel = mysqli_fetch_array($queryAntNivel);

                //BUSCAMOS EL TIPO DE COMPETENCIA QUE COINCIDE
                $queryNewNivel = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION["anio"]."' 
                AND nombre = '".$dataAntNivel["nombre"]."' ");  
                $dataNewNivel = mysqli_fetch_array($queryNewNivel);
                
                mysqli_query($connect_valoracion,"INSERT INTO Competencias_Niveles (id_empresa, anio, id_ciclo, id_competencia, id_nivel, created_at, update_at) 
                VALUES 
                ('".$_SESSION['id_empresa']."', '".$_SESSION['anio']."', '".$_SESSION['ciclo']."', '".$id_temp."', '".$dataNewNivel["id"]."', 
                '".$hoy."', '".$hoy."' ) ");
                
                $id_tempNivel = mysqli_insert_id($connect_valoracion);
                
                //echo $dataNiveles["id_nivel"].":<br>";

                $queryPreguntas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE id_nivel_competencia = '".$dataNiveles["id"]."' 
                AND id_ciclo = '".$_POST["id_ciclo_anterior"]."'ORDER BY id DESC ");
                while($dataPreguntas = mysqli_fetch_array($queryPreguntas)){
                    
                    //echo $dataPreguntas["pregunta"].'<br>'; 
                    
                    mysqli_query($connect_valoracion,"INSERT INTO Competencias_Preguntas (id_empresa, anio, id_ciclo, id_competencia, id_nivel_competencia, indicador, pregunta, contra_pregunta, fortaleza, oportunidad, created_at, update_at) 
                    VALUES 
                    ('".$_SESSION['id_empresa']."', '".$_SESSION['anio']."', '".$_SESSION['ciclo']."', '".$id_temp."', '".$id_tempNivel."',  '".$dataPreguntas["indicador"]."', 
                    '".$dataPreguntas["pregunta"]."', '".$dataPreguntas["contra_pregunta"]."', '".$dataPreguntas["fortaleza"]."', '".$dataPreguntas["oportunidad"]."', 
                    '".$hoy."', '".$hoy."' ) ");
                    
                }
            }

        }
        
        echo '<script> window.location = "'.$url.'?pg=valoracion/competencias"; </script>';
    }

    
    


    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);

    $queryCicloAnterior = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id != '".$_SESSION['ciclo']."' AND id < '".$_SESSION['ciclo']."'  AND id_empresa = '".$_SESSION['id_empresa']."'  ORDER BY id DESC ");
    $dataCicloAnterior = mysqli_fetch_array($queryCicloAnterior);

    //NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$dataCicloAnterior['anio']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}

?>



<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%" style="margin-bottom: 10px">
                <tr>
                    <td>
                        <h2>Replicar Competencias para el año <b><?php echo $_SESSION["anio"]; ?></b> de Ciclo: <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right">
                        <a href="<?php echo $url; ?>?pg=valoracion/arbol">
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
                        <input type="hidden" name="anio_anterior" value="<?php echo $dataCicloAnterior["anio"]; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">
                            Confirmar Replicar Ciclo Anterior
                        </button>
                        </form>
                    </div>
                    
                    <table class="table table-bordered table-sm" style="margin-top: 15px">
                        <thead class="thead-success">
                        <tr>
                            <th scope="col" width="15">#</th>
                            <th scope="col">Año</th>
                            <th scope="col">Competencias</th>
                            <th scope="col">Nivel</th>
                            <th scope="col">Preguntas</th>
                        </tr>
                        </thead>

                        <tbody id="tabla_lista">
                        <?php
                            $count = 1;
                            $query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias 
                            WHERE anio = '".$dataCicloAnterior["anio"]."' AND id_empresa = '".$_SESSION['id_empresa']."' ORDER BY id DESC ");  
                            while($data = mysqli_fetch_array($query)){ 
                                
                                echo '
                                <tr>
                                    <td>'.$count.'</td>
                                    <td>'.$data["anio"].'</td>
                                    <td>'.$data["nombre"].'</td>
                                    <td colspan="2"></td>
                                </tr>
                                ';
                                
                                $queryNiveles = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id_competencia = '".$data["id"]."' ORDER BY id DESC ");
                                while($dataNiveles = mysqli_fetch_array($queryNiveles)){

                                    $text_nivel = '';
                                    foreach ($arrayNiveles as $nivel) {
                                        if( $dataNiveles["id_nivel"] == $nivel[0] ){ $text_nivel = $nivel[1]; }
                                    }

                                    $queryPreguntas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE id_nivel_competencia = '".$dataNiveles["id"]."' ORDER BY id DESC ");
                                    while($dataPreguntas = mysqli_fetch_array($queryPreguntas)){

                                        echo '
                                        <tr>
                                            <td colspan="3"></td>
                                            <td><b>'.$text_nivel.'</b></td>
                                            <td>'.$dataPreguntas["pregunta"].'</td>
                                        </tr>
                                        ';

                                    }
                                }
                                
                                

                                
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
  
    $("#bt_val_competencias").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();


    
    
    
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



