<script>
$( document ).ready(function() {
	$('#menuEstructura').collapse();
    $("#bt_estructura_cargos").addClass("active");
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
				estado = '".$_POST["estado"]."' 
			WHERE
				id = '".$_POST["id_registro"]."'
			";
			
			$query = mysqli_query( $connect_admin, $sentencia );
		
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
				estado
			)
			VALUES(
				'".$_POST["categoria"]."',
				'".$_POST["descripcion"]."',
				'".$_POST["link"]."',
				'".$_POST["estado"]."'
			)
			";
			$query = mysqli_query( $connect_admin, $sentencia );
			
			
			
			//para evitar reinsersion
			echo '<script> window.location = "?pg=asistentes/preguntas";</script>';
		}
	}

	$query = mysqli_query($connect_admin,"SELECT * FROM Ayudas WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
?>

<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
    		<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=asistentes/asistentes">Asistentes</a></li>
    		<li class="breadcrumb-item active" aria-current="page">Detalle</li>
		</ol>
	</nav>
	
	<?php echo $respuesta; ?>
	
	<div class="row">
	
		<div class="col-md-6">
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
							<label>Nombre del Asistente *</label>
							<input type="text"  class="form-control" name="categoria" value="<?php echo $data["categoria"]; ?>" required >
						</div>
						
						<div class="col-md-12" style="margin-bottom: 10px">
							<label>Descripción *</label>
							<textarea class="form-control" name="descripcion" required placeholder="Indica a tus usuarios que pueden hacer y como utilizar este bot..."><?php echo $data["descripcion"]; ?></textarea>
						</div>

						<div class="col-md-12" style="margin-bottom: 10px">
							<label>Nombre del Asistente *</label>
							<input type="text"  class="form-control" name="link" value="<?php echo $data["link"]; ?>" required >
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
		
		<!-- CHAT -->
		<div class="col-md-6">
		<?php if($id){ ?>
			<div class="card" >
		
				<div class="card-header">
					<h4>Vista Previa: <?php echo $data["nombre"]; ?></h4>
					<i class="bx bx-volume-mute parlante" onClick="CancelarVoz()" style="background-color: #F44336;"></i>
					<input type="hidden" id="voz_sintetica" value="<?php echo $data["idioma_chat"]; ?>">
				</div>

				<div class="card-body">

					<div class="chat" id="chat"></div>
					
					<table width="100%" style="margin-bottom: 20px">
						<tr>
							<td>
								<input type="text" class="form-control" id="pregunta" placeholder="Por favor ingrese su pregunta...">
							</td>
							<td width="56">
								<button class="btn btn-success" onClick="EnviarPregunta()" >
									<i class="bx bx-send"></i>
								</button>
							</td>
							<td width="56">
								<button class="btn btn-warning" onClick="Iniciar()" id="boton_preguntar" title="Usar MIcrofono" >
									<i class="bx bx-microphone"></i>
								</button>
								<button class="btn btn-danger" onClick="Detener()" style="display: none" id="boton_detener" title="Apagar Micrófono" >
									<i class="bx bx-microphone-off"></i>
								</button>
							</td>
							
							
						</tr>
					</table>

					<div class="respuestas" id="respuesta_ia" align="left" style="display: none"></div>
					
					<button id="bt_leer_nuevamente" class="btn btn-warning w-100" onClick="ReproducirVoz(this)" data-text="Hi, I'm William." style="display: none">Leer respuesta nuevamente</button>
				</div>
				
				<div class="card-footer">
					<h5>Vista previa del promt a la IA</h5>
					<p>
						<?php echo nl2br($promt); ?>
					</p>
				</div>
			</div>
			
			<?php include("views/asistentes/javascript.php"); ?>
			
		<?php } ?>
		</div>
	</div>
	
</div>


	
