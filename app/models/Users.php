<?php
class Users{
    public function user($id, $connect_valentina){
        $qry = mysqli_query($connect_valentina,"SELECT 
        Empleados.id AS id,  
        Empleados.nombre AS nombre, 
		Empleados.nombre_2 AS nombre_2,  
        Empleados.apellidos AS apellidos, 
		Empleados.apellidos_2 AS apellidos_2, 
        Empleados.correo AS correo, 
        Empleados.documento AS documento, 
        Empleados.role AS role, 
        Empleados.foto_formal AS foto_formal,  
		Cargos.nombre AS cargo, Cargos.id AS id_cargo,
        ad.preferencia    
        FROM Empleados 
		LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
        RIGHT JOIN Empleados_Adicionales  as ad ON ad.id_empleado = Empleados.id
        WHERE Empleados.id = '".$id."' ");
        $dt = mysqli_fetch_array($qry);
	
        $foto = $url."/recursos/".$dt["foto_formal"];
        if($dt["foto_formal"] == ""){$foto = "/img/1.png"; }
		
        if($dt["preferencia"] != ""){ 
            $nombre = $dt["preferencia"]." ".$dt["apellidos"]." ".$dt["apellidos_2"];
            
        }else{
            $nombre = $dt["nombre"]." ".$dt["nombre_2"]." ".$dt["apellidos"]." ".$dt["apellidos_2"];
        }

        

        return array(
            "id" => $dt["id"],
            "nombre" => $nombre, 
            "role" => $dt["role"],  
            "correo" => $dt["correo"], 
            "documento" => $dt["documento"], 
			"cargo" => $dt["cargo"], 
			"id_cargo" => $dt["id_cargo"], 
            "foto" => $foto,      
        );
        
    }
    
}

?>