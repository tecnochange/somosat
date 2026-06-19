<?php 
	session_start();
    //VALIDACION DE SESION
    if($_SESSION['id_user'] == ""){
        header('Location: log.php' );
    }

    include("../app/models/connect.php");
    include("../app/models/library.php");

	$hoy = date("Y-m-d H:i:s");
	$ahora = date("Y-m-d");
	//FUNCION PARA OBTENER LOS AÑOS
	function Anios($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

		$years  = floor($dateDifference / (365 * 60 * 60 * 24));
		$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

		$decimal2 = ($months*30+$days)/365;
		$decimal2 = round($decimal2, 1);
		$parte2 = explode(".", $decimal2);

		return ($years.".".$parte2[1]." años");
	}

	//FUNCION PARA OBTENER LOS AÑOS
	function Dias($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
		
		$dias  = floor($dateDifference / ( 60 * 60 * 24));

		return $dias ;
	}
?>





<!DOCTYPE html>
<html>

<head>
    <!-- metas -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="HR Suite">

    <title>Somos AT - Innovando Juntos - Bajas</title>
    
    <style>
        table{
            border-collapse: collapse;
            font-size: 10px;
            font-family: sans-serif;
        }
        .boton{
            background-color: #0364ba; 
            color: #ffffff;
            padding: 6px 20px;
            border: 0;
            border-radius: 7px;
        }
    </style>
    <script src="<?php echo $url; ?>/js/jquery-3.3.1.js"></script>
    
</head>

    
<!-- export-->
<form action="exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
</form>

<body>
    <div style="margin-bottom: 10px">
        <button type="button" class="boton" onclick="exportarReporte()">
            Exportar a Excel
        </button> 
    </div>

    <table border="1" id="tabla_reporte">
        <thead>
            <tr>
                <td colspan="49">
                    <h2>Somos AT - Bajas</h2>
                    <p>Fecha de generación: <?php echo date("Y-m-d H:i:s"); ?></p>
                </td>
            </tr>
            <tr>
                	<th scope="col" width="15">#</th>
                    <th scope="col">Nombres y Apellidos</th>
                    <th scope="col" >Fecha de inactivación</th>
					<th scope="col" >Observaciones</th>
					<th scope="col" >Motivo del retiro</th>
            </tr>
        </thead>

        <tbody>
			<?php
                    $hoy = date("Y-m-d H:i:s");
                    $count = 1;
                    $sentencia = "SELECT * FROM Empleados WHERE fecha_inactivacion != '' AND estado = 2 ORDER BY fecha_inactivacion DESC; ";
                $query = mysqli_query($connect_valentina, $sentencia);  
                while($data = mysqli_fetch_array($query)){ 

                    echo '
                    <tr>
                        <td>'.$count.'</td>
                    	<td class="align-middle">'.$data["nombre"].' '.$data["nombre_2"].' '.$data["apellidos"].' '.$data["apellidos_2"].'</td>
                    	<td class="align-middle">'.$data["fecha_inactivacion"].'</td>
                    	<td class="align-middle">'.$data["observaciones_inactivacion"].'</td>
                    	<td class="align-middle">'.$data["motivo_retiro"].'</td>
                    </tr>
                    ';
                    $count++;
                }
                ?>
        </tbody>
    </table>    
    
</body>
</html>

<script>
function exportarReporte(){
	$("#datos_a_enviar").val( $("<div>").append( $("#tabla_reporte").eq(0).clone()).html());
	$("#FormularioExportacion").submit();
}
</script>




