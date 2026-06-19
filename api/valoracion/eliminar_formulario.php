<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];

    $id_evaluado = $_POST["id_evaluado"];
    $id_evaluador = $_POST["id_evaluador"];
    $id_tipo = $_POST["id_tipo"];

	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");

	$queryRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE id_evaluado = '".$id_evaluado."' 
    AND id_evaluador = '".$id_evaluador."' AND tipo_evaluador =  '".$id_tipo."'  ");
	while($dataResp = mysqli_fetch_array($queryRespuestas)){
        echo $dataResp["id"].'<br>';
        mysqli_query($connect_valoracion,"DELETE FROM Competencias_Respuestas_Comportamientos WHERE id_respuesta = '".$dataResp["id"]."'  ");
        mysqli_query($connect_valoracion,"DELETE  FROM Competencias_Respuestas WHERE id = '".$dataResp["id"]."'  ");
	}

    mysqli_query($connect_valoracion,"DELETE  FROM Competencias_Evaluaciones WHERE id = '".$id."'  ");



?>

<script>
	window.location = "<?php echo $urlRedirect; ?>";
</script>