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

        if($_POST["id_informacion"] != ""){
            
            $sentencia_adicional = "
            UPDATE Empleados_Emergencia SET 
                nombres1 = '".$_POST["nombres1"]."',
                parentezco1 = '".$_POST["parentezco1"]."',    
                telefono1 = '".$_POST["telefono1"]."',  
                direccion1 = '".$_POST["direccion1"]."',
                nombres2 = '".$_POST["nombres2"]."',
                parentezco2 = '".$_POST["parentezco2"]."',    
                telefono2 = '".$_POST["telefono2"]."',  
                direccion2 = '".$_POST["direccion2"]."',
                nombres3 = '".$_POST["nombres3"]."',
                parentezco3 = '".$_POST["parentezco3"]."',    
                telefono3 = '".$_POST["telefono3"]."',  
                direccion3 = '".$_POST["direccion3"]."',
                update_at = '".$hoy."'
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            
                        
            //print_r($sentencia_adicional);
            mysqli_query($connect_valentina, $sentencia_adicional);

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Emergencia (
                id_empleado, 
                nombres1,
                parentezco1, 
                telefono1, 
                direccion1,
                nombres2,
                parentezco2, 
                telefono2, 
                direccion2,
                nombres3,
                parentezco3, 
                telefono3, 
                direccion3,
                created_at, 
                update_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."',   
                '".$_POST["nombres1"]."',  
                '".$_POST["parentezco1"]."',
                '".$_POST["telefono1"]."', 
                '".$_POST["direccion1"]."',
                '".$_POST["nombres2"]."',  
                '".$_POST["parentezco2"]."',
                '".$_POST["telefono2"]."', 
                '".$_POST["direccion2"]."',
                '".$_POST["nombres3"]."',  
                '".$_POST["parentezco3"]."',
                '".$_POST["telefono3"]."', 
                '".$_POST["direccion3"]."',
                '".$hoy."', 
                '".$hoy."' 
            )
            ";
            //echo $sentencia;
            //print_r($sentencia_adicional);
            
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
 
        
	}
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Emergencia WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);


?>



<div class="container"> 
    
    <?php include("views/administrar/colaborador/navegacion.php"); ?>
    
    <?php echo $respuesta; ?>

	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/detalle" class="nav-link ">Básicos</a>
		</li>
		<?php if($_SESSION["id_colaborador_edit"]){ ?>

		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link ">Datos Personales</a>
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
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/emergencia" class="nav-link active">En Caso de Emergencia</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/remuneracion" class="nav-link"> Remuneración</a>
		</li>
		<?php } ?>
	</ul>
        
    <!-- LISTADO -->
    <div class="card">
        <div class="card-body"> 
            
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 30px">
                    <h2>En caso de presentar alguna emergencia indícanos con quienes podemos comunicarnos: </h2>
                </div>
<!-- bloque 1 -->
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <h2>Opción 1: </h2>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" name="nombres1" value="<?php echo $dataInforma["nombres1"]; ?>" required>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Parentesco</label>
                    <select class="form-control" name="parentezco1" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Parentezco as $tipo){  
                            if($tipo[1] == $dataInforma["parentezco1"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Teléfono de Contacto:</label>
                    <input type="text" class="form-control" name="telefono1" value="<?php echo $dataInforma["telefono1"]; ?>" required>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Dirección:</label>
                    <input type="text" class="form-control" name="direccion1" value="<?php echo $dataInforma["direccion1"]; ?>">
                </div>
                
<!-- bloque 2 --> 
                
                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 20px">
                    <h2>Opción 2: </h2>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" name="nombres2" value="<?php echo $dataInforma["nombres2"]; ?>" >
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Parentesco</label>
                    <select class="form-control" name="parentezco2" >
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Parentezco as $tipo){  
                            if($tipo[1] == $dataInforma["parentezco2"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Teléfono de Contacto:</label>
                    <input type="text" class="form-control" name="telefono2" value="<?php echo $dataInforma["telefono2"]; ?>" >
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Dirección:</label>
                    <input type="text" class="form-control" name="direccion2" value="<?php echo $dataInforma["direccion2"]; ?>">
                </div>
                
<!-- bloque 3 -->  
                
                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 20px">
                    <h2>Opción 3: </h2>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" name="nombres3" value="<?php echo $dataInforma["nombres3"]; ?>" >
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Parentesco</label>
                    <select class="form-control" name="parentezco3" >
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Parentezco as $tipo){  
                            if($tipo[1] == $dataInforma["parentezco3"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Teléfono de Contacto:</label>
                    <input type="text" class="form-control" name="telefono3" value="<?php echo $dataInforma["telefono3"]; ?>" >
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Dirección:</label>
                    <input type="text" class="form-control" name="direccion3" value="<?php echo $dataInforma["direccion3"]; ?>">
                </div>
                
                <?php if($dtEmpleado["role"] == 1 || $_SESSION["id_colaborador_edit"] == $_SESSION['id_user_seleccion'] ){ ?>
                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 20px">
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
    
function Eliminar_Emergencia(id_registro){
	jQuery.ajax({
		url: api+"eliminar_emergencia.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>/?pg=administrar/colaborador/emergencia"},
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
    });

</script>




