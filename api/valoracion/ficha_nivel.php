<?php
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	
	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id = '".$id."'  ");
	$data = mysqli_fetch_array($query);
?>


<form action="" method="post">
                	<input type="hidden" name="id_tipo" value="<?php echo $data["id"]; ?>" />
					<div class="row">
                        
                        <div class="col-md-12">
                          	<label class="ti_label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required value="<?php echo $data["nombre"]; ?>">
                        </div>
                        
                        <div class="col-md-12" style="margin-top:15px; text-align: right;">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                        
					</div>
				</form>