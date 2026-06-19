<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_valoracion,"DELETE FROM Competencias_Acciones WHERE id = '".$id."'  ");
	$data = mysqli_fetch_array($query);

?>

<script>
	window.location = "<?php echo $urlRedirect; ?>";
</script>