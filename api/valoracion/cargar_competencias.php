<?php
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	
	include("../../app/models/connect.php");

?>

<select class="form-control" name="competencia" id="competencia" >
                                <option value="">Selecciona</option>
                                <?php
                                $query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id_tipo = '".$id."'  ");
                                while($data = mysqli_fetch_array($query)){
                                    echo '<option value="'.$data["id"].'">'.$data["nombre"].'</option>';
                                }
                                ?>
</select> 


