<?php
    $hoy = date("Y-m-d H:i:s");

    if($_POST["guardar_replicar"] != ""){
        $queryEvalTmp = mysqli_query($connect_valoracion,"SELECT * FROM Perfiles_Cargos WHERE id_ciclo = '".$_POST["id_ciclo_anterior"]."' ");  
        while($dataEvalTmp = mysqli_fetch_array($queryEvalTmp)){
            
            $perfiles = explode("," , $dataEvalTmp["perfiles"] );
            $nuevo_perfil = "";
            
            foreach($perfiles as $perfil_nivel){
                
                //BUSCAMOS LOS DATOS DEL NIVEL ANTERIOR
                $queryAntNivel = mysqli_query($connect_valoracion,"SELECT Competencias.nombre AS nombre_competencia, Niveles.nombre AS nombre_nivel
                FROM Competencias_Niveles 
                LEFT JOIN Competencias ON Competencias.id = Competencias_Niveles.id_competencia 
                LEFT JOIN Niveles ON Niveles.id = Competencias_Niveles.id_nivel  
                WHERE Competencias_Niveles.id = '".$perfil_nivel."' ");  
                $dataAntNivel = mysqli_fetch_array($queryAntNivel);
                
                //echo $dataAntNivel["nombre_competencia"]."<br>";
                
                

                $queryNewNivel = mysqli_query($connect_valoracion,"SELECT Competencias_Niveles.id AS id, Competencias.nombre AS nombre_competencia, Niveles.nombre AS nombre_nivel
                FROM Competencias_Niveles 
                LEFT JOIN Competencias ON Competencias.id = Competencias_Niveles.id_competencia 
                LEFT JOIN Niveles ON Niveles.id = Competencias_Niveles.id_nivel  
                WHERE Competencias_Niveles.anio = '".$_SESSION['anio']."' AND Competencias_Niveles.id_empresa = '".$_SESSION['id_empresa']."' 
                AND Competencias.nombre = '".$dataAntNivel["nombre_competencia"]."' AND Niveles.nombre =  '".$dataAntNivel["nombre_nivel"]."'  ");  
                $dataNewNivel = mysqli_fetch_array($queryNewNivel);
                
                //echo $dataAntNivel["nombre_nivel"]." - ".$dataNewNivel["nombre_nivel"]." ".$queryNewNivel->num_rows." <br>";
                
                if($nuevo_perfil == ""){
                    $nuevo_perfil = $dataNewNivel["id"];
                }
                else{
                    $nuevo_perfil .= ",".$dataNewNivel["id"];
                }
            }
            
            //echo "<hr>";
            //print_r($nuevo_perfil);
            
            
            mysqli_query($connect_valoracion,"INSERT INTO Perfiles_Cargos ( anio, id_ciclo, id_empresa, id_cargo, perfiles, created_at) 
            VALUES 
            ('".$_SESSION['anio']."', '".$_SESSION['ciclo']."', '".$_SESSION['id_empresa']."', '".$dataEvalTmp["id_cargo"]."', '".$nuevo_perfil."', '".$hoy."' ) ");
            
        }

        echo '<script> window.location = "'.$url.'?pg=valoracion/perfiles"; </script>';
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



<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%" style="margin-bottom: 10px">
                <tr>
                    <td>
                        <h2>Replicar Perfiles Competencias para el año <b><?php echo $_SESSION["anio"]; ?></b> de Ciclo: <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right">
                        <a href="<?php echo $url; ?>?pg=valoracion/perfiles">
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
                            <th scope="col" style="max-width: 180px">Cargo</th>
                            <th scope="col">Tipo de compentecias</th>
                            <th scope="col">Competencias</th>
                            <th scope="col">Nivel</th>
                            <th scope="col">Año Lic.</th>
                        </tr>
                        </thead>

                        <tbody id="tabla_lista">
                        <?php
                            $count = 1;
                            $query = mysqli_query($connect_valentina,"SELECT * FROM Cargos 
                            WHERE id_empresa = '".$dtEmpleado['id_empresa']."' ORDER BY nombre ASC ");
                            while($data = mysqli_fetch_array($query)){

                                $queryPerfiles = mysqli_query($connect_valoracion,"SELECT * FROM Perfiles_Cargos 
                                WHERE id_cargo = '".$data["id"]."' AND id_empresa = '".$_SESSION["id_empresa"]."' AND anio = '".$dataCicloAnterior['anio']."' ");
                                $dataPerfiles = mysqli_fetch_array($queryPerfiles);

                                $perfiles = explode("," , $dataPerfiles["perfiles"] );

                                $tipo_list = '';
                                $competencia_list = '';
                                $nivel_list = '';
                                foreach($perfiles as $prf){

                                    $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$prf."' ");
                                    $dataNivel = mysqli_fetch_array($queryNivel);

                                    $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias 
                                    WHERE id = '".$dataNivel["id_competencia"]."'  ");
                                    $dataComp = mysqli_fetch_array($queryComp);

                                    $competencia_list .= $dataComp["nombre"]."<br>";

                                    $text_nivel = '';
                                    foreach ($arrayNiveles as &$nivel) {
                                        if( $dataNivel["id_nivel"] == $nivel["0"] ){ $text_nivel = $nivel["1"]; }
                                    }
                                    $nivel_list .= $text_nivel."<br>";

                                    $text_tipo = '';
                                    foreach ($arrayTipos as &$tipo) {
                                        if( $dataComp["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
                                    }
                                    $tipo_list .= $text_tipo."<br>";

                                }



                                echo '
                                        <tr>
                                            <td scope="row">'.$count.'</td>
                                            <td style="max-width: 180px;">'.$data["nombre"].'</td>
                                            <td>
                                                '.$tipo_list .'
                                            </td>
                                            <td style="font-size: 13px;">
                                                '.$competencia_list.'
                                            </td>
                                            <td>
                                               '.$nivel_list.'
                                            </td>
                                            <td>'.$dataPerfiles['anio'].'</td>
                                            
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
  
    $("#bt_val_perfiles").addClass("active_item");
    
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



