<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	include("app/models/Collaborators.php");
	$ClassCollaborators = new Collaborators();
	$colaboradores = $ClassCollaborators->lista_colaboradores($connect_valentina, 1);

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["id_empleado"] != ""){

        mysqli_query($connect_valentina,"INSERT INTO Jefes ( id_empleado, id_jefe, created_at ) 
        VALUES 
        ( '".$_POST["id_empleado"]."', '".$_POST["id_jefe"]."', '".$hoy."' ) ");  
		
        echo '<script> window.location = "?pg=administrar/jefes";</script>';//para evitar reinsersion  
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT emp.id, emp.nombre, emp.nombre_2, emp.apellidos, emp.apellidos_2, adi.preferencia FROM Empleados as emp
    INNER JOIN Empleados_Adicionales as adi
    on adi.id_empleado = emp.id
    WHERE emp.id = '".$id."' ");
	$data = mysqli_fetch_array($query);

    $nombre_completoj = strtoupper($data["nombre"]." ".$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
    if($data["preferencia"]){
        $nombre_completoj = strtoupper($data["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
    }
?>



<div class="container"> 
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/jefes">Administrar jefes</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Agregar Jefe</a></li>
		  </ol>
	</nav>

	<div class="card">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Jefe</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <lable>Empleado</lable>
                    <input type="text" class="form-control" value="<?php echo $nombre_completoj; ?>" disabled >
                    <input type="hidden" value="<?php echo $id; ?>" name="id_empleado">
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <lable>Jefe</lable>
                    <select class="form-control" name="id_jefe">
                        <option value="">Selecciona..</option>
						<?php
						foreach($colaboradores as $colaborador){
							
							if($data["id_jefe"] == $colaborador["id"] ){
								echo '<option value="'.$colaborador["id"].'" selected>'.$colaborador["nombre_completo"].'</option>';
							}
							else{
								echo '<option value="'.$colaborador["id"].'" >'.$colaborador["nombre_completo"].'</option>';
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
</div>

<script>
    $("#bt_adm_jefes").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>