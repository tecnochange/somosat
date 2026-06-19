<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

    if($_GET["id"]){
        $_SESSION["id_colaborador_edit"] = $_GET["id"];
    }


    //CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["informacion_basica"] != ""){
        $sentencia = "UPDATE Empleados SET role = '".$_POST["role"]."',  estado = '".$_POST["estado"]."' WHERE id = '".$_POST["id_registro"]."'  ";
        mysqli_query($connect_valentina, $sentencia);
            
        $respuesta = '
            <div class="alert alert-success" role="alert">
                La información ha sido guardada con éxito.
            </div>
        ';
        
    }

	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);

    $queryPosicion = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE codigo = '".$data["codigo_posicion"]."' ");
	$dataPosicion = mysqli_fetch_array($queryPosicion);

    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");
	$dataCargo = mysqli_fetch_array($queryCargo);

    $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."'  ");
    $dataArea = mysqli_fetch_array($queryArea);
    
    $queryGerencia = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_gerencia"]."'  ");
    $dataGerencia = mysqli_fetch_array($queryGerencia);




    $txt_role = '';
    foreach($Array_Role as $role){
        if($role[0] == $data["role"]){  $txt_role = $role[1]; }
    }
                        
    $txt_estado = '';
    foreach($Array_Estado  as $estado){
        if($estado[0] == $data["estado"]){  $txt_estado = $estado[1]; }
    }

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
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/editar" class="nav-link active">Básicos</a>
            </li>
            <?php if($_SESSION["id_colaborador_edit"]){ ?>

            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link">Adicionales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/perfil" class="nav-link">P. Ocupacional</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/preferencia" class="nav-link">Preferencias</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/academico" class="nav-link ">Académico</a>
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
            <?php } ?>
        </ul>

<div class="card">
        
    <div class="card-body"> 
        <h2>Resumen Colaborador</h2>
        
        <div>
            Nombre: <b><?php echo $data["nombre"]; ?></b><br>
            Apellidos: <b><?php echo $data["apellidos"]; ?></b><br>
            Cargo: <b><?php echo $dataCargo["nombre"]; ?></b><br>
            Gerencia: <b><?php echo $dataGerencia["nombre"]; ?></b><br>
            Área: <b><?php echo $dataArea["nombre"]; ?></b><br>
            Documento: <b><?php echo $data["documento"]; ?></b><br>
            Contraseña: <b><?php echo $data["password"]; ?></b><br>
            Correo: <b><?php echo $data["correo"]; ?></b><br>
            Role: <b><?php echo $txt_role; ?></b><br>
            Estado: <b><?php echo $txt_estado; ?></b><br>
        </div>
        
    </div>
</div>
  
<div class="card" style="margin-top: 12px">
        
    <div class="card-body">   
    
        <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Datos Básicos</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $_SESSION["id_colaborador_edit"]; ?>">
                    <input type="hidden" name="informacion_basica" value="true">
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
             

<script>
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>
