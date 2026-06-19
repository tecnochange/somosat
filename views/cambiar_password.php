<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
	$respuesta = "";
    

	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$user_log["id"]."' ");
	$data = mysqli_fetch_array($query);

    




    $txt_role = '';
    foreach($Array_Role as $role){
        if($role[0] == $data["role"]){  $txt_role = $role[1]; }
    }
                        
    $txt_estado = '';
    foreach($Array_Estado  as $estado){
        if($estado[0] == $data["estado"]){  $txt_estado = $estado[1]; }
    }


	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["pass_actual"] != ""){
		
		if($_POST["pass_actual"] == $data["password"] ){
			$sentencia = "UPDATE Empleados SET password = '".$_POST["nuevo_pass"]."', cambiar_pass = 1 WHERE id = '".$_SESSION['id_user']."'  ";
			mysqli_query($connect_valentina, $sentencia);

			$respuesta = '
				<div class="alert alert-success" role="alert">
					La contraseña a sido actualizada con éxito.
				</div>
			';
		}
		else{
			$respuesta = '
				<div class="alert alert-danger" role="alert">
					La contraseña actual no es correcta.
				</div>
			';
		}
		
    }

?>

<div class="container">

	<div class="card" >
        
        <div class="card-body"> 
			
			<?php echo $respuesta; ?>
            
			<form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Actualizar mi contraseña</h2>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Contraseña Actual:</label>
                    <input type="text"  class="form-control" name="pass_actual" value="">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Nueva contraseña:</label>
                    <input type="text"  class="form-control" name="nuevo_pass" value="" >
                </div>

                <div class="col-md-12" style=" margin-top: 15px; margin-bottom: 10px">
                    <button type="submit" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Cambiar Contraseña
                    </button>
                </div>


            </div>
        	</form>

        </div>
    </div>
           
</div>