<?php

function ApiRequicisiones(){
    date_default_timezone_set('America/Bogota');

    $tipo_token = 'Authorization';
    $token = 'Basic cmNhcnJhc2NhbDpGb3J0dW5hOQ==';
    $isuario = $_GET["id"];
    $url_autenticacion = 'https://creeser.hr-suite.app/es/api/requisiciones?Authorization='.$token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_autenticacion ); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    $data = curl_exec($ch);
    $array_datos = json_decode($data, JSON_UNESCAPED_SLASHES);
    curl_close($ch); 
    
    return $array_datos;
}

function ApiRequicision($id){
    date_default_timezone_set('America/Bogota');

    $tipo_token = 'Authorization';
    $token = 'Basic cmNhcnJhc2NhbDpGb3J0dW5hOQ==';
    $isuario = $_GET["id"];
    $url_autenticacion = 'https://creeser.hr-suite.app/es/api/requisiciones?Authorization='.$token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_autenticacion ); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    $data = curl_exec($ch);
    $array_datos = json_decode($data, JSON_UNESCAPED_SLASHES);
    
    $nodo;
    foreach($array_datos as $requicision){
        if($id == $requicision["id"]){
            $nodo = $requicision;
        }
    }
    curl_close($ch); 

    return $nodo;
}

?>