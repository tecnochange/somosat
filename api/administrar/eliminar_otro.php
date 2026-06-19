<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id_registro"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");


	$query = mysqli_query($connect_valentina,"DELETE FROM Empleados_Familiares_Otros WHERE id = '".$id."'  ");
	//$data = mysqli_fetch_array($query);

    echo '<script> 	window.location = "'.$urlRedirect.'"; </script>';

?>

