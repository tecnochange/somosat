<script>  
$(document).ready(function(){
    $("#bt_formacion_alarmas").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
    $ahora = date("Y-m-d");

	//FUNCION PARA OBTENER LOS AÑOS
	function Dias($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
		
		$dias  = floor($dateDifference / ( 60 * 60 * 24));

		return $dias ;
	}
?>

<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Procesos de formación a punto de vencer</h2></td>
				<td align="right" width="200">
					<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />

				</td>
			</tr>
		</table>
	</div>


	<div class="table-responsive">
    <table class="table">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
				<th scope="col">Estudiante</th>
                <th scope="col">Formación</th>
				<th scope="col">Año del Proceso</th>
                <th scope="col">Fecha de Evaluación</th>
                <th scope="col">Fecha de Vencimiento</th>
				<th scope="col">Validez Meses</th>
				<th scope="col">Días para Vencer</th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
			<?php
				$count = 1;

				$queryEstudiantes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes GROUP BY id_empleado "); 
				while($dataEstudiantes = mysqli_fetch_array($queryEstudiantes)){ 

                    $sentencia = " 
                    SELECT
                    Cohortes.*, Procesos.nombre AS nombre_proceso, Procesos.anio AS anio_proceso, Procesos.validez_meses AS validez_meses
                    FROM
                    Cohortes 
                    LEFT JOIN Procesos ON Procesos.id = Cohortes.id_proceso
                    WHERE
                    Cohortes.id_empleado = '".$dataEstudiantes["id_empleado"]."' AND Procesos.id > 0 AND Procesos.validez_meses > 0 
                    GROUP BY Cohortes.id 
                    ";
                    $queryCohortes = mysqli_query( $connect_formacion, $sentencia ); 
				    while($dataCohortes = mysqli_fetch_array($queryCohortes)){ 

                        //DATOS DEL EMPLEADO
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

                        $fecha_vence = date("Y-m-d",strtotime($dataCohortes["fecha_evaluacion"]."+ ".$dataCohortes["validez_meses"]." month")); 

                        $vence_dias = Dias($fecha_vence);
                        $bg_color = '';
                        $mensaje_dias = "Por Vencer. ".$vence_dias;


                        if($vence_dias <= 20){
                            $bg_color = '#ffe6c2';
                            $mensaje_dias = "Por Vencer. ".$vence_dias;
                        }

                        if($fecha_vence <= $ahora){
                            $vence_dias = "-".$vence_dias;
                            $bg_color = '#ffb7b2';
                        }

                        


                        echo '
							<tr bgcolor="'.$bg_color.'">
								<td>'.$count.'</td>
								<td>'.$participante.'</td>
								<td>'.$dataCohortes["nombre_proceso"].'</td>
								<td>'.$dataCohortes["anio_proceso"].'</td>
                                <td>'.$dataCohortes["fecha_evaluacion"].'</td>
                                <td>'.$fecha_vence.'</td>
								<td>'.$dataCohortes["validez_meses"].'</td>
								<td>'.$mensaje_dias.' </td>
							</tr>

						';
						$count++;



                    }










/*
					
					$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos 
					WHERE id = '".$dataCohortes["id_proceso"]."' ".$filtros." ");  
                	$dataProceso = mysqli_fetch_array($queryProceso);
					
					if($queryProceso->num_rows > 0){
					
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

						$fecha_certificado = "";
						$lista_certificados = "";
						$queryCertificado = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_proceso = '".$dataProceso["id"]."' AND id_empleado = '".$dataCohortes["id_empleado"]."' "); 
						while($dataCertificado = mysqli_fetch_array($queryCertificado)){ 
							
							$fecha_certificado = $dataCertificado["fecha_evaluacion"];
							
							$lista_certificados .= '<div>
							<a href="'.$url.'/recursos/'.$dataCertificado["archivo"].'" target="_blank"> 
								<button type="button" class="btn btn-warning btn-sm" title="Participantes">
										Certificado
									</button>
							</a> 
							</div>';
						}
						
						$fecha_alarma_curso = "n/a";
						if($dataProceso["fecha_alarma"] ){
							$fecha_alarma_curso = $dataProceso["fecha_alarma"];
						}
						
						$validez_meses = "n/a";
						if($dataProceso["validez_meses"] ){
							$validez_meses = $dataProceso["validez_meses"];
						}
						
						
					
						echo '
							<tr>
								<td>'.$count.'</td>
								<td>'.$participante.'</td>
								<td>'.$dataProceso["nombre"].'</td>
								<td>'.$dataProceso["anio"].'</td>
								<td>'.$fecha_alarma_curso.'</td>
								<td>'.$validez_meses.'</td>
								
								<td>'.$fecha_certificado.' </td>
							</tr>

						';
						$count++;
					}
                        */
					
				}
            ?>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
            <?php
                $count = 1;
				$lista_filas = "";
                $query = mysqli_query($connect_formacion,"SELECT * FROM Procesos ORDER BY nombre ASC ");  
                while($data = mysqli_fetch_array($query)){ 
					
					$dia_para_vencer =  Dias($data["fecha_alarma"]);
					
					$permitir = true;
					if($dia_para_vencer <= 30){
						
					
                    
						$queryParticipantes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_proceso = '".$data["id"]."' ");  

						$lista_responsables = "";
						$queryResponsables = mysqli_query($connect_formacion,"SELECT * FROM Responsables WHERE id_proceso = '".$data["id"]."' "); 
						while($dataResponsable = mysqli_fetch_array($queryResponsables)){ 

							$queryRes = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataResponsable["id_empleado"]."' ");  
							$dataRes = mysqli_fetch_array($queryRes);

							$lista_responsables .= '<div>'.$dataRes["nombre"].' '.$dataRes["apellidos"].'</div>';
						}

						$txt_estado = '';
						foreach($Array_Estado as $nivel){
							if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
						}

						$bt_editar = '';
						$bt_responsables = '';
						if($user_log["role"] == 1){
							$bt_editar = '
								<a href="'.$url.'?pg=formacion/proceso/detalle&id='.$data["id"].'">
									<button type="button" class="btn btn-primary btn-sm" title="Editar">
										<i class="bx bx-message-square-edit"></i>
									</button>
								</a>
							';

							$bt_responsables = '
								<a href="'.$url.'?pg=formacion/proceso/responsables&id='.$data["id"].'">
									<button type="button" class="btn btn-success btn-sm" title="Responsables">
										<i class="bx bx-user-check"></i>
									</button>
								</a>
							';

							$bt_participantes = '
								<a href="'.$url.'?pg=formacion/proceso/participantes&id='.$data["id"].'">
									<button type="button" class="btn btn-warning btn-sm" title="Participantes">
										<i class="bx bx-user"></i>
									</button>
								</a>
							';
						}

						$txt_motivo = "";
						foreach($Array_Motivo_Formacion as $motivo){
							if($motivo[0] == $data["motivo"]){ $txt_motivo = $motivo[1]; }
						}

						$lista_filas .= '
							<tr>
								<td>'.$count.'</td>
								<td>'.$data["nombre"].'</td>
								
								<td style="background-color: #ffcbc7;">'.$dia_para_vencer.'</td>
								
								<td>'.$txt_motivo.'</td>
								<td><span class="badge bg-primary">'.$queryParticipantes->num_rows.'</span></td>
								<td>'.$lista_responsables.'</td>

								<td>'.$txt_estado.'</td>
								<td  align="center">
									'.$bt_editar.' '.$bt_responsables.' '.$bt_participantes.'
								</td>
							</tr>

						';
						$count++;
					}
                }
			
				if($lista_filas == ""){
					echo '
					<tr>
						<td colspan="11">No hay capacitaciones próximas a vencer en los siguientes 30 días</td>
					</tr>
					';
				}
				else{
					echo $lista_filas;
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
</script>
