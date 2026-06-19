<option value="0">Selecciona..</option>
<?php
	$hoy = date("Y-m-d H:i:s");
	include("../../app/models/connect.php");
    include("../../app/models/library.php");
	$id_equipo = $_POST["id_equipo"];

	$sentencia = "
		SELECT 
		Organigrama.id AS id, Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2 , 
		Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2  
		FROM Organigrama 
		LEFT JOIN Empleados ON Empleados.id = Organigrama.id_empleado
		WHERE Organigrama.id_equipo = '".$id_equipo."' AND Empleados.estado = 1 
		GROUP BY Empleados.id ORDER BY Empleados.nombre ASC 
	";
	$queryList = mysqli_query($connect_valentina, $sentencia);  
	while($dataList = mysqli_fetch_array($queryList)){
		
		$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataList["id"]."' " );  
		$dataAdd = mysqli_fetch_array($queryAdd);

		if($dataAdd["preferencia"] !== ""){
			$dataList["nombre_completo"] = strtoupper($dataAdd["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
		}else{
			$dataList["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
		}
		
		if($data["id_depende"] == $dataList["id"] ){
			echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].' '.$dataList["nombre_2"].' '.$dataList["apellidos"].' '.$dataList["apellidos_2"].'</option>';
		}
		else{
			echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' '.$dataList["nombre_2"].' '.$dataList["apellidos"].' '.$dataList["apellidos_2"].'</option>';
		}
	}

	
	

    

?>
