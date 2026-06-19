<script>  
$(document).ready(function(){
    $("#bt_formacion_gestionar").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["id_empleado"] != ""){

		if($_POST["id_registro"] != ""){
			$sentencia = "
			UPDATE Responsables SET id_empleado = '".$_POST["id_empleado"]."', estado = '".$_POST["estado"]."'  WHERE id = '".$_POST["id_registro"]."'
			";
			
			mysqli_query($connect_formacion, $sentencia);
  
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
		}
		else{
			$sentencia = "
			INSERT INTO Responsables ( id_proceso ,  id_empleado ,  estado ,  created_at ) 
			VALUES 
			( '".$id."', '".$_POST["id_empleado"]."', 
			'".$_POST["estado"]."', '".$hoy."'  )
			";
			mysqli_query($connect_formacion, $sentencia);  
            echo '<script> window.location = "?pg=formacion/proceso/responsables&id='.$id.'";</script>';//para evitar reinsersion  
		}
        
        
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);

	//INFORMACION DE LA BATERIA
	$queryResponsable = mysqli_query($connect_formacion,"SELECT * FROM Responsables WHERE id = '".$_GET["r"]."' ");
	$dataResponsable = mysqli_fetch_array($queryResponsable);
	
?>

<div class="container">
 
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/gestionar">Gestionar Procesos</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
		</ol>
	</nav>
    
	<?php echo $respuesta; ?>

	<div class="card" style="margin-bottom: 15px">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Proceso</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $dataResponsable["id"]; ?>">
                </div>

				<div class="col-md-8" style="margin-bottom: 10px">
                    <label>Responsable</label>
                    <select class="form-control" name="id_empleado" required>
                        <option value="0">Selecciona..</option>
                        <?php
                        $queryGerencia = mysqli_query($connect_valentina,"SELECT * FROM Empleados ORDER BY nombre ASC ");  
                        while($dataJer = mysqli_fetch_array($queryGerencia)){
                            if($dataResponsable["id_empleado"] == $dataJer["id"] ){
                                echo '<option value="'.$dataJer["id"].'" selected>'.$dataJer["nombre"].' '.$dataJer["apellidos"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataJer["id"].'">'.$dataJer["nombre"].' '.$dataJer["apellidos"].' </option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
				
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Estado</label>
                    <select class="form-control" name="estado" id="estado" required>
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Estado as $nivel){
                            if($dataResponsable["estado"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        
                        ?>
                    </select>
                </div>

                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Guardar
                    </button>
                </div>

            </div>
            </form>
        </div> 
        
	</div>
	
	
	
	<div class="card">
        
        <div class="card-body"> 
			<table class="table">
				<tr>
					<th>Nombre</th>
					<th>Estado</th>
					<th>
						<a href="<?php echo $url; ?>?pg=formacion/proceso/responsables&id=<?php echo $id; ?>">
                                <button type="button" class="btn btn-warning btn-sm" title="Editar">
                                    Nuevo
                                </button>
						</a>
					</th>
				</tr>
				<?php
				$queryRespo = mysqli_query($connect_formacion,"SELECT * FROM Responsables WHERE id_proceso = '".$id."' ORDER BY id ASC ");  
                while($dataRespo = mysqli_fetch_array($queryRespo)){
					
					$queryEmpl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataRespo["id_empleado"]."' ");  
                	$dataEmpl = mysqli_fetch_array($queryEmpl);
					
					$txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $dataRespo["estado"]){ $txt_estado = $nivel[1]; }
                    }
					
					$bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=formacion/proceso/responsables&id='.$id.'&r='.$dataRespo["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                            </a>
                        ';
                    }
					
					echo '
					<tr>
						<td>'.$dataEmpl["nombre"].' '.$dataEmpl["apellidos"].'

						</td>
						<td>'.$txt_estado.'</td>
						<td>'.$bt_editar.'</td>
					</tr>
					';
				}
				?>
				
			</table>
		</div>
		
	</div>
	
</div>
