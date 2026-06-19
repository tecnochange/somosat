<?php
	include("../../app/models/connect.php");
	$id = $_POST["id"];
	$hoy = date("Y-m-d H:i:s");
	
	mysqli_query($connect_endomarketing,"DELETE FROM Publicaciones WHERE id = '".$id."' ");

?>

<script>
	location.reload();
</script>