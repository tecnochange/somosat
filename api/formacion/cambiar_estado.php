<?php        
	$hoy = date("Y-m-d H:i:s");
	$id_cohorte = $_POST["id_cohorte"];
	$estado = $_POST["estado"];

	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_formacion,"UPDATE Cohortes SET estado = '".$estado."' 
	WHERE id = '".$id_cohorte."'  ");
	$data = mysqli_fetch_array($query);

?>

