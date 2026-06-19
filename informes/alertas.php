<?php 
	session_start();
    //VALIDACION DE SESION
    if($_SESSION['id_user'] == ""){
        header('Location: log.php' );
    }

    include("../app/models/connect.php");
    include("../app/models/library.php");

	$hoy = date("Y-m-d H:i:s");
	$ahora = date("Y-m-d");
	//FUNCION PARA OBTENER LOS AÑOS
	function Anios($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

		$years  = floor($dateDifference / (365 * 60 * 60 * 24));
		$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

		$decimal2 = ($months*30+$days)/365;
		$decimal2 = round($decimal2, 1);
		$parte2 = explode(".", $decimal2);

		return ($years.".".$parte2[1]." años");
	}

	//FUNCION PARA OBTENER LOS AÑOS
	function Dias($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
		
		$dias  = floor($dateDifference / ( 60 * 60 * 24));

		return $dias ;
	}
?>





<!DOCTYPE html>
<html>

<head>
    <!-- metas -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="HR Suite">

    <title>Somos AT - Innovando Juntos - Alertas</title>
    
    <style>
        table{
            border-collapse: collapse;
            font-size: 10px;
            font-family: sans-serif;
        }
        .boton{
            background-color: #0364ba; 
            color: #ffffff;
            padding: 6px 20px;
            border: 0;
            border-radius: 7px;
        }
    </style>
    <script src="<?php echo $url; ?>/js/jquery-3.3.1.js"></script>
    
</head>

    
<!-- export-->
<form action="exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
</form>

<body>
    <div style="margin-bottom: 10px">
        <button type="button" class="boton" onclick="exportarReporte()">
            Exportar a Excel
        </button> 
    </div>

    <table border="1" id="tabla_reporte">
        <thead>
            <tr>
                <td colspan="49">
                    <h2>Somos AT - Alertas de vencimiento</h2>
                    <p>Fecha de generación: <?php echo date("Y-m-d H:i:s"); ?></p>
                </td>
            </tr>
            <tr>
                	<th scope="col" width="15">#</th>
                    <th scope="col">Nombres y Apellidos</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Fecha de Vencimiento Documento de Identidad</th>
                    <th scope="col">Fecha de Vencimiento Pasaporte</th>
                    <th scope="col">Fecha de Vencimiento Caja Profesional</th>
                    <th scope="col">Fecha de Vencimiento Carné de Salud</th>
                    <th scope="col">Fecha de Vencimiento Aptitud Física</th>
                    <th scope="col">Fecha de Vencimiento Libreta de Conducir</th>
            </tr>
        </thead>

        <tbody>
			<?php
                    $hoy = date("Y-m-d H:i:s");
                    $count = 1;
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 ORDER BY nombre ASC ");  
                    while($data = mysqli_fetch_array($query)){ 

                        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
                        $dataCargo = mysqli_fetch_array($queryCargo);
                        
                        $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' ");
	                    $dataInforma = mysqli_fetch_array($queryInforma);
                        
                        $queryPerfil = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$data["id"]."' ");
	                    $dataPerfil = mysqli_fetch_array($queryPerfil);
                       
                        
                        $queryJefe = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE codigo_posicion = '".$dataPosicionJefe["codigo"]."' ");  
                        $dataJefe = mysqli_fetch_array($queryJefe);
						
						
						
						//VALIDACION DE ALERTAS
						//VALIDACION DE ALERTAS
						//VALIDACION DE ALERTAS
						$alertas_doc = $dataInforma["fecha_vencimiento"];

						// FECHA DOCUMENTO
						if($dataInforma["fecha_vencimiento"]){
							$dia_documento =  Dias($dataInforma["fecha_vencimiento"]);
							if( $dataInforma["fecha_vencimiento"] < $ahora){

								$alertas_doc .= '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_documento.' días.<br>
									'.$dataInforma["fecha_vencimiento"].'
								</div>';
							}
							if( $dataInforma["fecha_vencimiento"] >= $ahora){
								if($dia_documento < 15){
									$alertas_doc .= '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_documento.' días.<br>
										'.$dataInforma["fecha_vencimiento"].'
									</div>';
								}

							}
						}

						$alertas_pass = $dataInforma["fecha_vencimiento_p"];
						// FECHA DOCUMENTO
						if($dataInforma["fecha_vencimiento_p"]){
							$dia_pasaporte =  Dias( $dataInforma["fecha_vencimiento_p"] );
							if( $dataInforma["fecha_vencimiento_p"] < $ahora){

								$alertas_pass .= '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_pasaporte.' días.<br>
									'.$dataInforma["fecha_vencimiento_p"].'
								</div>';
							}
							if( $dataInforma["fecha_vencimiento_p"] >= $ahora){
								if($dia_pasaporte < 15){
									$alertas_pass .= '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_pasaporte.' días.<br>
										'.$dataInforma["fecha_vencimiento_p"].'
									</div>';
								}

							}
						}

						$alertas_caja = $dataInforma["fv_docu"];
						// FECHA CAJA PROFESIONAL
						if($dataInforma["fv_docu"]){
							$dia_caja =  Dias( $dataInforma["fv_docu"] );
							if( $dataInforma["fv_docu"] < $ahora){

								$alertas_caja .= '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_caja.' días.<br>
									'.$dataInforma["fv_docu"].'
								</div>';
							}
							if( $dataInforma["fv_docu"] >= $ahora){
								if($$dia_caja < 15){
									$alertas_caja .= '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_caja.' días.<br>
										'.$dataInforma["fv_docu"].'
									</div>';
								}

							}
						}
						
						
						$alertas_salud = $dataPerfil["car_salud"];
						// FECHA CAJA PROFESIONAL
						if($dataPerfil["car_salud"]){
							$dia_salud =  Dias( $dataPerfil["car_salud"] );
							if( $dataPerfil["car_salud"] < $ahora){

								$alertas_salud .= '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_salud.' días.<br>
									'.$dataPerfil["car_salud"].'
								</div>';
							}
							if( $dataPerfil["car_salud"] >= $ahora){
								if($dia_salud < 15){
									$alertas_salud .= '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_salud.' días.<br>
										'.$dataPerfil["car_salud"].'
									</div>';
								}

							}
						}
						
						$alertas_fisica = $dataPerfil["apt_fisica"];
						// FECHA CAJA PROFESIONAL
						if($dataPerfil["apt_fisica"]){
							$dia_fisica =  Dias( $dataPerfil["apt_fisica"] );
							if( $dataPerfil["apt_fisica"] < $ahora){

								$alertas_fisica .= '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_fisica.' días.<br>
									'.$dataPerfil["apt_fisica"].'
								</div>';
							}
							if( $dataPerfil["apt_fisica"] >= $ahora){
								if($dia_fisica < 15){
									$alertas_fisica .= '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_fisica.' días.<br>
										'.$dataPerfil["apt_fisica"].'
									</div>';
								}

							}
						}
						
						$alertas_libreta = $dataPerfil["fecha_libreta"];
						// FECHA CAJA PROFESIONAL
						if($dataPerfil["fecha_libreta"]){
							$dia_libreta =  Dias( $dataPerfil["fecha_libreta"] );
							if( $dataPerfil["fecha_libreta"] < $ahora){

								$alertas_libreta .= '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_libreta.' días.<br>
									'.$dataPerfil["fecha_libreta"].'
								</div>';
							}
							if( $dataPerfil["fecha_libreta"] >= $ahora){
								if($dia_libreta < 15){
									$alertas_libreta .= '
									<div >
										Vence en '.$dia_libreta.' días.<br>
										'.$dataPerfil["fecha_libreta"].'
									</div>';
								}

							}
						}
                        
                        
                        
                            
                        
                        
                        
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].' '.$data["nombre_2"].' '.$data["apellidos"].' '.$data["apellidos_2"].'</td>
                            <td>'.$dataCargo["nombre"].'</td>
                            <td>'.$alertas_doc.'</td>
                            <td>'.$alertas_pass.'</td>
                            <td>'.$alertas_caja.'</td>
                            <td>'.$alertas_salud.'</td>
                            <td>'.$alertas_fisica.'</td>
                            <td>'.$alertas_libreta.'</td>
                        </tr>
                        
                        ';
                        $count++;
                    };
                ?>
        </tbody>
    </table>    
    
</body>
</html>

<script>
function exportarReporte(){
	$("#datos_a_enviar").val( $("<div>").append( $("#tabla_reporte").eq(0).clone()).html());
	$("#FormularioExportacion").submit();
}
</script>




