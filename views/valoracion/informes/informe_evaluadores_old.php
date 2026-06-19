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

    //VALIDAMOS SI TIENE EVALUACION COMPLETA DE ESTE EVALUADOR
    $queryEvaluacion = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  anio = '2021' AND id_evaluado = '".$evaludo."' ORDER BY created_at DESC ");
    while($dataEvaluacion = mysqli_fetch_array($queryEvaluacion)){
        $fecha_evaluacion = $dataEvaluacion["created_at"];
        $observaciones_generales_lista .= "* ".$dataEvaluacion["observaciones"].'<br>';
    }
   
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
        
        $datos_evaluadores = $ponderacion_compet["tabla"];
        
        
        
        $tabla = '<table style="width: 100%;">';
        
        foreach($datos_evaluadores as $datosEvals){
            
            $txt_tipo = '';
            foreach($array_Tipo_Colaborador as $tipo){ 
                if( $tipo[0] == $datosEvals[0] ){ $txt_tipo = $tipo[1]; } 
            }
            
            $no_porciento = $datosEvals[2] *100/4; 
            
            $color_compt = '';
            if( $datosEvals[2] >= 0 && $datosEvals[2] < 1.7 ){ $color_compt = "#FF7173" ; }
            if( $datosEvals[2] >= 1.7 && $datosEvals[2] < 2.7 ){ $color_compt = "#FFC03A" ; }
            if( $datosEvals[2] >= 2.7 && $datosEvals[2] < 3.7 ){ $color_compt = "#2ADAFF" ; }
            if( $datosEvals[2] >= 3.7 && $datosEvals[2] <= 4 ){ $color_compt = "#B5FF87" ; }
            
            $tabla .= '
                <tr>
                    <td>
                    '.$txt_tipo.' - '.$datosEvals[1].'
                    <div class="base_porcentajes">
                        <div class="barra_porcien" style="width:'.$no_porciento.'%; background-color: '.$color_compt.';">
                            '.$datosEvals[2].'
                        </div>
                    <div>
                    </td>
                </tr>
            ';
        }
        
        $tabla .= '</table>';
        
        
        $color_compt = '';
        if( $promedio_compt >= 0 && $promedio_compt < 1.7 ){ $color_compt = "#FF7173" ; }
        if( $promedio_compt >= 1.7 && $promedio_compt < 2.7 ){ $color_compt = "#FFC03A" ; }
        if( $promedio_compt >= 2.7 && $promedio_compt < 3.7 ){ $color_compt = "#2ADAFF" ; }
        if( $promedio_compt >= 3.7 && $promedio_compt <= 4 ){ $color_compt = "#B5FF87" ; }
 
        $porcentaje_comt = ($promedio_compt * 100) / 4;
        
        $competencia_list .= '
            <div class="col-md-12" align="left" >
                <div  class="titulo_comp">'.$dataComp["nombre"].' / '.number_format($promedio_compt).'</div>
                '.$tabla.'
            </div>
        
        
        
        
        <!--
        <td align="center" valign="bottom"  width="'.( 100/count($perfiles) ).'%" >
            
            <div>'.$promedio_compt.'<div>
            <div style="width: 60px; height:200px; background-color: #E9E9E9">
                <div style="height: '.(100-$porcentaje_comt).'%; width: 60px;">
                </div>
                <div style="height: '.$porcentaje_comt.'%; width: 60px; background-color: '.$color_compt.'">
                </div>
            </div>
            <div style="font-size: 12px; height: 35px;">'.$dataComp["nombre"].'</div>
        </td>
        -->
        ';
        

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


<?php include("views/layouts/ficha_competencia.php"); ?>
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
                <div align="center" class="titulo" >INFORME CONSOLIDADO POR EVALUADORES</div>
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
                    Promedio Consolidado Valoración: <b><?php echo $promedio_general;  ?></b><br>
                    Porcentaje nivel de desarrollo: <b><?php echo (($promedio_general*100)/4)  ?>%</b>
                </div>
                <div style="width: 100%; background-color: #E9E9E9">
                    <div style="width: <?php echo $porcentaje_general; ?>%; background-color: <?php echo $color_general; ?>;     text-align: center;font-weight: bold; padding: 5px;">
                        <?php echo $promedio_general;  ?> - <?php echo (($promedio_general*100)/4)  ?>%
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

