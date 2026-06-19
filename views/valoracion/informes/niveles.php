<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<?php 

    function DatosNivel($id_nivel, $connect_valentina, $connect_valoracion){
        $array_cargos = array();
		
        $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empresa = '".$_SESSION["id_empresa"]."' ORDER BY nombre ASC ");
		while($dataCargos = mysqli_fetch_array($queryCargos)){
            $perfiles = explode("," , $dataCargos["perfil"] ); 
            
            foreach($perfiles as $prf){
                $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles 
                WHERE id = '".$prf."' AND id_nivel = '".$_POST["id_nivel"]."'  ");
                if($queryNivel->num_rows > 0){
                    array_push($array_cargos, $dataCargos["id"] );
                }
            }
            
        }

        $array_cargos = array_unique($array_cargos);
        return $array_cargos;
    }





    if($_POST["id_nivel"] != ""){
        $array_cargos = array();
		$queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empresa = '".$_SESSION["id_empresa"]."' ORDER BY nombre ASC ");
		while($dataCargos = mysqli_fetch_array($queryCargos)){
            $perfiles = explode("," , $dataCargos["perfil"] ); 
            
            foreach($perfiles as $prf){
                $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles 
                WHERE id = '".$prf."' AND id_nivel = '".$_POST["id_nivel"]."'  ");
                if($queryNivel->num_rows > 0){
                    array_push($array_cargos, $dataCargos["id"] );
                }
            }
            
        }

        $array_cargos = array_unique($array_cargos);
        //print_r($array_cargos);
    
    }
?>


<?php echo $respuesta; ?>

<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Informes Por Niveles <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
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
        <a class="nav-link " href="?pg=valoracion/informes/areas">Area / Procesos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/informes/niveles">Niveles</a>
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

<style>
    .titulo{
        font-size: 18px; 
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>


<?php      
include("views/valoracion/informes/controladores_informes.php");

$count = 1;
//$queryNiveles = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$_SESSION['id_empresa']."' ORDER BY id DESC ");
//while($dataNiveles = mysqli_fetch_array($queryNiveles)){
foreach($Array_Nivel_Cargo as $NIVEL){
    
    $lista_cargos = '';
    $promedio_general = 0;
    $cantidad_promedios = 0;
 
    $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE 
    id_empresa = '".$_SESSION["id_empresa"]."' AND nivel_cargo = '".$NIVEL[0]."' ORDER BY nombre ASC ");
    while($dataCargos = mysqli_fetch_array($queryCargos)){
        
        $promedio_cargo = 0;
        
        $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
        WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND 
        role > 1 AND id_cargo = '".$dataCargos["id"]."' ORDER BY nombre ASC ");  
        while($data = mysqli_fetch_array($queryEmpleados)){ 
            $EVALUACIONES = ValidarEvaluacionesCompletas( $data["id"], $connect_valoracion, $connect_valentina);
            if($EVALUACIONES["promedio_general"] > 0){
                $promedio_general += $EVALUACIONES["promedio_general"];
                $promedio_cargo += $EVALUACIONES["promedio_general"];
                $cantidad_promedios ++;
            }
        }
        
        $lista_cargos .= $dataCargos["nombre"]. " - ".round($promedio_cargo,2)."<br>";
    }
    
    $promedio_nivel = $promedio_general/$cantidad_promedios;
    $porcentaje_promedio_nivel = ($promedio_nivel*100)/4;
    
    $color_general = '';
    if( $promedio_nivel >= 0 && $promedio_nivel < 1.7 ){ $color_general = "#FF7173" ; }
    if( $promedio_nivel >= 1.7 && $promedio_nivel < 2.7 ){ $color_general = "#FFC03A" ; }
    if( $promedio_nivel >= 2.7 && $promedio_nivel < 3.7 ){ $color_general = "#2ADAFF" ; }
    if( $promedio_nivel >= 3.7 && $promedio_nivel <= 4 ){ $color_general = "#B5FF87" ; }
    
    $barra = '
        <div style="width: 100%; background-color: #E9E9E9">
            <div style="width: '.$porcentaje_promedio_nivel.'%; background-color: '.$color_general.'; text-align: center;font-weight: bold; padding: 5px;">
                '.round($promedio_nivel,2).' - '.round($porcentaje_promedio_nivel, 2).'%
            </div>
        </div>
    ';
    
    
 
        
    if( $promedio_general > 0){
    
?>

    <div class="card">

        <div class="card-header" align="center">
            <h4><?php echo $NIVEL[1]; ?></h4>
        </div>

        <div class="card-body">
            <?php echo $barra; ?>
        </div>

        <div class="card-body">
            <?php echo $lista_cargos; ?>
        </div>

    </div>

<?php } } ?>


























<?php 







        
$count = 1;
foreach($arrayNivelesCargos as $nivel){
    
    $lista_cargos = '';
    $promedio = 0;
    $cantidad = 0;
    $total = 0;
    
    //$ARRAY_NIVELES = DatosNivel($nivel["id"], $connect_valentina, $connect_valoracion);
    

    foreach($ARRAY_NIVELES as $cargo){
                if( $cargo["nivel_cargo"] == $nivel[0] ){
                    $lista_cargos .= $cargo["nombre"]."<br>";
                    
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
                            
                            $ponderacion_empleado = PonderacionPorEmpleado( $arrayEvaluadores, $arrayCompetencias_Evaluaciones, $arrayEmpleados, $empleado["id"], $arrayComRespuestas, $arrayRespuestas, $connect_valoracion );
                            
                            if( $ponderacion_empleado["datos"]["total"] > 0){
                                $promedio += $ponderacion_empleado["datos"]["total"];
                                $cantidad++;
                            }
                            
                        }
                    
                    }
                    
                    $total = round( ($promedio/$cantidad) , 1) ;
                    if( is_nan($total)) { $total = "Sin evaluaciones";}
 
                }
                
                
    }
            
    $porcentj = $total*100/4;
    $color_general = '';
    if( $total >= 0 && $total < 1.7 ){ $color_general = "#FF7173" ; }
    if( $total >= 1.7 && $total < 2.7 ){ $color_general = "#FFC03A" ; }
    if( $total >= 2.7 && $total < 3.7 ){ $color_general = "#2ADAFF" ; }
    if( $total >= 3.7 && $total <= 4 ){ $color_general = "#B5FF87" ; }
            
    $barra = '
        <div style="width: 100%; background-color: #E9E9E9">
                    <div style="width: '.$porcentj.'%; background-color: '.$color_general.'; text-align: center;font-weight: bold; padding: 5px;">
                        '.$total.' - '.round($porcentj, 2).'%
                    </div>
        </div>
    ';
            
            //if($total > 0){
            
?>



<?php           
    //}
        
    $count++; 
}    
?>










<?php if($_POST["id_nivel"] != ""){ ?>
<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                <div align="center" class="titulo" >CARGOS RELACIONADOS</div>
            </div>
            
            <?php
            foreach($array_cargos as $cargo){
                $queryCar = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$cargo."' ");
                $dataCar = mysqli_fetch_array($queryCar);
            ?>
            <div class="col-md-12" align="left">
                <?php echo $dataCar["nombre"]; ?>
            </div>
            <?php } ?>

        </div>
        
    </div>
</div>

<?php } ?>






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

