<script>  
$(document).ready(function(){
    $("#bt_formacion_planificar").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Planificar Formación</h2></td>
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
				<th scope="col">Fecha de planificación/ Q</th>
				<th scope="col">Fecha Termina</th>
				<th scope="col">Motivo</th>
                <th scope="col">Participantes</th>
                <th scope="col">Estado</th>
                <th scope="col" width="130" align="center">
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
                $query = mysqli_query($connect_formacion,"SELECT * FROM Solicitudes WHERE id_empleado = '".$user_log["id"]."' ");  
                while($data = mysqli_fetch_array($query)){ 
					
					$no_participantes = explode(",", $data["colaboradores"]);
					
					$querySolicitado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");  
                	$dataSolicitado = mysqli_fetch_array($querySolicitado);
					
					$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$data["id_proceso"]."' ");  
                	$dataProceso = mysqli_fetch_array($queryProceso);

                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $dataProceso["estado"]){ $txt_estado = $nivel[1]; }
                    }
                        
                   
                    $bt_editar = '
                            <a href="'.$url.'?pg=formacion/gestionar/resumen_jefe&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Aprobar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                            </a>
                    ';
                    
					
					$txt_motivo = "";
					foreach($Array_Motivo_Formacion as $motivo){
						if($motivo[0] == $data["motivo"]){ $txt_motivo = $motivo[1]; }
					}
                            
                    echo '
                        <tr>
                            <td>'.$count.'</td>	
							<td>'.$dataSolicitado["nombre"].' '.$dataSolicitado["apellidos"].'</td>
                            <td>'.$dataProceso["nombre"].'</td>
							<td>'.$dataProceso["fecha_inicia"].'</td>
							<td>'.$dataProceso["fecha_termina"].'</td>
							<td>'.$txt_motivo.'</td>
                            <td><span class="badge bg-primary">'.count($no_participantes).'</span></td>
                            <td>'.$txt_estado.'</td>
                            <td  align="center">
                                '.$bt_editar.' 
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
