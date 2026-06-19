<?php
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	
	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$id."'  ");
	$data = mysqli_fetch_array($query);

?>

<form action="" method="post">
                	<input type="hidden" name="id_competencia" value="<?php echo $data["id"]; ?>" />
					<div class="row">
                        
                        <div class="col-md-6">
                          	<label class="ti_label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required value="<?php echo $data["nombre"]; ?>">
                        </div>
                        <div class="col-md-6">
                          	<label class="ti_label">Tipo.</label>
                            <select class="form-control" name="id_tipo"  required>
                            	<option value="">Selecciona...</option>
                                <?php
								$queryTipo = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$data["id_empresa"]."' AND anio = '".$data["anio"]."' ORDER BY id ASC ");
								while($dataTipo = mysqli_fetch_array($queryTipo)){
                                    if($data["id_tipo"] == $dataTipo["id"] ){
                                        echo '<option value="'.$dataTipo["id"].'" selected>'.$dataTipo["nombre"].'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$dataTipo["id"].'">'.$dataTipo["nombre"].'</option>';
                                    }
									
								}
								?>
                            </select>
                        </div>
                        <div class="col-md-12">
                          	<label class="ti_label">Definición</label>
                            <textarea class="form-control" name="definicion" required placeholder="Ingrese definición..." rows="5"><?php echo $data["definicion"]; ?></textarea>
                        </div>
                        <div class="col-md-12" style="margin-top:15px; text-align: right;">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                        
					</div>
				</form>