<?php
    define('DURACION_SESION','14400'); //4 horas
    ini_set("session.cookie_lifetime",DURACION_SESION);
    ini_set("session.gc_maxlifetime",DURACION_SESION); 
    session_cache_expire(DURACION_SESION);

    date_default_timezone_set('America/Montevideo');
    setlocale(LC_TIME,"es_ES");

    //BASE DE DATOS ADMINISTRACION
    $connect_valentina = mysqli_connect("localhost", "SomosAtUser", "AtSmsP2022!", "somosat_admin") or die("sin conexion");
	mysqli_set_charset($connect_valentina,"utf8");

    //VALORACION DE COMPETENCIAS
    $connect_valoracion = mysqli_connect("localhost", "SomosAtUser", "AtSmsP2022!", "somosat_valoracion") or die("sin conexion");
	mysqli_set_charset($connect_valoracion,"utf8");

	//VALORACION DE COMPETENCIAS
    $connect_formacion = mysqli_connect("localhost", "SomosAtUser", "AtSmsP2022!", "somosat_formacion") or die("sin conexion");
	mysqli_set_charset($connect_formacion,"utf8");

	//DESEMPENIO
    $connect_desempenio = mysqli_connect("localhost", "SomosAtUser", "AtSmsP2022!", "somosat_desempenio") or die("sin conexion");
	mysqli_set_charset($connect_desempenio,"utf8");

    //ENDOMARKETING
    $connect_endomarketing = mysqli_connect("localhost", "SomosAtUser", "AtSmsP2022!", "somosat_endomarketing") or die("sin conexion");
    mysqli_set_charset($connect_endomarketing, "utf8");

  

    $url = 'https://'.$_SERVER['SERVER_NAME'];
    $recursos_hv = 'https://'.$_SERVER['SERVER_NAME'].'/recursos';
    $api = $url.'/api';







	$uri_ruta = $url.$_SERVER['REQUEST_URI'];
	$recursos_local = $_SERVER['DOCUMENT_ROOT'].'/recursos/';
	$recursos_plubico = $url.'/recursos';	
		
?>

