<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
	$(document).ready(function () {
		$('#menuAgente').collapse();
		$("#bt_agente_preguntas").addClass("active");

		$('.multiples_roles').select2();
	});
</script>

<?php 
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	if($_POST["guardar_formulario"]){
		if($_POST["id_registro"]){
			
			$sentencia = "
			UPDATE
				Ayudas
			SET
				categoria = '".$_POST["categoria"]."',
				descripcion = '".$_POST["descripcion"]."',
				link = '".$_POST["link"]."', 
                roles = '".implode(",", $_POST["roles"])."', 
				estado = '".$_POST["estado"]."' 
			WHERE
				id = '".$_POST["id_registro"]."'
			";
			
			$query = mysqli_query( $connect_valentina, $sentencia );
            
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
            //$acciones = array("modulo" => "Agente IA", "accion" => "Editar", "entidad" => "Guiones" );
            //GuardarBitacora($_POST, $acciones, $_POST["id_registro"]);
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
		
			$respuesta = '
                <div class="alert alert-success" role="alert">
                    Los datos ha sido actualizados con éxito.
                </div>
            ';
		}
		else{
			$sentencia = "
			INSERT INTO Ayudas(
				categoria,
				descripcion,
				link, 
                roles, 
				estado
			)
			VALUES(
				'".$_POST["categoria"]."',
				'".$_POST["descripcion"]."',
				'".$_POST["link"]."', 
                '".implode(",", $_POST["roles"])."', 
				'".$_POST["estado"]."'
			)
			";
			$query = mysqli_query( $connect_valentina, $sentencia );
			
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
            //$id_temp_reg = mysqli_insert_id($connect_beneficios);
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
            //$acciones = array("modulo" => "Agente IA", "accion" => "Crear", "entidad" => "Guiones" );
            //GuardarBitacora($_POST, $acciones, $id_temp_reg);
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
            //PARA GUARAR LA BITACORA: EL PRIMER PARAMETRO ES EL POST
			
			
			//para evitar reinsersion
			echo '<script> window.location = "?pg=asistentes/preguntas";</script>';
		}
	}

	$query = mysqli_query($connect_valentina,"SELECT * FROM Ayudas WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);

    $obj_roles = explode(",", $data["roles"]);
	
?>

<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
    		<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=asistentes/preguntas">Asistente</a></li>
    		<li class="breadcrumb-item active" aria-current="page">Detalle</li>
		</ol>
	</nav>
	
	<?php echo $respuesta; ?>
	
	<div class="row">
	
		<div class="col-md-12">
			<div class="card" >
		
				<div class="card-header">
					Detalle
				</div>

				<div class="card-body">   

					<form action="" method="post" enctype="multipart/form-data">

					<div class="row">
						<div class="col-md-12">

							<input type="hidden" name="id_registro" value="<?php echo $id; ?>">
							<input type="hidden" name="guardar_formulario" value="true">
						</div>

						<div class="col-md-12" style="margin-bottom: 10px">
							<label>Categoría *</label>
							<input type="text"  class="form-control" name="categoria" value="<?php echo $data["categoria"]; ?>" required >
						</div>
						
						<div class="col-md-6" style="margin-bottom: 10px">
							<label>Descripción </label>
							<textarea rows="10" class="form-control" name="descripcion" ><?php echo $data["descripcion"]; ?></textarea>
						</div>

						<div class="col-md-6" style="margin-bottom: 10px">
							<label>Link </label>
							<textarea rows="10" class="form-control" name="link" ><?php echo $data["link"]; ?></textarea>
						</div>
						
						<div class="col-md-12" style="margin-bottom: 10px">
							<label>Estado</label>
							<select class="form-control" name="estado" required>
								<option value="">Selecciona...</option>
								<?php
								foreach($Array_Estado as $role){  
									if($role[0] == $data["estado"]){
										echo '<option value="'.$role[0].'" selected>'.$role[1].'</option>';  
									}
									else{
										echo '<option value="'.$role[0].'">'.$role[1].'</option>';
									}
								}
								?>
							</select>
						</div>

                        <div class="col-md-12" style="margin-bottom: 10px; margin-top:3px">
						<label><b>Roles Múltiples Plataforma *</b></label>

						<select class="form-control multiples_roles" name="roles[]" id="role_usuario" multiple="multiple"
							required style="width: 100%">
							<option value="">Selecciona...</option>
							<?php
							$queryRoles = mysqli_query($connect_valentina, " SELECT * FROM Roles WHERE estado = 1  ");
							while ($dataRoles = mysqli_fetch_array($queryRoles)) {

								$permitir = false;
								foreach ($obj_roles as $id_role) {
									if ($id_role == $dataRoles["id"]) {
										$permitir = true;
									}
								}

								if ($permitir == true) {
									echo '<option value="' . $dataRoles["id"] . '" selected >' . $dataRoles["nombre"] . '</option>';
								} else {
									echo '<option value="' . $dataRoles["id"] . '">' . $dataRoles["nombre"] . '</option>';
								}
							}
							?>
						</select>
					</div>

						<div class="col-md-12" align="right" >
							<button type="submit" class="btn btn-primary " >
								Guardar
							</button>
						</div>

					</div>
					</form>
				</div>
		
			</div>
		</div>
		
		
	</div>
	
</div>


	
