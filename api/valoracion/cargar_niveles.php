<?php
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
    $id_empresa = $_POST["id_empresa"];
	
	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id = '".$id."' AND id_empresa = '".$id_empresa."'  ");
	$data = mysqli_fetch_array($query);
?>

<select class="form-control" name="nivel" id="nivel" onChange="CargarCompetencias(this.value)">
                                <option value="">Selecciona</option>
                                <?php
                                $queryT = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$id_empresa."' ");
                                while($dataT = mysqli_fetch_array($queryT)){
                                    echo '<option value="'.$dataT["id"].'">'.$dataT["nombre"].'</option>';
                                }
                                ?>
                            </select> 


