<?php

function ApiColaboradores(){
    date_default_timezone_set('America/Bogota');

    $tipo_token = 'Authorization';
    $token = 'Basic cmNhcnJhc2NhbDpGb3J0dW5hOQ==';
    $isuario = $_GET["id"];
    $url = 'https://creeser.hr-suite.app/es/api/users/?Authorization='.$token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url ); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    $data = curl_exec($ch);
    $array_datos = json_decode($data, JSON_UNESCAPED_SLASHES);
    curl_close($ch); 

    return $array_datos;
}

function ApiColaborador($id){
    date_default_timezone_set('America/Bogota');

    $tipo_token = 'Authorization';
    $token = 'Basic cmNhcnJhc2NhbDpGb3J0dW5hOQ==';
    $isuario = $_GET["id"];
    $url = 'https://creeser.hr-suite.app/es/api/users/'.$id.'?Authorization='.$token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url ); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    $data = curl_exec($ch);
    $array_datos = json_decode($data, JSON_UNESCAPED_SLASHES);
    curl_close($ch); 
    
    $nodo;
    foreach($array_datos as $datos){
        if($id == $datos["id"]){
            $nodo = $datos;
        }
    }

    return $nodo;
}


function ApiEditarRoleSeleccion($id, $role){
    date_default_timezone_set('America/Bogota');

    $url = 'https://creeser.hr-suite.app/es/user/'.$id;
    $headers = array( 
        'Authorization: Basic dXNyX2hyc3VpdGU6Rm9ydHVuYTk=',
        'Content-Type: application/json'
    ); 
    
    $data = array(
        "field_user_rol_seleccion"=>array("value"=>$role)
    );
                                            
    $ch = curl_init($url);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($data) );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    //RESULTADO WS                                                                                                                                
    $result = curl_exec($ch);
    //print_r($result);
 
}

/*
function ApiCrearColaborador($id, $datos){
    date_default_timezone_set('America/Bogota');

    $url = 'https://estilocontigo.hr-suite.app/es/entity/user';
    $headers = array( 
        'Authorization: Basic dXNyX2VzdGlsbzpGb3J0dW5hOSQl',
        'Content-Type: application/json'
    ); 
    
    $data = array(
        "name" => array("value"=> $datos["nombre"]), 
        "pass" => array("value"=> $datos["documento"]), 
        "mail" => array("value"=> $datos["mail"]), 
        "status" => array("value"=> true ) , 
        "created" => array(
            "value"=> $datos["created"], 
            "format" => "Y-m-d\\TH:i:sP" 
        ), 
        "roles" => array(
            "target_id"=> "administrator", 
            "target_type" => "user_role", 
            "target_uuid" => "35cedb8a-71cf-4611-ba9b-b02686284c0b" 
        ), 
        "field_user_rol_seleccion" => array("value"=> 2 ), 
        "field_user_salario_base" => array(), 
        "field_user_salario_flexibilizado" => array( 
            array( "value" => false 
                 ) 
        )
    );
    
    
    
                                            
    $ch = curl_init($url);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($data) );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    //RESULTADO WS                                                                                                                                
    $result = curl_exec($ch);
    print_r($result);
 
}
*/

function ApiCrearColaborador($datos){
    $fecha_service = (date("Y-m-d")."T".date("H:i:s")."+00:00");
    /*
    $datos = array(
        "nombre" => "Empleado Test 02", 
        "documento" => "2234568895", 
        "email" => "correo@test.com.com", 
        "created" => $fecha_service, 
        "target_id" => "administrator",
        "target_uuid" => "35cedb8a-71cf-4611-ba9b-b02686284c0b" 
    );
    */

    date_default_timezone_set('America/Bogota');

    $url = 'https://creeser.hr-suite.app/es/entity/user';
    $headers = array( 
        'Authorization: Basic dXNyX2VzdGlsbzpGb3J0dW5hOSQl',
        'Content-Type: application/json'
    ); 
    
    $data = array(
        "name" => array("value" => $datos["nombre"]), 
        "pass" => array("value" => $datos["documento"]), 
        "mail" => array("value" => $datos["correo"] ), 
        "status" => array( "value"=> true ) , 
        "roles" => array( array(
            "target_id"=> "colaborador" , 
            "target_type" => "user_role", 
            )
        ), 
        "field_user_nombre" => array("value" => $datos["nombre"] ), 
        "field_user_nombre_2" => array("value" => $datos["nombre_2"] ), 
        "field_user_primer_apellido" => array("value" => $datos["apellidos"] ), 
        "field_user_segundo_apellido" => array("value" => $datos["apellidos_2"] ), 
        "field_user_rol_seleccion" => array("value"=> 0 ), 
        "field_user_salario_base" => array(), 
        "field_user_salario_flexibilizado" => array( 
            array( "value" => false ) 
        )
    );
    //echo '<pre>';
    //print_r(json_encode($data, JSON_UNESCAPED_SLASHES) );
    //echo '</pre>';
    
                                           
    $ch = curl_init($url);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($data) );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    //RESULTADO WS                                                                                                                                
    $result = curl_exec($ch);
    print_r($result);
}

?>