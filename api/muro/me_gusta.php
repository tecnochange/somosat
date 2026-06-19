<?php
	include("../../app/models/connect.php");
	$id = $_POST["id"];
	$id_user = $_POST["u"];
	$name = $_POST["name"];
	
	$q = mysqli_query($connect_endomarketing,"SELECT id FROM Me_Gusta WHERE id_user = '".$id_user."' AND id_publicacion =  '".$id."' ");
	
	if($q->num_rows == 0){
		mysqli_query($connect_endomarketing,"INSERT INTO Me_Gusta (id_publicacion, id_user, nombre_full, calificacion) VALUES ('".$id."', '".$id_user."', '".$name."', 1 ) ");
	}
?>

<script>
	location.reload();
</script>