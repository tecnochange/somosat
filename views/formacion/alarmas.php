<script>  
$(document).ready(function(){
    $("#bt_formacion_alarmas").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
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
                <th scope="col">Formación</th>
				<th scope="col">Año</th>
				<th scope="col">Alarma</th>
				<th scope="col">Dias para vencer</th>
				<th scope="col">Motivo</th>
                <th scope="col">Participantes</th>
				<th scope="col">Responsables</th>
                <th scope="col">Estado</th>
                <th scope="col" width="130" align="center">
                    <?php if($user_log["role"] == 1){ ?>
                    <a href="<?php echo $url; ?>?pg=formacion/proceso/detalle">
                        <button type="button" class="btn btn-warning btn-sm" >
                            <i class="fas fa-plus"></i> Crear
                        </button>
                    </a>
                    <?php } ?>
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
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
								<td>'.$data["anio"].'</td>
								<td>'.$data["fecha_alarma"].'</td>
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
