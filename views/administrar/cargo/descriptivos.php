<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_cargos").addClass("active_item");
});
</script>

<?php
	if($_GET["id"]){
        $_SESSION["id_cargo_edit"] = $_GET["id"];
    }

	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

    //CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["proposito"] != ""){

		if($_POST["id_registro_adicional"] != ""){
            
            $sentencia = "UPDATE Cargos_Descriptivo SET 
            proposito = '".$_POST["proposito"]."',
            decisiones_tomar = '".$_POST["decisiones_tomar"]."',  
            decisiones_consulta = '".$_POST["decisiones_consulta"]."', 
            responsabilidades_sg = '".$_POST["responsabilidades_sg"]."',  
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
            
            $txt_nivel_educativo = '';
            foreach($Array_Nivel_edu as $nivel){
                if($_POST["nivel_educativo"] == $nivel[0] ){ $txt_nivel_educativo = $nivel[1]; }
            }
            
            $txt_nivel_educativo_avanzazdo = '';
            foreach($Array_Nivel_edu as $nivel){
                if($_POST["nivel_educativo_avanzado"] == $nivel[0] ){ $txt_nivel_educativo_avanzazdo = $nivel[1]; }
            }
            
            $comentario = 'Cargo edición - descriptivo: 
                Nombre Cargo: '.$_POST["nombre_cargo"].'
                Proposito: '.$_POST["proposito"].'
                Decisiones que debe tomar: '.$_POST["decisiones_tomar"].'  
                Decisiones que debe consultar: '.$_POST["decisiones_consulta"].' 
                Responsabilidades SG: '.$_POST["responsabilidades_sg"].'  
                Nivel Educativo: '.$txt_nivel_educativo.' 
                Títulos requeridos: '.$_POST["titulos_requeridos"].'  
                Nivel Educativo Avanzado: '.$txt_nivel_educativo_avanzazdo.', 
                Titulos Avanzados Requeridos: '.$_POST["titulos_avanzado_requeridos"].' 
                Conocimientos Especificos: '.$_POST["conocimientos_especificos"].' 
                Conocimientos técnicos: '.$_POST["conocimientos_tecnicos"].'  
                Experiencia total area: '.$_POST["experiencia_total_area"].' 
                Experiencia total años: '.$_POST["experiencia_total_años"].'  
                Experiencia específica_areas: '.$_POST["experiencia_específica_areas"].'  
                Experiencia especifica_anios: '.$_POST["experiencia_especifica_anios"].' 
                Internas: '.$_POST["internas"].'
                Externas: '.$_POST["externas"].' 
                No. de Salarios Variables: '.$_POST["salarios_variable"].' 
            ';

            //CUANDO ES ADMINSITRADOR SE REALIZA EL REGISTRO
            if($user_log["role"] == 1 || $user_log["role"] == 8 ){
                mysqli_query($connect_valentina, $sentencia); 
            }
            
            //CUANDO ES JEFE DEBE SOLICITAR AUTORIZACION
            if($user_log["role"] == 2){
                $id_tmp = $_POST["id_registro_adicional"];
                $sku = time(); 
                $tipo = 4; // Cargo Actualizado
                include("views/administrar/cargo/controller_autorizaciones.php");
            }

            //ESTA LINEA DE CODIGO GUARDA LA NOVEDAD DEL NUEVO REGISTRO
            $ClassNovedades->Novedad( 
                $_SESSION['id_user_valentina'], 
                "Cargos Edición - Descriptivo", 
                4, 
                $sentencia, 
                $connect_valentina, 
                $_SESSION["id_cargo_edit"], 
                $comentario 
            );
            //ESTA LINEA DE CODIGO GUARDA LA NOVEDAD DEL NUEVO REGISTRO
            
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
            
            $txt_nivel_educativo = '';
            foreach($Array_Nivel_edu as $nivel){
                if($_POST["nivel_educativo"] == $nivel[0] ){ $txt_nivel_educativo = $nivel[1]; }
            }
            
            $txt_nivel_educativo_avanzazdo = '';
            foreach($Array_Nivel_edu as $nivel){
                if($_POST["nivel_educativo_avanzado"] == $nivel[0] ){ $txt_nivel_educativo_avanzazdo = $nivel[1]; }
            }
            
            $comentario = 'Cargo edición - descriptivo: 
                Nombre Cargo: '.$_POST["nombre_cargo"].'
                Proposito: '.$_POST["proposito"].'
                Decisiones que debe tomar: '.$_POST["decisiones_tomar"].'  
                Decisiones que debe consultar: '.$_POST["decisiones_consulta"].' 
                Responsabilidades SG: '.$_POST["responsabilidades_sg"].'  
                Nivel Educativo: '.$txt_nivel_educativo.' 
                Títulos requeridos: '.$_POST["titulos_requeridos"].'  
                Nivel Educativo Avanzado: '.$txt_nivel_educativo_avanzazdo.', 
                Titulos Avanzados Requeridos: '.$_POST["titulos_avanzado_requeridos"].' 
                Conocimientos Especificos: '.$_POST["conocimientos_especificos"].' 
                Conocimientos técnicos: '.$_POST["conocimientos_tecnicos"].'  
                Experiencia total area: '.$_POST["experiencia_total_area"].' 
                Experiencia total años: '.$_POST["experiencia_total_años"].'  
                Experiencia específica_areas: '.$_POST["experiencia_específica_areas"].' 
                Experiencia especifica_anios: '.$_POST["experiencia_especifica_anios"].'
                Internas: '.$_POST["internas"].' 
                Externas: '.$_POST["externas"].' 
                No. de Salarios Variables: '.$_POST["salarios_variable"].' 
            ';

            //CUANDO ES ADMINSITRADOR SE REALIZA EL REGISTRO
            if($user_log["role"] == 1 || $user_log["role"] == 8){
                mysqli_query($connect_valentina, $sentencia); 
            }
            
            //CUANDO ES JEFE DEBE SOLICITAR AUTORIZACION
            if($user_log["role"] == 2){
                $id_tmp = 0;
                $sku = time(); 
                $tipo = 4; //cargo actualizado 
                
                include("views/administrar/cargo/controller_autorizaciones.php");
            }

            //ESTA LINEA DE CODIGO GUARDA LA NOVEDAD DEL NUEVO REGISTRO
            $ClassNovedades->Novedad( 
                $_SESSION['id_user_valentina'], 
                "Cargo creación - descriptivo", 
                4, //Cargo actualizado
                $sentencia, 
                $connect_valentina, 
                $_SESSION["id_cargo_edit"], 
                $comentario 
            );
            //ESTA LINEA DE CODIGO GUARDA LA NOVEDAD DEL NUEVO REGISTRO

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
            
            $comentario = 'Cargo edición - descriptivo: 
                Nombre Cargo: '.$_POST["nombre_cargo"].'
                Que hace: '.$_POST["que_hace"].'
                Cómo lo hace: '.$_POST["como_hace"].'  
                Para qué lo hace: '.$_POST["para_hace"].' 
            ';

            //CUANDO ES ADMINSITRADOR SE REALIZA EL REGISTRO
            if($user_log["role"] == 1 || $user_log["role"] == 8){
                mysqli_query($connect_valentina, $sentencia); 
            }
            
            //CUANDO ES JEFE DEBE SOLICITAR AUTORIZACION
            if($user_log["role"] == 2){
                $id_tmp = $_SESSION["id_cargo_edit"];
                $sku = time(); 
                $tipo = 6; //funcion actualizada
                include("views/administrar/cargo/controller_autorizaciones.php");
            }

            //ESTA LINEA DE CODIGO GUARDA LA NOVEDAD DEL NUEVO REGISTRO
            $ClassNovedades->Novedad( 
                $_SESSION['id_user_valentina'], 
                "Cargo Edición - Función descriptivo", 
                6, //funcion actualizada
                $sentencia, 
                $connect_valentina, 
                $_SESSION["id_cargo_edit"], 
                $comentario 
            );
            //ESTA LINEA DE CODIGO GUARDA LA NOVEDAD DEL NUEVO REGISTRO
			
            
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

            $comentario = 'Cargo edición - descriptivo: 
                Nombre Cargo: '.$_POST["nombre_cargo"].'
                Que hace: '.$_POST["que_hace"].'
                Cómo lo hace: '.$_POST["como_hace"].'  
                Para qué lo hace: '.$_POST["para_hace"].' 
            ';

            //CUANDO ES ADMINSITRADOR SE REALIZA EL REGISTRO
            if($user_log["role"] == 1 || $user_log["role"] == 8){
                mysqli_query($connect_valentina, $sentencia); 
            }
            
            //CUANDO ES JEFE DEBE SOLICITAR AUTORIZACION
            if($user_log["role"] == 2){
                $id_tmp = 0;
                $sku = time(); 
                $tipo = 5; // funcion nueva 

                include("views/administrar/cargo/controller_autorizaciones.php");
            }

            //ESTA LINEA DE CODIGO GUARDA LA NOVEDAD DEL NUEVO REGISTRO
            $ClassNovedades->Novedad( 
                $_SESSION['id_user_valentina'], 
                "Cargos - Descriptivo - Creación Función", 
                5, //funcion nueva 
                $sentencia, 
                $connect_valentina, 
                $_SESSION["id_cargo_edit"], 
                $comentario
            );
            //ESTA LINEA DE CODIGO GUARDA LA NOVEDAD DEL NUEVO REGISTRO
            
            echo '<script> window.location = "'.$ulr.'?pg=administrar/cargo/descriptivo"; </script>';
			
		}
}

	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$_SESSION["id_cargo_edit"]."'  ");
	$data = mysqli_fetch_array($query);	

    $queryDescriptivo = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Descriptivo WHERE id_cargo = '".$_SESSION["id_cargo_edit"]."'  ");
    $dataDescriptivo = mysqli_fetch_array($queryDescriptivo);
?>

<!-- CABECERA -->
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
          
<?php include("views/administrar/layouts/ficha_funciones.php"); ?>

<?php echo $respuesta; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-body">
                    
                    <!-- NAVEGACION -->
                    <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                        
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo $url; ?>?pg=administrar/cargo/detalle">
                                <i class="icofont icofont-business-man"></i>Configuración
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $url; ?>?pg=administrar/cargo/areas">
                                <i class="icofont icofont-contact-add"></i>Áreas
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link active"  href="<?php echo $url; ?>?pg=administrar/cargo/descriptivo">
                                <i class="icofont icofont-list"></i>Descriptivo
                            </a>
                        </li>
                        <li class="nav-item" style="display: none">
                            <a class="nav-link" href="<?php echo $url; ?>?pg=administrar/cargo/remuneracion">
                                <i class="icofont icofont-coins"></i>Remuneración
                            </a>
                        </li>
                        <li class="nav-item" style="display: none">
                            <a class="nav-link" href="<?php echo $url; ?>?pg=administrar/cargo/politica">
                                <i class="icofont icofont-law-alt-3"></i>Política
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $url; ?>?pg=administrar/cargo/valoracion">
                                <i class="icofont icofont-paper"></i>Valoración
                            </a>
                        </li>
                    </ul>
                    <!-- FIN NAVEGACION -->
                    
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
                                
                                <div class="col-md-12">
                                    <h5>Propósito</h5>
                                </div>

                                <div class="col-md-12" style="margin-bottom: 10px">
                                    <textarea rows="4" class="form-control" name="proposito"><?php echo $dataDescriptivo["proposito"]; ?></textarea>
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <h5>Funciones</h5>
                                </div>
                                
                                
                                <!-- FUNCIONES -->
                                <div class="col-md-12" style="margin-bottom: 10px">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Que hace</th>
                                            <th>Cómo lo hace</th>
                                            <th>Para qué lo hace</th>
                                            <th width="60">
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target=".modal_funciones" onclick="Borrar()" >
                                                    +
                                                </button>
                                            </th>
                                        </tr>
                                        <?php 
                                        $query = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Funciones 
                                        WHERE id_cargo = '".$_SESSION["id_cargo_edit"]."'  ");
	                                    while($data = mysqli_fetch_array($query)){
                                            echo '
                                            <tr>
                                                <td>'.nl2br($data["que_hace"]).'</td>
                                                <td>'.nl2br($data["como_hace"]).'</td>
                                                <td>'.nl2br($data["para_hace"]).'</td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target=".modal_funciones" onclick="DatosFuncion('.$data["id"].')" >
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            ';   
                                        }	
                                        ?>
                                    </table>
                                </div>
                               
                                
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <h5>Decisiones</h5>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Decisiones que debe tomar</label>
                                    <textarea rows="4" class="form-control" name="decisiones_tomar"><?php echo $dataDescriptivo["decisiones_tomar"]; ?></textarea>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Decisiones que debe Consultar</label>
                                    <textarea rows="4" class="form-control" name="decisiones_consulta"><?php echo $dataDescriptivo["decisiones_consulta"]; ?></textarea>
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <h5>Responsabilidades en el SG-SST</h5>
                                </div>

                                <div class="col-md-12" style="margin-bottom: 10px">
                                    <select class="form-control" name="responsabilidades_sg" onChange="DatosResponsabilidadesSG(this.value)">
                                        <option value="">Selecciona..</option>
                                        <?php
                                        $descriptivo = "";
                                        $queryRepon = mysqli_query($connect_valentina,"SELECT * FROM Responsabilidades_SG_SST 
                                        WHERE estado = 1  ");
	                                    while($dataRepon = mysqli_fetch_array($queryRepon)){
                                            if($dataDescriptivo["responsabilidades_sg"] == $dataRepon["nombre"] ){
                                                echo '<option value="'.$dataRepon["nombre"].'" selected>'.$dataRepon["nombre"].'</option>';
                                                $descriptivo = $dataRepon["descripcion"];
                                            }
                                            else{
                                                echo '<option value="'.$dataRepon["nombre"].'">'.$dataRepon["nombre"].'</option>';
                                            }
                                            
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <div id="descripcion_responsabilidades_sg">
                                        <?php echo nl2br($descriptivo); ?>
                                    </div>
                                </div>

                                
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <h5>Requisitos Académicos</h5>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Nivel Educativo</div>
                                    <select class="form-control" name="nivel_educativo">
                                        <option value="">Selecciona..</option>
                                        <?php
                                        foreach($Array_Nivel_edu as $nivel){
                                             if($dataDescriptivo["nivel_educativo"] == $nivel[0] ){
                                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                                            }
                                            else{
                                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Nivel Educativo Avanzado</div>
                                    <select class="form-control" name="nivel_educativo_avanzado">
                                        <option value="">Selecciona..</option>
                                        <?php
                                        foreach($Array_Nivel_Educativo_Avanzado as $nivel){
                                             if($dataDescriptivo["nivel_educativo_avanzado"] == $nivel[0] ){
                                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                                            }
                                            else{
                                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Títulos Requeridos</div>
                                    <textarea rows="4" class="form-control" name="titulos_requeridos"><?php echo $dataDescriptivo["titulos_requeridos"]; ?></textarea>
                                </div>

                                

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Títulos Avanzado Requeridos</div>
                                    <textarea rows="4" class="form-control" name="titulos_avanzado_requeridos"><?php echo $dataDescriptivo["titulos_avanzado_requeridos"]; ?></textarea>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Conocimientos Específicos</div>
                                    <textarea rows="4" class="form-control" name="conocimientos_especificos"><?php echo $dataDescriptivo["conocimientos_especificos"]; ?></textarea>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Conocimientos Técnicos</div>
                                    <textarea rows="4" class="form-control" name="conocimientos_tecnicos"><?php echo $dataDescriptivo["conocimientos_tecnicos"]; ?></textarea>
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <h5>Experiencia</h5>
                                </div>
                                
                                <div class="col-md-4" style="margin-bottom: 10px">
                                    <label>Experiencia Total</label>
                                    <input style="text" class="form-control" name="experiencia_total_años" value="<?php echo $dataDescriptivo["experiencia_total_años"]; ?>">
                                </div>

                                <div class="col-md-8" style="margin-bottom: 10px">
                                    <label>Experiencia Total</label>
                                    <input style="text" class="form-control" name="experiencia_total_area" value="<?php echo $dataDescriptivo["experiencia_total_area"]; ?>">
                                </div>


                                <div class="col-md-4" style="margin-bottom: 10px">
                                    <label>Experiencia Específica Años</label>
                                    <input style="text" class="form-control" name="experiencia_especifica_anios" value="<?php echo $dataDescriptivo["experiencia_especifica_anios"]; ?>">
                                </div>
                                
                                <div class="col-md-8" style="margin-bottom: 10px">
                                    <label>Experiencia Específica</label>
                                    <input style="text" class="form-control" name="experiencia_específica_areas" value="<?php echo $dataDescriptivo["experiencia_específica_areas"]; ?>">
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Internas</label>
                                    <input style="text" class="form-control" name="internas" value="<?php echo $dataDescriptivo["internas"]; ?>">
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Externas</label>
                                    <input style="text" class="form-control" name="externas" value="<?php echo $dataDescriptivo["externas"]; ?>">
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Número de salarios variables</label>
                                    <input style="text" class="form-control" name="salarios_variable" value="<?php echo $dataDescriptivo["salarios_variable"]; ?>">
                                </div>
                                
                                <?php 
                                    if($user_log["role"] == 2 || $user_log["role"] == 5){ 
                                        include("views/administrar/cargo/autorizaciones.php"); 
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
