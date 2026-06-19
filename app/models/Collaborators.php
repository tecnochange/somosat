<?php
class Collaborators {

    //LISTA POR NOMBRE PREFERENCIA
	public function lista_colaboradores_asc( $connect_valentina, $estado ){
		$sentencia = "
        SELECT
			Empleados.id AS id,
			Empleados.estado AS estado,
			Empleados.nombre AS nombre,
			Empleados.nombre_2 AS nombre_2,
			Empleados.apellidos AS apellidos,
			Empleados.apellidos_2 AS apellidos_2,
			Empleados.correo AS correo,
			Empleados.role AS role,
			Empleados.documento AS documento,
			Empleados.foto_formal AS foto_formal, 
			Empleados.foto_formal AS foto_formal,
			Cargos.nombre AS cargo_nombre,
			Areas.nombre AS area_nombre, 
			Gerencias.nombre AS gerencia_nombre, 
			Empleados_Adicionales.preferencia AS nombre_preferencia 
		FROM
			Empleados
		LEFT JOIN Empleados_Adicionales ON Empleados_Adicionales.id_empleado = Empleados.id
		LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo
		LEFT JOIN Areas ON Areas.id = Empleados.id_area
		LEFT JOIN Gerencias ON Gerencias.id = Empleados.id_departamento
		WHERE
			Empleados.estado = '".$estado."'
		GROUP BY
			Empleados.id
		";

		$array_colaboradores = array();
		$query = mysqli_query($connect_valentina, $sentencia);  
		while($data = mysqli_fetch_array($query)){ 
			$data["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);

			if($data["nombre_preferencia"] != ""){
				$data["nombre_completo"] = strtoupper($data["nombre_preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
			}
			array_push($array_colaboradores, $data );
		}

		foreach ($array_colaboradores as $key => $row) {
			$aux[$key] = $row['nombre_completo'];
		}

		array_multisort($aux, SORT_ASC, $array_colaboradores);
		
		return $array_colaboradores;
	}

	public function lista_colaboradores( $connect_valentina, $estado ){
		$filtro = "";
		if($estado > 0){
			$filtro = " AND Empleados.estado = '".$estado."' ";
		}
		$sentencia = "
        SELECT 
        Empleados.id AS id, 
        Empleados.estado AS estado, 
        Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2, 
        Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2, 
        Empleados.correo AS correo, 
        Empleados.role AS role, 
        Empleados.documento AS documento, 
        Empleados.foto_formal AS foto_formal, 
        Cargos.nombre AS cargo_nombre, 
		Cargos.id AS id_cargo, 
        Areas.nombre AS area_nombre, 
        Gerencias.nombre AS gerencia_nombre,
        ad.preferencia
        FROM Empleados 
        LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
        LEFT JOIN Areas ON Areas.id = Empleados.id_area 
        LEFT JOIN Gerencias ON Gerencias.id = Empleados.id_departamento
        RIGHT JOIN Empleados_Adicionales  as ad ON ad.id_empleado = Empleados.id
        WHERE Empleados.estado = 1 ".$filtro." 
		";

		$array_colaboradores = array();
		$query = mysqli_query($connect_valentina, $sentencia);  
		while($data = mysqli_fetch_array($query)){ 


			$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' " );  
			$dataAdd = mysqli_fetch_array($queryAdd);

			if($dataAdd["preferencia"] !== ""){
				$data["nombre_completo"] = strtoupper($dataAdd["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
			}else{
				$data["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
			}
			array_push($array_colaboradores, $data );
		}

		foreach ($array_colaboradores as $key => $row) {
			$aux[$key] = $row['nombre_completo'];
		}

		array_multisort($aux, SORT_ASC, $array_colaboradores);
		
		return $array_colaboradores;
	}
	
	
	public function colaborador( $connect_valentina, $id_col ){
		
		$sentencia = "
        SELECT 
        Empleados.id AS id, 
        Empleados.estado AS estado, 
        Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2, 
        Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2, 
        Empleados.correo AS correo, 
        Empleados.role AS role, 
        Empleados.documento AS documento, 
        Empleados.foto_formal AS foto_formal, 
        Cargos.nombre AS cargo_nombre, 
        Areas.nombre AS area_nombre, 
        Gerencias.nombre AS gerencia_nombre,
        ad.preferencia
        FROM Empleados 
        LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
        LEFT JOIN Areas ON Areas.id = Empleados.id_area 
        LEFT JOIN Gerencias ON Gerencias.id = Empleados.id_departamento
        RIGHT JOIN Empleados_Adicionales  as ad ON ad.id_empleado = Empleados.id
        WHERE  Empleados.id = '".$id_col."'
		";

		$array_colaboradores = array();
		$query = mysqli_query($connect_valentina, $sentencia);  
		while($data = mysqli_fetch_array($query)){ 


			$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' " );  
			$dataAdd = mysqli_fetch_array($queryAdd);

			if($dataAdd["preferencia"] !== ""){
				$data["nombre_completo"] = strtoupper($dataAdd["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
			}else{
				$data["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
			}
			array_push($array_colaboradores, $data );
		}

		foreach ($array_colaboradores as $key => $row) {
			$aux[$key] = $row['nombre_completo'];
		}

		array_multisort($aux, SORT_ASC, $array_colaboradores);
		
		return $array_colaboradores;
	}


	//LISTA POR NOMBRE PREFERENCIA
	public function lista_colaboradores_nuevo( $connect_valentina, $estado ){
		$sentencia = "
        SELECT
			Empleados.id AS id,
			Empleados.estado AS estado,
			Empleados.nombre AS nombre,
			Empleados.nombre_2 AS nombre_2,
			Empleados.apellidos AS apellidos,
			Empleados.apellidos_2 AS apellidos_2,
			Empleados.correo AS correo,
			Empleados.role AS role,
			Empleados.documento AS documento,
			Empleados.foto_formal AS foto_formal, 
			Empleados.foto_formal AS foto_formal,
			Cargos.nombre AS cargo_nombre,
			Areas.nombre AS area_nombre, 
			Gerencias.nombre AS gerencia_nombre, 
			Empleados_Adicionales.preferencia AS nombre_preferencia 
		FROM
			Empleados
		LEFT JOIN Empleados_Adicionales ON Empleados_Adicionales.id_empleado = Empleados.id
		LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo
		LEFT JOIN Areas ON Areas.id = Empleados.id_area
		LEFT JOIN Gerencias ON Gerencias.id = Empleados.id_departamento
		WHERE
			Empleados.estado = '".$estado."'
		GROUP BY
			Empleados.id
		";

		$array_colaboradores = array();
		$query = mysqli_query($connect_valentina, $sentencia);  
		while($data = mysqli_fetch_array($query)){ 
			$data["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);

			if($data["nombre_preferencia"] != ""){
				$data["nombre_completo"] = strtoupper($data["nombre_preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
			}
			array_push($array_colaboradores, $data );
		}

		foreach ($array_colaboradores as $key => $row) {
			$aux[$key] = $row['nombre_completo'];
		}

		array_multisort($aux, SORT_ASC, $array_colaboradores);
		
		return $array_colaboradores;
	}
	
}

?>