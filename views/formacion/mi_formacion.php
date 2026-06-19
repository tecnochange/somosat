<script>  
$(document).ready(function(){
    $("#bt_formacion_mi_formacion").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
	$hoy = date("Y-m-d");

	if($_POST["id_proceso_cohorte"] != ""){
		foreach ($_POST["empleados"] as &$valor) {
			mysqli_query($connect_formacion,"INSERT INTO Cohortes (id_proceso, id_empleado , estado, created_at) 
			VALUES 
			( '".$_SESSION["id_proceso_edit"]."', '".$valor."', '1', '".$hoy."' ) ");
		}
		echo '<script> location.href = "?pg=formacion/cohortes"; </script>';
	}


	if($_POST["id_proceso"]){
		$_SESSION["id_proceso_edit"] = $_POST["id_proceso"];
	}


	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_formacion,"SELECT * FROM Procesos 
	WHERE id = '".$_SESSION["id_proceso_edit"]."' ");
	$data = mysqli_fetch_array($query);
?>


<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td>
					<h2>Mi Formación: <?php echo $user_log["nombre"]; ?></h2>
				</td>
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
				<th scope="col">Formacion</th>
                <th scope="col">Participante</th>
				<th scope="col">Cargo</th>
				<th scope="col">% Beca</th>
				<th scope="col">Fecha de planificación/ Q</th>
				<th scope="col">Fecha Termina</th>
				<th scope="col">Motivo</th>
				<th scope="col">Certificado</th>
				<th scope="col">Exámen</th>
				<th scope="col">Fecha de Ejecución</th>
				<th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                    Acciones
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;
                $query = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$user_log["id"]."' ");  
                while($data = mysqli_fetch_array($query)){ 
                    
                    $queryParticipante = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");  
					$dataParticipante = mysqli_fetch_array($queryParticipante);

					$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataParticipante["id"]."' " );  
					$dataAdd = mysqli_fetch_array($queryAdd);
					$participante="";

					if($dataAdd["preferencia"] !== ""){
						$participante = strtoupper($dataAdd["preferencia"]." ".$dataParticipante["apellidos"]." ".$dataParticipante["apellidos_2"]);
					}else{
						$participante = strtoupper($dataParticipante["nombre"].' '.$dataParticipante["nombre_2"]." ".$dataParticipante["apellidos"]." ".$dataParticipante["apellidos_2"]);
					}

					
					$queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataParticipante["id_cargo"]."' "); 
					$dataCargo = mysqli_fetch_array($queryCargo);
					
					$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$data["id_proceso"]."' ");
					$dataProceso = mysqli_fetch_array($queryProceso);
					
					$lista_certificados = "";
					$queryCertificado = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_empleado = '".$data["id_empleado"]."' AND id_proceso = '".$dataProceso["id"]."' "); 
					while($dataCertificado = mysqli_fetch_array($queryCertificado)){
						$lista_certificados .= '<div>
							<a href="'.$url.'/recursos/'.$dataCertificado["archivo"].'" 	target="_blank">'.$dataCertificado["archivo"].'</a>
						</div>';
					}
					
					$txt_estado = "";
					foreach($Array_Estado_Formacion as $estado){
						if($estado[0] == $data["estado"]){ $txt_estado = $estado[1]; }
					}
					
					$txt_motivo = "";
					foreach($Array_Motivo_Formacion as $motivo){
						if($motivo[0] == $dataProceso["motivo"]){ $txt_motivo = $motivo[1]; }
					}
   
                    
                    $bt_editar = '
                    <a href="'.$url.'?pg=formacion/estudiante/resumen&id='.$data["id"].'">
                    	<button type="button" class="btn btn-success btn-sm" title="Gestionar ">
                    		<i class="bx bx-file"></i>
                    	</button>
                    </a>
                    ';
                    
                            
                    echo '
                        <tr>
                            <td>'.$count.'</td>
							<td>'.$dataProceso["nombre"].'</td>
                            <td>'.$participante.'</td>
                            <td>'.$dataCargo["nombre"].'</td>
							<td>'.$dataProceso["porcentaje_beca"].'</td>
							<td>'.$dataProceso["fecha_inicia"].'</td>
							<td>'.$dataProceso["fecha_termina"].'</td>
							<td>'.$txt_motivo.'</td>
							<td>'.$lista_certificados.'</td>
							<td>'.$dataProceso["examen"].'</td>
							<td>'.$dataProceso["created_at"].'</td>
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
	
	function Seleccionar_Todo(val2){
		if( $(val2).prop('checked') == true ){
			$('.chequeado').prop('checked', true);
		}
		else{
			$('.chequeado').prop('checked', false);
		}
	}
	
	function Filtrar(){
		$("#formulario_filtrar").submit();
	}
	
	var urls = "<?php echo $url; ?>/api/";
	var activar = false;
	//GUARDAR ACADEMICO
	function Eliminar(val){	
	
		if(activar == false){
			$("#modal_borrar").modal("show");
	
			$("#cont_modal_").html('Esta a punto de eliminar un colaborador de esta cohorte ¿Esta seguro?');
				
			$("#botones_modal").html('<button type="button" class="btn btn-danger" onclick="activar = true; Eliminar_Encuestado('+val+')">Eliminar</button>');
			$("#botones_modal").append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
		}
		
		else{	
			jQuery.ajax({
				url: urls+"formacion/eliminar_estudiante_cohorte.php",
				type:'post',
				data: {id:val, url:'?pg=formacion/cohortes'},
				}).done(function (resp){
					//$("this").hide();	
					$("#xscript").html(resp);
				})
				.fail(function() {
				})
				.always(function(resp){
				}
			);	
		}
	}
</script>
