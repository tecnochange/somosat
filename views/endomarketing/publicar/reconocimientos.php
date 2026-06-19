<script>  
$(document).ready(function(){
    $("#endomarketing_menu").addClass("active");
    $("#desplegable_endomarketing").show();
    $("#bt_wandbook_retos").addClass("active_item");
});
</script>

<style>

    .active {
        font-weight: bold;
    }
</style>
<?php	
    $queryEmplead = mysqli_query($connect_valentina,
		"SELECT *
		FROM Empleados c
		LEFT JOIN Posiciones p ON c.id_posicion = p.id
		WHERE c.id = '".$_SESSION['id_user']."' "
	);
	$dataEmplead = mysqli_fetch_array($queryEmplead);

    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEmplead['id_cargo']."' ");
	$dataCargo = mysqli_fetch_array($queryCargo);

    $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataEmplead['id_area']."' ");
	$dataArea = mysqli_fetch_array($queryArea);	

    $hoy = date("Y-m-d H:i:s");
	
	if(isset($_POST["colaborador"]) && $_POST["colaborador"] != "" && $_POST["descripcion"] != ""  ){
		
		$lista = "";
		include("app/controllers/subir_documento.php");
		//registramos los reconocimientos a los colaboradores
		foreach ($_POST["colaborador"] as &$valor) {
			if($lista == ""){
				$lista .= $valor;
			}
			else{
				$lista .= ",".$valor;
			}
				
		}
		
			
		// Insertar reconocimiento
        mysqli_query($connect_endomarketing,"INSERT INTO Publicaciones 
        (id_user, id_empresa, id_area, titulo, descripcion, tipo, visibilidad, copa, fecha_publicacion, estado, created_at) 
        VALUES 
        ('".$_SESSION['id_user']."', 1, '".$dataArea['id']."', 
        '".$lista."', '". utf8_encode($_POST["descripcion"])."', '3', '".$_POST["visibilidad"]."', '".$_POST["copa"]."', '".$_POST["fecha_publicacion"]."', '1', '".$hoy."'  ) ");
            
		$id_publicacion = mysqli_insert_id($connect_endomarketing);
            
		if($_FILES['archivo_multiples'] != ""){
			//Cargar_Archivos_Multiples_Clima($_FILES['archivo_multiples'],$id_publicacion, 3 ,$hoy,$connect_clima);
		}
        /*
		foreach ($_POST["colaborador"] as &$valor) {

            $queryEmpTmp = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$valor."' ");
            $dataEmpTmp = mysqli_fetch_array($queryEmpTmp);

            $nombre_mail = $dataEmpTmp["nombre"]." ".$dataEmpTmp["nombre_2"]." ".$dataEmpTmp["apellidos"]." ".$dataEmpTmp["apellidos_2"];
            $correo_mail = $dataEmpTmp["correo"];

            if($correo_mail != ""){

				//IMPORTAR BREVO
				include("app/models/Brevo/Brevo.php"); 
				$BrevoClass = new Brevo();

				$nombre_plantilla = isset($nombre_mail) ? $nombre_mail : 'Colaborador';
				$asunto_plantilla = "Smart HR-Suite - Nueva Publicación";
				$correo_plantilla = $correo_mail;
				include("mail/endomarketing/nueva_publicacion.php");
			}
				
		}
         */   
		echo '<script>location.href ="?pg=home/muro";</script>';	
	}
?>

<div class="container">
    
	<!-- Ficha -->
    <form action="" method="post" enctype="multipart/form-data">   
    <div class="card"  >
		
        <div class="card-body">
            
            <h3>Publicar Reconocimiento</h3>
      		<p>¿Quieres publicar un reconocimiento?, solo debes completar el formulario y dar clic en publicar</p>
   
        	<select name="visibilidad" required="required" class="form-control" style="margin-bottom:15px; width:auto; display: inline-table; color:#4286f5">
            	<option value="">Selecciona la visibilidad...</option>
                <option value="1">Para la organización / institución</option>
                <option value="2">Para el área o proceso</option>
                <option value="3">Privado</option>
            </select>
            
            <div style="padding: 15px; color: #ea4235;">Selecciona 1 o varios colaboradores <b><span></span></b></div>
            <input type="text" placeholder="Busca y selecciona a la persona que deseas reconocer.." class="form-control" id="myInput" />
            
            <div style=" margin-top:15px; max-height:200px; overflow:auto">
            <table width="100%" style="color: #4286f5; font-size: 13px;">
            	<tbody id="myTable">
                 <?php
					$queryColaboradores = mysqli_query($connect_valentina,"SELECT * FROM Empleados ORDER BY nombre ASC ");
					while($dataColaboradores = mysqli_fetch_array($queryColaboradores)){
						echo '
						<tr>
						<td>
							'.$dataColaboradores["nombre"].' '.$dataColaboradores["nombre_2"].' '.$dataColaboradores["apellidos"].' '.$dataColaboradores["apellidos_2"].'
							<input type="checkbox" name="colaborador[]" value="'.$dataColaboradores["id"].'" class="checkbox_list" onchange="Select_This(this)" />
						</td>
						</tr>
						';
					}
				?>
                </tbody> 
            </table>
            </div>

        	<select name="copa" required="required" class="form-control" style="margin-bottom:15px; display: inline-table; color:#4286f5; margin-top: 15px">
            	<option value="">Selecciona el tipo de reconocimiento...</option>
                <option value="1">Copa Oro</option>
                <option value="2">Copa Plata</option>
            </select>
            
            <input type="file" name="archivo_multiples[]" class="form-control"  multiple="" accept="image/*" class="entradas_texto" style="margin-bottom: 15px">

            <label> Fecha Publicación </label>
            <input type="date"  class="form-control" name="fecha_publicacion" value="<?php echo $data["fecha_publicacion"]; ?>" style="margin-bottom:15px;">
           
            
            <textarea name="descripcion" required="required" rows="4" class="form-control" rows="5" style="height: auto; margin-bottom:15px" placeholder="Ingresa una descripción detallada para el reconocimiento que desas enviar..."><?= isset($data["descripcion"]) ? $data["descripcion"] : ''; ?></textarea> 


            <div align="right" style="margin-top:20px">
                <input type="submit" value="Publicar" class="btn btn-primary btn-md bt_blue">
            </div>
        
        </div>
        
        
    </div>
    </form>
    <?php echo $respuesta ?> 

 
   
</div>



<script>

function Select_This(elemt){
	if( $(elemt).prop('checked') == false ){
		$(elemt).parent().addClass( "name_fil" );
	}
	else{
		$(elemt).parent().addClass( "name_fil_off" );
	}
}




$(document).ready(function(){
	  $("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		
		$("#myTable tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		
		$(".name_fil_off").parent().show();
		
	  });
});
</script>

<style>
.checkbox_list{
	float: right;
    width: 18px;
    height: 18px;
}
</style>

