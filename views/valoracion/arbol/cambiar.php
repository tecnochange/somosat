<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["id_empleado"] != ""){

        mysqli_query($connect_valentina,"UPDATE Jefes SET id_empleado = '".$_POST["id_empleado"]."', id_jefe = '".$_POST["id_jefe"]."'  
        WHERE id = '".$_POST["id_registro"]."'  ");

        echo '<script> window.location = "?pg=administrar/jefes";</script>';//para evitar reinsersion  
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
    $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");
	$dataEm = mysqli_fetch_array($queryEm);
?>



<div class="container-fluid"> 
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/jefes">Administrar jefes</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Cambiar Jefe</a></li>
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
                    <input type="text" class="form-control" value="<?php echo $dataEm["nombre"]." ".$dataEm["apellidos"]; ?>" disabled >
                    <input type="hidden" value="<?php echo $dataEm["id"]; ?>" name="id_empleado">
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <lable>Jefe</lable>
                    <select class="form-control" name="id_jefe">
                        <option value="">Selecciona..</option>
                        <?php
                        $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_empresa = '".$_SESSION["id_empresa"]."' AND role > 1 ORDER BY nombre ASC ");  
                        while($dataJer = mysqli_fetch_array($queryJer)){
                            if($data["id_jefe"] == $dataJer["id"] ){
                                echo '<option value="'.$dataJer["id"].'" selected>'.$dataJer["nombre"].' - '.$dataJer["jerarquia"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataJer["id"].'">'.$dataJer["nombre"].' - '.$dataJer["jerarquia"].'</option>';
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
</script>