<?php
	include("../../app/models/connect.php");
	
	$id_funcion = $_POST["id_funcion"];

    $query = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Funciones WHERE id = '".$id_funcion."' ");
	$data = mysqli_fetch_array($query);
?>


                    <label>Que hace</label>
                    <input type="hidden" name="guardar_funcion" value="true">
                    <input type="hidden" name="id_funcion" id="id_funcion" value="<?php echo $id_funcion; ?>">
                    <textarea rows="5" class="form-control" name="que_hace" id="que_hace"><?php echo $data["que_hace"] ?></textarea>
                    
                    <label>Cómo lo hace</label>
                    <textarea rows="5" class="form-control" name="como_hace" id="como_hace"><?php echo $data["como_hace"] ?></textarea>
                    
                    <label>Para qué lo hace</label>
                    <textarea rows="5" class="form-control" name="para_hace" id="para_hace"><?php echo $data["para_hace"] ?></textarea>




