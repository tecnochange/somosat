<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre"] != ""){

        if($_POST["id_registro"] != ""){
                mysqli_query($connect_valentina,"UPDATE Empleados SET nombre = '".$_POST["nombre"]."', apellidos = '".$_POST["apellidos"]."', 
                id_cargo = '".$_POST["id_cargo"]."', correo = '".$_POST["correo"]."', cedula = '".$_POST["cedula"]."', usuario = '".$_POST["usuario"]."', 
                password = '".$_POST["password"]."', estado = '".$_POST["estado"]."', genero = '".$_POST["genero"]."', fecha_nace = '".$_POST["fecha_nace"]."', 
                edad = '".$_POST["edad"]."', fecha_ingreso = '".$_POST["fecha_ingreso"]."', tipo_contrato = '".$_POST["tipo_contrato"]."', role = '".$_POST["role"]."', 
                celular = '".$_POST["celular"]."', direccion = '".$_POST["direccion"]."', ciudad_labor = '".$_POST["ciudad_labor"]."'
                WHERE id = '".$_POST["id_registro"]."'  ");
            
                $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
                ';
        }
        else{
                
            $queryVdl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE cedula = '".$_POST["cedula"]."' ");
            if($queryVdl->num_rows == 0 ){

                mysqli_query($connect_valentina,"INSERT INTO Empleados (nombre, apellidos,  id_cargo, correo, cedula, usuario, 
                password, estado, genero, fecha_nace, edad, fecha_ingreso, tipo_contrato, role, celular, direccion, ciudad_labor,  created_at ) 
                VALUES 
                ( '".$_POST["nombre"]."', '".$_POST["apellidos"]."', '".$_POST["id_cargo"]."', '".$_POST["correo"]."', '".$_POST["cedula"]."', '".$_POST["usuario"]."', 
                '".$_POST["password"]."', '".$_POST["estado"]."', '".$_POST["genero"]."', '".$_POST["fecha_nace"]."', '".$_POST["edad"]."', '".$_POST["fecha_ingreso"]."', 
                '".$_POST["tipo_contrato"]."', '".$_POST["role"]."',
                '".$_POST["celular"]."', '".$_POST["direccion"]."', '".$_POST["ciudad_labor"]."', '".$hoy."' ) ");  
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
	
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);

    $nacimiento = $data["fecha_nace"];
    $anioNace = explode("-", $nacimiento);
    $anioNace = $anioNace[0];
    $edad = (date("Y"))-$anioNace;

    $ingreso = $data["fecha_ingreso"];
    $anioIngresa = explode("-", $ingreso);
    $anioIngresa = $anioIngresa[0];
    $ingreso = (date("Y"))-$anioIngresa;



	
?>

<div class="container-fluid"> 
    
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
    
    <div class="card">
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Datos Básicos</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Nombres</lable>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Apellidos</lable>
                    <input type="text" class="form-control" name="apellidos" value="<?php echo $data["apellidos"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Cargo</lable>
                    <select class="form-control" name="id_cargo">
                        <option value="">Selecciona..</option>
                        <?php
                        $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                        while($dataJer = mysqli_fetch_array($queryJer)){
                            if($data["id_cargo"] == $dataJer["id"] ){
                                echo '<option value="'.$dataJer["id"].'" selected>'.$dataJer["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataJer["id"].'">'.$dataJer["nombre"].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>

               <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Email</lable>
                    <input type="text" class="form-control" name="correo" value="<?php echo $data["correo"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>No. Cédula</lable>
                    <input type="text" class="form-control" name="cedula" value="<?php echo $data["cedula"]; ?>">
                </div>
              
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Usuario</lable>
                    <input type="text" class="form-control" name="usuario" value="<?php echo $data["usuario"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Contraseña</lable>
                    <input type="text" class="form-control" name="password" value="<?php echo $data["password"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Estado</lable>
                    <select class="form-control" name="estado">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Estado as $nivel){
                            if($data["estado"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Role Plataforma</lable>
                    <select class="form-control" name="role" required>
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Role as $nivel){
                            if($data["role"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            } 
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <h2>Datos Complementarios</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Genero</lable>
                    <select class="form-control" name="genero">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Genero as $nivel){
                            if($data["genero"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Fecha Nacimiento</lable>
                    <input type="date" class="form-control" name="fecha_nace" value="<?php echo $data["fecha_nace"]; ?>">
                </div>
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Edad</lable>
                    <input type="text" class="form-control" value="<?php echo $edad; ?>" disabled>
                    <input type="hidden" name="edad" value="<?php echo $edad; ?>">
                </div>
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Fecha de ingreso</lable>
                    <input type="date" class="form-control" name="fecha_ingreso" value="<?php echo $data["fecha_ingreso"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Antiguedad</lable>
                    <input type="text" class="form-control"  value="<?php echo $ingreso; ?>" disabled>
                </div>
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Tipo de Contrato</lable>
                    <select class="form-control" name="tipo_contrato">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Tipo_Contrato as $nivel){
                            if($data["tipo_contrato"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>No. Celular</lable>
                    <input type="text" class="form-control" name="celular" value="<?php echo $data["celular"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Dirección</lable>
                    <input type="text" class="form-control" name="direccion" value="<?php echo $data["direccion"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Ciudad donde Labora</lable>
                    <input type="text" class="form-control" name="ciudad_labor" value="<?php echo $data["ciudad_labor"]; ?>" >
                </div>
                
                <?php if($user_log["role"] == 1){ ?>
                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Guardar
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