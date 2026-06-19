<script>
    $("#bt_val_informes").addClass("active_item"); 
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<?php

    $hoy = date("Y-m-d H:i:s");
    $id_evaluado = $_GET["e"];

    include("views/valoracion/informes/funciones.php");
    $datos_generales = ValidarEvaluacionesCompletas($id_evaluado, $connect_valoracion, $connect_valentina);
    //print_r($datos_generales);

    //TODAS LAS EVALUACIONES DEL EVALUADO
    $EVALUACIONES = array();
    $COMPETENCIAS = array();
    $comentarios_finales = "";
    $fecha_evaluacion = "";

    $id_cargo = 0;
    $queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND 
    id_evaluado = '".$id_evaluado."' AND anio = '".$_SESSION['anio']."' AND estado = 2 ORDER BY created_at DESC ");
    while($dataEvaluacion = mysqli_fetch_array($queryEvaluaciones)){
        
        $queryEvaluador = mysqli_query($connect_valentina,"SELECT nombre, apellidos FROM Empleados WHERE id = '".$dataEvaluacion["id_evaluador"]."' ");
        $dataEvaluador = mysqli_fetch_array($queryEvaluador);
        
        $id_cargo = $dataEvaluacion["id_cargo"];
        $fecha_evaluacion = $dataEvaluacion["created_at"];
        
        if($dataEvaluacion["observaciones"]){
            $comentarios_finales .= $dataEvaluacion["observaciones"]."<br>";
        }
        
        $Array_Objeto = json_decode($dataEvaluacion["obj_evaluacion"], true);
        foreach($Array_Objeto as $respuestas){
            array_push($COMPETENCIAS, $respuestas["competencia"] );
        }
        
        $text_tipo = "";
        foreach($array_Tipo_Colaborador as $tipo){
            if($tipo[0] == $dataEvaluacion["tipo_evaluacion"]){
                $text_tipo = $tipo[1];
            }
        }

        $datos = array(
            "id_evaluador"=> $dataEvaluacion["id_evaluador"],
            "nombre_evaluador" => $dataEvaluador["nombre"]." ".$dataEvaluador["apellidos"],
            "obj_evaluacion"=> $dataEvaluacion["obj_evaluacion"],
            "tipo_evaluacion" => $dataEvaluacion["tipo_evaluacion"], 
            "text_tipo" => $text_tipo
        );
        
        array_push($EVALUACIONES, $datos );
    }

    $COMPETENCIAS = array_unique($COMPETENCIAS);


/*
    foreach($EVALUACIONES as $evaluacion){
        //$objeto_respuestas_tmp = json_decode($evaluacion["obj_evaluacion"], true);

        array_push($COMPETENCIAS, );
    }
*/




    //DATOS DEL EVALUADO
    //DATOS DEL EVALUADO
    $queryEvaluado = mysqli_query($connect_valentina,"SELECT Empleados.nombre AS nombre, Empleados.apellidos AS apellidos, Cargos.nombre AS nombre_cargo
    FROM Empleados 
    LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
    WHERE Empleados.id = '".$id_evaluado."'");
    $dataEvaluado = mysqli_fetch_array($queryEvaluado);

    $queryCargoHistorico = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$id_cargo."'");
    $dataCargoHistorico = mysqli_fetch_array($queryCargoHistorico);

    

    
    //PERFIL DEL CARGO NIVEL COMPETENCIA
    //PERFIL DEL CARGO NIVEL COMPETENCIA   
    $queryCargo = mysqli_query($connect_valoracion,"SELECT * FROM Perfiles_Cargos WHERE id = '".$id_evaluado."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);
    $perfiles = explode("," , $dataCargo["perfil"] );

  //$observaciones_generales_lista = '';


?>

<style>
    .titulo{
        font-size: 18px; 
        font-weight: bold;
        margin-bottom: 10px;
    }
    .titulo_comp{
        font-size: 20px;
        font-weight: bold;
        text-align: left;
        margin-top: 30px;
    }
    .base_porcentajes{
        width: 100%; 
        background-color: #E9E9E9;
        margin-bottom: 10px;
        
    }
    
    .barra_porcien{
        width: 86.5%; 
        background-color: #2ADAFF;     
        text-align: center;
        font-weight: bold; 
        padding: 5px;
    }
</style>

<div class="container">

	<!-- FICHA -->
	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="center">

			<div class="row">
				<div class="col-md-8" align="left">
					Colaborador Evaluado: <b><?php echo $dataEvaluado["nombre"]." ".$dataEvaluado["apellidos"]; ?></b> <br>
					Fecha de Valoracion: <b><?php echo $fecha_evaluacion; ?></b> <br>
					Cargo: <b><?php echo $dataCargoHistorico["nombre"]; ?></b> <br>
				</div>
				<div class="col-md-4" align="center">
					<button type="button" class="btn btn-warning btn-sm" onclick="window.print();" style="background-color: #FFC107; border: 0; color: #ffffff; padding: 10px; ">
						<i class="fa fa-print"></i> Imprimir / Descargar
					</button>
				</div>
			</div>

		</div>
	</div>

	<!-- FICHA -->
	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="center">

			<div class="row">
				<div class="col-md-12" align="left">
					<div align="center" class="titulo" >INFORME CONSOLIDADO EVALUADORES</div>
					<?php
					//OBTENEMOS EL PROMEDIO GENERAL DEL EVALUADO
					//$PROMEDIOS_EVALUADO = PromedioGeneralEvaluado($connect_valoracion, $connect_valentina, $id_evaluado, 0, 0);

					$promedio_general = $datos_generales["promedio_general"];
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
				$queryEscala = mysqli_query($connect_valoracion,"SELECT * FROM Escalas WHERE id_empresa = '".$_SESSION["id_empresa"]."' AND anio = '".$_SESSION['anio']."' ");
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

	<!-- ESCALA -->
	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="center">

			<div class="titulo">RESULTADO GRÁFICO CONSOLIDADO</div>


				<?php
				foreach($COMPETENCIAS as $competencia){

					$queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$competencia."' ");
					$dataNivel = mysqli_fetch_array($queryNivel);

					$queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataNivel["id_competencia"]."' ");
					$dataComp = mysqli_fetch_array($queryComp);

					$total = 0;
					$cantidad = 0;
					$array_evaluadores = array();

					//OBTENEMOS EL PROMEDIO DE CADA COMPETENCIA
					foreach($EVALUACIONES as $evaluacion){
						$Array_Objeto = json_decode($evaluacion["obj_evaluacion"], true);
						foreach($Array_Objeto as $respuestas){
							//AQUI SE VALIDA SI LA COMPETENCIA DE LA EVALUACION CORRESPONDE A ESTA COMPETENCIA.
							if($respuestas["competencia"] == $competencia ){

								$prom_competencia = 0;
								$cant_prom_competencia = 0;
								$respuestas_competencia = $respuestas["respuestas"]; //array
								//consultamos las respuestas de esta competencia en esta evaluacion
								foreach($respuestas_competencia as $resp){
									//general de la competencia
									$total += $resp["respuesta"];
									$cantidad++;

									//indiviudal del evaluador
									$prom_competencia += $resp["respuesta"];
									$cant_prom_competencia++;
								}

								$prom_comp_evaluador = round(($prom_competencia/$cant_prom_competencia),2);
								$array_datos_evaluador_competencia = array(
									"nombre_evaluador"=> $evaluacion["nombre_evaluador"],
									"promedio"=> $prom_comp_evaluador, 
									"text_tipo"=> $evaluacion["text_tipo"], 
									"porcentaje" => ($prom_comp_evaluador*100)/4
								);

								//cargamos en un array los evaluadores con sus promedios en esta competencia.
								array_push($array_evaluadores, $array_datos_evaluador_competencia );

							}
						}
					}
					$promedio_compt = $total/$cantidad;

				?>
					<table style="width: 100%;">
					<tr>
						<td>
							<div  class="titulo_comp"><?php echo $dataComp["nombre"]; ?> / <?php echo round($promedio_compt,2); ?></div>


						<?php 
							foreach( $array_evaluadores as $datos ){
								$color_compt = '';
								if( $datos["promedio"] >= 0 && $datos["promedio"] < 1.7 ){ $color_compt = "#FF7173" ; }
								if( $datos["promedio"] >= 1.7 && $datos["promedio"] < 2.7 ){ $color_compt = "#FFC03A" ; }
								if( $datos["promedio"] >= 2.7 && $datos["promedio"] < 3.7 ){ $color_compt = "#2ADAFF" ; }
								if( $datos["promedio"] >= 3.7 && $datos["promedio"] <= 4 ){ $color_compt = "#B5FF87" ; }

								echo '
								<div>'.$datos["text_tipo"].' - '.$datos["nombre_evaluador"].'</div>
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

				<?php } ?>


		</div>
	</div>

</div>

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




