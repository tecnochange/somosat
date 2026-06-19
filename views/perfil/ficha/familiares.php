<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
});
</script>

<style>
    .form-control{
        text-transform: uppercase;
    }
</style>

<?php
	$hoy = date("Y-m-d H:i:s");
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    if($_POST["guardar_adicional"] != ""){
		
		include("app/controllers/subir_documento.php");

        if($_POST["id_informacion"] != ""){
            
            $sentencia_adicional = "
            UPDATE Empleados_Familiares SET 
                conyuge = '".$_POST["conyuge"]."',
                documento_conyuge = '".$_POST["documento_conyuge"]."',   
                numero_dcunyuge = '".$_POST["numero_dcunyuge"]."',
                fecha_conyuge = '".$_POST["fecha_conyuge"]."',
                numero_hijos = '".$_POST["numero_hijos"]."',
                cantidad_hijo = '".$_POST["cantidad_hijo"]."',
                nombre_hijo = '".$_POST["nombre_hijo"]."', 
                documento_hijo = '".$_POST["documento_hijo"]."',   
                numero_hijo = '".$_POST["numero_hijo"]."',
                fecha_hijo = '".$_POST["fecha_hijo"]."',    
                edadh = '".$_POST["edadh"]."',
                parentesco = '".$_POST["parentesco"]."',
                otros = '".$_POST["otros"]."',  
                nombre = '".$_POST["nombre"]."',  
                tipo_documento = '".$_POST["tipo_documento"]."',  
                fecha_nace = '".$_POST["fecha_nace"]."', 
                convives = '".implode(";", $_POST["convives"])."',
                mascotas = '".implode(";", $_POST["mascotas"])."',
                cuidado_especial = '".$_POST["cuidado_especial"]."',  
                gastos = '".$_POST["gastos"]."'
                WHERE id = '".$_POST["id_informacion"]."'
            ";
			mysqli_query($connect_valentina, $sentencia_adicional);
			
			foreach( $_POST["nombre_hijo"] as $key => $hijo){

				if( $_POST["id_hijo"][$key] != "" ){
					//echo $_POST["nombre_hijo"][$key]."<br>";
					//print_r($_FILES["foto_hijo"][0][0])."<br>";
					//print_r( $_FILES["foto_hijo"]["name"][$key]);
					
					$sentencia_hijo = "
					UPDATE Empleados_Hijos SET 
						nombre_hijo = '".$_POST["nombre_hijo"][$key]."',
                        documento_hijo = '".$_POST["documento_hijo"][$key]."',
                        numero_hijo = '".$_POST["numero_hijo"][$key]."',
                        fecha_hijo = '".$_POST["fecha_hijo"][$key]."',
                        edad = '".$_POST["edad"][$key]."'
						WHERE id = '".$_POST["id_hijo"][$key]."'
					";
					mysqli_query($connect_valentina, $sentencia_hijo); 

					if($_FILES["foto_hijo"]["name"][$key]){
						$archivo = Cargar_Foto_Hijos( $_FILES["foto_hijo"], $key );
						mysqli_query($connect_valentina,"UPDATE Empleados_Hijos SET foto = '".$archivo."' 
						WHERE id = '".$_POST["id_hijo"][$key]."' ");
					}

				}
				else{
					$arch = "";
					if($_FILES["foto_hijo"]["name"][$key]){
						$archivo = Cargar_Foto_Hijos( $_FILES["foto_hijo"], $key );
						$arch = $archivo; 
					}
					$sentencia_hijo = " INSERT INTO Empleados_Hijos
						(id_empleado, nombre_hijo, documento_hijo, numero_hijo, fecha_hijo, edad, foto, created_at)
						VALUES 
						( '".$_SESSION["id_user"]."', '".$_POST["nombre_hijo"][$key]."', 
						'".$_POST["documento_hijo"][$key]."','".$_POST["numero_hijo"][$key]."', 
						'".$_POST["fecha_hijo"][$key]."', '".$_POST["edad"][$key]."', '".$arch."', '".$hoy."' )
					";
					mysqli_query($connect_valentina, $sentencia_hijo);
				}
			}
			
			
			foreach( $_POST["parentesco_otros"] as $key => $hijo){

				if( $_POST["id_familiar"][$key] != "" ){

					$sentencia_otro = "
					UPDATE Empleados_Familiares_Otros  SET  parentesco_otros = '".$_POST["parentesco_otros"][$key]."', otros = '".$_POST["otros"][$key]."', nombre_otro = '".$_POST["nombre_otro"][$key]."', tipo_documento_otros = '".$_POST["tipo_documento_otros"][$key]."', fecha_nace_otros =  '".$_POST["fecha_nace_otros"][$key]."' WHERE id = '".$_POST["id_familiar"][$key]."'
					";
					mysqli_query($connect_valentina, $sentencia_otro);
				}
				else{
					$sentencia_otro = " 
					INSERT INTO Empleados_Familiares_Otros ( id_empleado , parentesco_otros , otros ,  nombre_otro , tipo_documento_otros , fecha_nace_otros ,  created_at ) 
					VALUES 
					( '".$_SESSION["id_user"]."', '".$_POST["parentesco_otros"][$key]."', '".$_POST["otros"][$key]."', '".$_POST["nombre_otro"][$key]."', '".$_POST["tipo_documento_otros"][$key]."', '".$_POST["fecha_nace_otros"][$key]."', '".$hoy."' )
					";
					mysqli_query($connect_valentina, $sentencia_otro);
				}
			}
			
			
			
			$respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';
			
			
			
            /*
            if($_FILES["foto_perfil"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_perfil"] );
                mysqli_query($connect_valentina,"UPDATE Empleados SET foto = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            }
            
            mysqli_query($connect_valentina, $sentencia_adicional);  

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
			*/
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Familiares (
                id_empleado, 
                conyuge,
                documento_conyuge,
                numero_dcunyuge,
                fecha_conyuge,
                numero_hijos,
                cantidad_hijo,
                nombre_hijo,
                documento_hijo, 
                numero_hijo,
                fecha_hijo, 
                edadh,
                foto2, 
                parentesco, 
                otros, 
                nombre, 
                tipo_documento, 
                fecha_nace,
                convives,
                mascotas, 
                cuidado_especial, 
                gastos,
                created_at
            ) 
            VALUES 
            (
                '".$_SESSION["id_user"]."', 
                '".$_POST["conyuge"]."',
                '".$_POST["documento_conyuge"]."', 
                '".$_POST["numero_dcunyuge"]."',
                '".$_POST["fecha_conyuge"]."',
                '".$_POST["numero_hijos"]."', 
                '".$_POST["cantidad_hijo"]."',
                '".$_POST["nombre_hijo"]."',  
                '".$_POST["documento_hijo"]."',     
                '".$_POST["numero_hijo"]."', 
                '".$_POST["fecha_hijo"]."',   
                '".$_POST["edadh"]."',
                '',
                '".$_POST["parentesco"]."',   
                '".$_POST["otros"]."', 
                '".$_POST["nombre"]."', 
                '".$_POST["tipo_documento"]."',  
                '".$_POST["fecha_nace"]."', 
                '".implode(";", $_POST["convives"])."', 
                '".implode(";", $_POST["mascotas"])."', 
                '".$_POST["cuidado_especial"]."',   
                '".$_POST["gastos"]."', 
                '".$hoy."'
            );
            ";
            //print_r($sentencia);
            mysqli_query($connect_valentina, $sentencia_adicional); 
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["foto_perfil"]["name"]){
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_perfil"] );
                mysqli_query($connect_valentina,"UPDATE Empleados SET foto = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            }
			
			foreach( $_POST["nombre_hijo"] as $key => $hijo){

					$arch = "";
					if($_FILES["foto_hijo"]["name"][$key]){
						$archivo = Cargar_Foto_Hijos( $_FILES["foto_hijo"], $key );
						$arch = $archivo; 
					}
					$sentencia_hijo = " INSERT INTO Empleados_Hijos
						(id_empleado, nombre_hijo, documento_hijo, numero_hijo, fecha_hijo, edad, foto, created_at)
						VALUES 
						( '".$_SESSION["id_user"]."', '".$_POST["nombre_hijo"][$key]."', 
						'".$_POST["documento_hijo"][$key]."','".$_POST["numero_hijo"][$key]."', 
						'".$_POST["fecha_hijo"][$key]."', '".$_POST["edad"][$key]."', '".$arch."', '".$hoy."' )
					";
					mysqli_query($connect_valentina, $sentencia_hijo);
				
			}
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
 
        
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
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_user"]."' ");
	$data = mysqli_fetch_array($query);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares WHERE id_empleado = '".$_SESSION["id_user"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_user"]."' ");
	$data = mysqli_fetch_array($query);

    $queryPosicion = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE codigo = '".$data["codigo_posicion"]."' ");
	$dataPosicion = mysqli_fetch_array($queryPosicion);

    $firstDate = $dataInforma["fecha_hijo"];
    $secondDate = date("Y-m-d");
    $dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

    $years  = floor($dateDifference / (365 * 60 * 60 * 24));
    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
    
                    
    $decimal2 = ($months*30+$days)/365;
    $decimal2 = round($decimal2, 1);
    $parte2 = explode(".", $decimal2);
                    
    $edad =  $years.".".$parte2[1]." años";

    //print_r($dataInforma);
?>



<div class="container"> 

    <?php echo $respuesta; ?>

	<!-- PESTAÑAS -->
    <!-- PESTAÑAS -->
    <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos" class="nav-link ">Básicos</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/adicionales" class="nav-link ">Datos Personales</a>
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
                <a href="<?php echo $url; ?>?pg=perfil/ficha/familiares" class="nav-link active">Familiares</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/emergencia" class="nav-link">En Caso de Emergencia</a>
            </li>
    </ul>
	
    <!-- LISTADO -->
    <div class="card">
        <div class="card-body"> 
            
            <form action="" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-12"style="margin-bottom: 30px">
                    <h2>Datos Familiares</h2>
                </div>
 <!-- conyuge -->               
                <div class="col-md-12"style="margin-bottom: 30px">
                    <h2>Cónyuge/Concubino:</h2>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" name="conyuge" value="<?php echo $dataInforma["conyuge"]; ?>">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Documento de Identidad:</label>
                    <select class="form-control" name="documento_conyuge">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Tipo_Doc as $tipo){  
                            if($tipo[0] == $dataInforma["documento_conyuge"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Número de Documento</label>
                    <input type="text"  class="form-control" name="numero_dcunyuge" value="<?php echo $dataInforma["numero_dcunyuge"]; ?>">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" name="fecha_conyuge" value="<?php echo $dataInforma["fecha_conyuge"]; ?>">
                </div>
                
<!-- hijos -->               
                <div class="col-md-12"style="margin-top: 30px">
                    <h2>Hijos/as:</h2>
                </div>
                
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Tiene Hijos</label>
                    <select class="form-control" name="numero_hijos" required onChange="MostrarHijos(this.value)">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Numero_Hijos as $tipo){  
                            if($tipo[0] == $dataInforma["numero_hijos"]){
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
                    
                function MostrarHijos(valor){
                    if(valor == 1){
                        $(".cajas_hijos").show();
                    }
                    if(valor == 2){
                        $(".cajas_hijos").hide();
                    }
                }
                </script>
                
                <style>
                    .cajas_hijos{
                        display: none;
                    }
                </style>
				
				<?php 
				$queryHijos = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Hijos WHERE id_empleado = '".$_SESSION["id_user"]."' ");
				?>
                
                <div class="col-md-3 cajas_hijos" style="margin-bottom: 10px">
                    <label>Cantidad de Hijos</label>
                    <input type="number" class="form-control" name="cantidad_hijo" value="<?php echo $queryHijos->num_rows; ?>" readonly >
                </div>
				
				<div class="col-md-3 cajas_hijos" style="margin-bottom: 10px">
                    <label>&nbsp;</label><br>
                    <button type="button" class="btn btn-primary btn-block" onClick="MostrarCantidadHijos()" >
                        <i class="fa fa-check"></i> Agregar hijo
                    </button>
                </div>
				
				<hr>
				<div class="col-md-12" id="lita_hijos">
				<?php 
				while($dataHijos = mysqli_fetch_array($queryHijos)){
					
					$edad_anios = Anios($dataHijos["fecha_hijo"]);
					$options = '';
					foreach($Lista_Tipo_Doc as $tipo){  
                        if($tipo[1] == $dataInforma["documento_hijo"]){
                            $options .= '<option value="'.$tipo[1].'" selected> '.$tipo[1].'</option>';  
                        }
                        else{
                            $options .= '<option value="'.$tipo[1].'"> '.$tipo[1].'</option>';  
                        }
                    }
					
					$foto = "";
					if($dataHijos["foto"] > 0){ 
                    	$foto = '<img src="'.$url.'/recursos/'.$dataHijos["foto"].'" width="100" >';
                    }
					
					echo '
					<div class="row">
						<input type="hidden" name="id_hijo[]" value="'.$dataHijos["id"].'">
                        
						<div class="col-md-4" style="margin-bottom: 10px">
							<label>Nombre Completo</label>
							<input type="text" class="form-control" name="nombre_hijo[]" value="'.$dataHijos["nombre_hijo"].'" required>
						</div>
						
                        <div class="col-md-4 " style="margin-bottom: 10px">
							<label>Documento de Identidad:</label>
							<select class="form-control" name="documento_hijo[]">
                                '.$options.'
                            </select>
				        </div>
                        
						<div class="col-md-4 " style="margin-bottom: 10px">
							<label>Número de Documento</label>
							<input type="text"  class="form-control" name="numero_hijo[]" value="'.$dataHijos["numero_hijo"].'">
						</div>

						<div class="col-md-4 " style="margin-bottom: 10px">
							<label>Fecha de Nacimiento:</label>
							<input type="date" class="form-control" name="fecha_hijo[]" value="'.$dataHijos["fecha_hijo"].'">
						</div>

						<div class="col-md-2 " style="margin-bottom: 10px">
							<label>Edad</label>
							<input type="text"  class="form-control" name="edad[]" value="'.$edad_anios.'" readonly>
						</div>

						<div class="col-md-4 " style="margin-bottom: 10px">
							<label>Foto Hijo (tamaño máximo 1 mega)</label>
							<input class="form-control" type="file" name="foto_hijo[]" accept="image/*" onChange="validarImagen()" size="1">
							'.$foto.'
						</div> 

						<div class="col-md-2 " style="margin-bottom: 10px" align="right">
							<label>&nbsp;</label><br>
							<button type="button" class="btn btn-danger" onclick="EliminarHijo('.$dataHijos["id"].')" >
								<i class="fa fa-times"></i>
							</button>
						</div>

					</div>
					
					';
				}
				
				?>
				</div>
                
				<hr>
			
				<!-- otros -->               
                <div class="col-md-9"style="margin-top: 30px" >
                    <h2>Otros:</h2>
                </div>
				
				<div class="col-md-3 cajas_hijos" style="margin-bottom: 10px">
                    <label>&nbsp;</label><br>
                    <button type="button" class="btn btn-primary btn-block" onClick="AgregarOtro()" >
                        <i class="fa fa-check"></i> Agregar Otro
                    </button>
                </div>
				
				<div class="col-md-12" id="lista_otros">
				<?php 
				$queryFamiliar = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares_Otros WHERE id_empleado = '".$_SESSION["id_user"]."' ");
				while($dataFamiliar = mysqli_fetch_array($queryFamiliar)){
					
					$options = '';
					foreach($Array_Parentezco as $tipo){  
                        if($tipo[1] == $dataFamiliar["parentesco_otros"]){
                            $options .= '<option value="'.$tipo[1].'" selected> '.$tipo[1].'</option>';  
                        }
                        else{
                            $options .= '<option value="'.$tipo[1].'"> '.$tipo[1].'</option>';  
                        }
                    }
					
					
					$options_2 = '';
					foreach($Lista_Tipo_Doc as $tipo){  
                        if($tipo[1] == $dataFamiliar["tipo_documento_otros"]){
                            $options_2 .= '<option value="'.$tipo[1].'" selected> '.$tipo[1].'</option>';  
                        }
                        else{
                            $options_2 .= '<option value="'.$tipo[1].'"> '.$tipo[1].'</option>';  
                        }
                    }

					echo '
					<div class="row">
						<input type="hidden" name="id_familiar[]" value="'.$dataFamiliar["id"].'">
						
						<div class="col-md-4" style="margin-bottom: 10px">
							<label>Parentesco</label>
							<select class="form-control" name="parentesco_otros[]">
								'.$options.'
							</select>
						</div>

						<div class="col-md-4" style="margin-bottom: 10px">
							<label>Si Tu Respuesta Anterior Fue Otros, Por Favor Especifica</label>
							<input type="text" class="form-control" name="otros[]" value="'.$dataFamiliar["otros"].'" >
						</div>

						<div class="col-md-4" style="margin-bottom: 10px">
							<label>Nombre Completo</label>
							<input type="text" class="form-control" name="nombre_otro[]" value="'.$dataFamiliar["nombre_otro"].'">
						</div>

						<div class="col-md-6" style="margin-bottom: 10px">
							<label>Documento de Identidad:</label>
							<select class="form-control" name="tipo_documento_otros[]">
								'.$options_2.'
							</select>
						</div>

						<div class="col-md-4" style="margin-bottom: 10px">
							<label>Fecha de Nacimiento:</label>
							<input type="date" class="form-control" name="fecha_nace_otros[]" value="'.$dataFamiliar["fecha_nace_otros"].'">
						</div>

						<div class="col-md-2 " style="margin-bottom: 10px" align="right">
							<label>&nbsp;</label><br>
							<button type="button" class="btn btn-danger" onclick="EliminarOtro('.$dataFamiliar["id"].')" >
								<i class="fa fa-times"></i>
							</button>
						</div>

					</div>
					
					';
				}
				
				?>	
				</div>

                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>¿Con Quien Convives?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["convives"]);
                        foreach($Array_Convives as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd">
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="convives[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>Si Tu Respuesta Anterior Fue Mascotas, Por Favor Especifica el Tipo :</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["mascotas"] ); 
                        foreach($Array_Mascotas as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                                            
                            
                            echo '
                            <div class="col-md-6">
                            <table class="table table-bordered table-smd">
                                <tr>
                                    <td style="padding: 15px">
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="60" style="padding: 15px">
                                        <input type="checkbox" name="mascotas[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
					
					
				
                
          
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Indica Si Alguno de los Miembros con los que Convives Requiere un Cuidado Especial que Amerite Tiempo Adicional en tu Jornada Laboral</label>
                    <textarea type="text" class="form-control" name="cuidado_especial" style="margin-top: 3px"><?php echo $dataInforma["cuidado_especial"]; ?></textarea>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>¿Los Gastos Del Hogar Son Asumidos Por?</label>
                    <select class="form-control" name="gastos">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_gastos as $tipo){  
                            if($tipo[0] == $dataInforma["gastos"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-primary btn-block" >
                        <i class="fa fa-check"></i> Guardar
                    </button>
                </div>                

            </div>
            </form>            
        </div>
    </div>
</div>

<!-- REFERENCIA HIJOS -->
<div id="ref_formulario_familia" style="display: none">
	<div class="row">
		<input type="hidden" name="id_hijo[]">
						<div class="col-md-4 " style="margin-bottom: 10px">
                            <label>Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre_hijo[]" value="" required>
                        </div>
						<div class="col-md-4 " style="margin-bottom: 10px">
                            <label>Documento de Identidad:</label>
                            <select class="form-control" name="documento_hijo[]">
                            <option value="">Selecciona...</option>';
                        	<?php 
                            foreach($Lista_Tipo_Doc as $tipo){  
								echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
							?>
							</select>
                        </div>
						<div class="col-md-4 " style="margin-bottom: 10px">
                            <label>Número de Documento</label>
                            <input type="text"  class="form-control" name="numero_hijo[]" value="">
                        </div>

                        <div class="col-md-4 " style="margin-bottom: 10px">
                            <label>Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="fecha_hijo[]" value="">
                        </div>

                        <div class="col-md-2 " style="margin-bottom: 10px">
                            <label>Edad</label>
                            <input type="text"  class="form-control" name="edad[]" value="" readonly>
                        </div>
		
		
		<div class="col-md-4 " style="margin-bottom: 10px">
			<label>Foto Formal (tamaño máximo 1 mega)</label>
            <input class="form-control" type="file" name="foto_hijo[]" accept="image/*" onChange="validarImagen()" size="1">
		</div> 
		
		<div class="col-md-2 " style="margin-bottom: 10px" align="right">
            <label>&nbsp;</label><br>
            <button type="button" class="btn btn-warning " title="Quitar Hijo" onClick="EliminarHijo(0)" >
                <i class="fa fa-times"></i>
            </button>
        </div>
		
	</div>
</div>

<!-- REFERENCIA HIJOS -->
<div id="ref_formulario_otro" style="display: none">
	<div class="row">
		<input type="hidden" name="id_familiar[]">
		
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Parentesco</label>
                    <select class="form-control" name="parentesco_otros[]">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Parentezco as $tipo){  
                            if($tipo[1] == $dataInforma["parentesco_otros"]){
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
                    <label>Si Tu Respuesta Anterior Fue Otros, Por Favor Especifica</label>
                    <input type="text" class="form-control" name="otros[]" value="" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" name="nombre_otro[]" value="">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Documento de Identidad:</label>
                    <select class="form-control" name="tipo_documento_otros[]">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Tipo_Doc as $tipo){  
                            if($tipo[0] == $dataInforma["tipo_documento"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" name="fecha_nace_otros[]" value="<?php echo $dataInforma["fecha_nace"]; ?>">
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
function validarImagen() {
    var fileSize = $('#foto_familiar')[0].files[0].size;
    console.log(fileSize);
    
    var siezekiloByte = parseInt(fileSize / 1024);
    if (siezekiloByte > 1000 ) {
        alert("La fotografía es demasiado grande. por favor reduzca su tamaño a menos de 1 mega.");
        $('#foto_familiar').val("");
        return false;
    }
}
</script>

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
       
function Eliminar_Familiares(id_registro){
	jQuery.ajax({
		url: api+"eliminar_familiares.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=perfil/ficha/familiares"},
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
        if($dataInforma["numero_hijos"] == 1){
        ?>
        MostrarHijos(1)
        <?php
        }
        ?>
        
});

function EliminarHijo(id){
	if(id > 0){
		jQuery.ajax({
			url: api+"eliminar_hijo.php",
			type:'post',
			data: {id_registro: id, url:"<?php echo $url; ?>?pg=perfil/ficha/familiares"},
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
	else{
		window.location = "<?php echo $url; ?>?pg=perfil/ficha/familiares";
	}
}

function EliminarOtro(id){
	if(id > 0){
		jQuery.ajax({
			url: api+"eliminar_otro.php",
			type:'post',
			data: {id_registro: id, url:"<?php echo $url; ?>?pg=perfil/ficha/familiares"},
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
	else{
		window.location = "<?php echo $url; ?>?pg=perfil/ficha/familiares";
	}
}
</script>



<script>
	function Buscar_hijos(id_cargo){


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
	
	
	
	$(document).ready( function () {
		formulario_hijo = $("#ref_formulario_familia").html();
		formulario_otro = $("#ref_formulario_otro").html();
	});

	function MostrarCantidadHijos(cantidad){
		//$("#lita_hijos").html("");
		$("#lita_hijos").append(formulario_hijo);
	}
	
	function AgregarOtro(){
		//$("#lita_hijos").html("");
		$("#lista_otros").append(formulario_otro);
	}

</script>




