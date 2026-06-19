<option value="">Selecciona...</option>
<?php
	$hoy = date("Y-m-d H:i:s");
    $id_empresa = $_POST["id_empresa"];
    $anio = $_POST["anio"];

	
	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id_empresa = '".$id_empresa."' AND anio = '".$anio."'  ");
	while($data = mysqli_fetch_array($query)){
        echo '<option value="'.$data["id"].'">'.$data["nombre"].'</option>';
    }
?>

