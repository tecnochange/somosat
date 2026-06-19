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
				mysqli_query($connect_formacion,"INSERT INTO Cohortes (id_proceso, id_solicitud, id_empleado , estado, created_at) 
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

	if($_POST["eliminar_solicitud"]){
		mysqli_query($connect_formacion, " DELETE FROM Solicitudes WHERE id = '".$id."' ");
		echo '<script> window.location = "?pg=formacion/solicitudes";</script>';//para evitar reinsersion
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


<div class="container">

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/solicitudes">Solicitudes Referentes</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Resumen del Plan de Formación</a></li>
		</ol>
	</nav>
	
	<?php echo $respuesta; ?>

	<div class="card">
		<div class="card-body">
			<h2>Resumen del Plan de formación: <?php echo $dataProc["nombre"]; ?></h2>
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

			<div style="padding: 10px 0px; color: #f56262;">
				A continuación encontrará la lista de colaboradores relacionados en esta solicitud. Para aprobar debe dar click en el checkbox al frente de cada registro. Puede realizar este proceso tantas veces como sea necesario.
			</div>

			<form action="" method="post">
				<input type="hidden" name="id_proceso" value="<?php echo $data["id_proceso"]; ?>">
				<div class="col-md-12" style="margin-top: 15px">
					<table class="table">
							<thead>
								<tr>
								  <th>#</th>
								  <th>Colaborador</th>
								  <th>Cargo</th>
								  <th>Correo</th>
								  <th>Estado</th>
								  <th style="text-align: center;" width="30"><input type="checkbox" onclick="Seleccionar_Todo(this)"></th>
								</tr>
							</thead>
							<tbody id="myTable">
							<?php
							$count = 0;
							$aprobados = 0;

							foreach($colaboradores as $colaborador){

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

								if(!$data["foto_formal"]){ $data["foto_formal"] = "1.png"; }

								$imput_checked = '
									<input type="checkbox" class="chequeado" name="empleados[]" value="'.$colaborador.'" >
								';
								$estado = "Sin Aprobar";
								$queryVal = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$colaborador."' AND id_proceso = '".$data["id_proceso"]."' ");
								if( $queryVal->num_rows > 0 ){
									$dataVal = mysqli_fetch_array($queryVal);
									foreach($Array_Estado_Procesos as $nivel){
										if($dataVal["estado"] == $nivel[0] ){
											$estado  = $nivel[1];
										}
									}

									$imput_checked = '';
									$aprobados++;
								}

								if($dataEmp["preferencia"] !== ""){
									$dataEmp["nombre_completo"] = strtoupper($dataEmp["preferencia"]." ".$dataEmp["apellidos"]." ".$dataEmp["apellidos_2"]);
								}else{
									$dataEmp["nombre_completo"] = strtoupper($dataEmp["nombre"].' '.$dataEmp["nombre_2"]." ".$dataEmp["apellidos"]." ".$dataEmp["apellidos_2"]);
								}

								echo '
									<tr>
										<td class="align-middle">'.($count+1).'</td>
										<td class="align-middle">'.$dataEmp["nombre_completo"].'</td>
										<td class="align-middle">'.$dataEmp["cargo_nombre"].'</td>
										<td class="align-middle">'.$dataEmp["correo"].'</td>
										<td>'.$estado.'</td>
										<td class="align-middle">
											'.$imput_checked.'
										</td>
								</tr>
								';
								$count++;


							}
						?>
						</tbody>
					</table>
				</div>

				<?php if( $aprobados < $count ){ ?>
				<div class="col-md-12" style="margin-top:15px" >
					<input type="submit" class="btn btn-primary bnt-block" value="Aprobar Participante" style="width: 100%"  />
				</div>
				<?php } ?>


			</form>
		</div>	
		
		
		<?php if($_SESSION['role_plataforma']  == 1){ ?>
		<div align="right">
		<form action="" method="post" id="form_eliminar">
			<input type="hidden" name="eliminar_solicitud" value="true">
			<button type="button" class="btn btn-sm" onClick="Elimimar_Solicitud()" >
				<i class="fas fa-check"></i> Eliminar
			</button>
		</form>
		</div>
		<?php } ?>
		
	</div>
</div>


<script>
	var urls = "<?php echo $url; ?>/api/";
	var activar_del_pro = false;
	function Elimimar_Solicitud(){
		
		if(activar_del_pro == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar esta solicitud, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar_del_pro = true; Elimimar_Solicitud()"> Confirmar </button>');  
        }
        else{
			$("#form_eliminar").submit();
		}
	}
	
	
	
	
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
