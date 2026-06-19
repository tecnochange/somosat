<?php
print_r("ingreso");

class Autorizaciones{
    
    public function autorizacion($id_autorizador, $id_requisicion, $connect_valentina, $connect_seleccion){
        
        print_r("algo");
        
        $queryAut = mysqli_query($connect_valentina,"SELECT Empleados.nombre AS nombre, Empleados.apellidos AS apellidos, 
        Empleados.correo AS correo,
        Cargos.nombre AS nombre_cargo FROM Empleados
        LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
        WHERE Empleados.id = '".$id_autorizador."' ");  
        $dataAut = mysqli_fetch_array($queryAut);
    
        $queryReq = mysqli_query($connect_seleccion,"SELECT * FROM Autorizaciones WHERE id_requisicion = '".$id_requisicion."' 
        AND id_autorizador = '".$id_autorizador."' ");  
        $dataReq = mysqli_fetch_array($queryReq);
        $txt_estado = "Sin Enviar";
        $fecha = "N/A";
        if($dataReq["estado"] == 1){ $txt_estado = "Pendiente"; }
        if($dataReq["estado"] == 2){ $txt_estado = "Aprobado"; }
        if($dataReq["estado"] == 3){ $txt_estado = "Rechazado"; }
        if($dataReq["created_at"]){ $fecha = $dataReq["created_at"]; }
        $enviado = 0;
        if($dataReq["id"]){ $enviado = 1; }
        
        return array(
            "nombre" => $dataAut["nombre"].' '.$dataAut["nombre_2"].'  '.$dataAut["apellidos"], 
            "correo" => $dataAut["correo"], 
            "estado" => $txt_estado, 
            "fecha" => $fecha, 
            "enviado" => $enviado
        );
    }
    
    
    
}

?>