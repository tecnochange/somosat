<?php
	$hoy = date("Y-m-d H:i:s");
	$id_cargo = $_POST["id_cargo"];

	
	include("../../app/models/connect.php");
    include("../../app/models/library.php");

    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Puestos WHERE id = '".$id_cargo."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);

    $query = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE cod_puesto = '".$dataCargo["cod_puesto"]."' "); 
    while($data = mysqli_fetch_array($query)){
        
        if($data["id"] == $id_poscion ){
            echo '<option value="'.$data["id"].'" selected>'.$dataCargo["nombre"].' -  '.$data["ciudad"].' - '.$data["cod_posicion"].'</option>';
        }
        else{
            echo '<option value="'.$data["id"].'">'.$dataCargo["nombre"].' - '.$data["ciudad"].' - '.$data["cod_posicion"].'</option>';
        }
        
    }

?>
