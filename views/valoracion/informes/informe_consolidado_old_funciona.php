<?php
    include("views/valoracion/informes/metodo_ponderacion.php");	
    $hoy = date("Y-m-d H:i:s");
    $evaludo = $_GET["e"];

    //EVALUADO
    $queryEvaluado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$evaludo."'");
    $dataEva = mysqli_fetch_array($queryEvaluado);
    
    //CARGO
    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEva["id_cargo"]."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);
    $perfiles = explode("," , $dataCargo["perfil"] );

    //EVALUACIONES
    $observaciones_generales_lista = '';
    $fecha_evaluacion = '';

/*
    //VALIDAMOS SI TIENE EVALUACION COMPLETA DE ESTE EVALUADOR
    $queryEvaluacion = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  anio = '2021' AND id_evaluado = '".$evaludo."' ORDER BY created_at DESC ");
    while($dataEvaluacion = mysqli_fetch_array($queryEvaluacion)){
        $fecha_evaluacion = $dataEvaluacion["created_at"];
        $observaciones_generales_lista .= "* ".$dataEvaluacion["observaciones"].'<br>';
    }
*/

    $queryEvaluacion = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  anio = '2021' AND id_evaluado = '".$evaludo."' AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY created_at DESC ");
    $dataEvaluacion = mysqli_fetch_array($queryEvaluacion);

    $fecha_evaluacion = $dataEvaluacion["created_at"];
    $observaciones_generales_lista .= "* ".$dataEvaluacion["observaciones"].'<br>';
    


        
    $tipo_list = '';
    $competencia_list = '';
    $nivel_list = '';
    foreach($perfiles as $prf){
                
        $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$prf."' ");
        $dataNivel = mysqli_fetch_array($queryNivel);
                
        $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataNivel["id_competencia"]."' ");
        $dataComp = mysqli_fetch_array($queryComp);
        
        
        
        $ponderacion_compet = PonderacionNumericaEmpleadoCompetencia( $connect_valoracion, $connect_valentina, $evaludo, $dataNivel["id_competencia"]  );
        $promedio_compt = $ponderacion_compet["datos"]["total"];
        
        $color_compt = '';
        if( $promedio_compt >= 0 && $promedio_compt < 1.7 ){ $color_compt = "#FF7173" ; }
        if( $promedio_compt >= 1.7 && $promedio_compt < 2.7 ){ $color_compt = "#FFC03A" ; }
        if( $promedio_compt >= 2.7 && $promedio_compt < 3.7 ){ $color_compt = "#2ADAFF" ; }
        if( $promedio_compt >= 3.7 && $promedio_compt <= 4 ){ $color_compt = "#B5FF87" ; }
 
        $porcentaje_comt = ($promedio_compt * 100) / 4;
        
        $competencia_list .= '
        <td align="center" valign="bottom"  width="'.( 100/count($perfiles) ).'%" >
            
            <div>'.number_format($promedio_compt).'<div>
            <div style="width: 60px; height:200px; background-color: #E9E9E9">
                <div style="height: '.(100-$porcentaje_comt).'%; width: 60px;">
                </div>
                <div style="height: '.$porcentaje_comt.'%; width: 60px; background-color: '.$color_compt.'">
                </div>
            </div>
            <div style="font-size: 12px; height: 35px;">'.$dataComp["nombre"].'</div>
        </td>
        ';
        

    }

    
?>

<?php include("views/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>

<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Reporte Consolidado</h2>
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
                Fecha de Valoracion: <b><?php echo $fecha_evaluacion; ?></b> <br>
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
                <div align="center" class="titulo" >INFORME CONSOLIDADO VALORACIÓN DE COMPETENCIAS</div>
                <?php
                //METODO PARA OBTENER LA PONDERACION POR EMPLEADO
                $ponderacion_empleado = PonderacionNumericaEmpleado( $connect_valoracion, $connect_valentina, $evaludo  );
                $promedio_general = $ponderacion_empleado["datos"]["total"];
                $porcentaje_general = ($promedio_general * 100) / 4;
                
                $color_general = '';
                if( $promedio_general >= 0 && $promedio_general < 1.7 ){ $color_general = "#FF7173" ; }
                if( $promedio_general >= 1.7 && $promedio_general < 2.7 ){ $color_general = "#FFC03A" ; }
                if( $promedio_general >= 2.7 && $promedio_general < 3.7 ){ $color_general = "#2ADAFF" ; }
                if( $promedio_general >= 3.7 && $promedio_general <= 4 ){ $color_general = "#B5FF87" ; }
                ?>
                <div style="margin-bottom: 20px">
                    Promedio Consolidado Valoración: <b><?php echo number_format($promedio_general, 2);  ?></b><br>
                    Porcentaje nivel de desarrollo: <b><?php echo number_format(($promedio_general*100)/4)  ?>%</b>
                </div>
                <div style="width: 100%; background-color: #E9E9E9">
                    <div style="width: <?php echo $porcentaje_general; ?>%; background-color: <?php echo $color_general; ?>; text-align: center;font-weight: bold; padding: 5px;">
                        <?php echo number_format($promedio_general);  ?> - <?php echo number_format(($promedio_general*100)/4)  ?>%
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
                
                <table>
                    <tr>
                        <?php
                            echo "<td>".$competencia_list."</td>";
                        ?>
                    </tr>
                </table>
                
               
                
                
            </div>
        </div>
        
    </div>
</div>







<!-- ESCALA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="titulo">INFORME POR COMPETENCIAS</div>
    </div>
</div>











<?php
    //VARIABLES
    $lista_competencias = '';

    $queryCompetencias = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos WHERE id_evaluado = '".$evaludo."' GROUP BY id_competencia ");
    while($dataCompetencias = mysqli_fetch_array($queryCompetencias)){
        
        $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataCompetencias["id_competencia"]."' ");
        $dataComp = mysqli_fetch_array($queryComp);
        
        $ponderacion_empleado = PonderacionNumericaEmpleadoCompetencia( $connect_valoracion, $connect_valentina, $evaludo, $dataCompetencias["id_competencia"]  );
        $promedio = $ponderacion_empleado["datos"]["total"];
        
        $color = '';
        $nivel = '';
        if( $promedio >= 0 && $promedio < 1.7 ){ $color = "#FF7173" ; $nivel = 'Insatisfactoria'; }
        if( $promedio >= 1.7 && $promedio < 2.7 ){ $color = "#FFC03A" ; $nivel = 'Marginal/Insuficiente'; }
        if( $promedio >= 2.7 && $promedio < 3.7 ){ $color = "#2ADAFF" ; $nivel = 'Satisfactorio'; }
        if( $promedio >= 3.7 && $promedio <= 4 ){ $color = "#B5FF87" ; $nivel = 'Supera expectativas'; }
 
        $porcentaje = ($promedio * 100) / 4;
        
        
        $lista_comportamientos = '';
        $lista_fortalezas = '';
        $lista_oportunidades = '';
        $lista_comentarios = '';
        
        $count_comp = 1;
        $queryRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos 
        WHERE id_evaluado = '".$evaludo."' AND id_competencia = '".$dataCompetencias["id_competencia"]."' GROUP BY 	id_comportamientos ");
        while($dataRespuestas = mysqli_fetch_array($queryRespuestas)){
            
            $queryComport = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE 
            id = '".$dataRespuestas["id_comportamientos"]."' ");
            $dataComport = mysqli_fetch_array($queryComport);
            
            $ponderacion_comportamiento = PonderacionNumericaEmpleadoCompetenciaComportamientos( $connect_valoracion, $connect_valentina, $evaludo, $dataCompetencias["id_competencia"], $dataRespuestas["id_comportamientos"] );
            $promedio_comportamiento = $ponderacion_comportamiento["datos"]["total"];

            if( $promedio_comportamiento >= 0 && $promedio_comportamiento < 1.7 ){ $color_cpmt = "#FF7173";  }
            if( $promedio_comportamiento >= 1.7 && $promedio_comportamiento < 2.7 ){ $color_cpmt = "#FFC03A"; }
            if( $promedio_comportamiento >= 2.7 && $promedio_comportamiento < 3.7 ){ $color_cpmt = "#2ADAFF"; }
            if( $promedio_comportamiento >= 3.7 && $promedio_comportamiento <= 4 ){ $color_cpmt = "#B5FF87"; }
            
            $porcentaje_cpmt = $promedio_comportamiento*100 / 4;
            
            
            $lista_comportamientos .= '
            <tr>
                <td width="30"><b>'.$count_comp.'</b></td>
                <td width="350">'.$dataComport["indicador"].'</td>
                <td>
                    <div style="width: 100%; background-color: #E9E9E9">
                        <div style="height: 20px; width: '.$porcentaje_cpmt.'%; background-color: '.$color_cpmt.'">
                            <b style="margin-left: 10px;">'.$promedio_comportamiento.'</b>
                        </div>
                    </div>
                </td>
            </tr>
            ';
            
            $count_comp++;
            
            if ( $promedio_comportamiento >= $dataCargo["corte"]   ){
                $lista_fortalezas .= "<b>↥</b> ".$dataComport["fortaleza"]."<br>";
            }
            
            if($promedio_comportamiento <= $dataCargo["corte"]  ){
                $lista_oportunidades .= "<b>↧</b> ".$dataComport["oportunidad"]."<br>";
            }
            
            //if(){$lista_comentarios .= $data;}
            
        }
     
?>
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="left">
        <div>Competencia: <b><?php echo $dataComp["nombre"]; ?></b></div>
        <div>Promedio: <b><?php echo round($ponderacion_empleado["datos"]["total"] , 2); ?></b></div>
        <div>Nivel: <b><?php echo $nivel; ?></b> </div>
        <div style="width: 100%; background-color: #E9E9E9">
            <div style="height: 20px; width: <?php echo $porcentaje; ?>%; background-color: <?php echo $color; ?>"></div>
        </div>
        
        <div style="margin-top: 10px; padding-left: 20px;">
            <div style="margin-bottom: 10px"><b>Comportamientos asociados</b></div>
            <table width="100%" class="table table-sm table-bordered ">
                <?php echo $lista_comportamientos; ?>
            </table>
            
        </div>
        
        <div class="row" style="margin-top: 10px;">
        
            <div class="col-md-6">
                <div align="center"><b>Fortalezas</b></div>
                <?php echo $lista_fortalezas; ?>
            </div>
            <div class="col-md-6">
                <div align="center"><b>Oportunidades</b></div>
                <?php echo $lista_oportunidades; ?>
            </div>
            
            <div class="col-md-12" style="margin-top: 15px">
                <div align="center"><b>Observaciones</b></div>
                <?php 
        
               
        
                    if( $ponderacion_comportamiento["observaciones"] != "" ){
                        echo $ponderacion_comportamiento["observaciones"];
                    }
                    else{
                        echo '<div style=" color: #a5a5a5;">No tiene observaciones</div>';
                    }
        
        
                ?>
            </div>
            
        </div>
        
    </div>
</div>

<?php
    }
?>
















<!-- Competencias -->
<!-- Competencias -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="titulo">OBSERVACIONES Y COMENTARIOS FINALES</div>
        <div align="left"><?php echo $observaciones_generales_lista; ?></div>

        
    </div>
</div>
</form>









<script>
    $("#bt_val_seguimiento").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<script>
    function SelectCheck(elem, id){
        
        estado = $(elem).prop('checked') ;
        //if(estado == true){
            //$(".comp_"+id).removeAttr('checked');
            //$(".comp_"+id).prop('disabled', !this.checked);
            //event.preventDefault();
            $(".comp_"+id).prop('checked',false);
            $(elem).prop('checked',true);
            
            $(".comp_"+id).prop('required',false);
        //}
        /*
        else{
            $(".comp_"+id).prop('checked',false);
            $(".comp_"+id).prop('required',false);
        }*/
    }
    
    
    function Activar_Terminar_Eval(elem){
        estado = $(elem).prop('checked') ;
        
        if(estado == true){
            //$(".comp_"+id).removeAttr('checked');
            //$(".comp_"+id).prop('disabled', !this.checked);
            //event.preventDefault();
            $("#bt_terminar_evaluacion").prop('disabled',false);
            $(elem).prop('checked',true);
        }
        else{
            $("#bt_terminar_evaluacion").prop('disabled',true);
            $(".comp_"+id).prop('checked',false);
        }
        
        
    }
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

