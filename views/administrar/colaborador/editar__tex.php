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
    if($_POST["guardar_adicional"] != ""){
        
	   if($_POST["informacion_basica"] != ""){
           
           $sentencia = "UPDATE Empleados SET 
           documentos = '".$_POST["documentos"]."',
           role = '".$_POST["role"]."',  
           estado = '".$_POST["estado"]."',
           WHERE id = '".$_POST["id_registro"]."'  
           ";
           mysqli_query($connect_valentina, $sentencia_adicional);
           $id_tmp = mysqli_insert_id($connect_valentina);
            
           if($_FILES["archivo"]["name"]){
               include("app/controllers/subir_documento.php");
               $archivo = Subir_Documento( $_FILES["archivo"] );
               mysqli_query($connect_valentina,"UPDATE Empleados SET cargar_archivo = '".$archivo."' WHERE id = '".$_POST["id_informacion"]."' ");
           }
                
        
            
           $respuesta = '
               <div class="alert alert-success" role="alert">
                   La información ha sido guardada con éxito.
               </div>
            ';
        
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados (
                id_empleado, 
                documentos, 
                role,
                estado, 
                cargar_archivo,
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                0, 
                '".$_POST["documentos"]."',
                '".$_POST["role"]."', 
                '".$_POST["estado"]."', 
                '', 
                '".$hoy."'
            );
            ";
            
            //print_r($sentencia_adicional);
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                mysqli_query($connect_valentina,"UPDATE Empleados SET cargar_archivo = '".$archivo."' WHERE id = '".$id_tmp."' ");
            }
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
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


<div class="container-fluid"> 
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/colaboradores">Colaboradores</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
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


    <div class="card">

        <div class="card-body"> 
            <h2>Resumen Colaborador</h2>

            <div>
                Nombre: <b><?php echo $data["nombre"]; ?> <?php echo $data["apellidos"]; ?></b><br>
                Cargo: <b><?php echo $data["cargo"]; ?></b><br>
                Nivel: <b><?php echo $data["nivel"]; ?></b><br>
                Gerencia: <b><?php echo $data["gerencia"]; ?></b><br>
                Áreas: <b><?php echo $data["area"]; ?></b><br>
                Documento: <b><?php echo $data["documento"]; ?></b><br>
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
                        <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
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
                    
                    <div class="col-md-12" style="margin-top: 20px">
                        <h2>Adjuntar Documentos</h2>
                        <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                        <input type="hidden" name="informacion_basica" value="true">
                    </div>
                    
                    <div class="col-md-6" style="margin-top: 14px">
                        <lable>Documento a Cargar</lable>
                        <select class="form-control" name="documentos" required>
                            <option value="">Selecciona...</option>
                            <?php
                            foreach($Array_Documentos_cargar as $tipo){  
                                if($tipo[0] == $dataInforma["documentos"]){
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
                        <label><b>Adjuntar un archivo</b></label>
                        <input type="file" id="archivo" name="archivo" class="form-control">
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
    
    <!-- LISTADO -->
    <div class="card">
        <div class="card-body"> 
            
            <table class="table table-bordered">
                <tr>
                    <th>Documento</th>
                    <th>Soporte</th>
                    <th width="60">
                        <a href="<?php echo $url; ?>/?pg=administrar/colaborador/editar__tex">
                        <button type="button" class="btn btn-primary btn-sm">
                            +
                        </button>
                        </a>
                    </th>
                </tr>
                <?php 
                $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
                WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
	            while($dataEmpleados = mysqli_fetch_array($queryEmpleados)){
                    echo '
                    <tr>
                        <td>'.$dataEmpleados["documentos"].'</td>
                        <td>
                            <a href="https://somosat.hr-suite.app//recursos/'.$dataEmpleados["cargar_archivo"].'" target="_blank">
                                '.$dataEmpleados["cargar_archivo"].'
                            </a>
                        </td>
                        <td>
                           <a href="'.$url.'/?pg=administrar/colaborador/editar__tex&acd='.$dataEmpleados["id"].'"> 
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-check"></i>
                            </button>
                            </a>
                            
                            <button type="button" class="btn btn-primary btn-sm" onclick="Eliminar_Editar('.$dataEmpleados["id"].')" >
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
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>