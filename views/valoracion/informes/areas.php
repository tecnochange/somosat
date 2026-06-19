<?php

    include("views/valoracion/informes/funciones.php");
    $array_empleados = array();
    $array_areas = array();
    $array_cargos = array();
    $array_competencias_niveles = array();
    $array_competencias = array();

    $EVALUACIONES = array();
    
    $hoy = date("Y-m-d H:i:s");
   
    
    $filtro = " AND jerarquia = 1  ";
    if($_GET["f"]){
        $filtro = " AND id = '".$_GET["f"]."'  ";
    }

    if( $_POST["id_area"] ){ 
        $filtro = " AND id = '".$_POST["id_area"]."'  ";
        //$id_area = $_POST["id_area"]; 
    }
    
    $lista_cargos = "";

    //1. PRIMERO CONSULTAMOS LAS AREAS EN CASCADA
    //1. PRIMERO CONSULTAMOS LAS AREAS EN CASCADA
    //1. PRIMERO CONSULTAMOS LAS AREAS EN CASCADA
    //1. PRIMERO CONSULTAMOS LAS AREAS EN CASCADA
    $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id_empresa = '".$_SESSION["id_empresa"]."' ".$filtro."  ");
    $dataArea = mysqli_fetch_array($queryArea);
    array_push($array_areas, $dataArea );

    $id_area = $dataArea["id"];


    //HIJOS
    $queryArea1 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$id_area."'");
    while($dataArea1 = mysqli_fetch_array($queryArea1)){
        //NIETOS
        $queryAreas2 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$dataArea1["id"]."'");
        while($dataAreas2 = mysqli_fetch_array($queryAreas2)){
            //BISNIETOS
            $queryAreas3 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$dataAreas2["id"]."'");
            while($dataAreas3 = mysqli_fetch_array($queryAreas3)){

                //BISNIETOS
                $queryAreas4 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$dataAreas3["id"]."'");
                while($queryAreas4 = mysqli_fetch_array($queryAreas4)){
                    //
                    array_push($array_areas, $queryAreas4 );
                    $count_areas++;
                }
                
                array_push($array_areas, $dataAreas3 );
                $count_areas++;

            }
            array_push($array_areas, $dataAreas2 );
            $count_areas++;
        }
        array_push($array_areas, $dataArea1 );
        $count_areas++;
    }

    //2. CONSULTAMOS LOS CARGOS DE ESTAS AREAS
    //2. CONSULTAMOS LOS CARGOS DE ESTAS AREAS
    //2. CONSULTAMOS LOS CARGOS DE ESTAS AREAS
    //2. CONSULTAMOS LOS CARGOS DE ESTAS AREAS
    foreach($array_areas as $area){
        $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_area = '".$area["id"]."'");
        while($dataCargo = mysqli_fetch_array($queryCargos)){
            array_push($array_cargos, $dataCargo );
        }
    }
    
    //3. CONSULTAMOS LOS EMPLEADOS DE ESTOS CARGO JUNTO CON LAS EVALUACIONES / SOLO PROMEDIO > A 0
    //3. CONSULTAMOS LOS EMPLEADOS DE ESTOS CARGO JUNTO CON LAS EVALUACIONES / SOLO PROMEDIO > A 0
    //3. CONSULTAMOS LOS EMPLEADOS DE ESTOS CARGO JUNTO CON LAS EVALUACIONES / SOLO PROMEDIO > A 0
    //3. CONSULTAMOS LOS EMPLEADOS DE ESTOS CARGO JUNTO CON LAS EVALUACIONES / SOLO PROMEDIO > A 0
    foreach($array_cargos as $cargo){
        //consultamos los empleados de este cargo
        $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_cargo = '".$cargo["id"]."'");
        while($dataEmpleado = mysqli_fetch_array($queryEmpleados)){
            
            $VALIDACION = PromedioGeneralEvaluado($dataEmpleado["id"], $connect_valoracion, $connect_valentina);
            if($VALIDACION["no_evaluadores_evaluacion"]  > 0){
                $promedio_empleados += $VALIDACION["promedio"];
                array_push($array_empleados, $dataEmpleado["id"] );
            } 

        }
    }

    //4. CARGAMOS LAS COMPETENCIAS LOS NIVELES DE COMPETENCIAS
    //4. CARGAMOS LAS COMPETENCIAS LOS NIVELES DE COMPETENCIAS
    //4. CARGAMOS LAS COMPETENCIAS LOS NIVELES DE COMPETENCIAS
    foreach($array_empleados as $evaluado){
        
        $queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New 
        WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND 
        id_evaluado = '".$evaluado."' AND anio = '".$_SESSION['anio']."' AND estado = 2 ORDER BY created_at DESC ");
        while($dataEvaluacion = mysqli_fetch_array($queryEvaluaciones)){
            
            $Array_Objeto = json_decode($dataEvaluacion["obj_evaluacion"], true);
            foreach($Array_Objeto as $respuestas){
                
                array_push($array_competencias_niveles, $respuestas["competencia"] ); 
                //BUSCAMOS EL ID DE COMPETENCIA Y LO CUARDAMOS
                $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$respuestas["competencia"]."' ");
                $dataNivel = mysqli_fetch_array($queryNivel);
                
                array_push($array_competencias, $dataNivel["id_competencia"] );
            }
            
            $datos = array(
                "id_evaluador"=> $dataEvaluacion["id_evaluador"],
                "obj_evaluacion"=> $dataEvaluacion["obj_evaluacion"],
                "tipo_evaluacion" => $dataEvaluacion["tipo_evaluacion"]
            );

            array_push($EVALUACIONES, $datos );
            
        }
        
    }
    
    //5. DEJAMOS LISTAS UNICAS DE COMPETENCIAS Y NIVELES
    $array_competencias_niveles  = array_unique($array_competencias_niveles);
    $array_competencias  = array_unique($array_competencias);

    //print_r($array_competencias);

    //break;


?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>

<script>
    $("#bt_val_informes").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<style>
    .fichas{
        margin-bottom: 15px;
    }
    
    .titulo{
        font-size: 18px; 
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .ti_ficha{
        font-size: 16px;
        color: #818181;
        font-weight: bold;
    }
    
    .numero_ficha{
        font-size: 30px;
    }
    
    .barra_avance{
        
    }
    
    .barra_avance{
        text-align: center;
        font-weight: bold;
        padding: 11px;
        border-radius: 0px 20px 20px 0px;
    }
    
</style>

<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Reporte Areas / Procesos <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right"> 
                        <button type="button" class="btn btn-warning btn-sm" onclick="window.print();" style="background-color: #FFC107; border: 0; color: #ffffff; padding: 10px; ">
                            <i class="fa fa-print"></i> Imprimir / Descargar
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<ul class="nav nav-tabs">  
    
    <li class="nav-item">
        <a class="nav-link  " href="?pg=valoracion/informes/individuales">Individuales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/informes/areas">Area / Procesos</a>
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


<?php if($id_area > 0){ ?>
<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-10">
            <h5 style="margin-top: 15px; font-weight: bold;">
                INFORME CONSOLIDADO VALORACIÓN DE COMPETENCIAS<br>
                <?php echo $dataArea["nombre"]; ?>
            </h5>
        </div>
        
        <div class="col-md-2" align="right">
            <form action="<?php echo $url; ?>/?pg=valoracion/informes/areas" method="post">
            <select class="form-control form-control-sm" name="id_area" style="margin-bottom: 5px; margin-top: 10px" >
                <option value="">Seleccione Área...</option>
                <?php
                    $queryAr = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  jerarquia >= 0 AND jerarquia <= 2 ORDER BY nombre DESC ");
                    while($dataAr = mysqli_fetch_array($queryAr)){

                        //$queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_area = '".$dataAr['id']."' ");
                        //if( $queryCargos->num_rows > 0 ){
                            if($_POST["id_area"] == $dataAr["id"] ){
                                echo '<option value="'.$dataAr["id"].'" selected >'.$dataAr["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataAr["id"].'" >'.$dataAr["nombre"].'</option>';
                            }
                        //}
                    }
                ?>
            </select>
            <button type="submit" class="btn btn-success btn-sm btn-block" style="margin-bottom: 20px" >
                Filtrar
            </button>
            </form>
            
        </div>

        <!-- FICHA -->
        <div class="col-md-3">
            <div class="card fichas">
                <div class="card-body">
                    <div class="ti_ficha">Áreas</div>
                    <div class="numero_ficha"><?php echo count($array_areas); ?></div>
                </div>
            </div>
        </div>
        
        <!-- FICHA -->
        <div class="col-md-3">
            <div class="card fichas">
                <div class="card-body">
                    <div class="ti_ficha">Cargos</div>
                    <div class="numero_ficha"><?php echo count($array_cargos); ?></div>
                </div>
            </div>
        </div>
        
        <!-- FICHA -->
        <div class="col-md-3">
            <div class="card fichas">
                <div class="card-body">
                    <div class="ti_ficha">Competencias</div>
                    <div class="numero_ficha"><?php echo count($array_competencias); ?></div>
                </div>
            </div>
        </div>
        
        <!-- FICHA -->
        <div class="col-md-3">
            <div class="card fichas">
                <div class="card-body">
                    <div class="ti_ficha">Evaluados</div>
                    <div class="numero_ficha"><?php echo count($array_empleados); ?></div>
                </div>
            </div>
        </div>
        
        <!-- BLOQUE -->
        <div class="col-md-12">
            <div class="card fichas">
                <div class="card-body">

                    <?php
                    $promedio_general = round( ( $promedio_empleados/count($array_empleados) ),2);
                    $porcentaje_general = ($promedio_general * 100) / 4;

                    $color_general = '';
                    if( $promedio_general >= 0 && $promedio_general < 1.7 ){ $color_general = "#FF7173" ; }
                    if( $promedio_general >= 1.7 && $promedio_general < 2.7 ){ $color_general = "#FFC03A" ; }
                    if( $promedio_general >= 2.7 && $promedio_general < 3.7 ){ $color_general = "#2ADAFF" ; }
                    if( $promedio_general >= 3.7 && $promedio_general <= 4 ){ $color_general = "#B5FF87" ; }
                    ?>
                    
                    <div style="width: 100%; background-color: #E9E9E9">
                        <div style="width: <?php echo $porcentaje_general; ?>%; background-color: <?php echo $color_general; ?>; text-align: center;font-weight: bold; padding: 5px;">
                            <?php echo round($promedio_general,2);  ?> - <?php echo round(($promedio_general*100)/4)  ?>%
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px">
                        Promedio Consolidado Valoración: <b><?php echo number_format($promedio_general, 2);  ?></b><br>
                        Porcentaje nivel de desarrollo: <b><?php echo number_format(($promedio_general*100)/4);  ?>%</b><br>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- BLOQUE -->
        <div class="col-md-12">
            <div class="card fichas">
                <div class="card-body">
                    
                    <div class="titulo">ESCALA PARA INTERPRETACIÓN DEL INFORME</div>
                    <?php
                        $queryEscala = mysqli_query($connect_valoracion,"SELECT * FROM Escalas WHERE id_empresa = '".$_SESSION["id_empresa"]."' AND anio = '".$_SESSION['anio']."' ");
                        $dataEscala = mysqli_fetch_array($queryEscala);
                    ?>
                    <table class="table table-bordered" width="100%">
                        <tr>
                            <td width="25%" bgcolor="#FF7173" align="center" style="font-size: 12px; padding: 5px; font-weight: bold">
                                0,1 a 1,69
                            </td>
                            <td width="25%" bgcolor=" #FFC03A" align="center" style="font-size: 12px; padding: 5px; font-weight: bold">
                                1,7 a 2,69
                            </td>
                            <td width="25%" bgcolor=" #2ADAFF" align="center" style="font-size: 12px; padding: 5px; font-weight: bold">
                                2,7 a 3,69
                            </td>
                            <td width="25%" bgcolor=" #B5FF87" align="center" style="font-size: 12px; padding: 5px; font-weight: bold">
                                3,7 a 4
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="padding-top: 15px" >
                                <b><?php echo $dataEscala["nombre_n_1"]; ?></b><br>
                                <?php echo $dataEscala["descripcion_n_1"]; ?>
                            </td>
                            <td align="center" valign="top" style="padding-top: 15px">
                                <b><?php echo $dataEscala["nombre_n_2"]; ?></b><br>
                                <?php echo $dataEscala["descripcion_n_2"]; ?>
                            </td>
                            <td align="center" valign="top" style="padding-top: 15px">
                                <b><?php echo $dataEscala["nombre_n_3"]; ?></b><br>
                                <?php echo $dataEscala["descripcion_n_3"]; ?>
                            </td>
                            <td align="center" valign="top" style="padding-top: 15px">
                                <b><?php echo $dataEscala["nombre_n_4"]; ?></b><br>
                                <?php echo $dataEscala["descripcion_n_4"]; ?>
                            </td>
                        </tr>
                    </table> 
                    
                    
                </div>
            </div>
        </div>
        
        <!-- BLOQUE -->
        <div class="col-md-12">
            <div class="card fichas">
                <div class="card-body">
                    
                    <div align="center" class="titulo" >RESULTADO GRÁFICO CONSOLIDADO</div>
                
                    <table width="100%">
                        <tr>
                        <?php
                        //LISTA DE COMPETENCIAS
                        foreach($array_competencias as $competencia){

                            $total = 0;
                            $cantidad = 0;

                            $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$competencia."' ");
                            $dataComp = mysqli_fetch_array($queryComp);

                            foreach($array_competencias_niveles as $nivel_competencia){

                                $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$nivel_competencia."'  ");
                                $dataNivel = mysqli_fetch_array($queryNivel);

                                //VALIDAMOS SI ESTE NIVEL CORRESPONDE A ESTA COMPETENCIA
                                if($dataNivel["id_competencia"] == $competencia){

                                    foreach($EVALUACIONES as $evaluacion){
                                        $Array_Objeto = json_decode($evaluacion["obj_evaluacion"], true);
                                        foreach($Array_Objeto as $respuestas){

                                            if($respuestas["competencia"] == $nivel_competencia ){
                                                $respuestas_competencia = $respuestas["respuestas"];
                                                foreach($respuestas_competencia as $resp){
                                                    $total += $resp["respuesta"];
                                                    $cantidad++;
                                                }
                                            }
                                        }
                                    }

                                }

                            }

                            $promedio_compt = $total/$cantidad;
                            $porcentaje_comt = ($promedio_compt * 100) / 4;

                            $color_compt = '';
                            if( $promedio_compt >= 0 && $promedio_compt < 1.7 ){ $color_compt = "#FF7173" ; }
                            if( $promedio_compt >= 1.7 && $promedio_compt < 2.7 ){ $color_compt = "#FFC03A" ; }
                            if( $promedio_compt >= 2.7 && $promedio_compt < 3.7 ){ $color_compt = "#2ADAFF" ; }
                            if( $promedio_compt >= 3.7 && $promedio_compt <= 4 ){ $color_compt = "#B5FF87" ; }

                            echo '
                            <td align="center" valign="bottom"  width="'.( 100/count($array_competencias) ).'%" >

                                <div>'.round($promedio_compt,2).'<div>
                                <div style="width: 60px; height:200px; background-color: #E9E9E9">
                                    <div style="height: '.(100-$porcentaje_comt).'%; width: 60px;">
                                    </div>
                                    <div style="height: '.$porcentaje_comt.'%; width: 60px; background-color: '.$color_compt.'">
                                    </div>
                                </div>
                                <div style="font-size: 10px; height: 35px;">'.$dataComp["nombre"].'</div>
                            </td>
                            ';

                        }
                        ?>
                        </tr>
                    </table> 
                    
                    
                </div>
            </div>
        </div>
        
        <!-- BLOQUE -->
        <div class="col-md-6">
            <div class="card fichas">
                <div class="card-body">
                    <div class="titulo">ÁREAS RELACIONADAS</div>
                    <div align="left">
                        
                        
                        
                        
                        <?php 
                        $count = 1;
                        foreach($array_areas as $areas){

                            echo $count.') '.$areas["nombre"].' 
                            <a href="?pg=valoracion/informes/areas&f='.$areas["id"].'">
                                <button type="button" class="btn btn-success btn-sm">Ver Reporte</button>
                            </a>  
                            <br>';
                            $count++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- BLOQUE -->
        <div class="col-md-6">
            <div class="card fichas">
                <div class="card-body">
                    <div class="titulo">CARGOS RELACIONADOS</div>
                    <div align="left">
                        <?php 
                        $count = 1;
                        foreach($array_cargos as $cargo){
                            echo $count.") ".$cargo["nombre"]."<br>";
                            $count++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        
 
    </div>
        
     
</div>

<?php } ?>

