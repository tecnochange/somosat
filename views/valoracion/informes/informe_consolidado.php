<?php

    $hoy = date("Y-m-d H:i:s");
    $id_evaluado = $_GET["e"];

    include("views/valoracion/informes/funciones.php");
    $datos_generales = ValidarEvaluacionesCompletas($id_evaluado, $connect_valoracion, $connect_valentina);

    //TODAS LAS EVALUACIONES DEL EVALUADO
    $EVALUACIONES = array();
    $COMPETENCIAS = array();
    $comentarios_finales = "";
    $fecha_evaluacion = "";


    $fortalezas_general = "";
    $mejoras_general = "";

    $id_cargo = 0;
    $queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND 
    id_evaluado = '".$id_evaluado."' AND anio = '".$_SESSION['anio']."' AND estado = 2 ORDER BY created_at DESC ");
    while($dataEvaluacion = mysqli_fetch_array($queryEvaluaciones)){
        
        $id_cargo = $dataEvaluacion["id_cargo"];
        
        $fecha_evaluacion = $dataEvaluacion["created_at"];
        
        if($dataEvaluacion["observaciones"]){
            $comentarios_finales .= $dataEvaluacion["observaciones"]."<br>";
            $fortalezas_general .= nl2br($dataEvaluacion["observaciones"])."<hr>";
        }

        if($dataEvaluacion["mejoras"]){
            $mejoras_general .= nl2br( $dataEvaluacion["mejoras"] )."<hr>";
        }
        
        $Array_Objeto = json_decode($dataEvaluacion["obj_evaluacion"], true);
        foreach($Array_Objeto as $respuestas){
            array_push($COMPETENCIAS, $respuestas["competencia"] );
        }

        $datos = array(
            "id_evaluador"=> $dataEvaluacion["id_evaluador"],
            "obj_evaluacion"=> $dataEvaluacion["obj_evaluacion"],
            "tipo_evaluacion" => $dataEvaluacion["tipo_evaluacion"]
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
    $queryCargo = mysqli_query($connect_valoracion,"SELECT * FROM Perfiles_Cargos WHERE id_cargo = '".$id_cargo."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);
    $perfiles = explode("," , $dataCargo["perfiles"] );

    $corte = $dataCargo["corte"];

  //$observaciones_generales_lista = '';


?>

<div class="container">

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
					<div align="center" class="titulo" >INFORME CONSOLIDADO VALORACIÓN DE COMPETENCIAS</div>
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

	<!-- FICHA -->
	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="center">

			<div class="row">
				<div class="col-md-12" align="left">
					<div align="center" class="titulo" >RESULTADO GRÁFICO CONSOLIDADO</div>

					<table width="100%">
						<tr>
						<?php
						foreach($COMPETENCIAS as $competencia){

							$total = 0;
							$cantidad = 0;
							foreach($EVALUACIONES as $evaluacion){
								$Array_Objeto = json_decode($evaluacion["obj_evaluacion"], true);
								foreach($Array_Objeto as $respuestas){

									if($respuestas["competencia"] == $competencia ){
										$respuestas_competencia = $respuestas["respuestas"];
										foreach($respuestas_competencia as $resp){
											$total += $resp["respuesta"];
											$cantidad++;
										}
									}
								}
							}

							$promedio_compt = $total/$cantidad;

							$queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$competencia."' ");
							$dataNivel = mysqli_fetch_array($queryNivel);

							$queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataNivel["id_competencia"]."' ");
							$dataComp = mysqli_fetch_array($queryComp);

							$porcentaje_comt = ($promedio_general * 100) / 4;

							$color_compt = '';
							if( $promedio_compt >= 0 && $promedio_compt < 1.7 ){ $color_compt = "#FF7173" ; }
							if( $promedio_compt >= 1.7 && $promedio_compt < 2.7 ){ $color_compt = "#FFC03A" ; }
							if( $promedio_compt >= 2.7 && $promedio_compt < 3.7 ){ $color_compt = "#2ADAFF" ; }
							if( $promedio_compt >= 3.7 && $promedio_compt <= 4 ){ $color_compt = "#B5FF87" ; }

							$porcentaje_comt = ($promedio_compt * 100) / 4;

							echo '
							<td align="center" valign="bottom"  width="'.( 100/count($COMPETENCIAS) ).'%" >

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
	</div>

	<!-- ESCALA -->
	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="center">

			<div class="titulo">INFORME POR COMPETENCIAS</div>
		</div>
	</div>

	<?php
	foreach($COMPETENCIAS as $competencia){

		$total = 0;
		$cantidad = 0;
		$array_respuestas = array();
		$comentarios_competencia = "";

		foreach($EVALUACIONES as $evaluacion){
			$Array_Objeto = json_decode($evaluacion["obj_evaluacion"], true);
			foreach($Array_Objeto as $respuestas){

				if($respuestas["competencia"] == $competencia ){

					$respuestas_competencia = $respuestas["respuestas"];
					foreach($respuestas_competencia as $resp){
						$total += $resp["respuesta"];
						$cantidad++;
						array_push($array_respuestas, $resp["pregunta"]);
					}

					if($respuestas["observaciones"]){

                        $cadenalimpia_edit = str_replace("u00e1", "á",  $respuestas["observaciones"]);
                        $cadenalimpia_edit = str_replace("u00f3", "ó",  $cadenalimpia_edit);
                        $cadenalimpia_edit = str_replace("u00e9", "é",  $cadenalimpia_edit);
                        $cadenalimpia_edit = str_replace("u00f1", "ñ",  $cadenalimpia_edit);
                        $cadenalimpia_edit = str_replace("u00ed", "í",  $cadenalimpia_edit); 
                        $cadenalimpia_edit = str_replace("u00fa", "ú",  $cadenalimpia_edit);

						$comentarios_competencia .= $cadenalimpia_edit."<br>";   
					}

				}

			}
		}
		$array_respuestas = array_unique($array_respuestas);

		$promedio_compt = $total/$cantidad;

		$queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$competencia."' ");
		$dataNivel = mysqli_fetch_array($queryNivel);

		$queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataNivel["id_competencia"]."' ");
		$dataComp = mysqli_fetch_array($queryComp);

		$porcentaje = ($promedio_compt * 100) / 4;

		$nivel = '';
		$color = '';
		if( $promedio_compt >= 0 && $promedio_compt < 1.7 ){ $color = "#FF7173" ; $nivel = 'Insatisfactoria'; }
		if( $promedio_compt >= 1.7 && $promedio_compt < 2.7 ){ $color = "#FFC03A" ; $nivel = 'Marginal/Insuficiente'; }
		if( $promedio_compt >= 2.7 && $promedio_compt < 3.7 ){ $color = "#2ADAFF" ; $nivel = 'Satisfactorio'; }
		if( $promedio_compt >= 3.7 && $promedio_compt <= 4 ){ $color = "#B5FF87" ; $nivel = 'Supera expectativas'; }

		$lista_comportamientos = '';
		$lista_fortalezas = '';
		$lista_oportunidades = '';

		$count_comp = 1;
		//CARGAMOS LA LISTA DE RESPUESTAS
		foreach($array_respuestas as $respuesta){

			$totalInd = 0;
			$cantidadInd = 0;
			foreach($EVALUACIONES as $evaluacion){

				$Array_respuesta = json_decode($evaluacion["obj_evaluacion"], true);

				foreach($Array_respuesta as $respuestas){

					foreach($respuestas["respuestas"] as $resp){
						if( $resp["pregunta"] == $respuesta ){
							$totalInd += $resp["respuesta"];
							$cantidadInd++;
						}
					}

				}

			}
			$promedio_comportamiento = $totalInd/$cantidadInd;

			$color_cpmt = '';
			if( $promedio_comportamiento >= 0 && $promedio_comportamiento < 1.7 ){ $color_cpmt = "#FF7173";  }
			if( $promedio_comportamiento >= 1.7 && $promedio_comportamiento < 2.7 ){ $color_cpmt = "#FFC03A"; }
			if( $promedio_comportamiento >= 2.7 && $promedio_comportamiento < 3.7 ){ $color_cpmt = "#2ADAFF"; }
			if( $promedio_comportamiento >= 3.7 && $promedio_comportamiento <= 4 ){ $color_cpmt = "#B5FF87"; }

			$porcentaje_cpmt = $promedio_comportamiento*100 / 4;

			$queryComport = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE 
			id = '".$respuesta."' ");
			$dataComport = mysqli_fetch_array($queryComport);

			$lista_comportamientos .= '
				<tr>
					<td width="30"><b>'.$count_comp.'</b></td>
					<td width="350">'.$dataComport["indicador"].'</td>
					<td>
						<div style="width: 100%; background-color: #E9E9E9">
							<div style="height: 20px; width: '.$porcentaje_cpmt.'%; background-color: '.$color_cpmt.'">
								<b style="margin-left: 10px;">'.round($promedio_comportamiento,2).'</b>
							</div>
						</div>
					</td>
				</tr>
			';
			$count_comp++;

			if ( $promedio_comportamiento >= $corte   ){
				if($dataComport["fortaleza"]){
					$lista_fortalezas .= "<b>↥</b> ".$dataComport["fortaleza"]."<br>";
				}
			}

			if($promedio_comportamiento <= $corte  ){
				if($dataComport["oportunidad"]){
					$lista_oportunidades .= "<b>↧</b> ".$dataComport["oportunidad"]."<br>";
				}
			}

		}





		/*
		$count_comp = 1;
		$queryRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos__ 
		WHERE id_evaluado = '".$id_evaluado."' AND id_competencia = '".$dataComp["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' 
		GROUP BY id_comportamientos ");
		while($dataRespuestas = mysqli_fetch_array($queryRespuestas)){

			$queryComport = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE 
			id = '".$dataRespuestas["id_comportamientos"]."' ");
			$dataComport = mysqli_fetch_array($queryComport);


			$PROM_COMPORTAMIENTO = PromedioGeneralEvaluado( $connect_valoracion, $connect_valentina, $id_evaluado, $dataComp["id"], $dataRespuestas["id_comportamientos"] );
			$promedio_comportamiento = $PROM_COMPORTAMIENTO["total"];
			$comentarios_competencia = $PROM_COMPORTAMIENTO["comentarios_competencias"];
			$comentarios_evaluaciones = $PROM_COMPORTAMIENTO["comentarios_evaluaciones"];


			//$promedio_comportamiento = round(($total_cal/$cant_resp),2);
			$color_cpmt = '';
			if( $promedio_comportamiento >= 0 && $promedio_comportamiento < 1.7 ){ $color_cpmt = "#FF7173";  }
			if( $promedio_comportamiento >= 1.7 && $promedio_comportamiento < 2.7 ){ $color_cpmt = "#FFC03A"; }
			if( $promedio_comportamiento >= 2.7 && $promedio_comportamiento < 3.7 ){ $color_cpmt = "#2ADAFF"; }
			if( $promedio_comportamiento >= 3.7 && $promedio_comportamiento <= 4 ){ $color_cpmt = "#B5FF87"; }

			$porcentaje_cpmt = $promedio_comportamiento*100 / 4;

			$lista_comportamientos .= '
				<tr>
					<td width="30"><b>'.$count_comp.'</b></td>
					<td width="350">'.$dataComport["indicador"].' - '.$corte.'</td>
					<td>
						<div style="width: 100%; background-color: #E9E9E9">
							<div style="height: 20px; width: '.$porcentaje_cpmt.'%; background-color: '.$color_cpmt.'">
								<b style="margin-left: 10px;">'.round($promedio_comportamiento,1).'</b>
							</div>
						</div>
					</td>
				</tr>
			';
			$count_comp++;

			if ( $promedio_comportamiento >= $corte   ){
				$lista_fortalezas .= "<b>↥</b> ".$dataComport["fortaleza"]."<br>";
			}

			if($promedio_comportamiento <= $corte  ){
				$lista_oportunidades .= "<b>↧</b> ".$dataComport["oportunidad"]."<br>";
			}

		}
		*/


	?>


	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="left">
			<div>Competencia: <b><?php echo $dataComp["nombre"]; ?></b></div>
			<div>Promedio: <b><?php echo round($promedio_compt , 2); ?></b></div>
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

				<div class="col-md-6" style="display:none">
					<div align="center"><b>Fortalezas</b></div>
					<?php echo $lista_fortalezas; ?>
				</div>
				<div class="col-md-6" style="display:none">
					<div align="center"><b>Oportunidades</b></div>
					<?php echo $lista_oportunidades; ?>
				</div>

				<div class="col-md-12" style="margin-top: 15px">
					<div align="center"><b>Observaciones</b></div>
					<?php 

						if( $comentarios_competencia ){
							echo $comentarios_competencia;
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


	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="center">

            <div class="row">
                <div class="col-md-6">
                    <div class="titulo">ÁREAS DE FORTALEZAS</div>
                    <div align="left"><?php echo $fortalezas_general; ?></div>
                </div>
                <div class="col-md-6">
                    <div class="titulo">ÁREAS DE MEJORAS</div>
                    <div align="left"><?php echo $mejoras_general; ?></div>
                </div>
            </div>




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

