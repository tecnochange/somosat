<script>  
$( document ).ready(function() {
	$('#menuEndomarketing').collapse();
    $("#bt_endo_publicar").addClass("active");
});
</script>

<?php

    header('Content-Type: text/html; charset=UTF-8');

	$hoy = date("Y-m-d H:i:s");
    $tipo_publicacion = $_GET["tp"];
    $txt_titulo = "";
    if($tipo_publicacion == 4){$txt_titulo = "Clasificado"; }
    if($tipo_publicacion == 5){$txt_titulo = "Nuevos Colaboradores"; }
    if($tipo_publicacion == 6){$txt_titulo = "SyST"; }
    if($tipo_publicacion == 7){$txt_titulo = "Celebración"; }
    if($tipo_publicacion == 8){$txt_titulo = "Calidad de Vida"; }
	if($tipo_publicacion == 9){$txt_titulo = "Noticias"; }

	if(isset($_POST["visibilidad"]) && $_POST["visibilidad"] != "" && $_POST["descripcion"] != ""  ){

		echo $_POST["id"]; 

		if($_POST["id"] != ""){
			$titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : NULL;
			mysqli_query($connect_endomarketing,"UPDATE Publicaciones SET titulo = '".$titulo."', descripcion = '".utf8_encode($_POST["descripcion"])."', 
			visibilidad = '".$_POST["visibilidad"]."' WHERE id = '".$_POST["id"]."' ");
			echo '<script>location.href ="'.$url.'?pg=home/muro";</script>';
		}

		//REGISTRO NUEVO
		else{

			include("app/controllers/subir_documento.php");
			
			$script = "";
			if( isset($_POST["youtube"]) && $_POST["youtube"] != "" ){
				$partes = explode("=", $_POST["youtube"] );
				$partes = explode("&", $partes[1] );
				if(count($partes) == 1){
					$script = $partes[0];
				}
				else{
					$script = $partes[0];
				}
			}
            
			mysqli_query($connect_endomarketing,"INSERT INTO Publicaciones (id_user, id_empresa, id_area, 
			descripcion, script, tipo, tipo_multimedia, visibilidad, fecha_publicacion, estado, created_at) VALUES 
			('".$user_log['id']."', 1, '".$user_log['id_area']."',  
			'".utf8_encode($_POST["descripcion"])."', '".$script."', '".$tipo_publicacion."', '".$_POST["tipo_multimedia"]."', '".$_POST["visibilidad"]."', '".$_POST["fecha_publicacion"]."', 1, '".$hoy."'  ) ");

			$id_publicacion = mysqli_insert_id($connect_endomarketing);
			if(isset($_FILES['archivo_multiples']) && $_FILES['archivo_multiples'] != ""){
				Cargar_Archivos_Multiples_Muro($_FILES['archivo_multiples'], $id_publicacion, 1, $hoy, $connect_endomarketing);
			}
            
            if($_FILES['archivo_multiples_docs'] != ""){
				Cargar_Archivos_Multiples_Muro($_FILES['archivo_multiples_docs'], $id_publicacion, 2, $hoy,$connect_endomarketing);
			}
            /*
			//IMPORTAR BREVO
			include("app/models/Brevo/Brevo.php");
			$BrevoClass = new Brevo();

			$nombre_plantilla = 'No definido';
			$asunto_plantilla = "Smart HR-Suite - Nueva Publicación";

			$queryColTmp = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
			WHERE id_empresa = 1 AND correo != ''  ");
			while($dataColTmp = mysqli_fetch_array($queryColTmp)){
				if( filter_var( $dataColTmp["correo"] , FILTER_VALIDATE_EMAIL) ){
					$nombre_colab = $dataColTmp["nombre"]." ".$dataColTmp["apellidos"];

					//DATOS DEL EMAIL
					$nombre_plantilla = isset($nombre_colab) ? $nombre_colab : 'Empleados';
					$asunto_plantilla = "Smart HR-Suite - Nueva Publicación";
					$correo_plantilla = $dataColTmp["correo"];
					include("mail/endomarketing/nueva_publicacion.php");
				}
			}
            */
			echo '<script> location.href ="/?pg=home/muro";</script>';
		}
	}
	
	$text_visibilidad = 'Selecciona la visibilidad...';

	//VALIDAMOS SI ES UNA EDICION
	if(isset($_GET["id"]) && $_GET["id"] != ""){
		//CONSULTAMOS LOS DATOS DE LA ASIGNACION
		$query = mysqli_query($connect_endomarketing,"SELECT * FROM Publicaciones WHERE id = '".$_GET["id"]."' ");
		$data = mysqli_fetch_array($query);

		if($data["visibilidad"] == 1){$text_visibilidad = 'Para la organización / institución'; }
		if($data["visibilidad"] == 2){$text_visibilidad = 'Para el área o proceso'; }
		
		if( $data["id_user"] != $_SESSION['id_user'] ){
			echo '<script>location.href ="?pg=home/muro";</script>';
		}
	}
?><head><meta charset="UTF-8"></head>



<div class="container">
    

	<!-- Ficha -->
    <div class="card">
		
		<div class="card-header">
			<h5>Publicar <?php echo $txt_titulo; ?></h5>
		</div>
        
        <div class="card-body">
			
			<form action="" method="post" enctype="multipart/form-data"> 
			<div class="row">
				
				<div class="col-md-12" style=" margin-bottom: 15px">
					¿Quieres publicar ?, solo debes completar el formulario y dar clic en publicar
				</div>
				
				<div class="col-md-6" style=" margin-bottom: 15px">
					<label>Visibilidad</label>
					<select name="visibilidad" required class="form-control" >
						<option value="">Selecciona..</option>
						<?php
						foreach($Array_Visibilidad as $visibilidad){
							if( $visibilidad[0] == $data["visibilidad"] ){
								echo '<option value="'.$visibilidad[0].'" selected>'.$visibilidad[1].'</option>';
							}
							else{
								echo '<option value="'.$visibilidad[0].'">'.$visibilidad[1].'</option>';
							}
						}
						?>
					</select>
				</div>
			
				<div class="col-md-6" style=" margin-bottom: 15px">
					<label>Fecha Publicación</label>
					<input type="date"  class="form-control" name="fecha_publicacion" value="<?php echo $data["fecha_publicacion"]; ?>">
				</div>
				
				<div class="col-md-12" style="margin-bottom: 15px">
                    <textarea name="descripcion" required="required" rows="5" class="form-control" placeholder="Ingresa una descripción detallada y completa de la solicitud, requerimiento o información sobre el clasificado..."><?= htmlspecialchars($data["descripcion"] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>


				</div>
				
				<div class="col-md-12" style=" margin-bottom: 15px">
					<select name="tipo_multimedia" class="form-control multimedia"  onchange="Tipo_Archivo(this.value)" style=" margin-bottom: 15px">
						<option value="">Multimedia...</option>
						<option value="1">Galeria de Imágenes</option>
						<option value="2">Video de Youtube</option>
                	</select>
					<div id="tipo_archivos">
                	</div>
				</div>
				
				<div class="col-md-12" style=" margin-bottom: 15px">
                    <div>* Para seleccionar varios archivos diferentes de CTRL+click y seleccione los archivos a cargar.</div>
                    <div style="color: #ff0606; font-size: 13px;">* Para seleccionar varios archivos consecutivos de SHIFT+click y seleccionr los archivos a cargar.</div>
                    <input type="file" name="archivo_multiples_docs[]" class="form-control"  multiple="" accept=".docx, application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/pdf " class="entradas_texto">
				</div>
				
				<div class="col-md-12" style=" margin-bottom: 15px">
					<input type="hidden" name="id" value="<?=isset($data["id"]) ? $data["id"] : ''; ?>" />
                    <input type="submit" value="Publicar" class="btn btn-primary btn-md bt_blue">
				</div>
				
			</div>
			</form>
 
        </div>
	</div>
 
    <?php echo $respuesta ?> 




    
</div>



<script>
	function Tipo_Archivo(val){
		if(val == 1){
			$("#tipo_archivos").html('<div style="color: #ff0606; font-size: 13px;">* Para seleccionar varios archivos diferentes de CTRL+click y seleccione los archivos a cargar.</div>');
			$("#tipo_archivos").append('<div style="color: #ff0606; font-size: 13px;">* Para seleccionar varios archivos consecutivos de SHIFT+click y seleccionr los archivos a cargar.</div>');
			$("#tipo_archivos").append('<input type="file" name="archivo_multiples[]" class="form-control"  multiple="" accept="image/*" class="entradas_texto">');
		}
		if(val == 2){
			$("#tipo_archivos").html('<textarea required="required" style="width:100%" rows="4" name="youtube" placeholder="Ingrese el link del video de youtube que desea publicar , que aparece en la ventana de su navegador..." class="entradas_texto"/></textarea> ');
		}
		if(val == ""){
			$("#tipo_archivos").html('');
		}

	}
</script>





