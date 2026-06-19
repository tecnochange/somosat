<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
    $("#desplegable_novedades").show();
    $("#bt_novedades_reportes").addClass("active_item");
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	//PARA CREAR O EDITAR UN NUEVO REGISTRO
	if($_POST["nombre"] != ""){

		if($_POST["id_registro"] != ""){
		}
		else{
            
            $sentencia = "INSERT INTO Vacaciones (nombre, jerarquia, padre, codigo, estado, created_at ) 
			VALUES 
			( '".$_POST["nombre"]."', '".$_POST["jerarquia"]."', '".$_POST["padre"]."', '".$_POST["padre"]."', 1, '".$hoy."' ) ";
			mysqli_query($connect_valentina, $sentencia);  
            echo '<script> window.location = "?pg=administrar/areas";</script>';//para evitar reinsersion  
		}
	}

    
	//INFORMACION DEL REGISTRO
	$query = mysqli_query($connect_novedades,"SELECT * FROM Vacaciones WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
?>


 
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3>Certificado de Ingresos y Retenciones</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estructura</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=novedades/reportes">Reportes</a></li> 
                    <li class="breadcrumb-item">Detalle</li> 
                </ol>
            </div>
        </div>
    </div>
</div>
    
<?php echo $respuesta; ?>

<div class="card">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Comprobante de Ingresos y retenciones</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                    <input type="hidden" name="padre" value="<?php echo $data["padre"]; ?>">
                    
                    <div>
                        Fecha de solicitud: <b><?php echo date("Y-m-d"); ?></b><br>
                        De: <b><?php echo $user_log['nombre']." ".$user_log['nombre_2']." ".$user_log['apellidos']." ".$user_log['apellidos_2']; ?></b><br>
                        Cargo: <b><?php echo $user_log['cargo']; ?></b><br>
                    </div>
                    
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 25px" align="center">
                    Integración Novasoft (en proceso)
                    
                </div>

                
                
            </div>
            </form>
        </div> 
        
</div>

