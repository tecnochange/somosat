<?php
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];

	
	include("../../app/models/connect.php");
    include("../../app/models/library.php");

    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_cargo = '".$id."' "); 
    while($data = mysqli_fetch_array($query)){
        echo $data["nombre"].' '.$data["apellidos"].'<br>';
    }


?>
