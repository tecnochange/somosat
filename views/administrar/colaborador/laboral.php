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
            UPDATE Empleados_Laborales SET 
                entidad = '".$_POST["entidad"]."', 
                cargo = '".$_POST["cargo"]."', 
                sector = '".$_POST["sector"]."', 
                fecha_inicio = '".$_POST["fecha_inicio"]."', 
                fecha_fin = '".$_POST["fecha_fin"]."', 
                pais = '".$_POST["pais"]."', 
                ciudad = '".$_POST["ciudad"]."', 
                experiencia = '".$_POST["experiencia"]."'  
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            mysqli_query($connect_valentina, $sentencia_adicional);
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                mysqli_query($connect_valentina,"UPDATE Empleados_Laborales SET cargar_archivo = '".$archivo."' WHERE id = '".$_POST["id_informacion"]."' ");
            }

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Laborales (
                id_empleado, 
                documento, 
                entidad, 
                cargo, 
                sector, 
                fecha_inicio, 
                fecha_fin, 
                pais, 
                ciudad, 
                experiencia, 
                cargar_archivo, 
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                0, 
                '".$_POST["entidad"]."', 
                '".$_POST["cargo"]."', 
                '".$_POST["sector"]."', 
                '".$_POST["fecha_inicio"]."', 
                '".$_POST["fecha_fin"]."',  
                '".$_POST["pais"]."',  
                '".$_POST["ciudad"]."',
                '".$_POST["experiencia"]."', 
                '', 
                '".$hoy."'  
            )
            ";

            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                mysqli_query($connect_valentina,"UPDATE Empleados_Laborales SET cargar_archivo = '".$archivo."' WHERE id = '".$id_tmp."' ");
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

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales WHERE id = '".$_GET["lab"]."' ");
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
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link">Datos Personales</a>
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
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/laboral" class="nav-link active">Experiencia Laboral</a>
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
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/remuneracion" class="nav-link"> Remuneración</a>
		</li>
		<?php } ?>
	</ul>

    <div class="card" style="margin-bottom: 15px">
       
        
        <div class="card-body"> 
            
            <table class="table table-bordered">
                <tr>
                    <th>Empresa</th>
                    <th>Cargo</th>
                    <th>Sector</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>País</th>
                    <th>Ciudad</th>
                    <th>Principales Tareas</th>
                    <th>Adjunto</th>
                    <th width="90">
                        <a href="<?php echo $url; ?>/?pg=administrar/colaborador/laboral">
                        <button type="button" class="btn btn-primary btn-sm">
                            +
                        </button>
                        </a>
                    </th>
                </tr>
                <?php 
                $querylaboral = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales 
                WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
	            while($datalaboral = mysqli_fetch_array($querylaboral)){
                    echo '
                    <tr>
                        <td>'.$datalaboral["entidad"].'</td>
                        <td>'.$datalaboral["cargo"].'</td>
                        <td>'.$datalaboral["sector"].'</td>
                        <td>'.$datalaboral["fecha_inicio"].'</td>
                        <td>'.$datalaboral["fecha_fin"].'</td>
                        <td>'.$datalaboral["pais"].'</td>
                        <td>'.$datalaboral["ciudad"].'</td>
                        <td>'.$datalaboral["experiencia"].'</td>
                        <td>
                            <a href="'.$url.'/recursos/'.$datalaboral["cargar_archivo"].'" target="_blank">
                                '.$datalaboral["cargar_archivo"].'
                            </a>
                        </td>
                        <td>
                           <a href="'.$url.'/?pg=administrar/colaborador/laboral&lab='.$datalaboral["id"].'"> 
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-check"></i>
                            </button>
                            </a>
							
							<button type="button" class="btn btn-danger btn-sm" onclick="Eliminar_Laboral('.$datalaboral["id"].')" >
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

    <div class="card">
  
        <div class="card-body">   
    
            <form action="" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Empresa *</label>
                    <input type="text" class="form-control" name="entidad" value="<?php echo $dataInforma["entidad"]; ?>" required>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Cargo *</label>
                    <input type="text" class="form-control" name="cargo" value="<?php echo $dataInforma["cargo"]; ?>" required>
                </div>
                
                <div class="col-md-3" style="margin-bottom: 10px">
                    <label>Sector</label>
                    <input type="text" class="form-control" name="sector" value="<?php echo $dataInforma["sector"]; ?>">
                </div>
                
                <div class="col-md-3" style="margin-bottom: 10px">
                    <label>Fecha Inicio *</label>
                    <input type="date" class="form-control" name="fecha_inicio" value="<?php echo $dataInforma["fecha_inicio"]; ?>" required>
                </div>
                
                <div class="col-md-3" style="margin-bottom: 10px">
                    <label>Fecha Fin *</label>
                    <input type="date" class="form-control" name="fecha_fin" value="<?php echo $dataInforma["fecha_fin"]; ?>" required>
                </div>
                
                <div class="col-md-3" style="margin-bottom: 10px">
                    <label>Pais *</label>
                    <input type="text" class="form-control" name="pais" value="<?php echo $dataInforma["pais"]; ?>" required>
                </div>
                
                <div class="col-md-3" style="margin-bottom: 10px">
                    <label>Ciudad *</label>
                    <input type="text" class="form-control" name="ciudad" value="<?php echo $dataInforma["ciudad"]; ?>" required>
                </div>
                
                <div class="col-md-3" style="margin-bottom: 10px">
                    <label><b>Adjuntar un archivo</b></label>
                    <input type="file" id="archivo" name="archivo" class="form-control">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Principales Tareas *</label>
					<textarea class="form-control" name="experiencia" required><?php echo $dataInforma["experiencia"]; ?></textarea>
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



<script>

    //PARA CAMBIAR A MAYUSCULAS
    $(document).ready( function () {
        $("input").on("keypress", function () {
           $input=$(this);
           setTimeout(function () {
            $input.val($input.val().toUpperCase());
           },50);
        });
    });
	
	var api = '<?php echo $url; ?>/api/administrar/';

	function Eliminar_Laboral(id_registro){
		jQuery.ajax({
			url: api+"eliminar_laboral.php",
			type:'post',
			data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=administrar/colaborador/laboral"},
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



