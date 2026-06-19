<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
});
</script>


<?php
	
	$hoy = date("Y-m-d H:i:s");

	if( $_POST["guardar_fotos"]  ){

			if($_FILES["foto_formal"]["name"]){
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_formal"] );
				
				$sent_foto = "INSERT INTO Multimedia_Foto_Perfil ( id_empleado ,  archivo , origen,  created_at ) 
				VALUES ( '".$_SESSION["id_user"]."', '".$archivo."', 1, '".$hoy."'  )";

                mysqli_query($connect_valentina, $sent_foto);
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_formal = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            }
			
			if($_FILES["foto_informal"]["name"]){
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_informal"] );
				
				$sent_foto = "INSERT INTO Multimedia_Foto_Perfil ( id_empleado ,  archivo , origen,  created_at ) 
				VALUES ( '".$_SESSION["id_user"]."', '".$archivo."', 2, '".$hoy."'  )";

                mysqli_query($connect_valentina, $sent_foto);
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_informal = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            }
		
			if($_POST["foto_formal_historico"]){
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_formal = '".$_POST["foto_formal_historico"]."' WHERE id = '".$_POST["id_registro"]."' ");
			}
			
			if($_POST["foto_informal_historico"]){
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_informal = '".$_POST["foto_informal_historico"]."' WHERE id = '".$_POST["id_registro"]."' ");
			}
			
			echo '<script> window.location = "?pg=perfil/ficha/mis_datos";</script>';//para evitar 
	}

	if($_POST["guardar_adjuntos"]){
		if($_FILES["archivo"]["name"]){
			include("app/controllers/subir_documento.php");
			$archivo = Subir_Documento( $_FILES["archivo"] );
				
				
			$sent_multi = "
			INSERT INTO Multimedia_Documentos ( id_empresa , id_tipo_doc , id_colaborador ,  archivo , created_at ) 
			VALUES 
			( 1, '".$_POST["documentos"]."', '".$_SESSION["id_user"]."', '".$archivo."', '".$hoy."' )
			";
				
			mysqli_query( $connect_valentina, $sent_multi );
			echo '<script> window.location = "?pg=perfil/ficha/mis_datos";</script>';//para evitar reinsersion  
		}

	}
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_user"]."' ");
	$data = mysqli_fetch_array($query);
?>

<style>
	.fotos_galeria{
		transition: 0.5s all;

	}
	.fotos_galeria:hover{
		transform: scale(1.1);
		opacity: 0.8;
	}
</style>


<!-- MODAL FOTOS -->
<div class="modal fade" id="modal_fotos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
    
			<!-- cerrar -->
			<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mi Galería</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
            
            <div class="modal-body" align="center">
				<?php
					$queryFotos = mysqli_query($connect_valentina,"SELECT * FROM Multimedia_Foto_Perfil 
					WHERE id_empleado = '".$_SESSION["id_user"]."'  ");
					while($dataFoto = mysqli_fetch_array($queryFotos)){
						echo '
							<img src="'.$url.'/recursos/'.$dataFoto["archivo"].'" width="160" title="'.$dataFoto["fecha"].'" class="fotos_galeria" onclick="SeleccionarFoto('."'".$dataFoto["archivo"]."'".')">
						';
					}
				?>
				<input type="hidden" id="tipo_imagen">
            </div>
		</div>
	</div>
</div>


<div class="container">
    <?php echo $respuesta; ?>

    <!-- PESTAÑAS -->
    <!-- PESTAÑAS -->
    <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos" class="nav-link active">Básicos</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/adicionales" class="nav-link">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/perfil" class="nav-link">Bienestar</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/preferencia" class="nav-link">RSE</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/academico" class="nav-link ">Académico</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/laboral" class="nav-link ">Experiencia Laboral</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/trayectoria" class="nav-link">Trayectoria en AT</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/familiares" class="nav-link">Familiares</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/emergencia" class="nav-link">En Caso de Emergencia</a>
            </li>
    </ul>





    <div class="card" style="margin-bottom: 15px">
        
        <div class="card-body"> 
            <h2>Resumen Colaborador</h2>
			
			<div class="row">
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Documento</label>
                    <input type="text"  class="form-control" readonly name="documento" value="<?php echo $data["documento"]; ?>" readonly>
                </div>
                
                <div class="col-md-8" style="margin-bottom: 10px">
                    <label> Nombre Completo</label>
                    <input type="text"  class="form-control" name="nombre" value="<?php echo $data["nombre"]." ".$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]; ?>" readonly >
                </div>

				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Cargo</label>
                    <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_cargo"] == $dataList["id"] ){
                                    echo '<input type="text" class="form-control" value="'.$dataList["nombre"].'" readonly > ';
                                }
                            }
                    ?>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nivel Cargo *</label>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_nivel_cargo"] == $dataList["id"] ){
                                    echo '<input type="text" class="form-control" value="'.$dataList["nombre"].'" readonly > ';
                                }
                                
                            }
                        ?>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Area</label>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Areas ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_area"] == $dataList["id"] ){
                                    echo '<input type="text" class="form-control" value="'.$dataList["nombre"].'" readonly > ';
                                }
                            }
                        ?>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Departamento *</label>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Gerencias ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_departamento"] == $dataList["id"] ){
                                    echo '<input type="text" class="form-control" value="'.$dataList["nombre"].'" readonly > ';
                                }
                            }
                        ?>
                </div>
                
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Correo eléctrónico *</label>
                    <input type="text"  class="form-control" name="correo" value="<?php echo $data["correo"]; ?>" readonly>
                </div>
				
			</div>
			
		</div>
		
	</div>
	
	<div class="card">
		<div class="card-body">
			
			<form action="" method="post" enctype="multipart/form-data">
			<div class="row">

				<input type="hidden" name="guardar_fotos" value="true">
				<input type="hidden" name="id_registro" value="<?php echo $_SESSION["id_user"]; ?>">
				
				<div class="col-md-12" style="margin-top: 20px">
                    <h2>Adjuntar Fotos</h2>
                </div>
				
				<div class="col-md-6" style="margin-bottom: 10px">
                    <label>Foto Formal (tamaño máximo 5 mega)</label>
                    <input class="form-control" type="file" name="foto_formal" id="foto_formal" accept="image/*" onChange="validarImagen(this)" size="1" style="width: 85%; display: inline-table;">
					
					<button type="button" class="btn btn-warning" onClick="VerGaleria(1)" >
                        <i class="bx bx-image"></i>
                    </button>
					<?php if($data["foto_formal"] > 0){ ?>
                    	<img src="<?php echo $url."/recursos/".$data["foto_formal"]; ?>" width="150" id="img_foto_formal" onClick="DescargarImagen(this)">
                    <?php } ?>
					<input type="hidden" name="foto_formal_historico" id="foto_formal_historico">
				</div>
				
				<div class="col-md-6" style="margin-bottom: 10px">
                    <label>Foto Formal (tamaño máximo 5 mega)</label>
                    <input class="form-control" type="file" name="foto_informal" id="foto_informal" accept="image/*" onChange="validarImagen(this)" size="1" style="width: 85%; display: inline-table;">
					<button type="button" class="btn btn-warning" onClick="VerGaleria(2)" >
                        <i class="bx bx-image"></i>
                    </button>
					<?php if($data["foto_informal"] > 0){ ?>
                    	<img src="<?php echo $url."/recursos/".$data["foto_informal"]; ?>" width="150" id="img_foto_informal" onClick="DescargarImagen(this)" >
                    <?php } ?>
					<input type="hidden" name="foto_informal_historico" id="foto_informal_historico">
				</div>

                <div class="col-md-12" style="margin-bottom: 10px" align="right">

                    <button type="submit" id="sidebarCollapse" class="btn btn-primary btn-block" style="width: 100%;margin-top: 15px;" >
                        <i class="fa fa-check"></i> Guardar
                    </button>
                </div>
				
				
				
				
			</div>
			</form>
			
        </div>
        
        
    </div>
	
	
	
	<!-- DOCUENTOS ADJUNTOS -->
	<div class="card" style="margin-bottom: 20px">
        
		<div class="card-body"> 
			<h2>Archivos Adjuntos</h2>
			
			<form action="" method="post" enctype="multipart/form-data">
            <div class="row">

                <input type="hidden" name="id_registro" value="<?php echo $id; ?>" >
				<input type="hidden" name="guardar_adjuntos" value="true">
				
				<div class="col-md-5" style="margin-bottom: 10px">
                    <select class="form-control" name="documentos" >
                        <option value="">Selecciona...</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Archivos_Adjuntos ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["documentos"] == $dataList["nombre"] ){
                                    echo '<option value="'.$dataList["nombre"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["nombre"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                    
                <div class="col-md-4" style="margin-bottom: 10px">
                    <input type="file" id="archivo" name="archivo" class="form-control">
                </div>

                <div class="col-md-3" style="margin-bottom: 10px" align="right">
                    <button type="submit" id="sidebarCollapse" class="btn btn-primary btn-block" >
                        <i class="fa fa-check"></i> Anexar
                    </button>
                </div>
				
            </div>
            </form>
			
			<table class="table table-bordered">
                <tr>
                    <th>Documento</th>
                    <th>Soporte</th>

                </tr>
                     
                <?php 
                $queryDocs = mysqli_query($connect_valentina,"SELECT * FROM Multimedia_Documentos 
                WHERE id_colaborador = '".$_SESSION["id_user"]."'  ");
	            while($dataDocs = mysqli_fetch_array($queryDocs)){
                    echo '
                    <tr>
                        <td>'.$dataDocs["id_tipo_doc"].'</td>
                        <td>
                            <a href="https://somosat.hr-suite.app//recursos/'.$dataDocs["archivo"].'" target="_blank">
                                '.$dataDocs["archivo"].'
                            </a>
                        </td>
                        
                    </tr>
                    ';   
                }	
                ?>
            </table>   
		</div>
		
	</div>
	
	
	
	
	
   
    
</div>




<script>
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>

<script>
//VALIDAR IMAGEN
function validarImagen(elem) {
    var fileSize = $(elem)[0].files[0].size;
    console.log(fileSize);
    
    var siezekiloByte = parseInt(fileSize / 1024);
    if (siezekiloByte > 5000 ) {
        alert("La fotografía es demasiado grande. por favor reduzca su tamaño a menos de 5 mega.");
        $('#foto_perfil').val("");
        return false;
    }
}

//VER GALERIA
function VerGaleria(tipo){
	$("#modal_fotos").modal("show");
	$("#tipo_imagen").val(tipo);
}
	
function SeleccionarFoto(imagen){
	$("#modal_fotos").modal("hide");
	
	if( $("#tipo_imagen").val() == 1 ){
		$("#img_foto_formal").attr("src", "<?php echo $url."/recursos/"; ?>"+imagen );
		$("#foto_formal_historico").val(imagen);
	}
	
	if( $("#tipo_imagen").val() == 2 ){
		$("#img_foto_informal").attr("src", "<?php echo $url."/recursos/"; ?>"+imagen );
		$("#foto_informal_historico").val(imagen);
	}
}
	
function DescargarImagen(elem){
	url = $(elem).attr("src");
	window.open(url);
}
</script>

<script>
var api = '<?php echo $url; ?>/api/administrar/';
    
function Eliminar_Empleados(id_registro){
	jQuery.ajax({
		url: api+"eliminar_editar.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=perfil/ficha/mis_datos"},
		}).done(function (resp){
			$("#xscript").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
    
   
</script>
         
           
</div>