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
                nombre  = '".$_POST["nombre"]."',
                apellidos  = '".$_POST["apellidos"]."',
                preferencia  = '".$_POST["preferencia"]."',
                apodo  = '".$_POST["apodo"]."',
                tipo_doc  = '".$_POST["tipo_doc"]."',    
                documento = '".$_POST["documento"]."', 
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
                area  = '".$_POST["area"]."', 
                departamento  = '".$_POST["departamento"]."',   
                equipo  = '".$_POST["equipo"]."',  
                cargo  = '".$_POST["cargo"]."',  
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
                c_profecional  = '".$_POST["c_profecional"]."',
                fv_docu  = '".$_POST["fv_docu"]."',
                talla_remera = '".$_POST["talla_remera"]."',
                pais_residencia  = '".$_POST["pais_residencia"]."',
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
                mysqli_query($connect_valentina,"UPDATE Empleados_Adicionales SET cargar_archivo = '".$archivo."' WHERE id = '".$_POST["id_informacion_adicional"]."' ");
            }
            

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional= "
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
                c_profecional,
                fv_docu,
                cargar_archivo,
                talla_remera,
                pais_residencia,
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
                '".$_POST["c_profecional"]."',
                '".$_POST["fv_docu"]."',
                '',
                '".$_POST["talla_remera"]."',
                '".$_POST["pais_residencia"]."',
                '".$_POST["departamento_residencia"]."',                
                '".$_POST["ciudad_residencia"]."', 
                '".$_POST["direccion"]."', 
                '".$_POST["cd_postal"]."', 
                '".$_POST["telefono"]."', 
                '".$_POST["celular"]."', 
                '".$_POST["email_p"]."',  
                '".$hoy."', 
                '".$hoy."'                 
            )
            ";
            
           //print_r($sentencia_adicional); 
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                mysqli_query($connect_valentina,"UPDATE Empleados_Adicionales SET cargar_archivo = '".$archivo."' WHERE id = '".$id_tmp."' ");
            }

            
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

    $queryPosicion = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE codigo = '".$data["codigo_posicion"]."' ");
	$dataPosicion = mysqli_fetch_array($queryPosicion);
    

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

    $fecha_actual = date("Y-m-d");
    $fecha_fven = $dataInforma["fecha_vencimiento"];
    $fecha_fvp = $dataInforma["fecha_vencimiento_p"];
    $fecha_fvd = $dataInforma["fv_docu"];
    

        function dias_vencer($fecha_actual,$fecha_fven,$fecha_fvp,$fecha_fvd){
        $dias_fven = (strtotime($fecha_fven)-strtotime($fecha_actual))/86400;
        $dias_fven = abs($dias_fven); 
        $dias_fven = floor($dias_fven);
            
        $dias_fvp = (strtotime($fecha_fvp)-strtotime($fecha_actual))/86400;
        $dias_fvp = abs($dias_fvp); 
        $dias_fvp = floor($dias_fvp);
            
        $dias_fvd = (strtotime($fecha_fvd)-strtotime($fecha_actual))/86400;
        $dias_fvd = abs($dias_fvd); 
        $dias_fvd = floor($dias_fvd);
        
            
        if($dias_fven < 15){
            echo('<div class="alert alert-danger" role="alert">
                faltan '.$dias_fven.' dias para vencer su Documento.
                </div>');
        };
        if($dias_fvp < 15){
            echo('<div class="alert alert-danger" role="alert">
                    faltan '.$dias_fvp.' dias para vencer su Pasaporte.
                </div>');
        };
        if($dias_fvd < 15){
            echo('<div class="alert alert-danger" role="alert">
                    faltan '.$dias_fvd.' dias para vencer su documento de caja profesional.
                </div>');
        };
            
    };
    echo dias_vencer( $fecha_actual, $fecha_fven,$fecha_fvp,$fecha_fvd );
   

//print_r($dataInforma);
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
                
                <div class="col-md-12" style="margin-bottom: 50px">
                    <h2>Datos Personales</h2>
                    <input type="hidden" name="id_informacion_adicional" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-12"style="margin-bottom: 30px">
                    <h2>Identificación</h2>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Nombres:</label>
                    <input type="text"  class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Apellidos:</label>
                    <input type="text"  class="form-control" name="apellidos" value="<?php echo $data["apellidos"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Nombre de Preferencia:</label>
                    <input type="text"  class="form-control" name="preferencia" value="<?php echo $dataInforma["preferencia"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Apodo:</label>
                    <input type="text"  class="form-control" name="apodo" value="<?php echo $dataInforma["apodo"]; ?>" >
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
                    <label>Fecha de Vencimiento</label>
                    <input type="date"  class="form-control" name="fecha_vencimiento" value="<?php echo $dataInforma["fecha_vencimiento"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Pasaporte</label>
                    <input type="text"  class="form-control" name="pasaporte" value="<?php echo $dataInforma["pasaporte"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha de Vencimiento</label>
                    <input type="date"  class="form-control" name="fecha_vencimiento_p" value="<?php echo $dataInforma["fecha_vencimiento_p"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Credencial Cívica:</label>
                    <input type="text"  class="form-control" name="credencial_civica" value="<?php echo $dataInforma["credencial_civica"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
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
                
<!-- DATOS LABORALES -->  
                
                <div class="col-md-12" style="margin-bottom: 30px; margin-top: 30px">
                    <h2>Datos Laborales</h2>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha de Ingreso</label>
                    <input type="date" class="form-control" name="fecha_ingreso" value="<?php echo $dataInforma["fecha_ingreso"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Código de colaborador AT</label>
                    <input type="text" class="form-control" name="cod_colaborador" value="<?php echo $dataInforma["cod_colaborador"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Mail Corporativo de AT:</label>
                    <input type="text" class="form-control" name="correo" placeholder="@" value="<?php echo $data["correo"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Áreas:</label>
                    <input type="text" class="form-control" name="area"  value="<?php echo $data["area"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Departamento:</label>
                    <input type="text" class="form-control" name="departamento"  value="<?php echo $dataInforma["departamento"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label for="lastName">Equipo:</label>
                    <input type="text" class="form-control" name="equipo"  value="<?php echo $dataInforma["equipo"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Cargo:</label>
                    <select class="form-control" name="cargo" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                            while($dataCargo = mysqli_fetch_array($queryCargo)){
                                if($data["cargo"] == $dataCargo["nombre"] ){
                                    echo '<option value="'.$dataCargo["nombre"].'" selected>'.$dataCargo["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataCargo["nombre"].'">'.$dataCargo["nombre"].' </option>';
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
                
                <div class="col-md-4" style="margin-bottom: 10px">
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
                
                <div class="col-md-4 cajas_dotacion" style="margin-bottom: 10px">
                    <label>Razón social:</label>
                    <input type="text" class="form-control" name="r_social"  value="<?php echo $dataInforma["r_social"]; ?>" >
                </div>
             
                <div class="col-md-4 cajas_dotacion" style="margin-bottom: 10px">
                    <label>Dirección Fiscal:</label>
                    <input type="text" class="form-control" name="dr_fisica"  value="<?php echo $dataInforma["dr_fisica"]; ?>" >
                </div>
                <div class="col-md-4 cajas_dotacion" style="margin-bottom: 10px">
                    <label>RUT:</label>
                    <input type="text" class="form-control" name="rut"  value="<?php echo $dataInforma["rut"]; ?>" >
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Banco:</label>
                    <input type="text" class="form-control" name="banco"  value="<?php echo $dataInforma["banco"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Tipo de cuenta:</label>
                    <input type="text" class="form-control" name="t_cuenta"  value="<?php echo $dataInforma["t_cuenta"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Número de cuenta:</label>
                    <input type="text" class="form-control" name="cuenta"  value="<?php echo $dataInforma["cuenta"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>AFAP</label>
                    <select class="form-control" name="afap" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_AFAP as $tipo){  
                            if($tipo[1] == $dataInforma["afap"]){
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
                    <label>Caja Profesional:</label>
                    <input type="text" class="form-control" name="c_profecional"  value="<?php echo $dataInforma["c_profecional"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>fecha de vencimiento de documento:</label>
                    <input type="date" class="form-control" name="fv_docu"  value="<?php echo $dataInforma["fv_docu"]; ?>" >
                </div>
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label><b>Adjuntar un archivo</b></label>
                    <input type="file" id="archivo" name="archivo" class="form-control">
                </div>
                
 <!-- vestimenta -->               
                <div class="col-md-12" style="margin-bottom: 30px; margin-top: 40px">
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
                
  <!-- datos de contacto -->              
                <div class="col-md-12" style="margin-bottom: 30px; margin-top: 40px">
                    <h2>Datos de Contacto</h2>
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
                    <label for="lastName">Ciudad de residencia:</label>
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



