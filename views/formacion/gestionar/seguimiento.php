<script>  
$(document).ready(function(){
    $("#bt_formacion_solicitudes").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
	$hoy = date("Y-m-d H:i:s ");
	$id = $_GET["id"];

	if($_POST["id_proceso"] != ""){
		
		foreach ($_POST["empleados"] as &$valor) {
			$queryValTmp = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$valor."' AND id_proceso = '".$data["id_proceso"]."' ");
			
			if($queryValTmp->num_rows == 0 ){
				mysqli_query($connect_formacion,"INSERT INTO Cohortes (id_proceso, id_empleado , id_solicitud, estado, created_at) 
				VALUES 
				( '".$_POST["id_proceso"]."', '".$id."', '".$valor."', '1', '".$hoy."' ) ");
			}
		}
		
		$respuesta = '
		<div class="alert alert-success" role="alert">
		  La información ha sido guardada.
		</div>
		';
		
	}

	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_formacion,"SELECT * FROM Solicitudes WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	$colaboradores = explode(",", $data["colaboradores"]);

	$queryProc = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$data["id_proceso"]."' "); 
	$dataProc = mysqli_fetch_array($queryProc);

	$querySolicitado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");  
                	$dataSolicitado = mysqli_fetch_array($querySolicitado);

	$txt_motivo = "";
	foreach($Array_Motivo_Formacion as $motivo){
		if($motivo[0] == $dataProc["motivo"]){ $txt_motivo = $motivo[1]; }
	}

	$txt_costo = "";
	foreach($Array_Moneda_Formacion as $nivel){
		if($dataProc["costo"] == $nivel[0] ){
			$txt_costo = $nivel[1];
		}                      
	}

	$queryMarca = mysqli_query($connect_formacion,"SELECT * FROM Marcas 
	WHERE id = '".$dataProc["id_marca"]."' ");
	$dataMarca = mysqli_fetch_array($queryMarca);
							
?>

<?php echo $respuesta; ?>
<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/solicitudes">Solicitudes Referentes</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Resumen del Plan de Formación</a></li>
		</ol>
	</nav>
	
	
	<div class="card">
		<div class="card-body">
			<h2>Seguimiento del Plan de formación: <?php echo $dataProc["nombre"]; ?></h2>
			<div>
				Solicitado por : <b><?php echo $dataSolicitado["nombre"].' '.$dataSolicitado["apellidos"]; ?></b><br>
				Fecha de ejecución: <b><?php echo $data["fecha_inicia"]; ?></b><br>
				Presupuesto: <b><?php echo $data["presupuesto"]; ?></b><br>
				Marca: <b><?php echo $dataMarca["nombre"]; ?></b><br>
				Motivo: <b><?php echo $txt_motivo; ?></b><br> 
				Costo en: <b><?php echo $txt_costo; ?></b><br> 
				El curso termina el: <b><?php echo $dataProc["fecha_termina"]; ?></b><br> 
			</div>

			<div>
				Observaciones: <b><?php echo $data["observaciones"]; ?></b>
			</div>




			<div class="col-md-12" style="margin-top: 15px">
					<table class="table">
							<thead>
								<tr>
								  <th>#</th>
								  <th>Colaborador</th>
								  <th>Cargo</th>
								  <th>Certificados</th>
								  <th>Estado</th>
								  <th style="text-align: center;" width="90">Acciones</th>
								</tr>
							</thead>
							<tbody id="myTable">
							<?php
							$count = 0;
							$aprobados = 0;

							foreach($colaboradores as $colaborador){

								$queryCohortes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$colaborador."' AND id_proceso = '".$data["id_proceso"]."' ");  
								$dataCohortes = mysqli_fetch_array($queryCohortes);

								if($queryCohortes->num_rows > 0){
									
									$select = '<select class="form-control" onchange="CambiarEstado(this, '.$dataCohortes["id"].' )">
										<option value="">Selecciona..</option>
									';
									foreach($Array_Estado_Procesos as $nivel){
										if($dataCohortes["estado"] == $nivel[0] ){
											$select .= '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
										}
										else{
											$select .= '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
										}
									}
									$select .= '</select>';	

									$sentencia = "
									SELECT 
									Empleados.id AS id, 
									Empleados.estado AS estado, 
									Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2, 
									Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2, 
									Empleados.correo AS correo, 
									Empleados.role AS role, 
									Empleados.documento AS documento, 
									Empleados.foto_formal AS foto_formal, 
									Cargos.nombre AS cargo_nombre, 
									Areas.nombre AS area_nombre, 
									Gerencias.nombre AS gerencia_nombre,
									ad.preferencia
									FROM Empleados 
									LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
									LEFT JOIN Areas ON Areas.id = Empleados.id_area 
									LEFT JOIN Gerencias ON Gerencias.id = Empleados.id_departamento 
									LEFT JOIN Jefes ON Jefes.id_empleado = Empleados.id 
									RIGHT JOIN Empleados_Adicionales  as ad ON ad.id_empleado = Empleados.id
									WHERE Empleados.id = '".$colaborador."' 
									";

									$queryEmp = mysqli_query($connect_valentina, $sentencia);  
									$dataEmp = mysqli_fetch_array($queryEmp);


									if($dataEmp["preferencia"] !== ""){
										$dataEmp["nombre_completo"] = strtoupper($dataEmp["preferencia"]." ".$dataEmp["apellidos"]." ".$dataEmp["apellidos_2"]);
									}else{
										$dataEmp["nombre_completo"] = strtoupper($dataEmp["dataEmp"].' '.$dataEmp["nombre_2"]." ".$dataEmp["apellidos"]." ".$dataEmp["apellidos_2"]);
									}

									if(!$data["foto_formal"]){ $data["foto_formal"] = "1.png"; }
									
									if($user_log["role"] == 1){
										$bt_eliminar = '
											<button type="button" class="btn btn-danger btn-sm" title="Eliminar Colaborador" onclick="Eliminar('.$dataCohortes["id"].')">
													<i class="bx bx-trash"></i>
											</button>
										';
									}

									$bt_editar = '
										 <a href="'.$url.'?pg=formacion/gestionar/certificado_detalle&id='.$dataCohortes["id"].'">
											<button type="button" class="btn btn-success btn-sm" title="Certificar Colaborador">
												<i class="bx bx-file"></i>
											</button>
										</a>
									';
									
									$lista_certificados = "";
									$queryCertificados = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_empleado = '".$colaborador."' AND id_cohorte = '".$dataCohortes["id"]."' ");  
									while($dataCertificados = mysqli_fetch_array($queryCertificados)){
										$lista_certificados .= '<div><a href="'.$url.'/recursos/'.$dataCertificados["archivo"].'"  target="_blank">'.$dataCertificados["archivo"].'</a></div>';
									}

				

									echo '
										<tr>
											<td class="align-middle">'.($count+1).'</td>
											<td class="align-middle">'.$dataEmp["nombre_completo"].'</td>
											<td class="align-middle">'.$dataEmp["cargo_nombre"].'</td>
											<td class="align-middle">'.$lista_certificados.'</td>
											<td>'.$select.'</td>
											<td class="align-middle">
												'.$bt_editar.' '.$bt_eliminar.'
											</td>
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
				
			$("#botones_modal").html('<button type="button" class="btn btn-danger" onclick="activar = true; Eliminar('+val+')">Eliminar</button>');
			$("#botones_modal").append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
		}
		
		else{	
			jQuery.ajax({
				url: urls+"formacion/eliminar_estudiante_cohorte.php",
				type:'post',
				data: {id:val, url:'?pg=formacion/gestionar/seguimiento&id=<?php echo $id; ?>'},
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
	
	function CambiarEstado( elem, id_cohorte ){
		estado = $(elem).val();
		jQuery.ajax({
			url: urls+"formacion/cambiar_estado.php",
			type:'post',
			data: {id_cohorte: id_cohorte, estado: estado,  url:"?pg=administrar/estructura"},
			}).done(function (resp){
				//$("#xscript").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
		);
	}

	
</script>
