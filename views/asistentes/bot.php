<script>
$( document ).ready(function() {
	$('#menuEstructura').collapse();
    $("#bt_estructura_cargos").addClass("active");
});
</script>

<?php include("views/asistentes/styles.php"); ?>

<?php 
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	$query = mysqli_query($connect_asistente,"SELECT * FROM Asistente WHERE id = '".$id."' AND id_empresa = '".$user_log["id_empresa"]."' ");
	$data = mysqli_fetch_array($query);
?>

<div class="container" style="max-width: 700px">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
    		<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=asistentes/dashboard">Volver</a></li>
    		<li class="breadcrumb-item active" aria-current="page">Detalle</li>
		</ol>
	</nav>
	
	<?php echo $respuesta; ?>
	
	<div class="row">
	
	
		
		<!-- CHAT -->
		<div class="col-md-12">
		<?php if($id){ ?>
			<div class="card" >
		
				<div class="card-header">
					<h3><?php echo $data["nombre"]; ?></h3>
					<i class="bx bx-volume-mute parlante" onClick="CancelarVoz()" style="background-color: #F44336;"></i>
					<input type="hidden" id="voz_sintetica" value="<?php echo $data["idioma_chat"]; ?>">
				</div>

				<div class="card-body">
					
					<p><?php echo $data["descripcion"]; ?></p>

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

			</div>
			
			<?php include("views/asistentes/javascript.php"); ?>
			
		<?php } ?>
		</div>
	</div>
	
</div>


	
