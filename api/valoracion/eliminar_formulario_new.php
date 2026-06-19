<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];

    $id_evaluado = $_POST["id_evaluado"];
    $id_evaluador = $_POST["id_evaluador"];
    $id_tipo = $_POST["id_tipo"];

	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");

	
    mysqli_query($connect_valoracion,"DELETE  FROM Competencias_Evaluaciones_New WHERE id = '".$id."'  ");



?>

<script>
	window.location = "<?php echo $urlRedirect; ?>";
</script>