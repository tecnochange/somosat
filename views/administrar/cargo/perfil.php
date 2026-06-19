<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_cargos").addClass("active_item");
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>

<?php
	if($_GET["id"]){
        $_SESSION["id_cargo_edit"] = $_GET["id"];
    }

	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

    //CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nivel_educativo"] != ""){

		if($_POST["id_registro_adicional"] != ""){
            
            $sentencia = "UPDATE Cargos_Descriptivo SET 
            nivel_educativo  = '".$_POST["nivel_educativo"]."', 
            titulos_requeridos = '".$_POST["titulos_requeridos"]."',  
            nivel_educativo_avanzado = '".$_POST["nivel_educativo_avanzado"]."', 
            titulos_avanzado_requeridos = '".$_POST["titulos_avanzado_requeridos"]."', 
            conocimientos_especificos = '".$_POST["conocimientos_especificos"]."', 
            conocimientos_tecnicos = '".$_POST["conocimientos_tecnicos"]."',  
            experiencia_total_area = '".$_POST["experiencia_total_area"]."', 
            experiencia_total_años  = '".$_POST["experiencia_total_años"]."',  
            experiencia_específica_areas = '".$_POST["experiencia_específica_areas"]."',  
            experiencia_especifica_anios = '".$_POST["experiencia_especifica_anios"]."', 
            internas = '".$_POST["internas"]."', 
            externas = '".$_POST["externas"]."', 
            salarios_variable = '".$_POST["salarios_variable"]."' 
            WHERE id = '".$_POST["id_registro_adicional"]."' 
            ";
            
            mysqli_query($connect_valentina, $sentencia);

            $respuesta = '
            <div class="alert alert-success" role="alert">
                Los datos han sido actualizado
            </div>
            ';
		}
		else{
            $sentencia = "
            INSERT INTO Cargos_Descriptivo 
            (
                id_cargo, 
                proposito, 
                decisiones_tomar, 
                decisiones_consulta,
                responsabilidades_sg, 
                nivel_educativo, 
                titulos_requeridos, 
                nivel_educativo_avanzado, 
                titulos_avanzado_requeridos, 
                conocimientos_especificos, 
                conocimientos_tecnicos, 
                experiencia_total_area, 
                experiencia_total_años, 
                experiencia_específica_areas, 
                experiencia_especifica_anios, 
                internas, 
                externas, 
                salarios_variable
            ) 
            VALUES 
            (
                '".$_SESSION["id_cargo_edit"]."', 
                '".$_POST["proposito"]."', 
                '".$_POST["decisiones_tomar"]."',  
                '".$_POST["decisiones_consulta"]."',  
                '".$_POST["responsabilidades_sg"]."',  
                '".$_POST["nivel_educativo"]."',  
                '".$_POST["titulos_requeridos"]."',  
                '".$_POST["nivel_educativo_avanzado"]."',  
                '".$_POST["titulos_avanzado_requeridos"]."',  
                '".$_POST["conocimientos_especificos"]."', 
                '".$_POST["conocimientos_tecnicos"]."', 
                '".$_POST["experiencia_total_area"]."',  
                '".$_POST["experiencia_total_años"]."',  
                '".$_POST["experiencia_específica_areas"]."',  
                '".$_POST["experiencia_especifica_anios"]."', 
                '".$_POST["internas"]."', 
                '".$_POST["externas"]."', 
                '".$_POST["salarios_variable"]."' 
            )
            ";
            
            mysqli_query($connect_valentina, $sentencia);
 
            echo '<script> window.location = "'.$ulr.'?pg=administrar/cargo/descriptivo"; </script>';
			
		}
	}
    
    //PARA CREAR NUEVAS FUNCIONES
    if($_POST["guardar_funcion"]){
        if($_POST["id_funcion"] != ""){

            $sentencia = "UPDATE Cargos_Funciones SET 
            que_hace = '".$_POST["que_hace"]."',   
            como_hace = '".$_POST["como_hace"]."',   
            para_hace = '".$_POST["para_hace"]."'    
            WHERE id = '".$_POST["id_funcion"]."' ";
 
            mysqli_query($connect_valentina, $sentencia); 

            $respuesta = '
            <div class="alert alert-success" role="alert">
                Los datos han sido actualizado
            </div>
            ';
		}
		else{
            $sentencia = "INSERT INTO Cargos_Funciones (
                id_cargo, 
                funcion, 
                responsable,
                que_hace,   
                como_hace,   
                para_hace,  
                created_at
            )
            VALUES (
                '".$_SESSION["id_cargo_edit"]."', 
                '', 
                '', 
                '".$_POST["que_hace"]."',   
                '".$_POST["como_hace"]."',   
                '".$_POST["para_hace"]."', 
                '".$hoy."' 
            )
            ";


            mysqli_query($connect_valentina, $sentencia); 

            echo '<script> window.location = "'.$ulr.'?pg=administrar/cargo/descriptivo"; </script>';
			
		}
}

	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$_SESSION["id_cargo_edit"]."'  ");
	$data = mysqli_fetch_array($query);	

    $queryDescriptivo = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Descriptivo WHERE id_cargo = '".$_SESSION["id_cargo_edit"]."'  ");
    $dataDescriptivo = mysqli_fetch_array($queryDescriptivo);
?>


          
<?php include("../layouts/ficha_funciones.php"); ?>

<?php echo $respuesta; ?>

<div class="container">
	
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-sm-6">
					<h3>Detalle del Cargo</h3>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">Estructura</li>
						<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/cargos">Cargos</a></li>
						<li class="breadcrumb-item active">Detalle</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	
    <div class="row">
        <div class="col-md-12">
			
			<!-- CABECERA -->
	
			
			<!-- NAVEGACION -->
			<ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link " href="<?php echo $url; ?>?pg=administrar/cargo/detalle">
						<i class="icofont icofont-business-man"></i>Detalle
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link "  href="<?php echo $url; ?>?pg=administrar/cargo/descriptivo">
						<i class="icofont icofont-list"></i>Descriptivo
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link active" href="<?php echo $url; ?>?pg=administrar/cargo/perfil">
						<i class="icofont icofont-contact-add"></i>Perfil
					</a>
				</li>
			</ul>
			<!-- FIN NAVEGACION -->
            
            <div class="card">
                <div class="card-body">
                    
                    
                    
                    <!-- CONTENIDO FORMULARIO -->
                    <!-- CONTENIDO FORMULARIO -->
                    <!-- CONTENIDO FORMULARIO -->
                    <!-- CONTENIDO FORMULARIO -->
                    <!-- CONTENIDO FORMULARIO -->
                    <div class="tab-content" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-configuracion" role="tabpanel" aria-labelledby="top-configuracion-tab">
                     
                            <!-- FORMULARIO -->
                            <form action="" method="post">
                            <input type="hidden" name="id_registro" value="<?php echo $_SESSION["id_cargo_edit"]; ?>">
                            <input type="hidden" name="id_registro_adicional" value="<?php echo $dataDescriptivo["id"]; ?>">
                            <input type="hidden" name="nombre_cargo" value="<?php echo $data["nombre"]; ?>">
                            <div class="row">
 
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <h5>Formación requerida</h5>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px; margin-top: 30px">
                                    <div class="titulos_rojo">Curricular</div>
                                    <textarea rows="4" class="form-control" name="nivel_educativo"><?php echo $dataDescriptivo["nivel_educativo"]; ?></textarea>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px; margin-top: 30px">
                                    <div class="titulos_rojo">Idiomas</div>
                                    <textarea rows="4" class="form-control" name="nivel_educativo_avanzado"><?php echo $dataDescriptivo["nivel_educativo_avanzado"]; ?></textarea>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Conocimientos específicos</div>
                                    <textarea rows="4" class="form-control" name="titulos_requeridos"><?php echo $dataDescriptivo["titulos_requeridos"]; ?></textarea>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Se valorará:</div>
                                    <textarea rows="4" class="form-control" name="titulos_avanzado_requeridos"><?php echo $dataDescriptivo["titulos_avanzado_requeridos"]; ?></textarea>
                                </div>

                                
                                
                                <div class="col-md-12" style="margin-top: 40px;">
                                    <h5>Experiencia requerida</h5>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Experiencia </label>
                                    <input style="text" class="form-control" name="experiencia_total_años" value="<?php echo $dataDescriptivo["experiencia_total_años"]; ?>">
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Otros requisitos</label>
                                    <input style="text" class="form-control" name="experiencia_total_area" value="<?php echo $dataDescriptivo["experiencia_total_area"]; ?>">
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 40px;">
                                    <h5>Competencias requeridas</h5>
                                </div>


                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Genéricas para trabajar en AT (ADN)</label>
                                    <textarea rows="4" style="text" class="form-control" name="experiencia_especifica_anios" ><?php echo $dataDescriptivo["experiencia_especifica_anios"]; ?></textarea>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Específicas para el cargo</label>
                                    <textarea rows="4" style="text" class="form-control" name="experiencia_específica_areas" ><?php echo $dataDescriptivo["experiencia_específica_areas"]; ?></textarea>
                                </div>
                                
                                <?php 
                                    if($user_log["role"] == 2 || $user_log["role"] == 5){ 
                                        include("autorizaciones.php"); 
                                    } 
                                ?>

                                <div class="col-md-12" style="margin-bottom: 10px" align="right">
                                    <hr>
                                    <button type="submit" id="sidebarCollapse" class="btn btn-primary" >
                                     Guardar
                                    </button>
                                </div>

                            </div>
                            </form>
                            <!-- FIN DEL FORMULARIO -->

                      </div>

                      
                    </div>
                  </div>
            </div>
            
        </div>
    </div>
</div>

<script>
function Borrar(){
    $("#id_funcion").val("");
    $("#que_hace").val("");
    $("#como_hace").val("");
    $("#para_hace").val("");
}
    
var api = '<?php echo $url; ?>/api/administrar/';   
    
function DatosFuncion(id_funcion){
    jQuery.ajax({
			url: api+"funcion_cargo.php",
			type:'post',
			data: {id_funcion: id_funcion, },
			}).done(function (resp){
				$("#modal-body").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
    );
} 
    
function DatosResponsabilidadesSG(id_resp){
    jQuery.ajax({
			url: api+"reponsabilidades_sg.php",
			type:'post',
			data: {id_resp: id_resp },
			}).done(function (resp){
				$("#descripcion_responsabilidades_sg").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
    );
} 
</script>
