<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_valoracion,"DELETE FROM Retroalimentacion WHERE id = '".$id."'  ");
	$data = mysqli_fetch_array($query);

	mysqli_query($connect_valoracion,"DELETE FROM Retroalimentacion_Comentarios WHERE id_retroalimentacion = '".$id."'  ");

?>

<script>
	window.location = "<?php echo $urlRedirect; ?>";
</script>