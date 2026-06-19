<script>  
$(document).ready(function(){
    $("#bt_formacion_solicitudes").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Solicitudes Referentes</h2></td>
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
				<th scope="col">Solitado por:</th>
                <th scope="col">Formación</th>
				<th scope="col">Año</th>
				<th scope="col">Motivo</th>
                <th scope="col">Participantes</th>
                <th scope="col">Estado</th>
                <th scope="col" width="130" style="text-align: center">
                    <a href="<?php echo $url; ?>?pg=formacion/gestionar/detalle">
                        <button type="button" class="btn btn-warning btn-sm" >
                            <i class="fas fa-plus"></i> Crear
                        </button>
                    </a>
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;
                $query = mysqli_query($connect_formacion,"SELECT * FROM Solicitudes ");  
                while($data = mysqli_fetch_array($query)){ 
					
					//VALIDAMOS LOS INVITADOS
					$count_inv = 0;
					$count_aprobados = 0;
					if($data["colaboradores"]){
						$no_participantes = explode(",", $data["colaboradores"]);
						foreach($no_participantes as $participante){
							$queryVal = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$participante."' AND id_proceso = '".$data["id_proceso"]."' "); 
							if( $queryVal->num_rows > 0 ){
								 $count_aprobados++;
							}
							$count_inv++;

						}
					}
					
					$color_bg = "";
					if( $count_inv == $count_aprobados ){
						$color_bg = 'bg-primary';	
					}
					else{
						$color_bg = 'bg-danger';
					}
					
					$querySolicitado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");  
                	$dataSolicitado = mysqli_fetch_array($querySolicitado);

                    $queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataSolicitado["id"]."' " );  
                    $dataAdd = mysqli_fetch_array($queryAdd);

                    $solicitado = "";
                    if($dataAdd["preferencia"] !== ""){
                        $solicitado = strtoupper($dataAdd["preferencia"]." ".$dataSolicitado["apellidos"]." ".$dataSolicitado["apellidos_2"]);
                    }else{
                        $solicitado = strtoupper($dataSolicitado["nombre"].' '.$dataSolicitado["nombre_2"]." ".$dataSolicitado["apellidos"]." ".$dataSolicitado["apellidos_2"]);
                    }
					
					$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$data["id_proceso"]."' ");  
                	$dataProceso = mysqli_fetch_array($queryProceso);
					
					
					if( $data["id_proceso"] == -1 ){ $dataProceso["nombre"] = 'Otro'; $dataProceso["anio"] = 'N/A'; }
						
   
                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $dataProceso["estado"]){ $txt_estado = $nivel[1]; }
                    }
                        
                    $bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=formacion/gestionar/resumen&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Aprobar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                            </a>
                        ';
						$bt_seguimiento = '
                            <a href="'.$url.'?pg=formacion/gestionar/seguimiento&id='.$data["id"].'">
                                <button type="button" class="btn btn-success btn-sm" title="Seguimiento">
                                    <i class="bx bx-task"></i>
                                </button>
                            </a>
                        ';
                    }
					
					$txt_motivo = "";
					foreach($Array_Motivo_Formacion as $motivo){
						if($motivo[0] == $dataProceso["motivo"]){ $txt_motivo = $motivo[1]; }
					}

                    if($dataProceso["nombre"] == 'Otro'){
                        $dataProceso["nombre"] = 'Otro: '.$data["otros"];
                    }

                    echo '
                        <tr>
                            <td>'.$count.'</td>	
							<td>'.$solicitado.'</td>
                            <td>'.$dataProceso["nombre"].'</td>
							<td>'.$dataProceso["anio"].'</td>
							
							<td>'.$txt_motivo.'</td>
                            <td><span class="badge '.$color_bg.'">'.$count_inv.' / '.$count_aprobados.'</span></td>
                            <td>'.$txt_estado.'</td>
                            <td  align="center">
                                '.$bt_editar.' '.$bt_seguimiento.'
                            </td>
                        </tr>
                        
                    ';
                    $count++;
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
