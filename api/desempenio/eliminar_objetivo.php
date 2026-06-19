<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");

	mysqli_query($connect_desempenio,"DELETE FROM Objetivos_Colaborador WHERE id = '".$id."'  ");
	//$data = mysqli_fetch_array($query);

    echo '<script> 	window.location = "'.$urlRedirect.'"; </script>';

?>

