<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>


<?php
    include("views/valoracion/informes/metodos.php");

    $array_empleados = array();
    $array_competencias = "";
    $lista_cargos = "";
    $count_cargos = 1;

    if($_POST["id_area"] != ""){
        
        $queryArs = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$_POST["id_area"]."'");
        $dataArs = mysqli_fetch_array($queryArs);

        $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_area = '".$_POST["id_area"]."'");
        while($dataCargo = mysqli_fetch_array($queryCargos)){
            $lista_cargos .= $count_cargos.") ".$dataCargo["nombre"]."<hr>";
            $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_cargo = '".$dataCargo["id"]."'");
            while($dataEmpleado = mysqli_fetch_array($queryEmpleados)){
                //VALIDAMOS SI EL EMPLEADO TIENE EVALUACIONES COMPLETAS
                $validar = ValidarEvaluacionesCompletas($arrayEvaluadores, $arrayCompetencias_Evaluaciones, $dataEmpleado["id"]);
                $permitir = $validar["permitir"];
                if($permitir == true){
                    array_push($array_empleados, $dataEmpleado["id"] );
                }
            }
        }

        $lista_competencia = '';
        //RECORREMOS LOS EMPLEADOS DEL AREA
        //RECORREMOS LOS EMPLEADOS DEL AREA
        //RECORREMOS LOS EMPLEADOS DEL AREA
        foreach($array_empleados as $evaluado){
            $queryResComport = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos WHERE id_evaluado = '".$evaluado."' AND id_ciclo = '".$_SESSION['ciclo']."' GROUP BY id_competencia ");
            while($dataResComport = mysqli_fetch_array($queryResComport)){
                if($lista_competencia == ''){
                   $lista_competencia = $dataResComport["id_competencia"]; 
                }
                else{
                    $lista_competencia .= ','.$dataResComport["id_competencia"]; 
                }
            }
        }

        //CARGAMOS LAS COMPETENCIAS QUE APLICAN PARA ESTA ÁREA
        //CARGAMOS LAS COMPETENCIAS QUE APLICAN PARA ESTA ÁREA
        //CARGAMOS LAS COMPETENCIAS QUE APLICAN PARA ESTA ÁREA
        $competencias = explode("," , $lista_competencia );
        $competencias = array_unique($competencias);
        
        //$array_competencias = array();
        $array_competencias = array();
        foreach($competencias as $comp){
            $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$comp."' ");
            $dataComp = mysqli_fetch_array($queryComp);

            $calificacion = 0;
            $cantidad = 0;
            foreach($array_empleados as $evaluado){
                
                $queryRC = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos 
                WHERE id_evaluado = '".$evaluado."' AND id_competencia = '".$dataComp["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
                while($dataRC = mysqli_fetch_array($queryRC)){
                    $calificacion += $dataRC["calificacion"];
                    $cantidad++;
                }
            }
            
            $dato = array(
                "promedio"=> ($calificacion/$cantidad), 
                "id_competencia"=>$dataComp["id"],
                "competencia"=>$dataComp["nombre"]
            );
                
            array_push( $array_competencias, $dato );
        }
        
        //EMPEZAMOS A PINTAR LA TABLA
        //EMPEZAMOS A PINTAR LA TABLA
        //EMPEZAMOS A PINTAR LA TABLA
        $lista_competencias = '';
        $cant_comp = count($competencias);
        $ancho = 100/$cant_comp;
        
        $promedio_global = 0;
        $porcentaje_global = 0;
        $cantidad_global =  0;
        
        foreach($array_competencias as $item_tabla){
            
            $porcentaje_competencia = $item_tabla["promedio"]*100/4;
            
            $color_compt = '';
            if( $item_tabla["promedio"] >= 0 && $item_tabla["promedio"] < 1.7 ){ $color_compt = "#FF7173" ; }
            if( $item_tabla["promedio"] >= 1.7 && $item_tabla["promedio"] < 2.7 ){ $color_compt = "#FFC03A" ; }
            if( $item_tabla["promedio"] >= 2.7 && $item_tabla["promedio"] < 3.7 ){ $color_compt = "#2ADAFF" ; }
            if( $item_tabla["promedio"] >= 3.7 && $item_tabla["promedio"] <= 4 ){ $color_compt = "#B5FF87" ; }

            $lista_competencias .= '
                <td align="center" valign="bottom"  width="'.$ancho.'%" >

                    <div>'.round($item_tabla["promedio"], 2).'<div>
                    <div style="width: 60px; height:200px; background-color: #E9E9E9">
                        <div style="height: '.(100-$porcentaje_competencia).'%; width: 60px;">
                        </div>
                        <div style="height: '.$porcentaje_competencia.'%; width: 60px; background-color: '.$color_compt.'">
                        </div>
                    </div>
                    <div style="font-size: 12px; height: 35px; margin-top: 10px; font-weight: bold;">'.$item_tabla["competencia"].'</div>
                </td>
            ';
            
            $promedio_global += $item_tabla["promedio"];
            $porcentaje_global += $porcentaje_competencia;
            $cantidad_global++;;
        }
        
        $promedio_global =  $promedio_global/$cantidad_global;
        $porcentaje_global = $porcentaje_global/$cantidad_global;
        
        $color_general = '';
        if( $promedio_global >= 0 && $promedio_global < 1.7 ){ $color_general = "#FF7173" ; }
        if( $promedio_global >= 1.7 && $promedio_global < 2.7 ){ $color_general = "#FFC03A" ; }
        if( $promedio_global >= 2.7 && $promedio_global < 3.7 ){ $color_general = "#2ADAFF" ; }
        if( $promedio_global >= 3.7 && $promedio_global <= 4 ){ $color_general = "#B5FF87" ; }
        
        
        
        
   /*
        

        $total_general = 0;
        $contador_general = 0;

        $lista_competencias = '';
        $cant_comp = count($competencias);
        $ancho = 100/$cant_comp;

        foreach($competencias as $comp){


            $total = 0;
            $cont_filas = 0;
            $nombre_comp = '';
            foreach($array_final_competencias as $compt_datos){
                if($compt_datos["id_competencia"] == $comp){
                    $total += $compt_datos["promedio"];
                    $nombre_comp = $compt_datos["nombre_comp"];
                    $cont_filas++;

                    $total_general += $compt_datos["promedio"];
                    $contador_general++;
                }
            }

            $promedio_compt = $total/$cont_filas;
            $porcentaje_competencia = ($promedio_compt*100)/4;

            $color_compt = '';
            if( $promedio_compt >= 0 && $promedio_compt < 1.7 ){ $color_compt = "#FF7173" ; }
            if( $promedio_compt >= 1.7 && $promedio_compt < 2.7 ){ $color_compt = "#FFC03A" ; }
            if( $promedio_compt >= 2.7 && $promedio_compt < 3.7 ){ $color_compt = "#2ADAFF" ; }
            if( $promedio_compt >= 3.7 && $promedio_compt <= 4 ){ $color_compt = "#B5FF87" ; }

            $lista_competencias .= '
                <td align="center" valign="bottom"  width="'.$ancho.'%" >

                    <div>'.round($promedio_compt, 2).'<div>
                    <div style="width: 60px; height:200px; background-color: #E9E9E9">
                        <div style="height: '.(100-$porcentaje_competencia).'%; width: 60px;">
                        </div>
                        <div style="height: '.$porcentaje_competencia.'%; width: 60px; background-color: '.$color_compt.'">
                        </div>
                    </div>
                    <div style="font-size: 12px; height: 35px; margin-top: 10px; font-weight: bold;">'.$nombre_comp.'</div>
                </td>
            ';
        }


        $promedio_general = $total_general/$contador_general;
        $porcentaje_general = ($promedio_general*100)/4;

        $color_general = '';
        if( $promedio_general >= 0 && $promedio_general < 1.7 ){ $color_general = "#FF7173" ; }
        if( $promedio_general >= 1.7 && $promedio_general < 2.7 ){ $color_general = "#FFC03A" ; }
        if( $promedio_general >= 2.7 && $promedio_general < 3.7 ){ $color_general = "#2ADAFF" ; }
        if( $promedio_general >= 3.7 && $promedio_general <= 4 ){ $color_general = "#B5FF87" ; }
        */

    }
?>


<?php echo $respuesta; ?>

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

<?php include("comp_escala.php"); ?>

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



<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <form action="" method="post">
        <div class="row">
            <div class="col-md-6" align="left">
                
                <select class="form-control" name="id_area">
                    <option value="">Seleccione Área...</option>
                    <?php
                    $queryAreas = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id_empresa = '".$_SESSION['id_empresa']."' ORDER BY nombre DESC ");
                    while($dataArea = mysqli_fetch_array($queryAreas)){
                        
                        $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_area = '".$dataArea['id']."' ");
                        if( $queryCargos->num_rows > 0 ){
                            if($_POST["id_area"] == $dataArea["id"] ){
                                echo '<option value="'.$dataArea["id"].'" selected >'.$dataArea["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataArea["id"].'" >'.$dataArea["nombre"].'</option>';
                            }
                        }
                    }
                    ?>
                    
                </select>

            </div>
            <div class="col-md-6" align="left">
                <button type="submit" class="btn btn-success" >
                     Filtrar
                </button>
            </div>
        </div>
        </form>
        
    </div>
</div>

<style>
    .titulo{
        font-size: 18px; 
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>

<?php if($_POST["id_area"] != ""){ ?>
<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                
                <div align="center" class="titulo" >
                    INFORME CONSOLIDADO VALORACIÓN DE COMPETENCIAS<br>
                    <b><?php echo $dataArs["nombre"]; ?></b>
                </div>
                
                <div style="margin-bottom: 20px">
                    Promedio Consolidado Valoración: <b><?php echo round($promedio_global,2);  ?></b><br>
                    Porcentaje nivel de desarrollo: <b><?php echo round($porcentaje_global, 2);  ?>%</b>
                </div>
                <div style="width: 100%; background-color: #E9E9E9">
                    <div style="width: <?php echo $porcentaje_global; ?>%; background-color: <?php echo $color_general; ?>;     text-align: center;font-weight: bold; padding: 5px;">
                        <?php echo round($promedio_global, 2);  ?> - <?php echo round($porcentaje_global, 2);  ?>%
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>



<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                <div align="center" class="titulo" >RESULTADO GRÁFICO CONSOLIDADO</div>
                
                <table width="100%">
                    <tr>
                        <?php
                            echo $lista_competencias;
                        ?>
                    </tr>
                </table>
                
               
                
                
            </div>
        </div>
        
    </div>
</div>

<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                <div align="center" class="titulo" >CARGOS RELACIONADOS</div>
                <table width="100%">
                    <tr>
                        <?php
                            echo $lista_cargos;
                        ?>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
</div>

<?php } ?>




<script>
    $("#bt_val_informes").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>


<style>
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

