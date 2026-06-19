<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
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
	$ahora = date("Y-m-d");

    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    if($_POST["guardar_adicional"] != ""){

        if($_POST["id_informacion_adicional"] != ""){
            
            $sentencia_adicional = "
            UPDATE Empleados_Adicionales SET 
                preferencia  = '".$_POST["preferencia"]."',
                apodo  = '".$_POST["apodo"]."',
                tipo_doc  = '".$_POST["tipo_doc"]."',    
                fecha_vencimiento = '".$_POST["fecha_vencimiento"]."', 
                pasaporte = '".$_POST["pasaporte"]."',    
                fecha_vencimiento_p = '".$_POST["fecha_vencimiento_p"]."', 
                credencial_civica = '".$_POST["credencial_civica"]."',    
                libreta_conducir = '".$_POST["libreta_conducir"]."',
                fecha_nacimiento = '".$_POST["fecha_nacimiento"]."',
                edad = '".$_POST["edad"]."',
                genero = '".$_POST["genero"]."', 
                estado_civil = '".$_POST["estado_civil"]."', 
                nacionalidad  = '".$_POST["nacionalidad"]."',
                pais_nacimiento = '".$_POST["pais_nacimiento"]."', 
                fecha_ingreso = '".$_POST["fecha_ingreso"]."',    
                cod_colaborador  = '".$_POST["cod_colaborador"]."',  
                correo  = '".$_POST["correo"]."',   
                equipo  = '".$_POST["equipo"]."',  
                cliente  = '".$_POST["cliente"]."',   
                dr_cliente  = '".$_POST["dr_cliente"]."',  
                correo_ou  = '".$_POST["correo_ou"]."',
                h_servicio  = '".$_POST["h_servicio"]."',
                dotacion_aplica = '".$_POST["dotacion_aplica"]."',
                r_social  = '".$_POST["r_social"]."',
                dr_fisica  = '".$_POST["dr_fisica"]."',
                rut  = '".$_POST["rut"]."',
                banco  = '".$_POST["banco"]."',
                t_cuenta  = '".$_POST["t_cuenta"]."',
                cuenta  = '".$_POST["cuenta"]."',
                afap  = '".$_POST["afap"]."',
                c_profesional  = '".$_POST["c_profesional"]."',
                fv_docu  = '".$_POST["fv_docu"]."',
                talla_remera = '".$_POST["talla_remera"]."',
                modelo = '".$_POST["modelo"]."',
                color = '".$_POST["color"]."',
                comentario = '".$_POST["comentario"]."',
                pais_residencia  = '".$_POST["pais_residencia"]."',
                pais_otro  = '".$_POST["pais_otro"]."',
                departamento_otro  = '".$_POST["departamento_otro"]."',
                ciudad_otro  = '".$_POST["ciudad_otro"]."',
                departamento_residencia  = '".$_POST["departamento_residencia"]."',
                ciudad_residencia  = '".$_POST["ciudad_residencia"]."', 
                direccion  = '".$_POST["direccion"]."',
                cd_postal  = '".$_POST["cd_postal"]."',
                telefono  = '".$_POST["telefono"]."',
                celular = '".$_POST["celular"]."',
                email_p = '".$_POST["email_p"]."',
                update_at = '".$hoy."'
                WHERE id = '".$_POST["id_informacion_adicional"]."'
            ";
            
            
			mysqli_query($connect_valentina, $sentencia_adicional);
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                 mysqli_query($connect_valentina,"INSERT INTO Multimedia_Adicionales (id_empleado ,  archivo ,  created_at ) 
				VALUES 
				( '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', '".$hoy."' )");
				
				echo "INSERT INTO Multimedia_Adicionales (id_empleado ,  archivo ,  created_at ) 
				VALUES 
				( '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', '".$hoy."' )";
            }
			
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Adicionales (
                id_empleado,
                nombre,
                apellidos,
                preferencia,
                apodo,
                tipo_doc,
                documento,
                fecha_vencimiento,
                pasaporte,
                fecha_vencimiento_p,
                credencial_civica,
                libreta_conducir,
                fecha_nacimiento,
                edad,
                genero,
                estado_civil,
                nacionalidad,
                pais_nacimiento, 
                fecha_ingreso, 
                cod_colaborador,
                correo,
                area,
                departamento,
                equipo,
                cargo,
                cliente,
                dr_cliente,
                correo_ou,
                h_servicio,
                dotacion_aplica,
                r_social,
                dr_fisica,
                rut,
                banco,
                t_cuenta,
                cuenta,
                afap,
                c_profesional,
                fv_docu,
                cargar_archivo,
                talla_remera,
                modelo,
                color,
                comentario,
                pais_residencia,
                pais_otro,
                departamento_otro,
                ciudad_otro,
                departamento_residencia,
                ciudad_residencia, 
                direccion,
                cd_postal,
                telefono,
                celular,
                email_p,
                created_at,
                update_at
            ) 
            VALUES   
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                '".$_POST["nombre"]."',
                '".$_POST["apellidos"]."',
                '".$_POST["preferencia"]."',
                '".$_POST["apodo"]."',
                '".$_POST["tipo_doc"]."',   
                '".$_POST["documento"]."',
                '".$_POST["fecha_vencimiento"]."',   
                '".$_POST["pasaporte"]."',  
                '".$_POST["fecha_vencimiento_p"]."',    
                '".$_POST["credencial_civica"]."',   
                '".$_POST["libreta_conducir"]."',
                '".$_POST["fecha_nacimiento"]."',
                '".$_POST["edad"]."', 
                '".$_POST["genero"]."', 
                '".$_POST["estado_civil"]."', 
                '".$_POST["nacionalidad"]."',
                '".$_POST["pais_nacimiento"]."',
                '".$_POST["fecha_ingreso"]."',  
                '".$_POST["cod_colaborador"]."', 
                '".$_POST["correo"]."', 
                '".$_POST["area"]."', 
                '".$_POST["departamento"]."',  
                '".$_POST["equipo"]."', 
                '".$_POST["cargo"]."', 
                '".$_POST["cliente"]."',   
                '".$_POST["dr_cliente"]."',  
                '".$_POST["correo_ou"]."',
                '".$_POST["h_servicio"]."',
                '".$_POST["dotacion_aplica"]."', 
                '".$_POST["r_social"]."',
                '".$_POST["dr_fisica"]."',
                '".$_POST["rut"]."',
                '".$_POST["banco"]."', 
                '".$_POST["t_cuenta"]."',
                '".$_POST["cuenta"]."',
                '".$_POST["afap"]."',
                '".$_POST["c_profesional"]."',
                '".$_POST["fv_docu"]."',   
                '',
                '".$_POST["talla_remera"]."',
                '".$_POST["modelo"]."',
                '".$_POST["color"]."',
                '".$_POST["comentario"]."',
                '".$_POST["pais_residencia"]."',
                '".$_POST["pais_otro"]."',
                '".$_POST["departamento_otro"]."',
                '".$_POST["ciudad_otro"]."',
                '".$_POST["departamento_residencia"]."',                
                '".$_POST["ciudad_residencia"]."', 
                '".$_POST["direccion"]."', 
                '".$_POST["cd_postal"]."', 
                '".$_POST["telefono"]."', 
                '".$_POST["celular"]."', 
                '".$_POST["email_p"]."',  
                '".$hoy."',
                '".$hoy."'
            );
            ";
           //echo $sentencia_adicional; 
           //print_r(sentencia_adicional); 
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                mysqli_query($connect_valentina,"INSERT INTO Multimedia_Adicionales (id_empleado ,  archivo ,  created_at ) 
				VALUES 
				( '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', '".$hoy."' )");
            }
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';
        }
        
	}

	//FUNCION PARA OBTENER LOS AÑOS
	function Anios_Edad($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

		$years  = floor($dateDifference / (365 * 60 * 60 * 24));
		$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

		$decimal2 = ($months*30+$days)/365;
		$decimal2 = round($decimal2, 1);
		$parte2 = explode(".", $decimal2);

		//return ($years.".".$parte2[1]." años");
		return ($years." años");
	}

	//FUNCION PARA OBTENER LOS AÑOS
	function Anios($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

		$years  = floor($dateDifference / (365 * 60 * 60 * 24));
		$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

		$decimal2 = ($months*30+$days)/365;
		$decimal2 = round($decimal2, 1);
		$parte2 = explode(".", $decimal2);

		return ($years.".".$parte2[1]." años");
	}

	//FUNCION PARA OBTENER LOS AÑOS
	function Dias($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
		
		$dias  = floor($dateDifference / ( 60 * 60 * 24));

		return $dias ;
	}
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);  

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

	$edad = 0;
	if($dataInforma["fecha_nacimiento"]){
		$edad = Anios_Edad($dataInforma["fecha_nacimiento"]);
	}

	$antiguedad = 0;
	if($dataInforma["fecha_ingreso"]){
		$antiguedad = Anios($dataInforma["fecha_ingreso"]);
	}

	//VALIDACION DE ALERTAS
	//VALIDACION DE ALERTAS
	//VALIDACION DE ALERTAS
	$alertas = "";
	
	// FECHA DOCUMENTO
	if($dataInforma["fecha_vencimiento"]){
		$dia_documento =  Dias($dataInforma["fecha_vencimiento"]);
		if( $dataInforma["fecha_vencimiento"] < $ahora){

			$alertas .= '
			<div class="alert alert-danger" role="alert">
				Su documento de indentidad venció hace '.$dia_documento.' días.
			</div>';
		}
		if( $dataInforma["fecha_vencimiento"] >= $ahora){
			if($dia_documento < 15){
				$alertas .= '
				<div class="alert alert-warning" role="alert">
					Su documento de indentidad vence en '.$dia_documento.' días.
				</div>';
			}

		}
	}

	// FECHA DOCUMENTO
	if($dataInforma["fecha_vencimiento_p"]){
		$dia_pasaporte =  Dias( $dataInforma["fecha_vencimiento_p"] );
		if( $dataInforma["fecha_vencimiento_p"] < $ahora){

			$alertas .= '
			<div class="alert alert-danger" role="alert">
				Su pasaporte venció hace '.$dia_pasaporte.' días.
			</div>';
		}
		if( $dataInforma["fecha_vencimiento_p"] >= $ahora){
			if($dia_pasaporte < 15){
				$alertas .= '
				<div class="alert alert-warning" role="alert">
					Su pasaporte vence en '.$dia_pasaporte.' días.
				</div>';
			}

		}
	}

	// FECHA CAJA PROFESIONAL
	if($dataInforma["fv_docu"]){
		$dia_caja =  Dias( $dataInforma["fv_docu"] );
		if( $dataInforma["fv_docu"] < $ahora){

			$alertas .= '
			<div class="alert alert-danger" role="alert">
				Su caja profesional venció hace '.$dia_caja.' días.
			</div>';
		}
		if( $dataInforma["fv_docu"] >= $ahora){
			if($$dia_caja < 15){
				$alertas .= '
				<div class="alert alert-warning" role="alert">
					Su caja profesional vence en '.$dia_caja.' días.
				</div>';
			}

		}
	}

	

    $fecha_actual = date("Y-m-d");
    $fecha_fven = $dataInforma["fecha_vencimiento"];
    $fecha_fvp = $dataInforma["fecha_vencimiento_p"];
    $fecha_fvd = $dataInforma["fv_docu"];

?>

<style>
    .form-control{
        text-transform: uppercase;
    }
</style>

<div class="container"> 
    
    <?php include("views/administrar/colaborador/navegacion.php"); ?>
    
    <?php echo $respuesta; ?>
	<?php echo $alertas; ?>
	
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/detalle" class="nav-link ">Básicos</a>
		</li>
		<?php if($_SESSION["id_colaborador_edit"]){ ?>

		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link active">Datos Personales</a>
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

    <div class="card">
        
        <div class="card-body">   
    
            <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                
                <div class="col-md-12" style="margin-bottom: 30px">
                    <input type="hidden" name="id_informacion_adicional" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-12"style="margin-bottom: 15px">
                    <h2>Identificación</h2>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Nombre Completo</label>
                    <input type="text"  class="form-control" readonly value="<?php echo $data["nombre"]." ".$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]; ?>" required >
                </div>

				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Documento</label>
                    <input type="text"  class="form-control" readonly value="<?php echo $data["documento"]; ?>" required>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Documento de Identidad *</label>
                    <select class="form-control" name="tipo_doc" required>
                        <option value="">Selecciona...</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Tipo_Documento ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($dataInforma["tipo_doc"] == $dataList["nombre"] ){
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
                    <label> Nombre de Preferencia </label>
                    <input type="text"  class="form-control" name="preferencia" value="<?php echo $dataInforma["preferencia"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Apodo </label>
                    <input type="text"  class="form-control" name="apodo" value="<?php echo $dataInforma["apodo"]; ?>" >
                </div>
                
                

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha de Vencimiento Documento de Identidad</label>
                    <input type="date"  class="form-control" name="fecha_vencimiento" value="<?php echo $dataInforma["fecha_vencimiento"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Pasaporte</label>
                    <input type="text"  class="form-control" name="pasaporte" value="<?php echo $dataInforma["pasaporte"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha de Vencimiento Pasaporte</label>
                    <input type="date"  class="form-control" name="fecha_vencimiento_p" value="<?php echo $dataInforma["fecha_vencimiento_p"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Credencial Cívica:</label>
                    <input type="text"  class="form-control" name="credencial_civica" value="<?php echo $dataInforma["credencial_civica"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label>Libreta de Conducir:</label>
                    <input type="text"  class="form-control" name="libreta_conducir" value="<?php echo $dataInforma["libreta_conducir"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha de Nacimiento</label>
                    <input type="date"  class="form-control" name="fecha_nacimiento" value="<?php echo $dataInforma["fecha_nacimiento"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Edad</label>
                    <input type="text"  class="form-control" name="edad" value="<?php echo $edad; ?>" readonly>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px;">
                    <label>Género</label>
                    <select class="form-control" name="genero">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Sexo_Biologico as $tipo){  
                            if($tipo[0] == $dataInforma["genero"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Estado Civil *</label>
                    <select class="form-control" name="estado_civil" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Estado_Civil as $tipo){  
                            if($tipo[0] == $dataInforma["estado_civil"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nacionalidad</label>
                    <select class="form-control" name="nacionalidad">
                        <option value="">Selecciona...</option>
                        <?php
						$queryNodo = mysqli_query($connect_valentina,"SELECT * FROM Nacionalidad 
						ORDER BY nombre ASC ");  
                        while($dataNodo = mysqli_fetch_array($queryNodo)){
                        	if($dataNodo["id"] == $dataInforma["nacionalidad"]){
                                echo '<option value="'.$dataNodo["id"].'" selected>'.$dataNodo["nombre"].'</option>';  
                            }
                            else{
                                echo '<option value="'.$dataNodo["id"].'">'.$dataNodo["nombre"].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label>País Nacimiento</label>
                    <select class="form-control" name="pais_nacimiento">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Pais_Nac as $role){
				            if($role[0] == $dataInforma["pais_nacimiento"]){
								echo '<option value="'.$role[0].'" selected>'.$role[1].'</option>';  
							}
							else{
								echo '<option value="'.$role[0].'">'.$role[1].'</option>';
							}
                        }
                        ?>
                    </select>
                </div>
                
				<!-- DATOS LABORALES -->  
                <div class="col-md-12" style="margin-top: 20px">
                    <h2>Datos Laborales</h2>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha de Ingreso</label>
                    <input type="date" class="form-control" name="fecha_ingreso" value="<?php echo $dataInforma["fecha_ingreso"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Antiguedad</label>
                    <input type="text"  class="form-control"  value="<?php echo $antiguedad; ?>" readonly>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Código de Colaborador AT</label>
                    <input type="text" class="form-control" name="cod_colaborador" value="<?php echo $dataInforma["cod_colaborador"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Mail Corporativo de AT:</label>
                    <input type="text" class="form-control" name="correo"  placeholder="@" value="<?php echo $data["correo"]; ?>" >
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
                    <label>Equipo</label>
                    <select class="form-control" name="equipo" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Equipos ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($dataInforma["equipo"] == $dataList["id"] ){
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
                    <label for="lastName">Cliente:</label>
                    <input type="text" class="form-control" name="cliente"  value="<?php echo $dataInforma["cliente"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Dirección de Cliente:</label>
                    <input type="text" class="form-control" name="dr_cliente"  value="<?php echo $dataInforma["dr_cliente"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Correo de Outsourcing:</label>
                    <input type="text" class="form-control" name="correo_ou" placeholder="@" value="<?php echo $dataInforma["correo_ou"]; ?>" >
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label for="lastName">Horario del Servicio:</label>
                    <input type="text" class="form-control" name="h_servicio"  value="<?php echo $dataInforma["h_servicio"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Independiente/Dependiente:</label>
                    <select class="form-control" name="dotacion_aplica" required onChange="MostrarDotacion(this.value)">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Dotacion_Aplica as $tipo){  
                            if($tipo[0] == $dataInforma["dotacion_aplica"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <script>
                function MostrarDotacion(valor){
					$(".cajas_dep_indep").hide();
					
                    if(valor == 2){
                        $(".dependiente").show();
                    }
                    if(valor == 1){
                        $(".dependiente").show();
						$(".independiente").show();
                    }
					if(valor == 3){
                        $(".dependiente").show();
						$(".independiente").show();
                    }
                }
                </script>
                
                <style>
                    .cajas_dep_indep{
                        display: none;
                    }
                </style>
                
                <div class="col-md-4 cajas_dep_indep independiente" style="margin-bottom: 10px">
                    <label>Razón Social:</label>
                    <input type="text" class="form-control" name="r_social"  value="<?php echo $dataInforma["r_social"]; ?>" >
                </div>
             
                <div class="col-md-4 cajas_dep_indep independiente" style="margin-bottom: 10px">
                    <label>Dirección Fiscal:</label>
                    <input type="text" class="form-control" name="dr_fisica"  value="<?php echo $dataInforma["dr_fisica"]; ?>" >
                </div>
                <div class="col-md-4 cajas_dep_indep independiente" style="margin-bottom: 10px">
                    <label>RUT:</label>
                    <input type="text" class="form-control" name="rut"  value="<?php echo $dataInforma["rut"]; ?>" >
                </div>

                <div class="col-md-4 cajas_dep_indep dependiente" style="margin-bottom: 10px">
                    <label>Banco:</label>
                    <input type="text" class="form-control" name="banco"  value="<?php echo $dataInforma["banco"]; ?>" >
                </div>
                
                <div class="col-md-4 cajas_dep_indep dependiente" style="margin-bottom: 10px">
                    <label>Tipo de Cuenta:</label>
                    <input type="text" class="form-control" name="t_cuenta"  value="<?php echo $dataInforma["t_cuenta"]; ?>" >
                </div>
                
                <div class="col-md-4 cajas_dep_indep dependiente" style="margin-bottom: 10px">
                    <label>Número de Cuenta:</label>
                    <input type="text" class="form-control" name="cuenta"  value="<?php echo $dataInforma["cuenta"]; ?>" >
                </div>
				
				<div class="col-md-12">
				</div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>AFAP</label>
                    <select class="form-control" name="afap" >
                        <option value="">Selecciona...</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Afap ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($dataInforma["afap"] == $dataList["nombre"] ){
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
                    <label>Caja Profesional:</label>
                    <input type="text" class="form-control" name="c_profesional"  value="<?php echo $dataInforma["c_profesional"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha de Vencimiento Caja Profesional:</label>
                    <input type="date" class="form-control" name="fv_docu"  value="<?php echo $dataInforma["fv_docu"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label><b>Adjuntar un Archivo</b></label>
                    <input type="file" id="archivo" name="archivo" class="form-control">
                </div>
                
                <!-- LISTADO -->
                <div class="col-md-12">
                    
					<table class="table table-bordered">
                            <tr>
                                <th>Documento</th>
                                <th width="30">
                                    Eliminar
                                </th>
                            </tr>

                            <?php 
                            $queryDocumentos = mysqli_query($connect_valentina,"SELECT * FROM Multimedia_Adicionales 
                            WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
                            while($dataAdicionales = mysqli_fetch_array($queryDocumentos)){
                                echo '
                                <tr>
                                    <td>
                                        <a href="'.$url.'/recursos/'.$dataAdicionales["archivo"].'" target="_blank">
                                            '.$dataAdicionales["archivo"].'
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="Eliminar('.$dataAdicionales["id"].')" >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                ';   
                            }	
                            ?>
					</table>            

                </div>
      
                
 				<!-- vestimenta -->               
                <div class="col-md-12" style="margin-bottom: 0px; margin-top: 20px">
                    <h2>Vestimenta</h2>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Talle Remera</label>
                    <select class="form-control" name="talla_remera">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Talla_Camisa as $tipo){  
                            if($tipo[1] == $dataInforma["talla_remera"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Modelo</label>
                    <select class="form-control" name="modelo">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Modelo as $tipo){  
                            if($tipo[1] == $dataInforma["modelo"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Color</label>
                    <select class="form-control" name="color">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Color as $tipo){  
                            if($tipo[1] == $dataInforma["color"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Comentarios</label>
                    <input type="text" class="form-control" name="comentario" value="<?php echo $dataInforma["comentario"]; ?>">
                </div>
                
                
  <!-- datos de contacto -->              
                <div class="col-md-12" style="margin-bottom: 0px; margin-top: 20px">
                    <h2>Datos de Contacto</h2>
                </div>  
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label >Pais Residencia</label>
                    <select class="form-control" name="pais_residencia" onChange="MostrarPais(this.value)">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Pais_Residencia as $tipo){ 
				            if($tipo[0] == $dataInforma["pais_residencia"]){
				                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
				            }
							else{
								echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
							}
				        }
                        ?>
                    </select>
                </div>
                
                
                <div class="col-md-4 cajas_pais" style="margin-bottom: 10px; display:none;">
                    <label>Pais Residencia</label>
                    <input type="text" class="form-control" name="pais_otro" value="<?php echo $dataInforma["pais_otro"]; ?>">
                </div>
                
                <div class="col-md-4 cajas_pais" style="margin-bottom: 10px; display:none;">
                    <label>Departamento Residencia.</label>
                    <input type="text" class="form-control" name="departamento_otro" value="<?php echo $dataInforma["departamento_otro"]; ?>">
                </div>
                
                <div class="col-md-4 cajas_pais" style="margin-bottom: 10px; display:none;">
                    <label>Ciudad de Residencia</label>
                    <input type="text" class="form-control" name="ciudad_otro" value="<?php echo $dataInforma["ciudad_otro"]; ?>">
                </div>
                
                <div class="col-md-4 departamento_ciudad" style="margin-bottom: 10px; display:none;">
                    <label for="lastName">Departamento Residencia. </label>
                    <select class="form-control" name="departamento_residencia" id="departamento_residencia" onChange="CargarCiudades(this.value)">
                        <option value="">Selecciona...</option>
                        <?php
						$queryDep = mysqli_query($connect_valentina,"SELECT * FROM Departamentos WHERE id_pais = 1 ORDER BY departamento ASC ");
						while($dataDep = mysqli_fetch_array($queryDep) ){
							if($dataDep['id_departamento'] == $dataInforma["departamento_residencia"]){
                                echo '<option value="'.$dataDep['id_departamento'].'" selected>'.$dataDep['departamento'].'</option>';  
                            }
                            else{
                                echo '<option value="'.$dataDep['id_departamento'].'">'.$dataDep['departamento'].'</option>';
                            }
						}
                        ?>
                    </select>
                </div>

                <div class="col-md-4 departamento_ciudad" style="margin-bottom: 10px; display:none;">
                    <label for="lastName">Ciudad / Barrio:</label>
                    <select class="form-control" name="ciudad_residencia" id="ciudad_residencia">
                        <option value="">Selecciona...</option>
                        <?php
						$queryCity = mysqli_query($connect_valentina,"SELECT * FROM Municipios WHERE id_municipio <= 1100  ORDER BY municipio ASC ");
						while($dataCity = mysqli_fetch_array($queryCity) ){
							if($dataCity['id_municipio'] == $dataInforma["ciudad_residencia"]){
                                echo '<option value="'.$dataCity['id_municipio'].'" selected>'.$dataCity['municipio'].'</option>';  
                            }
                            else{
                                echo '<option value="'.$dataCity['id_municipio'].'">'.$dataCity['municipio'].'</option>';
                            }
						}
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Dirección de Residencia:</label>
                    <input type="text" class="form-control" name="direccion" value="<?php echo $dataInforma["direccion"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Código Postal:</label>
                    <input type="text" class="form-control" name="cd_postal" value="<?php echo $dataInforma["cd_postal"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" placeholder="" value="<?php echo $dataInforma["telefono"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Celular:</label>
                    <input type="text" class="form-control" name="celular" value="<?php echo $dataInforma["celular"]; ?>" >
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">E-mail Personal:</label>
                    <input type="text" class="form-control" name="email_p" placeholder="@" value="<?php echo $dataInforma["email_p"]; ?>" >
                </div>
                
                <?php if($dtEmpleado["role"] == 1 || $_SESSION["id_colaborador_edit"] == $_SESSION['id_user_seleccion'] ){ ?>
                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 30px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-primary btn-block" >
                        <i class="fa fa-check"></i> Guardar
                    </button>
                </div>
                <?php } ?>

            </div>
            </form>
        </div> 
        
    </div>
    
</div>






<script>
var api = '<?php echo $url; ?>/api/administrar/';

function Cargar_Posiciones(id_cargo){
	
	
	jQuery.ajax({
		url: api+"cargar_posiciones.php",
		type:'post',
		data: {id_cargo: id_cargo, id_posicion: 0, url:""},
		}).done(function (resp){
			$("#id_posicion").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
	
}

</script>


<script>

var api = '<?php echo $url; ?>/api/administrar/';

function CargarDepartamento(id_pais){
	jQuery.ajax({
		url: api+"departamentos_admin.php",
		type:'post',
		data: {id_pais: id_pais},
		}).done(function (resp){
			$("#departamento_nacimiento").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
    
    
    function CargarCiudades(id_dep){
	jQuery.ajax({
		url: api+"lista_ciudades.php",
		type:'post',
		data: {id_dep: id_dep},
		}).done(function (resp){
			$("#ciudad_residencia").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
    
    
function CargarDepartamentoRes(id_pais){
	jQuery.ajax({
		url: api+"departamentos_admin.php",
		type:'post',
		data: {id_pais: id_pais},
		}).done(function (resp){
			$("#departamento_residencia").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
    
    
    function CargarCiudadesNacimiento(id_dep){
        jQuery.ajax({
            url: api+"lista_ciudades.php",
            type:'post',
            data: {id_dep: id_dep},
            }).done(function (resp){
                $("#ciudad_nacimiento").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp){
            }
        );
    }
    
var api = '<?php echo $url; ?>/api/administrar/';
    
function Eliminar(id_registro){
	jQuery.ajax({
		url: api+"eliminar_doc_adicional.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>/?pg=administrar/colaborador/adicionales"},
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
    
    //PARA CAMBIAR A MAYUSCULAS
    $(document).ready( function () {
        $("input").on("keypress", function () {
           $input=$(this);
           setTimeout(function () {
            $input.val($input.val().toUpperCase());
           },50);
        });
        
        
        <?php
        if($dataInforma["dotacion_aplica"]){
        ?>
        MostrarDotacion(<?php echo $dataInforma["dotacion_aplica"]; ?>)
        <?php
        }
        ?>                        
    });

    var pais_residencia = <?php echo $dataInforma["pais_residencia"] ;?>;
    if(pais_residencia == 2){
        $(".cajas_pais").show();
        $(".departamento_ciudad").hide(); // Ocultar campos de departamento y ciudad
    } else {
        $(".cajas_pais").hide();
        $(".departamento_ciudad").show(); // Mostrar campos de departamento y ciudad
    }
    function MostrarPais(valor){
        if(valor == 2){
            $(".cajas_pais").show();
            $(".departamento_ciudad").hide(); // Ocultar campos de departamento y ciudad
        } else {
            $(".cajas_pais").hide();
            $(".departamento_ciudad").show(); // Mostrar campos de departamento y ciudad
        }
    }
  
</script>



