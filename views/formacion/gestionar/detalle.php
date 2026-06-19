<script>  
$(document).ready(function(){
    $("#bt_formacion_planificar").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
	$hoy = date("Y-m-d H:i:s ");
	$id = $_GET["id"];

	if($_POST["id_proceso"] != ""){
		
		if($_POST["id_registro"] ){
			
		}
		else{
			$sentencia = "
			INSERT INTO Solicitudes ( id_empleado , id_proceso , otros,  colaboradores ,  observaciones , presupuesto, fecha_inicia,   estado ,  created_at ) 
			VALUES 
			( '".$_SESSION["id_user"]."', '".$_POST["id_proceso"]."', '".$_POST["otros"]."', '".implode(",", $_POST["empleados"])."' 
			, '".$_POST["observaciones"]."', '".$_POST["presupuesto"]."', '".$_POST["fecha_inicia"]."', 1, '".$hoy."' )
			";
			
			mysqli_query($connect_formacion, $sentencia);

			echo '<script> location.href = "?pg=formacion/planificar"; </script>';
		}
		
		
	}


	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_formacion,"SELECT * FROM Solicitudes 
	WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
?>

<div class="card">

	<div class="card-body">
		<h2>Gestionar plan de formación</h2>
		
		<form action="" method="post">
			<input type="hidden" name="id_registro" value="<?php echo $id; ?>">
		<div class="row">
			<div class="col-md-6">
				<label>Proceso de formación *</label>
				<select class="form-control" name="id_proceso" required onChange="ValidarOtros(this.value)">
					<option value="">Seleccione Proceso..</option>
					<?php
                        $queryProc = mysqli_query($connect_formacion,"SELECT * FROM Procesos ORDER BY nombre ASC ");  
                        while($dataProc = mysqli_fetch_array($queryProc)){
                            if($data["id_proceso"] == $dataProc["id"] ){
                                echo '<option value="'.$dataProc["id"].'" selected>'.$dataProc["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataProc["id"].'">'.$dataProc["nombre"].' </option>';
                            }
                        }
					?>
					<option value="-1">Otros</option>
				</select>
			</div>
			
			<div class="col-md-6" style="display: none" id="otros_cont">
				<label>Por favor indique la opción otro</label>
				<input type="text" class="form-control" name="otros" value="<?php echo $data["otros"]; ?>" >
			</div>
			
			<script>
			function ValidarOtros(id){
				if(id == -1){
				   $("#otros_cont").show();
				}
				else{
				   $("#otros_cont").hide();
				}
			}
			</script>
			
			<div class="col-md-6">
				<label>Fecha de ejecución *</label>
				<input type="date" class="form-control" name="fecha_inicia" value="<?php echo $data["fecha_inicia"]; ?>" required>
			</div>
			
			<div class="col-md-12">
				<label>Presupuesto *</label>
				<input type="text" class="form-control" name="presupuesto" value="<?php echo $data["presupuesto"]; ?>" required>
			</div>
			
			<div class="col-md-12">
				<label>Observaciones</label>
				<textarea class="form-control" name="observaciones" ><?php echo $data["observaciones"]; ?></textarea>
			</div>
			
			
			
			<div class="col-md-12" style="margin-top: 15px">
				<table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                              <th>#</th>
                              <th>Nombre</th>
                              <th>Cargo</th>
								<th>Correo</th>
                              <th style="text-align: center;" width="30"><input type="checkbox" onclick="Seleccionar_Todo(this)"></th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php
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
							WHERE Jefes.id_jefe = '".$_SESSION["id_user"]."' 
							ORDER BY Empleados.nombre ASC
						";
						$count = 1;
						$query = mysqli_query($connect_valentina, $sentencia);  
						while($data = mysqli_fetch_array($query)){ 

							$txt_role = '';
							foreach($Array_Role as $role){
								if($role[0] == $data["role"]){  $txt_role = $role[1]; }
							}

							$txt_estado = '';
							foreach($Array_Estado  as $estado){
								if($estado[0] == $data["estado"]){  $txt_estado = $estado[1]; }
							}

							if($data["preferencia"] !== ""){
								$data["nombre_completo"] = strtoupper($data["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
							}else{
								$data["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
							}

							if(!$data["foto_formal"]){ $data["foto_formal"] = "1.png"; }
							
							$queryVal = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$data["id"]."' AND id_proceso = '".$id."' ");
                            if( $queryVal->num_rows == 0 ){
							}

							echo '
								<tr>
									<td class="align-middle">'.$count.'</td>
									<td class="align-middle">'.$data["nombre_completo"].'</td>
									<td class="align-middle">'.$data["cargo_nombre"].'</td>
									<td class="align-middle">'.$data["correo"].'</td>
									<td class="align-middle">
										<input type="checkbox" class="chequeado" name="empleados[]" value="'.$data["id"].'">
									</td>
							</tr>
							';
							$count++;
						}
					?>
					</tbody>
				</table>
			</div>
			
			<div class="col-md-12" style="margin-top:15px" >
                <input type="submit" class="btn btn-success bnt-block" value="Guardar" style="width: 100%"  />
			</div>
		
		</div>
		</form>
		
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
