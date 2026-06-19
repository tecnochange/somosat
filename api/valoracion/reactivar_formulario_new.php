<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");
	
	$query = mysqli_query($connect_valoracion,"UPDATE Competencias_Evaluaciones_New SET observaciones = '', mejoras = '', promedio = '', obj_evaluacion = '',  
    estado = 1,  update_at = '".$hoy."' WHERE id = '".$id."'  ");
	$data = mysqli_fetch_array($query);

?>

<script>
	window.location = "<?php echo $urlRedirect; ?>";
</script>