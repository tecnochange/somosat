<?php
    session_start();
    //VALIDACION DE SESION
    if($_SESSION['id_user'] == ""){
        header('Location: log.php' );
    }

    include("../app/models/connect.php");
    include("../app/models/library.php");

    $hoy = date("Y-m-d H:i:s");

    $qryEmpleado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION['id_user']."' ");
    $dtEmpleado = mysqli_fetch_array($qryEmpleado);

    $qryAdicionales = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION['id_colaborador_edit']."' ");
    $dtAdicionales = mysqli_fetch_array($qryAdicionales);

    $qryEditar = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Editar WHERE id_empleado = '".$_SESSION['id_user']."' ");
    $dtEditar = mysqli_fetch_array($qryEditar);

    $qryPerfiles = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$_SESSION['id_user']."' ");
    $dtPerfiles = mysqli_fetch_array($qryPerfiles);

    $qryPreferencias = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$_SESSION['id_user']."' ");
    $dtPreferencias = mysqli_fetch_array($qryPreferencias);

    $qryEmergencia = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Emergencia WHERE id_empleado = '".$_SESSION['id_user']."' ");
    $dtEmergencia = mysqli_fetch_array($qryEmergencia);
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

    <title>Somos AT - Innovando Juntos - Reportes</title>
    
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
                    <h2>Somos AT - Reportes</h2>
                    <p>Fecha de generación: <?php echo date("Y-m-d H:i:s"); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="col" width="15">#</th>
				<th scope="col">Nombre Participante</th>
				<th scope="col">Estado del participante</th>
				<th scope="col">Marca</th>
				<th scope="col">Promotor(PM)</th>
				<th scope="col">Formación (Nombre de la capacitación)</th>
				<th scope="col">Int/Ext</th>
				<th scope="col">Tipo de actividad (Motivo)</th>
				<th scope="col">Tipo de Capacitación</th>
				
				
				
				<th scope="col">Proveedor</th>
				<th scope="col">Fecha evaluación</th>
				<th scope="col">Año</th>
				<th scope="col">Carga Horaria</th>
				<th scope="col">Presupuesto (Costo, presupuesto y Beca)</th>

				<th scope="col">Certificado (adjunto)</th>
				<th scope="col">Descripción (Eficacia)</th>
				<th scope="col">Evidencia (adjunto)</th>

            </tr>
        </thead>

		
		<tbody class="tabla_lista">
            <?php
				$queryCohortes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes "); 
				while($dataCohortes = mysqli_fetch_array($queryCohortes)){ 
					
					$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos 
					WHERE id = '".$dataCohortes["id_proceso"]."' ".$filtros." ");  
                	$dataProceso = mysqli_fetch_array($queryProceso);
					
					if($queryProceso->num_rows > 0){
						
						$txt_estado_participante = "";
						foreach($Array_Estado_Procesos as $nivel){
							if($nivel[0] == $dataCohortes["estado"] ){ $txt_estado_participante = $nivel[1]; }
						}
						
						$queryTipo = mysqli_query($connect_valentina,"SELECT * FROM Tipo_Capacitacion 
						WHERE id = '".$dataProceso["tipo_capacitacion"]."' ");
						$dataTipo = mysqli_fetch_array($queryTipo);
					
						$queryCol = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataCohortes["id_empleado"]."' ");  
						$dataCol = mysqli_fetch_array($queryCol);



						$queryMarca = mysqli_query($connect_formacion,"SELECT * FROM Marcas 
						WHERE id = '".$dataProceso["id_marca"]."' ");  
						$dataMarca = mysqli_fetch_array($queryMarca);

						$queryProveedor = mysqli_query($connect_formacion,"SELECT * FROM Proveedores 
						WHERE id = '".$dataProceso["proveedor"]."' ");  
						$dataProveedor = mysqli_fetch_array($queryProveedor);

						$lista_responsables = "";
						$queryResponsables = mysqli_query($connect_formacion,"SELECT * FROM Responsables WHERE id_proceso = '".$dataProceso["id"]."' "); 
						while($dataResponsable = mysqli_fetch_array($queryResponsables)){ 

							$queryRes = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataResponsable["id_empleado"]."' ");  
							$dataRes = mysqli_fetch_array($queryRes);

							$lista_responsables .= '<div>'.$dataRes["nombre"].' '.$dataRes["apellidos"].'</div>';
						}

						$lista_certificados = "";
						$queryCertificado = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_proceso = '".$dataProceso["id"]."' AND id_empleado = '".$dataCohortes["id_empleado"]."' "); 
						while($dataCertificado = mysqli_fetch_array($queryCertificado)){ 

							$lista_certificados .= '<div>
							<a href="'.$url.'/recursos/'.$dataCertificado["archivo"].'" target="_blank"> 
								<button type="button" class="btn btn-warning btn-sm" title="Participantes">
										Certificado
									</button>
							</a> 
							</div>';
						}
						
						
						
						
						
						$lista_evidencias = "";
						$queryEvidencias = mysqli_query($connect_formacion,"SELECT * FROM Evidencias WHERE id_empleado = '".$dataCohorte["id_empleado"]."' AND id_cohorte = '".$dataCohorte["id"]."' ");  
						while($dataEvidencia = mysqli_fetch_array($queryEvidencias)){
							$lista_evidencias .= '<div>
							<a href="'.$url.'/recursos/'.$dataEvidencia["archivo"].'" target="_blank"> 
								<button type="button" class="btn btn-warning btn-sm" title="Participantes">
										Certificado
									</button>
							</a> 
							</div>';
						}
						
						
						
						
						
						
						
						
						
						
						
						
						
						

						$txt_estado_estudiante = '';
						foreach($Array_Estado as $nivel){
							if($nivel[0] == $dataCohortes["estado"]){ $txt_estado_estudiante = $nivel[1]; }
						}

						$txt_motivo = "";
						foreach($Array_Motivo_Formacion as $motivo){
							if($motivo[0] == $dataProceso["motivo"]){ $txt_motivo = $motivo[1]; }
						}

						$txt_interno = "";
						foreach($Array_Interno_Externo as $nivel){
							if($dataProceso["interno_externo"] == $nivel[0] ){
								$txt_interno = $nivel[1];
							}
						}

						$txt_estado_curso = '';
						foreach($Array_Estado as $nivel){
							if($nivel[0] == $dataProceso["estado"]){ $txt_estado_curso = $nivel[1]; }
						}

						echo '
							<tr>
								<td>'.$count.'</td>
								<td>'.$dataCol["nombre"].' '.$dataCol["apellidos"].'</td>
								<td>'.$txt_estado_participante.'</td>
								<td>'.$dataMarca["nombre"].'</td>
								<td>'.$lista_responsables.'</td>
								<td>'.$dataProceso["nombre"].'</td>
								<td>'.$txt_interno.'</td>
								<td>'.$txt_motivo.'</td>
								
								
								<td>'.$dataTipo["nombre"].'</td>
								
								<td>'.$dataProveedor["nombre"].'</td>
								<td>'.$dataCohortes["fecha_evaluacion"].'</td>
								<td>'.$dataProceso["anio"].'</td>
								<td>'.$dataProceso["carga_horaria"].' Hrs.</td>
								<td>'.$dataProceso["valor"].'</td>

								<td>'.$lista_certificados.'</td>


								<td>'.$dataProceso["descripcion"].'</td> 
								<td>'.$lista_evidencias.'</td>


							</tr>

						';
						$count++;
					}
					
				}
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




