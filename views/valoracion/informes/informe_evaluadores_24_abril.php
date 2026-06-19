<?php
    include("views/valoracion/informes/metodo_ponderacion_empleados.php");	
    $hoy = date("Y-m-d H:i:s");
    $id_evaluado = $_GET["e"];

    //DATOS DEL EVALUADO
    //DATOS DEL EVALUADO
    $queryEvaluado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$id_evaluado."'");
    $dataEva = mysqli_fetch_array($queryEvaluado);

    //ULTIMA EVALUACION
    $qUltimaEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND 
    id_evaluado = '".$id_evaluado."' AND estado = 2 ORDER BY created_at DESC ");
    $dUltimaEval = mysqli_fetch_array($qUltimaEval);
    
    //PERFIL DEL CARGO NIVEL COMPETENCIA
    //PERFIL DEL CARGO NIVEL COMPETENCIA
    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEva["id_cargo"]."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);
    $perfiles = explode("," , $dataCargo["perfil"] );

    //RECORREMOS EL PERFIL DEL CARGO CON LOS NIVELES Y COMPETENCIAS
    $array_competencias_por_evaluador = array();
    $competencia_list = '';
    foreach($perfiles as $prf){
        
        $array_grupo = array();
        $promedio_general_competencia = 0;
        $count_promedios = 0;

        //DATOS DEL NIVEL
        $queryNivel = mysqli_query($connect_valoracion,"SELECT id, id_competencia FROM Competencias_Niveles WHERE id = '".$prf."' ");
        $dataNivel = mysqli_fetch_array($queryNivel);
        
        //DATOS DE LA COMPETENCIA
        $queryComp = mysqli_query($connect_valoracion,"SELECT id,nombre FROM Competencias WHERE id = '".$dataNivel["id_competencia"]."' ");
        $dataComp = mysqli_fetch_array($queryComp);
        
        //CONSULTAMOS A LOS EVALUADORES
        $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_empleado = '".$id_evaluado."' AND 
        id_ciclo = '".$_SESSION['ciclo']."' ");  
        while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
            
            //DATO DEL EVALUADOR
            $queryEmpl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_evaluador"]."' ");  
            $dataEmpl = mysqli_fetch_array($queryEmpl); 
            
            //DATOS DE LA EVALUACION ESTE EVALUADOR CON ESTADO TERMINADO
            $qEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones 
            WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND 
            id_evaluado = '".$id_evaluado."' AND id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND estado = 2 ");
            $dEvaluaciones = mysqli_fetch_array($qEvaluaciones);
            
            $total_promedio = 0;
        
            //OBTENEMOS LAS RESPUESTAS DE CADA COMPETENCIA Y LOS COMPORTAMIENTOS SUBYACENTES DE ESTA EVALUACION
            //OBTENEMOS LAS RESPUESTAS DE CADA COMPETENCIA Y LOS COMPORTAMIENTOS SUBYACENTES DE ESTA EVALUACION
            $qRespuestas = mysqli_query($connect_valoracion,"SELECT 
            Competencias_Respuestas.id as id_respuesta, 
            COUNT(Competencias_Respuestas_Comportamientos.id) AS cantidad_resp , 
            SUM(Competencias_Respuestas_Comportamientos.calificacion) AS suma_calificacion  
            FROM Competencias_Respuestas 
            INNER JOIN Competencias_Respuestas_Comportamientos 
            ON Competencias_Respuestas.id = Competencias_Respuestas_Comportamientos.id_respuesta 
            WHERE Competencias_Respuestas.id_evaluacion = '".$dEvaluaciones['id']."' AND 
            Competencias_Respuestas.id_competencia = '".$dataComp["id"]."' ");
            
            while($dRespuestas = mysqli_fetch_array($qRespuestas)){
                $promedio = $dRespuestas["suma_calificacion"]/$dRespuestas["cantidad_resp"];
                $total_promedio += $promedio;
            }

            $txt_tipo = '';
            foreach($array_Tipo_Colaborador as $tipo){ 
                if( $tipo[0] == $dEvaluaciones["tipo"] ){ $txt_tipo = $tipo[1]; } 
            }
            
            if($total_promedio > 0){
                
                $promedio_eval = $total_promedio/$qRespuestas->num_rows;
                $no_porciento = $promedio_eval *100/4; //EL NUMERO MÁXIMO SIEMPRE ES 4
                $promedio_general_competencia += $promedio_eval;
                
                array_push($array_grupo,  
                    array(
                        "id_evaluacion"=>$dEvaluaciones["id"], 
                        "tipo"=>$txt_tipo, 
                        "nombre"=>($dataEmpl["nombre"]." ".$dataEmpl["apellidos"]),
                        "promedio"=> round($promedio_eval,2),
                        "porcentaje"=> round($no_porciento)
                    ) 
                );
                $count_promedios++;
            }
  
        }
        
        $nodo = array(
            "id_nivel"=>$dataNivel["id"], 
            "competencia"=> $dataComp["nombre"], 
            "promedio_general"=> round(($promedio_general_competencia/$count_promedios),2) , 
            "datos"=>$array_grupo
        );
        
        array_push($array_competencias_por_evaluador, $nodo );
        
    }
  
?>


<style>
    .base_porcentajes{
        width: 100%; 
        background-color: #E9E9E9;
        
    }
    
    .barra_porcien{
        width: 86.5%; 
        background-color: #2ADAFF;     
        text-align: center;
        font-weight: bold; 
        padding: 5px;
    }
    .titulo_comp{
        font-size: 20px;
        font-weight: bold;
        text-align: left;
        margin-top: 30px;
    }
</style>

<?php echo $respuesta; ?>

<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12" >
            <table width="100%">
                <tr>
                    <td>
                        <h2>Informe por Evaluadores</h2>
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

<ul class="nav nav-tabs" style="display: none">  
    
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



<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                Colaborador Evaluado: <b><?php echo $dataEva["nombre"]." ".$dataEva["apellidos"]; ?></b> <br>
                Fecha de Valoracion: <b><?php echo $dUltimaEval["created_at"]; ?></b> <br>
                Cargo: <b><?php echo $dataCargo["nombre"]; ?></b> <br>
            </div>
        </div>
        
    </div>
</div>

<style>
    .titulo{
        font-size: 18px; 
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>


<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                <div align="center" class="titulo" >INFORME CONSOLIDADO POR EVALUADORES</div>
                <?php
                //OBTENEMOS EL PROMEDIO GENERAL DEL EVALUADO
                $PROMEDIOS_EVALUADO = PromedioGeneralEvaluado($connect_valoracion, $connect_valentina, $id_evaluado, 0, 0);
                
                $promedio_general = $PROMEDIOS_EVALUADO["total"];
                $porcentaje_general = ($promedio_general * 100) / 4;
                
                $color_general = '';
                if( $promedio_general >= 0 && $promedio_general < 1.7 ){ $color_general = "#FF7173" ; }
                if( $promedio_general >= 1.7 && $promedio_general < 2.7 ){ $color_general = "#FFC03A" ; }
                if( $promedio_general >= 2.7 && $promedio_general < 3.7 ){ $color_general = "#2ADAFF" ; }
                if( $promedio_general >= 3.7 && $promedio_general <= 4 ){ $color_general = "#B5FF87" ; }
                
                ?>
                <div style="margin-bottom: 20px">
                    Promedio Consolidado Valoración: <b><?php echo round($promedio_general,2);  ?></b><br>
                    Porcentaje nivel de desarrollo: <b><?php echo round(($promedio_general*100)/4)  ?>%</b>
                </div>
                <div style="width: 100%; background-color: #E9E9E9">
                    <div style="width: <?php echo $porcentaje_general; ?>%; background-color: <?php echo $color_general; ?>;     text-align: center;font-weight: bold; padding: 5px;">
                        <?php echo round($promedio_general,2);  ?> - <?php echo round(($promedio_general*100)/4)  ?>%
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- ESCALA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="titulo">ESCALA PARA INTERPRETACIÓN DEL INFORME</div>
        
        <?php
            $queryEscala = mysqli_query($connect_valoracion,"SELECT * FROM Escalas WHERE id_empresa = '".$dtEmpresa["id"]."' ");
	        $dataEscala = mysqli_fetch_array($queryEscala);
        ?>
        <table width="100%">
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
                    <b>Insatisfactoria</b><br>
                    El colaborador muestra un nivel muy básico de desarrollo en la competencia/comportamiento y debe mejorar en el desarrollo de la misma de manera dedicada y constante
                </td>
                <td align="center" valign="top" style="padding-top: 15px">
                    <b>Marginal/Insuficiente</b><br>
                    El colaborador muestra un nivel medio en el nivel de desarrollo de la competencia/comportamiento y es importante que trabaje en llevar este nivel a uno superior para crecer personal y profesionalmente
                </td>
                <td align="center" valign="top" style="padding-top: 15px">
                    <b>Satisfactorio</b><br>
                    El colaborador muestra un nivel de desarrollo aceptable en la competencia/comportamiento; sin embargo debe trabajar un poco más en mejorar el desarrollo de las mismas para crecer personal y profesionalmente
                </td>
                <td align="center" valign="top" style="padding-top: 15px">
                    <b>Supera expectativas</b><br>
                    El colaborador muestra un nivel superior de desarrollo en la competencia/comportamiento, debe seguir manteniendo este nivel, lo que le permitirá ser un colaborador destacado para la Organización
                </td>
            </tr>
        </table> 
    </div>
</div>

<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        <div class="row">
            
            <div class="col-md-12" align="left">
                <div align="center" class="titulo" >RESULTADO GRÁFICO CONSOLIDADO</div>
            </div>
            
            
            <?php
            foreach($array_competencias_por_evaluador as $competencia){
                if($competencia["competencia"]){
            ?>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div  class="titulo_comp"><?php echo $competencia["competencia"]; ?> / <?php echo $competencia["promedio_general"]; ?></div>
                    
                        
                    <?php 
                        foreach( $competencia["datos"] as $datos ){

                            $color_compt = '';
                            if( $datos["promedio"] >= 0 && $datos["promedio"] < 1.7 ){ $color_compt = "#FF7173" ; }
                            if( $datos["promedio"] >= 1.7 && $datos["promedio"] < 2.7 ){ $color_compt = "#FFC03A" ; }
                            if( $datos["promedio"] >= 2.7 && $datos["promedio"] < 3.7 ){ $color_compt = "#2ADAFF" ; }
                            if( $datos["promedio"] >= 3.7 && $datos["promedio"] <= 4 ){ $color_compt = "#B5FF87" ; }

                            echo '
                            <div>'.$datos["tipo"].' - '.$datos["nombre"].'</div>
                            <div class="base_porcentajes">
                                <div class="barra_porcien" style="width:'.$datos["porcentaje"].'%; background-color: '.$color_compt.';">
                                    '.$datos["promedio"].'
                                </div>
                            </div>
                            ';
                        }
                    ?>
                    
                    </td>
                </tr>
            </table>
                
            <?php } } ?>
            
            
            
            <?php
                echo $competencia_list;
            ?>
        </div>
        
    </div>
</div>

<script>
    $("#bt_val_seguimiento").addClass("active_item"); 
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
    margin-left: 8px;
}
    
.pagina {
    padding: 0.3cm 1cm;
    background-color:#fff;
    page-break-after: always;
    border-bottom: 1px solid #ccc;
    width:100%;
    margin: 0.5cm auto;
    font-family: sans-serif;
    font-size: 14px;
}
    
       
@media screen {
    body { font-size: 10pt }
}
@media screen, print {
    body { line-height: 1.2 }
}			
@media print{
    body {
        margin: 0;
        padding: 0;
        background-color: #ffffff;
        font-size: 10pt;
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
	
    .bt_print{
        display:none;
    }			
    .pagina {
        border: initial;
        width: initial;
        min-height: initial;
        page-break-after: always;
        font-size:16px;
    }
                
    #sidebar{
        display: none;
    }
                
    #content{
        width: 100%;
    }
    #menu_header{
        display: none;
    }
				
} 
</style>

