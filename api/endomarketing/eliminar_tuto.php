<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id_registro"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");


	
	$query = mysqli_query($connect_estructura,"DELETE FROM Tutoriales WHERE id = '".$id."'  ");

    echo '<script> 	window.location = "'.$urlRedirect.'"; </script>';

?>

