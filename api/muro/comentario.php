<?php
	include("../../app/models/connect.php");
	$id = $_POST["id"];
	$id_user = $_POST["u"];
	$name = $_POST["name"];
	$hoy = date("Y-m-d H:i:s");
	
	mysqli_query($connect_endomarketing,"INSERT INTO Comentarios (id_publicacion, id_user, comentario, nombre_full, created_at) VALUES 
	( '".$id."', '".$id_user."', '".utf8_encode($_POST["comentario"])."', '".$name."', '".$hoy."' ) ");

?>

<script>
	location.reload();
</script>