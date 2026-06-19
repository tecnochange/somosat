<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");

    $queryPadre = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$id."'  ");
    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_area = '".$id."'  ");

    $validar = true;
    if($queryPadre->num_rows > 0){
        $validar = false; 
    }
    if($queryCargo->num_rows > 0){
        $validar = false;
    }
	

if($validar == true ){
//$data = mysqli_fetch_array($queryVal);
	
	$query = mysqli_query($connect_valentina,"DELETE FROM Areas WHERE id = '".$id."'  ");
	//$data = mysqli_fetch_array($query);

    echo '<script> 	window.location = "'.$urlRedirect.'"; </script>';
}
else{
   echo '<script> 	alert("Lo sentimos, esta area tiene realacionado areas dependientes o cargos dependientes."); </script>'; 
}
?>

