<script>  
$(document).ready(function(){
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>
<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  >= 3){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>

<?php
	$hoy = date("Y-m-d H:i:s");
    
    if($_GET["id"]){
        $_SESSION["id_colaborador_edit"] = $_GET["id"];
    }

    //EDICION CREACION

	if($_POST["informacion_basica"] != ""){
		
		include("app/controllers/subir_documento.php");
        
		if($_POST["id_registro"] != ""){

			$sentencia = "UPDATE Empleados SET 
			documento = '".$_POST["documento"]."',   
			nombre = '".$_POST["nombre"]."',  
			nombre_2 = '".$_POST["nombre_2"]."',  
			apellidos = '".$_POST["apellidos"]."',  
			apellidos_2 = '".$_POST["apellidos_2"]."',  
			id_cargo = '".$_POST["id_cargo"]."',  
			id_nivel_cargo = '".$_POST["id_nivel_cargo"]."',  
			id_area = '".$_POST["id_area"]."',  
			id_departamento = '".$_POST["id_departamento"]."',  
			correo = '".$_POST["correo"]."',  
			role = '".$_POST["role"]."',  
			estado = '".$_POST["estado"]."'  
            WHERE id = '".$_POST["id_registro"]."'  ";
			mysqli_query($connect_valentina, $sentencia);
			
			if($_FILES["foto_formal"]["name"]){
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_formal"] );
				
				$sent_foto = "INSERT INTO Multimedia_Foto_Perfil ( id_empleado ,  archivo , origen,  created_at ) 
				VALUES ( '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', 1, '".$hoy."'  )";

                mysqli_query($connect_valentina, $sent_foto);
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_formal = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            }
			
			if($_FILES["foto_informal"]["name"]){
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_informal"] );
				
				$sent_foto = "INSERT INTO Multimedia_Foto_Perfil ( id_empleado ,  archivo , origen,  created_at ) 
				VALUES ( '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', 2, '".$hoy."'  )";

                mysqli_query($connect_valentina, $sent_foto);
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_informal = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            }
			
			if($_POST["foto_formal_historico"]){
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_formal = '".$_POST["foto_formal_historico"]."' WHERE id = '".$_POST["id_registro"]."' ");
			}
			
			if($_POST["foto_informal_historico"]){
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_informal = '".$_POST["foto_informal_historico"]."' WHERE id = '".$_POST["id_registro"]."' ");
			}
			
			echo '<script> window.location = "?pg=administrar/colaborador/detalle";</script>';//para evitar reinsersion  
		}
		
		else{
			
			$sentencia = "
			INSERT INTO Empleados ( id_posicion ,  id_cargo, id_nivel_cargo, id_area, id_departamento, correo, 
			documento, nombre, nombre_2, apellidos, apellidos_2, fecha_ingreso, cod_colaborador, id_equipo, foto_formal, foto_informal, role, estado, created_at) 
			VALUES 
			( 0, '".$_POST["id_cargo"]."', '".$_POST["id_nivel_cargo"]."', '".$_POST["id_area"]."', '".$_POST["id_departamento"]."', '".$_POST["correo"]."', '".$_POST["documento"]."', '".$_POST["nombre"]."', '".$_POST["nombre_2"]."', '".$_POST["apellidos"]."', '".$_POST["apellidos_2"]."', '".$_POST["fecha_ingreso"]."', '".$_POST["cod_colaborador"]."', '0', '', '', '".$_POST["role"]."', '".$_POST["estado"]."',  '".$hoy."' )
			";

			mysqli_query($connect_valentina, $sentencia);  
			$id_temp = mysqli_insert_id($connect_valentina);
			
			if($_FILES["foto_formal"]["name"]){
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_formal"] );
				
				$sent_foto = "INSERT INTO Multimedia_Foto_Perfil ( id_empleado ,  archivo , origen,  created_at ) 
				VALUES ( '".$id_temp."', '".$archivo."', 1, '".$hoy."'  )";

                mysqli_query($connect_valentina, $sent_foto);
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_formal = '".$archivo."' WHERE id = '".$id_temp."' ");
            }
			
			if($_FILES["foto_informal"]["name"]){
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_informal"] );
				
				$sent_foto = "INSERT INTO Multimedia_Foto_Perfil ( id_empleado ,  archivo , origen,  created_at ) 
				VALUES ( '".$id_temp."', '".$archivo."', 2, '".$hoy."'  )";

                mysqli_query($connect_valentina, $sent_foto);
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_informal = '".$archivo."' WHERE id = '".$id_temp."' ");
            }
			
			if($_POST["foto_formal_historico"]){
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_formal = '".$_POST["foto_formal_historico"]."' WHERE id = '".$id_temp."' ");
			}
			
			if($_POST["foto_informal_historico"]){
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto_informal = '".$_POST["foto_informal_historico"]."' WHERE id = '".$id_temp."' ");
			}
			
            echo '<script> window.location = "?pg=administrar/colaborador/detalle&id='.$id_temp.'";</script>';//para evitar reinsersion  
		} 
        
        
	}

	if($_POST["guardar_adjuntos"]){
		if($_FILES["archivo"]["name"]){
			include("app/controllers/subir_documento.php");
			$archivo = Subir_Documento( $_FILES["archivo"] );
				
				
			$sent_multi = "
			INSERT INTO Multimedia_Documentos ( id_empresa , id_tipo_doc , id_colaborador ,  archivo , created_at ) 
			VALUES 
			( 1, '".$_POST["documentos"]."', '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', '".$hoy."' )
			";
				
			mysqli_query( $connect_valentina, $sent_multi );
			echo '<script> window.location = "?pg=administrar/colaborador/detalle";</script>';//para evitar reinsersion  
		}

	}
	if($_POST["inactivar_colaborador"]){
		$sentencia = "UPDATE Empleados SET   
		estado = 2, 
		fecha_inactivacion = '".$_POST["fecha_inactivacion"]."', 
		observaciones_inactivacion = '".$_POST["observaciones_inactivacion"]."', 
		motivo_retiro = '".$_POST["motivo_retiro"]."'  
        WHERE id = '".$_SESSION["id_colaborador_edit"]."'  ";
		mysqli_query($connect_valentina, $sentencia);
		echo '<script> window.location = "?pg=administrar/colaborador/detalle";</script>';//para evitar 
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
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
	.foto_lib{
		width: 180px; 
		display: inline-table;
	}
</style>

<!-- MODAL FOTOS -->
<div class="modal fade" id="modal_inactivar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content">
    
			<!-- cerrar -->
			<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Inactivar Colabordor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			
            
            <div class="modal-body" align="left">
				<form action="" method="post" >
					<input type="hidden" name="inactivar_colaborador" value="true">
					<label>Fecha de Inactivación *</label>
					<input type="date" class="form-control" name="fecha_inactivacion" value="<?php echo $data["fecha_inactivacion"]; ?>" required>
					<label>Observaciones de Inactivación *</label>
					<textarea class="form-control" name="observaciones_inactivacion"><?php echo $data["observaciones_inactivacion"]; ?></textarea>
					
					<label>Motivo de Retiro *</label>
					<select class="form-control" name="motivo_retiro" required>
						<option value="" >Seleccione...</option>
						<option value="Retiro Voluntario" >Retiro Voluntario</option>
						<option value="Retiro Involuntario" >Retiro Involuntario</option>
					</select>
					
					<button type="submit" class="btn btn-danger btn-sm"  style="margin-top: 10px" >
                        Cambiar estado
                    </button>
					
				</form>
            </div>

    
		</div>
	</div>
</div>


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
					WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
					while($dataFoto = mysqli_fetch_array($queryFotos)){
						echo '
						<div class="foto_lib">
							<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" onclick="EliminarFoto('.$dataFoto["id"].')"  >
                                <i class="fa fa-times"></i>
                            </button>
							<img src="'.$url.'/recursos/'.$dataFoto["archivo"].'" width="160" title="'.$dataFoto["fecha"].'" class="fotos_galeria" onclick="SeleccionarFoto('."'".$dataFoto["archivo"]."'".')">
						</div>
						';
					}
				?>
				<input type="hidden" id="tipo_imagen">
            </div>

    
		</div>
	</div>
</div>


<div class="container">
	
	
	
	<?php if($_SESSION['role_plataforma'] == 1 ){ ?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/colaboradores">Colaboradores</a></li>
        	<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle Colaborador</a></li>
		</ol>
	</nav>
	<?php } ?>
	<?php if($_SESSION['role_plataforma'] == 2 ){ ?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/mi_equipo">Mi Equipo</a></li>
        	<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle Colaborador</a></li>
		</ol>
	</nav>
	<?php } ?>
	
	<?php echo $respuesta; ?>
	
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/detalle" class="nav-link active">Básicos</a>
		</li>
		<?php if($_SESSION["id_colaborador_edit"]){ ?>

		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link">Datos Personales</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/perfil" class="nav-link">Bienestar</a>
		</li> 
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/preferencia" class="nav-link">RSE</a>
		</li> 
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/academico" class="nav-link ">Académico</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/laboral" class="nav-link ">Experiencia Laboral</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/trayectoria" class="nav-link">Trayectoria en AT</a>
		</li>
		<li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/familiares" class="nav-link">Familiares</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/emergencia" class="nav-link">En Caso de Emergencia</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/remuneracion" class="nav-link"> Remuneración</a>
		</li>
		<?php } ?>
	</ul>
	
	<div class="card" style="margin-bottom: 20px">
        
		<div class="card-body"> 
			<h2>Detalle Colaborador</h2>
			<p>Los campos con * son requeridos</p>
			
			<form action="" method="post" enctype="multipart/form-data">
            <div class="row">

                <input type="hidden" name="id_registro" value="<?php echo $_SESSION["id_colaborador_edit"]; ?>" >
				<input type="hidden" name="informacion_basica" value="true">
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Documento *</label>
                    <input type="text"  class="form-control" name="documento" value="<?php echo $data["documento"]; ?>" required>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Primer Nombre *</label>
                    <input type="text"  class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>" required >
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Segundo Nombre:</label>
                    <input type="text"  class="form-control" name="nombre_2" value="<?php echo $data["nombre_2"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Primer Apellido *</label>
                    <input type="text"  class="form-control" name="apellidos" value="<?php echo $data["apellidos"]; ?>" required >
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Segundo Apellido:</label>
                    <input type="text"  class="form-control" name="apellidos_2" value="<?php echo $data["apellidos_2"]; ?>" >
                </div>
				

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Cargo *</label>
                    <select class="form-control" name="id_cargo" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_cargo"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nivel Cargo *</label>
                    <select class="form-control" name="id_nivel_cargo" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_nivel_cargo"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Area *</label>
                    <select class="form-control" name="id_area" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Areas ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_area"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Departamento *</label>
                    <select class="form-control" name="id_departamento" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Gerencias ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_departamento"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>

				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Correo eléctrónico *</label>
                    <input type="text"  class="form-control" name="correo" value="<?php echo $data["correo"]; ?>" required>
                </div>

				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>* Role</label>
                    <select class="form-control" name="role" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Role as $role){  
                            if($role[0] == $data["role"]){
                                echo '<option value="'.$role[0].'" selected>'.$role[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$role[0].'">'.$role[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>* Estado</label>
                    <select class="form-control" name="estado" required onChange="ValidarInactivo(this.value)">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Estado as $estado){  
                            if($estado[0] == $data["estado"]){
                                echo '<option value="'.$estado[0].'" selected>'.$estado[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$estado[0].'">'.$estado[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
				
				<?php if( $data["fecha_inactivacion"] && $data["estado"] == 2 ){ ?>
				<div class="col-md-12" style="margin-bottom: 10px">
					Fecha de inactivación: <b><?php echo $data["fecha_inactivacion"]; ?></b><br>
					Observaciones: <b><?php echo $data["observaciones_inactivacion"]; ?></b><br>
					Motivo del retiro: <b><?php echo $data["motivo_retiro"]; ?></b><br>
				</div>
				<?php } ?>
				
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
                    	<img src="<?php echo $url."/recursos/".$data["foto_informal"]; ?>" width="150" id="img_foto_informal" onClick="DescargarImagen(this)">
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
                    <th width="30">
                        Eliminar
                    </th>
                </tr>
                     
                <?php 
                $queryDocs = mysqli_query($connect_valentina,"SELECT * FROM Multimedia_Documentos 
                WHERE id_colaborador = '".$_SESSION["id_colaborador_edit"]."'  ");
	            while($dataDocs = mysqli_fetch_array($queryDocs)){
                    echo '
                    <tr>
                        <td>'.$dataDocs["id_tipo_doc"].'</td>
                        <td>
                            <a href="https://somosat.hr-suite.app//recursos/'.$dataDocs["archivo"].'" target="_blank">
                                '.$dataDocs["archivo"].'
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="EliminarDocumento('.$dataDocs["id"].')"  >
                                <i class="fa fa-times"></i>
                            </button>
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

var api = '<?php echo $url; ?>/api/administrar/';
var activar = false;
function EliminarDocumento(id_registro){
	
	if(activar == false ){
		$("#modal_general").modal("show");
		$("#modal_body").html('Está a punto de eliminar un documento de este colaborador. esta acción es irreversible. ¿Esta seguro?<br><br>');
		$("#modal_body").append('<button type="submit" class="btn btn-primary" onclick="activar = true; EliminarDocumento('+id_registro+')" >Eliminar</button>');
	}
	else{

		jQuery.ajax({
			url: api+"eliminar_documento.php",
			type:'post',
			data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=administrar/colaborador/detalle"},
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
}
	
function EliminarFoto(id_registro){
	
	if(activar == false ){
		$("#modal_general").modal("show");
		$("#modal_body").html('Está a punto de eliminar una foto de este colaborador. esta acción es irreversible. ¿Esta seguro?<br><br>');
		$("#modal_body").append('<button type="submit" class="btn btn-primary" onclick="activar = true; EliminarFoto('+id_registro+')" >Eliminar</button>');
	}
	else{

		jQuery.ajax({
			url: api+"eliminar_foto.php",
			type:'post',
			data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=administrar/colaborador/detalle"},
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
}
	
function ValidarInactivo(estado){
	if(estado == 2){
		$("#modal_inactivar").modal("show");
	}
}
  
	
</script>


