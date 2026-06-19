<script>  
$( document ).ready(function() {
	$('#menuEndomarketing').collapse();
    $("#bt_endo_publicar").addClass("active");
});
</script>


<style>

    .active {
        font-weight: bold;
    }   
</style>

<?php	
    $queryEmplead = mysqli_query($connect_admin,"SELECT * FROM Empleados WHERE id = '".$_SESSION['id_user']."' ");
	$dataEmplead = mysqli_fetch_array($queryEmplead);

    $queryCargo = mysqli_query($connect_admin,"SELECT * FROM Cargos WHERE id = '".$dataEmplead['id_cargo']."' ");
	$dataCargo = mysqli_fetch_array($queryCargo);

    $queryArea = mysqli_query($connect_admin,"SELECT * FROM Areas WHERE id = '".$dataCargo['id_area']."' ");
	$dataArea = mysqli_fetch_array($queryArea);

    $hoy = date("Y-m-d H:i:s");
	
	if($_POST["titulo"] != "" && $_POST["descripcion"] != ""  ){

		if($_POST["id"] != ""){
			mysqli_query($connect_clima,"UPDATE Publicaciones SET titulo = '".$_POST["titulo"]."', descripcion = '".utf8_encode($_POST["descripcion"])."', 
			visibilidad = '".$_POST["visibilidad"]."',  variable = '".$_POST["variable"]."' WHERE id = '".$_POST["id"]."' ");
			echo '<script>location.href ="?pg=home";</script>';
		
		}
		//REGISTRO NUEVO
		//REGISTRO NUEVO
		//REGISTRO NUEVO
		else{
			include("app/controllers/subir_documento.php");
			//$archivo = Subir_Documento($_FILES['imagen']);
			$script = '';
			if($_POST['youtube'] != ""){ 
                
                $partes = explode("=", $_POST['youtube']);
                if(count($partes) > 1  ){
                    $script = $partes[1]; 
                }
                else{
                    $script = $_POST['youtube']; 
                }
                
            }
			if($_POST['vimeo'] != ""){ 
                $partes = explode("=", $_POST['youtube']);
                if(count($partes) > 1  ){
                    $script = $partes[1]; 
                }
                else{
                    $script = $_POST['youtube']; 
                }
            }
			
			mysqli_query($connect_clima,"INSERT INTO Publicaciones (id_user, id_empresa, id_proceso, 
			titulo, descripcion, script, tipo, tipo_multimedia, visibilidad, variable, estado, created_at) 
			VALUES 
			('".$_SESSION['id_user']."', '".$_SESSION['id_empresa']."', '".$dataArea['id']."',  
			'".$_POST["titulo"]."', '".utf8_encode($_POST["descripcion"])."', '".$script."', '2', '".$_POST["tipo_multimedia"]."', '".$_POST["visibilidad"]."', '".$_POST["variable"]."', '1', '".$hoy."'  ) ");
			$id_publicacion = mysqli_insert_id($connect_clima);
			
			if($_FILES['archivo_multiples'] != ""){
				Cargar_Archivos_Multiples_Clima($_FILES['archivo_multiples'],$id_publicacion,1,$hoy,$connect_clima);
			}
            
            
            if($_FILES['archivo_multiples_docs'] != ""){
				Cargar_Archivos_Multiples_Clima($_FILES['archivo_multiples_docs'],$id_publicacion,2,$hoy,$connect_clima);
			}
			
			echo '<script>location.href ="?pg=home";</script>';
		}
	}
	
	$text_visibilidad = 'Selecciona la visibilidad...';
	//VALIDAMOS SI ES UNA EDICION
	if($_GET["id"] != ""){
		//CONSULTAMOS LOS DATOS DE LA ASIGNACION
		$query = mysqli_query($connect_clima,"SELECT * FROM Publicaciones WHERE id = '".$_GET["id"]."' ");
		$data = mysqli_fetch_array($query);

		if($data["visibilidad"] == 1){$text_visibilidad = 'Para la organización / institución'; }
		if($data["visibilidad"] == 2){$text_visibilidad = 'Para el área o proceso'; }
		
		if( $data["id_user"] != $_SESSION['id_user'] ){
			echo '<script>location.href ="?pg=clima/wandbook/home";</script>';
		}
	}
	
	$queryVarEmpresa = mysqli_query($connect_clima,"SELECT * FROM Encuestas WHERE id_empresa = '".$_SESSION['id_empresa']."' ");
	$dataVarEmpresa = mysqli_fetch_array($queryVarEmpresa);
	
	$varaibles = explode(",", $dataVarEmpresa["variables"]);
	
?>

<div class="container">
    


	<!-- Ficha -->
    <form action="" method="post" enctype="multipart/form-data">
    <div class="card">
		<div class="card-body">
        	<h3>Publicar Motivador</h3>
      		<p>¿Quieres publicar un motivador?, solo debes completar el formulario y dar clic en publicar</p>
       
        	<select name="visibilidad" required="required" class="form-control" style="margin-bottom:15px; width:auto; ">
            	<option value="<?php echo $data["visibilidad"]; ?>"><?php echo $text_visibilidad; ?></option>
                <option value="1">Para la organización / institución</option>
                <option value="2">Para el área o proceso</option>
            </select>

            <select name="variable" required="required" class="form-control" style="margin-bottom:15px; width:auto;">
            	<option value="">Selecciona variable...</option>
                <?php 
					foreach ($varaibles as &$variable) {
						$queryVariables = mysqli_query($connect_clima,"SELECT * FROM Variables WHERE id =  '".$variable."' ");
						$dataVariables = mysqli_fetch_array($queryVariables);
						
						
						echo '<option value="'.$dataVariables["id"].'">'.$dataVariables["nombre"].'</option>';
					}
				?>
            </select>

        	<input name="titulo" required="required" type="text" placeholder="Título..."  class="form-control" value="<?php echo $data["titulo"] ?>" style="margin-bottom:15px" />
           
            
            <textarea name="descripcion" required="required" rows="4" class="form-control" rows="5" style="height: auto; margin-bottom:15px" placeholder="Ingresa una descripción detallada del motivador que deseas publicar..."><?php echo $data["descripcion"] ?></textarea> 
            
            <?php if($_GET["id"] == ""){ ?>
            <select name="tipo_multimedia" class="form-control multimedia" style="margin-bottom:15px; width:auto; display: inline-table; color:#4286f5" onchange="Tipo_Archivo(this.value)">
            	<option value="">Multimedia...</option>
                <option value="1">Galeria de Imágenes</option>
                <option value="2">Video de Youtube</option>
            </select>
			<?php } ?>
            
            <div id="tipo_archivos">
            </div>
            
            <div>
                <div>* Para seleccionar varios archivos diferentes de CTRL+click y seleccione los archivos a cargar.</div>
			    <div style="color: #ff0606; font-size: 13px;">* Para seleccionar varios archivos consecutivos de SHIFT+click y seleccionr los archivos a cargar.</div>
			    <input type="file" name="archivo_multiples_docs[]" class="form-control"  multiple="" accept=".docx, application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/pdf " class="entradas_texto">
            </div>
        

            <div align="right" style="margin-top:20px">
            	<input type="hidden" name="id" value="<?php echo $data["id"] ?>" />
                <input type="submit" value="Publicar" class="btn btn-primary btn-md bt_blue">
            </div>
        
        </div>
        </form>
        
	</div>
 
    <?php echo $respuesta ?> 







    
 
    
   


    
</div>

<style>
.cabecera_card{
	margin-top: 10px;
}

.titulo_card{
    padding-bottom: 0px;
    color: #2666ab;
    font-size: 18px;
    font-weight: bold;
}

.fecha_card{
	color: #c1c1c1;
}

.parrafo_card{
	font-size:14px;
	padding: 10px;
	padding-left: 15px;
    padding-right: 15px;
}

.bt_option_card{
	border: 1px solid #e0e0e0;
	cursor:pointer
}

.bt_option_card:hover{
	border: 1px solid #fff;
	background-color:#ececec;
	
}
.bt_publicar{
	width: 150px;
    background-color: #2ca5de;
    color: #fff;
    border: 0;
    padding: 5px;
    border-radius: 5px;
}
</style>

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




