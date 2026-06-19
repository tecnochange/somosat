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

    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    if($_POST["guardar_adicional"] != ""){

        if($_POST["id_informacion_adicional"] != ""){
            
            $sentencia = "
            UPDATE Empleados_Adicionales SET 
                tipo_doc  = '".$_POST["tipo_doc"]."',
                documento = '".$_POST["documento"]."', 
                fecha_nacimiento = '".$_POST["fecha_nacimiento"]."', 
                edad = '".$_POST["edad"]."',
                genero = '".$_POST["genero"]."', 
                estado_civil = '".$_POST["estado_civil"]."', 
                compania  = '".$_POST["compania"]."',
                tipo_contrato  = '".$_POST["tipo_contrato"]."',
                pais_residencia  = '".$_POST["pais_residencia"]."',
                departamento_residencia  = '".$_POST["departamento_residencia"]."',
                ciudad_residencia  = '".$_POST["ciudad_residencia"]."', 
                direccion  = '".$_POST["direccion"]."',
                estrato   = '".$_POST["estrato"]."',
                telefono  = '".$_POST["telefono"]."',
                celular = '".$_POST["celular"]."',
                email_c = '".$_POST["email_c"]."',
                email_p = '".$_POST["email_p"]."',
                n_hijos  = '".$_POST["n_hijos"]."', 
                n_personas  = '".$_POST["n_personas"]."',
                nivel_academico  = '".$_POST["nivel_academico"]."',
                situacion  = '".$_POST["situacion"]."',
                eps = '".$_POST["eps"]."',
                afp  = '".$_POST["afp"]."',
                libreta_no  = '".$_POST["libreta_no"]."',
                libreta_clase  = '".$_POST["libreta_clase"]."', 
                libreta_distrito  = '".$_POST["libreta_distrito"]."', 
                nacionalidad  = '".$_POST["nacionalidad"]."',
                pais_nacimiento = '".$_POST["pais_nacimiento"]."', 
                departamento_nacimiento  = '".$_POST["departamento_nacimiento"]."', 
                ciudad_nacimiento = '".$_POST["ciudad_nacimiento"]."',  
                sexo_biologico = '".$_POST["sexo_biologico"]."',                   
                fecha_ingreso = '".$_POST["fecha_ingreso"]."',                    
                factor_salarial = '".$_POST["factor_salarial"]."',   
                salario_base = '".$_POST["salario_base"]."',   
                salario_total = '".$_POST["salario_total"]."',   
                salario_flexibilizado = '".$_POST["salario_flexibilizado"]."',   
                tipo_salario = '".$_POST["tipo_salario"]."',   
                hora_extra = '".$_POST["hora_extra"]."',
                capacitacion = '".$_POST["capacitacion"]."',
                dotacion_aplica = '".$_POST["dotacion_aplica"]."',  
                dotacion_tipo = '".$_POST["dotacion_tipo"]."', 
                people = '".$_POST["people"]."', 
                fecha = '".$_POST["fecha"]."',  
                valor = '".$_POST["valor"]."', 
                talla_remera = '".$_POST["talla_remera"]."', 
                grupo_sanguineo = '".$_POST["grupo_sanguineo"]."',   
                factor_rh = '".$_POST["factor_rh"]."',  
                embarazada = '".$_POST["embarazada"]."', 
                fuero_paternidad = '".$_POST["fuero_paternidad"]."', 
                incapacidad_permanente = '".$_POST["incapacidad_permanente"]."',  
                pre_pensionado = '".$_POST["pre_pensionado"]."',  
                estratos = '".$_POST["estratos"]."',  
                vivienda = '".$_POST["vivienda"]."',
                tenencia = '".$_POST["tenencia"]."',
                cantidad = '".$_POST["cantidad"]."',
                servicios = '".implode(";", $_POST["servicios"])."', 
                condicion_vivienda = '".$_POST["condicion_vivienda"]."',
                material_predominante = '".$_POST["material_predominante"]."',
                material_pisos = '".$_POST["material_pisos"]."',
                material_baño = '".$_POST["material_baño"]."',
                elementos = '".implode(";", $_POST["elementos"])."',
                adquirir_vivienda = '".$_POST["adquirir_vivienda"]."',
                credito_vivienda = '".$_POST["credito_vivienda"]."',
                credito = '".$_POST["credito"]."',
                mejora_locativa = '".$_POST["mejora_locativa"]."',
                mejoras = '".$_POST["mejoras"]."',
                credito_vehiculos = '".$_POST["credito_vehiculos"]."',
                credito_vehiculo = '".$_POST["credito_vehiculo"]."',
                convives = '".implode(";", $_POST["convives"])."',
                mascotas = '".implode(";", $_POST["mascotas"])."',
                n_mascotas = '".implode(";", $_POST["n_mascotas"])."',
                cuidado_especial = '".$_POST["cuidado_especial"]."',
                gastos = '".$_POST["gastos"]."',
                cabeza_familia = '".$_POST["cabeza_familia"]."'
                WHERE id = '".$_POST["id_informacion_adicional"]."'
            ";
             
            echo $sentencia;
            
            mysqli_query($connect_valentina, $sentencia);

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia = "
            INSERT INTO Empleados_Adicionales (
                id_empleado,
                tipo_doc,
                documento, 
                fecha_nacimiento,
                edad,
                genero,
                estado_civil,
                compania,
                tipo_contrato,
                pais_residencia,
                departamento_residencia,
                ciudad_residencia, 
                direccion,
                estrato,
                telefono,
                celular,
                email_c,
                email_p,
                n_hijos,
                n_personas,
                nivel_academico,
                situacion,
                eps,
                afp,
                libreta_no,
                libreta_clase,
                libreta_distrito,
                nacionalidad, 
                pais_nacimiento, 
                departamento_nacimiento, 
                ciudad_nacimiento, 
                sexo_biologico,                 
                fecha_ingreso,                  
                factor_salarial, 
                salario_base, 
                salario_total, 
                salario_flexibilizado, 
                tipo_salario,
                hora_extra,
                capacitacion,
                dotacion_aplica, 
                dotacion_tipo,
                people,
                fecha,
                valor,
                talla_remera,
                grupo_sanguineo, 
                factor_rh, 
                embarazada,
                fuero_paternidad,
                incapacidad_permanente,
                pre_pensionado,
                estratos, 
                vivienda,
                tenencia,
                cantidad,
                servicios,
                condicion_vivienda,
                material_predominante,
                material_pisos,
                material_baño,
                elementos,
                adquirir_vivienda,
                credito_vivienda,
                credito,
                mejora_locativa,
                mejoras,
                credito_vehiculos,
                credito_vehiculo,
                convives,
                mascotas,
                n_mascotas,
                cuidado_especial,
                gastos,
                cabeza_familia,
                created_at,
                update_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                '".$_POST["tipo_doc"]."',
                '".$_POST["documento"]."',
                '".$_POST["fecha_nacimiento"]."',
                '".$_POST["edad"]."', 
                '".$_POST["genero"]."', 
                '".$_POST["estado_civil"]."', 
                '".$_POST["compania"]."', 
                '".$_POST["tipo_contrato"]."', 
                '".$_POST["pais_residencia"]."',
                '".$_POST["departamento_residencia"]."',                
                '".$_POST["ciudad_residencia"]."', 
                '".$_POST["direccion"]."', 
                '".$_POST["estrato"]."', 
                '".$_POST["telefono"]."', 
                '".$_POST["celular"]."', 
                '".$_POST["email_c"]."', 
                '".$_POST["email_p"]."', 
                '".$_POST["n_hijos"]."', 
                '".$_POST["n_personas"]."', 
                '".$_POST["nivel_academico"]."',
                '".$_POST["situacion"]."',
                '".$_POST["eps"]."', 
                '".$_POST["afp"]."',  
                '".$_POST["libreta_no"]."', 
                '".$_POST["libreta_clase"]."', 
                '".$_POST["libreta_distrito"]."', 
                '".$_POST["nacionalidad"]."', 
                '".$_POST["pais_nacimiento"]."',
                '".$_POST["departamento_nacimiento"]."',
                '".$_POST["ciudad_nacimiento"]."', 
                '".$_POST["sexo_biologico"]."', 
                '".$_POST["fecha_ingreso"]."',
                '".$_POST["factor_salarial"]."', 
                '".$_POST["salario_base"]."', 
                '".$_POST["salario_total"]."', 
                '".$_POST["salario_flexibilizado"]."', 
                '".$_POST["tipo_salario"]."', 
                '".$_POST["hora_extra"]."',
                '".$_POST["capacitacion"]."',
                '".$_POST["dotacion_aplica"]."', 
                '".$_POST["dotacion_tipo"]."', 
                '".$_POST["people"]."', 
                '".$_POST["fecha"]."',
                '".$_POST["valor"]."',
                '".$_POST["talla_remera"]."',                
                '".$_POST["grupo_sanguineo"]."',
                '".$_POST["factor_rh"]."',
                '".$_POST["embarazada"]."',
                '".$_POST["fuero_paternidad"]."',
                '".$_POST["incapacidad_permanente"]."',
                '".$_POST["pre_pensionado"]."',
                '".$_POST["estratos"]."',
                '".$_POST["vivienda"]."',
                '".$_POST["tenencia"]."',
                '".$_POST["cantidad"]."',
                '".implode(";", $_POST["servicios"])."', 
                '".$_POST["condicion_vivienda"]."',
                '".$_POST["material_predominante"]."',
                '".$_POST["material_pisos"]."',
                '".$_POST["material_baño"]."',
                '".implode(";", $_POST["elementos"])."', 
                '".$_POST["adquirir_vivienda"]."',
                '".$_POST["credito_vivienda"]."',
                '".$_POST["credito"]."',
                '".$_POST["mejora_locativa"]."',
                '".$_POST["mejoras"]."',
                '".$_POST["credito_vehiculos"]."',
                '".$_POST["credito_vehiculo"]."',
                '".implode(";", $_POST["convives"])."', 
                '".implode(";", $_POST["mascotas"])."', 
                '".implode(";", $_POST["n_mascotas"])."', 
                '".$_POST["cuidado_especial"]."',
                '".$_POST["gastos"]."',
                '".$_POST["cabeza_familia"]."',
                '".$hoy."', 
                '".$hoy."' 
                
            )
            ";
            
            //echo $sentencia;
            
            mysqli_query($connect_valentina, $sentencia); 
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';
        }
	}
	
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);  


    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $queryCity = mysqli_query($connect_valentina,"SELECT * FROM Municipios WHERE codigo = '".$data["id_municipio"]."' ");
	$dataCity = mysqli_fetch_array($queryCity);
    

    $firstDate = $dataInforma["fecha_nacimiento"];
    $secondDate = date("Y-m-d");
    $dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

    $years  = floor($dateDifference / (365 * 60 * 60 * 24));
    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
    
                    
    $decimal2 = ($months*30+$days)/365;
    $decimal2 = round($decimal2, 1);
    $parte2 = explode(".", $decimal2);
                    
    $edad =  $years.".".$parte2[1]." años";

?>


<div class="container-fluid"> 
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/colaboradores">Colaboradores</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
      </ol>
    </nav>
    
    <?php echo $respuesta; ?>

    <div class="card">
        
        <!-- PESTAÑAS -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/editar" class="nav-link ">Básicos</a>
            </li>
            <?php if($_SESSION["id_colaborador_edit"]){ ?>

            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link active">Adicionales</a>
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
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/laboral" class="nav-link ">Experiencia laboral previa</a>
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
            <?php } ?>
        </ul>
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">
<!-- informacion Adicional -->
                
                <div class="col-md-12">
                    <h2>Datos Personales</h2>
                    <input type="hidden" name="id_informacion_adicional" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Documento de Identidad</label>
                    <select class="form-control" name="tipo_doc">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Tipo_Doc as $tipo){  
                            if($tipo[0] == $dataInforma["tipo_doc"]){
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
                    <label>Número de Documento</label>
                    <input type="text"  class="form-control" name="documento" value="<?php echo $data["documento"]; ?>">
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
                    <label>Estado civil *</label>
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
                    <label>Compañía</label>
                    <select class="form-control" name="compania" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Compania as $tipo){  
                            if($tipo[0] == $dataInforma["compania"]){
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
                    <label>Tipo de contrato *</label>
                    <select class="form-control" name="tipo_contrato" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Tipo_Contratos as $tipo){  
                            if($tipo[0] == $dataInforma["tipo_contrato"]){
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
                    <label for="lastName">Pais Residencia</label>
                    <select class="form-control" name="pais_residencia">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Pais_Residencia as $tipo){ 
							if($tipo[0] == 1){
							
							
								if($tipo[0] == $dataInforma["pais_residencia"]){
									echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
								}
								else{
									echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
								}
							}
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
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

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Ciudad de residencia</label>
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
                    <label>Dirección de Residencia</label>
                    <input type="text" class="form-control" name="direccion" value="<?php echo $dataInforma["direccion"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label>Estrato social</label>
                    <select class="form-control" name="estrato">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Estratos as $tipo){  
                            if($tipo[0] == $dataInforma["estrato"]){
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
                    <label for="lastName">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" placeholder="" value="<?php echo $dataInforma["telefono"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Celular:</label>
                    <input type="text" class="form-control" name="celular" value="<?php echo $dataInforma["celular"]; ?>" >
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">E-mail Corporativo:</label>
                    <input type="text" class="form-control" name="email_c" placeholder="@" value="<?php echo $dataInforma["email_c"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">E-mail Personal:</label>
                    <input type="text" class="form-control" name="email_p" placeholder="@" value="<?php echo $dataInforma["email_p"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Número de Hijos:</label>
                    <input type="text" class="form-control" name="n_hijos" value="<?php echo $dataInforma["n_hijos"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Número de Personas Convive:</label>
                    <input type="text" class="form-control" name="n_personas" value="<?php echo $dataInforma["n_personas"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Nivel Académico: *</label>
                    <select class="form-control" name="nivel_academico" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Nivel_Formacion as $tipo){  
                            if($tipo[1] == $dataInforma["nivel_academico"]){
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
                    <label for="lastName">Situación *</label>
                    <select class="form-control" name="situacion" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Situacion as $tipo){  
                            if($tipo[1] == $dataInforma["situacion"]){
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
                    <label for="lastName">Prestador de Salud:</label>
                    <select class="form-control" name="eps" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Mutualistas as $tipo){  
                            if($tipo[1] == $dataInforma["eps"]){
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
                    <label for="lastName">Emergencia médica :</label>
                    <select class="form-control" name="afp" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Emergencia_medica as $tipo){  
                            if($tipo[1] == $dataInforma["afp"]){
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
                    <label>AFAP</label>
                    <select class="form-control" name="libreta_no" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_AFAP as $tipo){  
                            if($tipo[1] == $dataInforma["libreta_no"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label>Libreta Militar Clase</label>
                    <input type="text" class="form-control" name="libreta_clase" value="<?php echo $dataInforma["libreta_clase"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label>Libreta Militar Distrito</label>
                    <input type="text" class="form-control" name="libreta_distrito" value="<?php echo $dataInforma["libreta_distrito"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nacionalidad</label>
                    <select class="form-control" name="nacionalidad">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Nacionalidad as $role){  
                            if($role[0] == $dataInforma["nacionalidad"]){
                                echo '<option value="'.$role[0].'" selected>'.$role[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$role[0].'">'.$role[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="lastName">País Nacimiento</label>
                    <select class="form-control" name="pais_nacimiento" id="pais_nacimiento">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Pais_Nac as $role){
							if($role[0] == 1){
							
								if($role[0] == $dataInforma["pais_nacimiento"]){
									echo '<option value="'.$role[0].'" selected>'.$role[1].'</option>';  
								}
								else{
									echo '<option value="'.$role[0].'">'.$role[1].'</option>';
								}
							}
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="lastName">Departamento Nacimiento</label>
                    <select class="form-control" name="departamento_nacimiento" id="departamento_nacimiento" onChange="CargarCiudadesNacimiento(this.value)">
                        <option value="">Selecciona...</option>
						
						<?php
						$queryDep = mysqli_query($connect_valentina,"SELECT * FROM Departamentos WHERE id_pais = 1 ORDER BY departamento ASC ");
						while($dataDep = mysqli_fetch_array($queryDep) ){
							if($dataDep['id_departamento'] == $dataInforma["departamento_nacimiento"]){
                                echo '<option value="'.$dataDep['id_departamento'].'" selected>'.$dataDep['departamento'].'</option>';  
                            }
                            else{
                                echo '<option value="'.$dataDep['id_departamento'].'">'.$dataDep['departamento'].'</option>';
                            }
						}
                        ?>	
                    </select>
                </div>
 
                <div class="col-md-4">
                    <label for="lastName">Ciudad Nacimiento</label>
                    <select class="form-control" name="ciudad_nacimiento" id="ciudad_nacimiento">
                        <option value="">Selecciona...</option>
						<?php
						$queryCity = mysqli_query($connect_valentina,"SELECT * FROM Municipios WHERE id_municipio <= 1100  ORDER BY municipio ASC ");
						while($dataCity = mysqli_fetch_array($queryCity) ){
							if($dataCity['id_municipio'] == $dataInforma["ciudad_nacimiento"]){
                                echo '<option value="'.$dataCity['id_municipio'].'" selected>'.$dataCity['municipio'].'</option>';  
                            }
                            else{
                                echo '<option value="'.$dataCity['id_municipio'].'">'.$dataCity['municipio'].'</option>';
                            }
						}
                        ?>
                    </select>
                </div>
                

                <div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label>Sexo Biológico *</label>
                    <select class="form-control" name="sexo_biologico" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Sexo_Biologico as $tipo){  
                            if($tipo[0] == $dataInforma["sexo_biologico"]){
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
                    <label>Fecha de Ingreso</label>
                    <input type="date" class="form-control" name="fecha_ingreso" value="<?php echo $dataInforma["fecha_ingreso"]; ?>">
                </div>

                <?php if( $user_log['role'] == 1 ){ ?> 
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Sueldo nominal base</label>
                    <input type="text" class="form-control" name="factor_salarial" value="<?php echo $dataInforma["factor_salarial"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Partida en tickets alimentación</label>
                    <input type="text" class="form-control" name="salario_base" value="<?php echo $dataInforma["salario_base"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Complemento outsourcing</label>
                    <input type="text" class="form-control" name="salario_total" value="<?php echo $dataInforma["salario_total"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Viático </label>
                    <input type="text" class="form-control" name="salario_flexibilizado" value="<?php echo $dataInforma["salario_flexibilizado"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <labeL>Guardia </labeL>
                    <input type="text" class="form-control" name="tipo_salario" value="<?php echo $dataInforma["tipo_salario"]; ?>">
                </div> 
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <labeL>Hora extra </labeL>
                    <input type="text" class="form-control" name="hora_extra" value="<?php echo $dataInforma["hora_extra"]; ?>">
                </div> 
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <labeL>% de capacitación </labeL>
                    <input type="text" class="form-control" name="capacitacion" value="<?php echo $dataInforma["capacitacion"]; ?>">
                </div>
                
                <?php } ?>
                
<!-- Dotacion -->
                
                
                <div class="col-md-12">
                    <h2>Vestimenta</h2>
                </div>
                <!-- off
                <div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label>Aplica Uniforme *</label>
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
                    if(valor == 1){
                        $(".cajas_dotacion").show();
                    }
                    if(valor == 2){
                        $(".cajas_dotacion").hide();
                    }
                }
                </script>
                
                <style>
                    .cajas_dotacion{
                        display: none;
                    }
                </style>
                
                <div class="col-md-4 cajas_dotacion" style="margin-bottom: 10px; display: none">
                    <label>Tipo Uniforme *</label>
                    <select class="form-control" name="dotacion_tipo" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Dotacion_Tipo as $tipo){  
                            if($tipo[0] == $dataInforma["dotacion_tipo"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
             
                <div class="col-md-4 cajas_dotacion" style="margin-bottom: 10px; display: none">
                    <label>People Pass</label>
                    <select class="form-control" name="people">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_People_Pass as $tipo){  
                            if($tipo[1] == $dataInforma["people"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4 cajas_dotacion" style="margin-bottom: 10px; display: none">
                    <label>Fecha</label>
                    <input type="date"  class="form-control" name="fecha" value="<?php echo $dataInforma["fecha"]; ?>">
                </div>
                
                <div class="col-md-4 cajas_dotacion" style="margin-bottom: 10px; display: none">
                    <label>Valor</label>
                    <input type="text"  class="form-control" name="valor" value="<?php echo $dataInforma["valor"]; ?>">
                </div>  
                -->
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

<!-- Información Personal
                <div class="col-md-12">
                    <h2>Información Personal</h2>
                </div>
              
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Grupo Sanguineo</label>
                    <select class="form-control" name="grupo_sanguineo">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Grupo_Sanguineo as $tipo){  
                            if($tipo[1] == $dataInforma["grupo_sanguineo"]){
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
                    <label>Factor RH</label>
                    <select class="form-control" name="factor_rh">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Factor as $tipo){  
                            if($tipo[1] == $dataInforma["factor_rh"]){
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
                    <label>Embarazada:</label>
                    <select class="form-control" name="embarazada">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Embarazada as $tipo){  
                            if($tipo[1] == $dataInforma["embarazada"]){
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
                    <label>Fuero Paternidad:</label>
                    <select class="form-control" name="fuero_paternidad">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Fuero_Paternidad as $tipo){  
                            if($tipo[1] == $dataInforma["fuero_paternidad"]){
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
                    <label>Incapacidad Permanente:</label>
                    <select class="form-control" name="incapacidad_permanente">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Incapacidad_Permanente as $tipo){  
                            if($tipo[1] == $dataInforma["incapacidad_permanente"]){
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
                    <label>Pre Pensionado:</label>
                    <select class="form-control" name="pre_pensionado">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Pre_Pensionado as $tipo){  
                            if($tipo[1] == $dataInforma["pre_pensionado"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                -->
                
<!-- ubicacion -->    
                
                <div class="col-md-12">
                    <h2>Ubicaciones</h2>
                </div>
                 
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label>¿A que estrato socioeconómico perteneces?</label>
                    <select class="form-control" name="estratos">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Estratos as $tipo){  
                            if($tipo[0] == $dataInforma["estratos"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label>¿Cuál es tu tipo de vivienda actual?</label>
                    <select class="form-control" name="vivienda">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_vivienda as $tipo){  
                            if($tipo[0] == $dataInforma["vivienda"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label>¿Cuál es el tipo de tenencia de la vivienda en la que resides?</label>
                    <select class="form-control" name="tenencia">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_tenencia as $tipo){  
                            if($tipo[0] == $dataInforma["tenencia"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label>Indica la cantidad de habitaciones de la vivienda.</label>
                    <input type="text" class="form-control" name="cantidad" value="<?php echo $dataInforma["cantidad"]; ?>">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>La vivienda cuenta con cual de los siguientes servicios</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["servicios"]);
                        foreach($Array_servicios as $tipo){  
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
                                        <input type="checkbox" name="servicios[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label>¿Cuál es el estado actual de la vivienda en la que vives?</label>
                    <select class="form-control" name="condicion_vivienda">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Condicion_Vivienda as $tipo){  
                            if($tipo[0] == $dataInforma["condicion_vivienda"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label>Indica el material predominante en el que está construida la vivienda</label>
                    <select class="form-control" name="material_predominante">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Material_Predominante as $tipo){  
                            if($tipo[0] == $dataInforma["material_predominante"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label>¿Cuál es el material predominante  de los pisos  de la vivienda?</label>
                    <select class="form-control" name="material_pisos">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Material_Pisos as $tipo){  
                            if($tipo[0] == $dataInforma["material_pisos"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label>¿El material predominante del baño está?</label>
                    <select class="form-control" name="material_baño">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Material_Baño as $tipo){  
                            if($tipo[0] == $dataInforma["material_baño"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>El baño cuenta con cual de los siguientes elementos</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["elementos"]);
                        foreach($Array_Elementos as $tipo){  
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
                                        <input type="checkbox" name="elementos[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label>¿Tiene planes de adquirir vivienda propia en un lapso no mayor a 1 año?</label>
                    <select class="form-control" name="adquirir_vivienda">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Adquirir_Vivienda as $tipo){  
                            if($tipo[0] == $dataInforma["adquirir_vivienda"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label>¿Tiene actualmente crédito de vivienda o leasing habitacional?</label>
                    <select class="form-control" name="credito_vivienda">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Credito_Vivienda as $tipo){  
                            if($tipo[0] == $dataInforma["credito_vivienda"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                    
                    <input type="text" class="form-control" name="credito" value="<?php echo $dataInforma["credito"]; ?>" style="margin-top: 3px" placeholder="Si tu respuesta es Si, favor especifica qué entidad:"></input>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label>¿Tienes contemplado en un plazo de 1 año realizar mejoras locativas a tu vivienda?</label>
                    <select class="form-control" name="mejora_locativa">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Mejora_Locativa as $tipo){  
                            if($tipo[0] == $dataInforma["mejora_locativa"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                    <input type="text" class="form-control" name="mejoras" value="<?php echo $dataInforma["mejoras"]; ?>" style="margin-top: 3px" placeholder="Si tu respuesta es Si, favor especifica:"></input>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label>¿Actualmente pagas crédito de vehículo o moto?</label>
                    <select class="form-control" name="credito_vehiculos">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Credito_Vehiculos as $tipo){  
                            if($tipo[0] == $dataInforma["credito_vehiculos"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                    <input type="text" class="form-control" name="credito_vehiculo" value="<?php echo $dataInforma["credito_vehiculo"]; ?>" style="margin-top: 3px" placeholder="Si contestas Si, especifica con que entidad tienes el crédito:"></input>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>¿Con quien convives?</b></label>
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
                    <label><b>Si tu respuesta anterior fue mascotas, por favor especifica el tipo y la cantidad</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["mascotas"] , $dataInforma["n_mascotas"]); 
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
                                    <td align="center" width="63">
                                        <input type="text" name="n_mascotas[]"  class="form-control"  value="'.$dataInforma["n_mascotas"].'">
                                        </input>   
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
                    <label>Indica si alguno de los mienbros con los que convives requiere un cuidado especial que amerite tiempo adicional en tu jornada laboral</label>
                    <textarea type="text" class="form-control" name="cuidado_especial" style="margin-top: 3px"><?php echo $dataInforma["cuidado_especial"]; ?></textarea>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>¿Los gastos del hogar son asumidos por?</label>
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
                    <label>¿Eres madre o padre cabeza de familia? Recuerda que este estado es cuando no recibes ningún apoyo de la ex pareja y respondes sol@ por los gastos del hogar</label>
                    <select class="form-control" name="cabeza_familia">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Cabeza_familia as $tipo){  
                            if($tipo[0] == $dataInforma["cabeza_familia"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                
                

                <?php if($dtEmpleado["role"] == 1 || $_SESSION["id_colaborador_edit"] == $_SESSION['id_user_seleccion'] ){ ?>
                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-primary btn-block" >
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
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>

<script>
var api = '<?php echo $url; ?>/api/administrar/';

function Cargar_Posiciones(id_cargo){
	
	
	jQuery.ajax({
		url: api+"cargar_posiciones.php",
		type:'post',
		data: {id_cargo: id_cargo, id_posicion: <?php echo $id_posicion; ?>, url:""},
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
    
    //PARA CAMBIAR A MAYUSCULAS
    $(document).ready( function () {
        $("input").on("keypress", function () {
           $input=$(this);
           setTimeout(function () {
            $input.val($input.val().toUpperCase());
           },50);
        });
        
        
        <?php
        if($dataInforma["dotacion_aplica"] == 1){
        ?>
        MostrarDotacion(1)
        <?php
        }
        ?>
        
    });

    
  
</script>



