<?php        
	$hoy = date("Y-m-d H:i:s");
	$id_cohorte = $_POST["id_cohorte"];
	$fecha = $_POST["fecha"];

	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_formacion,"UPDATE Cohortes SET fecha_evaluacion = '".$fecha."' 
	WHERE id = '".$id_cohorte."'  ");
	$data = mysqli_fetch_array($query);

?>

