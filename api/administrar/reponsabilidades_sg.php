<?php
	$hoy = date("Y-m-d H:i:s");
	$id_resp = $_POST["id_resp"];

	
	include("../../app/models/connect.php");
    include("../../app/models/library.php");

    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Responsabilidades_SG_SST WHERE nombre = '".$id_resp."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);
    
    echo nl2br($dataCargo["descripcion"]);
?>
