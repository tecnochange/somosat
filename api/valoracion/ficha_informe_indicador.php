<?php
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	
	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE id = '".$id."'  ");
	$data = mysqli_fetch_array($query);
?>

<form action="" method="post">
                	<input type="hidden" name="id_informe_indicador" value="<?php echo $data["id"]; ?>" />
					<div class="row">
                        
                        <div class="col-md-12">
                          	<h5 id="nombre_indicador"><?php echo $data["indicador"]; ?></h5>
                        </div>
                        

                        <div class="col-md-12">
                          	<label class="ti_label">Fortaleza</label>
                            <textarea class="form-control" name="fortaleza" required placeholder="Ingrese..." rows="3"><?php echo $data["fortaleza"]; ?></textarea>
                        </div>
                        
                        <div class="col-md-12">
                          	<label class="ti_label">Oportunidad de mejora</label>
                            <textarea class="form-control" name="oportunidad" required placeholder="Ingrese..." rows="3"><?php echo $data["oportunidad"]; ?></textarea>
                        </div>

                        <div class="col-md-12" style="margin-top:15px; text-align: right;">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                        
					</div>
				</form>