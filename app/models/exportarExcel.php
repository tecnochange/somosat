<?php
	$fecha = date("d/m/y");

	header("Content-type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: filename=Reporte_Somos_AT_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo utf8_decode($_POST['datos_a_enviar']);
?>