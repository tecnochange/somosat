<?php
	session_start();
	$_SESSION['id_user'] = "";
	$_SESSION['role_plataforma'] = "";
	header('Location: ../../log.php');
?>

