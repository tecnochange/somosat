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
            UPDATE Empleados_Trayectoria SET 
                cargo = '".$_POST["cargo"]."', 
                fecha_inicia = '".$_POST["fecha_inicia"]."', 
                fecha_fin = '".$_POST["fecha_fin"]."', 
                vigente = '".$_POST["vigente"]."',
                resumen = '".$_POST["resumen"]."'  
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            mysqli_query($connect_valentina, $sentencia_adicional);
            
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Trayectoria (
                id_empleado, 
                documento, 
                cargo,
                fecha_inicia, 
                fecha_fin, 
                vigente,
                resumen, 
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."',  
                0,
                '".$_POST["cargo"]."',
                '".$_POST["fecha_inicia"]."', 
                '".$_POST["fecha_fin"]."', 
                '".$_POST["vigente"]."', 
                '".$_POST["resumen"]."', 
                '".$hoy."'
            );
            ";

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

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id = '".$_GET["tra"]."' ");
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
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/trayectoria" class="nav-link active">Trayectoria en AT</a>
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
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>

                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Cargo</label>
                    <input type="text" class="form-control" name="cargo" value="<?php echo $dataInforma["cargo"]; ?>" required>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha Inicio</label>
                    <input type="date" class="form-control" name="fecha_inicia" value="<?php echo $dataInforma["fecha_inicia"]; ?>" required>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha Fin</label>
                    <input type="date" class="form-control" name="fecha_fin" value="<?php echo $dataInforma["fecha_fin"]; ?>">
                </div>
				
				<?php
				$chequed = '';
				if($dataInforma["vigente"] == 'on'){
					$chequed = 'checked';
				}
				?>
                
                <div class="col-md-4 " style="margin-bottom: 10px">
                    <label>Vigente</label><br>
					<input  type="checkbox" class="form-check-input" style="width: 31px; height: 35px" name="vigente" <?php echo $chequed; ?>>
                </div>              
                
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Resumen de Tareas</label>
                    <textarea class="form-control" name="resumen"><?php echo $dataInforma["resumen"]; ?></textarea>
                </div>

                <?php if($dtEmpleado["role"] == 1 || $_SESSION["id_colaborador_edit"] == $_SESSION['id_user_seleccion'] ){ ?>
                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-primary btn-block " >
                        <i class="fa fa-check"></i> Guardar
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
                    <th>Cargo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Vigente</th>
                    <th>Resumen</th>
                    <th width="90">
                        <a href="<?php echo $url; ?>/?pg=administrar/colaborador/trayectoria">
                        <button type="button" class="btn btn-warning btn-sm btn-block">
                            Nuevo
                        </button>
                        </a>
                    </th>
                </tr>
                <?php 
                $querytrayectoria = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria 
                WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ORDER BY fecha_inicia DESC  ");
	            while($datatrayectoria = mysqli_fetch_array($querytrayectoria)){
                    echo '
                    <tr>
                        <td>'.$datatrayectoria["cargo"].'</td>
                        <td>'.$datatrayectoria["fecha_inicia"].'</td>
                        <td>'.$datatrayectoria["fecha_fin"].'</td>
                        <td>'.$datatrayectoria["vigente"].'</td>
                        <td>'.$datatrayectoria["resumen"].'</td>
                        <td>
                           <a href="'.$url.'/?pg=administrar/colaborador/trayectoria&tra='.$datatrayectoria["id"].'"> 
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-eye"></i>
                            </button>
                            </a>
							<button type="button" class="btn btn-danger btn-sm" onclick="Eliminar_Trayectoria('.$datatrayectoria["id"].')" >
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
	var api = '<?php echo $url; ?>/api/administrar/';

	function Eliminar_Trayectoria(id_registro){
		jQuery.ajax({
			url: api+"eliminar_trayectoria.php",
			type:'post',
			data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=administrar/colaborador/trayectoria"},
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

</script>



