<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");

    $query = mysqli_query($connect_valentina,"DELETE FROM Gerencias WHERE id = '".$id."'  ");
	


    echo '<script> 	window.location = "'.$urlRedirect.'"; </script>';

?>

