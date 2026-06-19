<?php        
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];
	$urlRedirect = $_POST["url"];

	include("../../app/models/connect.php");

    $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_cargo = '".$id."'  ");
   
    $validar = true;
    if($queryEmpleados->num_rows > 0){
        $validar = false; 
    }
  
	

if($validar == true ){
//$data = mysqli_fetch_array($queryVal);
	
	$query = mysqli_query($connect_valentina,"DELETE FROM Cargos WHERE id = '".$id."'  ");
	//$data = mysqli_fetch_array($query);

    echo '<script> 	window.location = "'.$urlRedirect.'"; </script>';
}
else{
   echo '<script> 	alert("Lo sentimos, esta cargo tiene colaboradores relacionados."); </script>'; 
}
?>

