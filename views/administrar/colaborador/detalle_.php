<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	if($_SESSION["role"] != 1){
		echo '
		<script>
			window.location = "https://somosat.hr-suite.app/";
		</script>
		';
	}

    //CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["informacion_basica"] != ""){
        //EDITAR
        if($_POST["id_registro"] != ""){
            $sentencia = "
            UPDATE Empleados SET nombre = '".$_POST["nombre"]."', nombre_2 = '".$_POST["nombre_2"]."', 
            apellidos = '".$_POST["apellidos"]."', apellidos_2 = '".$_POST["apellidos_2"]."', 
            password = '".$_POST["password"]."', correo = '".$_POST["correo"]."', correo_2 = '".$_POST["correo_2"]."', 
            movil = '".$_POST["movil"]."', contacto = '".$_POST["contacto"]."', tipo_documento = '".$_POST["tipo_documento"]."', 
            no_documento = '".$_POST["no_documento"]."', id_cargo = '".$_POST["id_cargo"]."', id_posicion = '".$_POST["id_posicion"]."', 
            regional = '".$_POST["regional"]."', role = '".$_POST["role"]."',  estado = '".$_POST["estado"]."' 
            WHERE id = '".$_POST["id_registro"]."'  
            ";
            mysqli_query($connect_valentina, $sentencia);
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        //CREAR
        else{
            $queryVdl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE cedula = '".$_POST["cedula"]."' ");
            if($queryVdl->num_rows == 0 ){
                $sentencia = "INSERT INTO Empleados (
                    nombre, nombre_2, 
                    apellidos, apellidos_2, 
                    password, correo , correo_2, 
                    movil , contacto , tipo_documento , 
                    no_documento , id_cargo , id_posicion, 
                    regional, role, role_seleccion,  estado, created_at  
                ) 
                VALUES 
                ( 
                    '".$_POST["nombre"]."', '".$_POST["nombre_2"]."', 
                    '".$_POST["apellidos"]."', '".$_POST["apellidos_2"]."', 
                    '".$_POST["password"]."', '".$_POST["correo"]."', '".$_POST["correo_2"]."', 
                    '".$_POST["movil"]."', '".$_POST["contacto"]."', '".$_POST["tipo_documento"]."', 
                   '".$_POST["no_documento"]."', '".$_POST["id_cargo"]."', '".$_POST["id_posicion"]."', 
                    '".$_POST["regional"]."', '".$_POST["role"]."', 3,  '".$_POST["estado"]."', '".$hoy."' 
                ) 
                ";
                mysqli_query($connect_valentina, $sentencia); 
                echo '<script> window.location = "?pg=administrar/colaboradores";</script>';//para evitar reinsersion  
            }
             else{
                $respuesta = '
                <div class="alert alert-danger" role="alert">
                  Lo sentimos, este usuario ya se encuentra registrado en el sistema.
                </div>
                ';
            }
        }
 
        
	}



	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["guardar_adicional"] != ""){

        //EDITAR
        if($_POST["id_registro_adicional"] != ""){
            
            $sentencia = "
                UPDATE Empleados_Informacion SET 
                fecha_nace = '".$_POST["nombre"]."',
                sexo_biologico = '".$_POST["nombre"]."',
                genero = '".$_POST["nombre"]."',
                fecha_ingreso = '".$_POST["nombre"]."',
                tipo_contrato = '".$_POST["nombre"]."',
                factor_salario = '".$_POST["nombre"]."',
                salario_base = '".$_POST["nombre"]."',
                tipo_salario = '".$_POST["nombre"]."',
                cod_area = '".$_POST["nombre"]."',
                talla_camisa = '".$_POST["nombre"]."',
                talla_chaqueta = '".$_POST["nombre"]."',
                talla_zapato = '".$_POST["nombre"]."',
                talla_pantalon = '".$_POST["nombre"]."',
                canal = '".$_POST["nombre"]."' 
                WHERE id = '".$_POST["id_registro"]."' 
            ";
            
            print_r($sentencia);
            
            //mysqli_query($connect_valentina, $sentencia);
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        //CREAR
        else{
            $sentencia = "
            INSERT INTO Empleados_Informacion (
                id_empleado, 
                fecha_nace, 
                sexo_biologico, 
                genero, 
                fecha_ingreso, 
                tipo_contrato, 
                factor_salario, 
                salario_base, 
                tipo_salario, 
                cod_area, 
                talla_camisa, 
                talla_chaqueta, 
                talla_zapato, 
                talla_pantalon, 
                canal, 
                created_at
            ) 
            VALUES 
            ( 
                '".$id."', 
                '".$_POST["fecha_nace"]."',  
                '".$_POST["sexo_biologico"]."',  
                '".$_POST["genero"]."',  
                '".$_POST["fecha_ingreso"]."',  
                '".$_POST["tipo_contrato"]."',  
                '".$_POST["factor_salario"]."',  
                '".$_POST["salario_base"]."',  
                '".$_POST["tipo_salario"]."',  
                '".$_POST["cod_area"]."',  
                '".$_POST["talla_camisa"]."',  
                '".$_POST["talla_chaqueta"]."',  
                '".$_POST["talla_zapato"]."',  
                '".$_POST["talla_pantalon"]."',  
                '".$_POST["canal"]."',
                '".$hoy."'
            ) 

            ";
            
            //print_r($sentencia);
            mysqli_query($connect_valentina, $sentencia); 
            echo '<script> window.location = "?pg=administrar/colaboradores";</script>';//para evitar reinsersion  

            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Datos Almacenados.
                </div>
            ';
            
        }
 
        
	}
	
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);

    $queryAdicional = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Informacion WHERE id_empleado = '".$id."' ");
	$dataAdicional = mysqli_fetch_array($queryAdicional);

	
    

    $id_posicion = 0;

    if($id){
        $id_posicion = $data["id_posicion"];
    }

    $nacimiento = $data["fecha_nace"];
    $anioNace = explode("-", $nacimiento);
    $anioNace = $anioNace[0];
    $edad = (date("Y"))-$anioNace;

    $ingreso = $data["fecha_ingreso"];
    $anioIngresa = explode("-", $ingreso);
    $anioIngresa = $anioIngresa[0];
    $ingreso = (date("Y"))-$anioIngresa;



	
?>




<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <?php if($dtEmpleado["role"] == 1){ ?>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/colaboradores">Administrar Colabordores</a></li>
          <?php } ?>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Colaborador</a></li>
      </ol>
</nav>

<?php echo $respuesta; ?>

<!-- PESTAÑAS -->
    <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/editar" class="nav-link ">Básicos</a>
            </li>
            <?php if($_SESSION["id_colaborador_edit"]){ ?>

            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link">Adicionales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/perfil" class="nav-link ">P. Ocupacional</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/preferencia" class="nav-link ">Preferencias</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/academico" class="nav-link active ">Académico</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/laboral" class="nav-link ">Laboral</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/trayectoria" class="nav-link">Trayectoria</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/familiares" class="nav-link">Familiares</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/emergencia" class="nav-link">En Caso de Emergencia</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/juridica" class="nav-link" >Jurídica</a>
            </li>
            <?php } ?>
    </ul>
    
<div class="card">
        
    <div class="card-body">   
    
        <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Datos Básicos</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                    <input type="hidden" name="informacion_basica" value="true">
                </div>
                
                <div class="col-md-5" style="margin-bottom: 10px">
                    <label>* Cargo</label>
                    <select class="form-control" name="id_cargo" required onChange="Cargar_Posiciones(this.value)" >
                        <option value="">Selecciona..</option>
                        <?php
                            $nombre_cargo = "";
                            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                            while($dataCargo = mysqli_fetch_array($queryCargo)){
                                if($data["id_cargo"] == $dataCargo["id"] ){
                                    $nombre_cargo = $dataCargo["nombre"];
                                    echo '<option value="'.$dataCargo["id"].'" selected>'.$dataCargo["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataCargo["id"].'">'.$dataCargo["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-7" style="margin-bottom: 10px">
                    <label>* Posición</label>
                    <select class="form-control" name="id_posicion" required id="id_posicion" >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryPosicion = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE id_cargo = '".$data["id_cargo"]."' ORDER BY ciudad ASC ");  
                            while($dataPosicion = mysqli_fetch_array($queryPosicion)){
                                if($data["id_posicion"] == $dataPosicion["id"] ){
                                    echo '<option value="'.$dataPosicion["id"].'" selected>'.$nombre_cargo.' -  '.$dataPosicion["ciudad"].' - '.$dataPosicion["codigo"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataPosicion["id"].'">'.$nombre_cargo.' - '.$dataPosicion["ciudad"].' - '.$dataPosicion["codigo"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                
                
                <div class="col-md-4" >
                    <label>Primer Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Segundo Nombre</label>
                    <input type="text" class="form-control" name="nombre_2" value="<?php echo $data["nombre_2"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Primer Apellido</label>
                    <input type="text" class="form-control" name="apellidos" value="<?php echo $data["apellidos"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Segundo Apellido</label>
                    <input type="text" class="form-control" name="apellidos_2" value="<?php echo $data["apellidos_2"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Contraseña</label>
                    <input type="text" class="form-control" name="password" value="<?php echo $data["password"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Correro Usuario</label>
                    <input type="text" class="form-control" name="correo" value="<?php echo $data["correo"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Correo Contacto</label>
                    <input type="text" class="form-control" name="correo_2" value="<?php echo $data["correo_2"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Móvil</label>
                    <input type="text" class="form-control" name="movil" value="<?php echo $data["movil"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Número Móvil Corporativo</label>
                    <input type="text" class="form-control" name="contacto" value="<?php echo $data["contacto"]; ?>">
                </div>
                
                <div class="col-md-4" >
                    <label>Tipo Documento</label>
                    <select type="text" class="form-control" name="tipo_documento">
                        <option value="">...</option>
                        <?php
                        foreach($Array_Tipo_Doc_Empleado as $nivel){
                            if($data["tipo_documento"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4" >
                    <label>Numero Documento</label>
                    <input type="text" class="form-control" name="no_documento" value="<?php echo $data["no_documento"]; ?>">
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
                    <select class="form-control" name="estado" required>
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
                
                <?php if($user_log["role"] == 1){ ?>
                <div class="col-md-12" style=" margin-top: 15px; margin-bottom: 10px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Guardar
                    </button>
                </div>
                <?php } ?>

            </div>
        </form>
    </div>
</div>
                
                
                

                
<div class="card">
        
    <div class="card-body">   
    
        <form action="" method="post">
            <div class="row">
                
                <div class="col-md-12" style="margin-top: 20px" >
                    <h3>Información Adicional</h3>
                    <input type="hidden" name="guardar_adicional" value="true">
                    <input type="hidden" name="id_registro_adicional" value="<?php echo $dataAdicional["id"]; ?>">
                    
                </div>
                

                <div class="col-md-4" >
                    <label>Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nace" value="<?php echo $dataAdicional["fecha_nace"]; ?>">
                </div>
                
                <div class="col-md-4" >
                    <label>Sexo Biológico</label>
                    <select type="text" class="form-control" name="sexo_biologico" >
                        <option value="">...</option>
                        <?php
                        foreach($Array_Sexo_Empleado as $nivel){
                            if($dataAdicional["sexo_biologico"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                

                <div class="col-md-4" >
                    <label>Identidad de Genero</label>
                    <select type="text" class="form-control" name="genero" value="<?php echo $dataAdicional["genero"]; ?>">
                        <option value="">...</option>
                        <?php
                        foreach($Array_Sexo_Empleado as $nivel){
                            if($dataAdicional["genero"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4" >
                    <label>Regional</label>
                    <input type="text" class="form-control" name="regional" value="<?php echo $dataAdicional["regional"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Fecha Ingreso</label>
                    <input type="date" class="form-control" name="fecha_ingreso" value="<?php echo $dataAdicional["fecha_ingreso"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Tipo Contrato</label>
                    <input type="text" class="form-control" name="tipo_contrato" value="<?php echo $dataAdicional["tipo_contrato"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Factor Salarial</label>
                    <input type="text" class="form-control" name="factor_salario" value="<?php echo $dataAdicional["factor_salario"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Salario Base</label>
                    <input type="text" class="form-control" name="salario_base" value="<?php echo $dataAdicional["salario_base"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Tipo Salario</label>
                    <input type="text" class="form-control" name="tipo_salario" value="<?php echo $dataAdicional["tipo_salario"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Codigo Área</label>
                    <input type="text" class="form-control" name="cod_area" value="<?php echo $dataAdicional["cod_area"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Talla Camisa</label>
                    <input type="text" class="form-control" name="talla_camisa" value="<?php echo $dataAdicional["talla_camisa"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Talla Chaqueta</label>
                    <input type="text" class="form-control" name="talla_chaqueta" value="<?php echo $dataAdicional["talla_chaqueta"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Talla Zapatos</label>
                    <input type="text" class="form-control" name="talla_zapato" value="<?php echo $dataAdicional["talla_zapato"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Talla Pantalón</label>
                    <input type="text" class="form-control" name="talla_pantalon" value="<?php echo $dataAdicional["talla_pantalon"]; ?>">
                </div>

                <div class="col-md-4" >
                    <label>Canal</label>
                    <input type="text" class="form-control" name="canal" value="<?php echo $dataAdicional["canal"]; ?>">
                </div>

                
                
                <?php if($user_log["role"] == 1){ ?>
                <div class="col-md-12" style=" margin-top: 15px; margin-bottom: 10px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Guardar
                    </button>
                </div>
                <?php } ?>

            </div>
        </form>
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