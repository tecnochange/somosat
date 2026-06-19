<script>  
$(document).ready(function(){
    $("#bt_formacion_reportes").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
$filtros = " ";
$filtros_estudiante = " ";
if($_POST["fill_inicia"]){
	$filtros_estudiante .= " AND fecha_evaluacion >= '".$_POST["fill_inicia"]."' ";
}
if($_POST["fill_termina"]){
	$filtros_estudiante .= " AND fecha_evaluacion <= '".$_POST["fill_termina"]."' ";
}
?>

<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<form action="" method="post">
		<table width="100%">
			<tr>
				<td><h2>Reportes</h2></td>
				
				<td width="200">
                    <input type="date" class="form-control" name="fill_inicia" value="<?php echo $_POST["fill_inicia"]; ?>">
				</td>
				
				<td width="200">
                    <input type="date" class="form-control" name="fill_termina" value="<?php echo $_POST["fill_termina"]; ?>">
				</td>
				
				<td width="200">
					<button type="submit" class="btn btn-warning" title="Participantes">
                    	Filtrar
					</button>
				</td>

				<td align="right" width="200">
					<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
				</td>
                
                <td align="right" width="50">
		
                    <button type="button" class="btn btn-info btn-sm" onclick="exportarReporte()">
                        <i class="fas fa-download"></i>
                    </button>
				</td>
			</tr>
		</table>
		</form>
	</div>

    <form action="app/models/exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
    </form>


	<div class="table-responsive">
    <table class="table" id="TablaExcel">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
				<th scope="col">Nombre Participante</th>
				<th scope="col">Estado del participante</th>
                <th scope="col">Estado empleado</th>
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
				$queryCohortes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id > 0 ".$filtros_estudiante." "); 
				while($dataCohortes = mysqli_fetch_array($queryCohortes)){ 
					


					$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos 
					WHERE id = '".$dataCohortes["id_proceso"]."'  ");  
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

						$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataCol["id"]."' " );  
						$dataAdd = mysqli_fetch_array($queryAdd);
						$participante="";
						if($dataAdd["preferencia"] !== ""){
							$participante = strtoupper($dataAdd["preferencia"]." ".$dataCol["apellidos"]." ".$dataCol["apellidos_2"]);
						}else{
							$participante = strtoupper($dataCol["nombre"].' '.$dataCol["nombre_2"]." ".$dataCol["apellidos"]." ".$dataCol["apellidos_2"]);
						}

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

                        $estado_colabordor = "Activo";
                        if($dataCol["estado"] != 1){
                            $estado_colabordor = "inactivo";
                        }

						echo '
							<tr>
								<td>'.$count.'</td>
								<td>'.$participante.'</td>
								<td>'.$txt_estado_participante.'</td>
                                <td>'.$estado_colabordor.'</td>
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
	</div>
	
</div>
<script>  
$(document).ready(function(){
	$("#buscador").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tabla_lista tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});	
});

function exportarReporte() {
		$("#datos_a_enviar").val($("<div>").append($("#TablaExcel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
	}
</script>
