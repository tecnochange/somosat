<?php
    session_start();

    //VALIDACION DE SESION
    if($_SESSION['id_user'] == ""){
        header('Location: log.php' );
    }

    include("../app/models/connect.php");
    include("../app/models/library.php");

    $hoy = date("Y-m-d H:i:s");

    
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

    <title>Somos AT - Reporte Objetivos</title>
    
    <style>
        table{
            border-collapse: collapse;
            font-size: 10px;
            font-family: sans-serif;
        }
        .boton{
            background-color: #b4003b; 
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
    <input type="hidden" name="nombre" value="jefes" />
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar"  />
</form>

<body>
    <div>
        <button type="button" class="boton" onclick="exportarReporte()">
            Exportar a Excel
        </button> 
    </div>
    
    
    
    <table border="1" id="tabla_reporte" class="table table-bordered" style="margin-top: 15px">
        <thead>
            
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col">Documento</th>
                <th scope="col">Colaborador</th>
                <th scope="col">Cargo</th>
				<th scope="col">Área</th>
                <th scope="col">Objetivo</th>
				<th scope="col">Descripción del Indicador</th>
                <th scope="col">Meta</th>
                <th scope="col">Peso Ponderado</th>
                <th scope="col">Periodicidad</th>
                <th scope="col">Tipo de Objetivo</th>
                <th scope="col">Avance Seguimiento Mitad de Año</th>
                <th scope="col">Comentarios del colaborador</th>
                <th scope="col">Evaluación del Jefe</th>
                <th scope="col">Comentarios del Jefe</th>
                <th scope="col">Avance General</th>
                <th scope="col">Fecha del seguimiento</th>
                <th scope="col">Seguimiento Cierre de Objetivos</th>
                <th scope="col">Comentarios del colaborador</th>
                <th scope="col">Evaluación del Jefe</th>
                <th scope="col">Comentarios del Jefe</th>
                <th scope="col">Fecha del seguimiento</th>
                <th scope="col">Avance General</th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $hoy = date("Y-m-d H:i:s");
                $count = 1;
                
                        
                $query = mysqli_query($connect_valentina, "
                SELECT e.id, e.documento, e.nombre, e.nombre_2, e.apellidos, e.apellidos_2, c.nombre as nombre_cargo, a.nombre as nombre_area, p.id_area as id_area
				FROM Empleados e
                LEFT JOIN Posiciones p ON p.id = e.id_posicion
                LEFT JOIN Cargos c ON c.id = p.id_cargo 
                LEFT JOIN Areas a ON a.id = p.id_area 
                WHERE e.estado = 1 
                ORDER BY e.nombre ASC
                ");
                while($data = mysqli_fetch_array($query)){
					
					$queryJefes = mysqli_query($connect_valentina,"
                    SELECT j.id, e.documento, e.nombre, e.nombre_2, e.apellidos, e.apellidos_2, e.documento, c.nombre as nombre_cargo, a.nombre as nombre_area FROM Jefes j
                    INNER JOIN Empleados e ON e.id = j.id_jefe
                    LEFT JOIN Posiciones p ON p.id = e.id_posicion
                    LEFT JOIN Cargos c ON c.id = p.id_cargo 
					LEFT JOIN Areas a ON a.id = p.id_area 
                    WHERE j.id_empleado = '".$data["id"]."'
                    ");
                	$dataJefes = mysqli_fetch_array($queryJefes);
					
					
					$queryArea = mysqli_query($connect_valentina,"
                    SELECT * FROM Areas WHERE id = '".$data["id_area"]."' ");
                	$dataArea = mysqli_fetch_array($queryArea);
					
					
					
					$count = 1;
                    
					$queryObjetivos = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
                    WHERE anio = '".$_SESSION['anio']."' 
                    AND id_empleado = '".$data['id']."' ORDER BY id ASC "); 
                    while($dataObjetivos = mysqli_fetch_array($queryObjetivos)){ 
						
                        $obj_resultados = json_decode($dataObjetivos["obj_meses_resultados"], true);
						$resultados_obj = $obj_resultados[0]["meta"];
						$meta_obj = $dataObjetivos["meta"];
						
						$avance_uno =  $resultados_obj*100/$meta_obj;
						$avance_uno = round($avance_uno, 1);
						
						//CIERRE
						$resultados_obj_2 = $obj_resultados[1]["meta"];
						$meta_obj = $dataObjetivos["meta"];
						
						$avance_dos =  $resultados_obj_2*100/$meta_obj;
						$avance_dos = round($avance_dos, 1);
                        
                        
                        $total_avance_general += $avance_uno + $avance_dos;
                        
                        

						$txt_tipo = "";
						foreach($Array_Tipo_Desempenio_Objetivos as $objetivo){
							if($objetivo[0] == $dataObjetivos["tipo"]){
								$txt_tipo = $objetivo[1];
							}
						}
						$txt_periodicidad = "";
						$queryPer = mysqli_query($connect_desempenio,"SELECT * FROM Periodicidad  ");
						while($dataPer = mysqli_fetch_array($queryPer)){
							if($dataPer["id"] == $dataObjetivos["periodicidad"] ){
								$txt_periodicidad = $dataPer["nombre"];
							}
						}
						
						$comentarios = "";
						$queryComentarios = mysqli_query($connect_desempenio,"SELECT * FROM Observaciones_Mes 
                    	WHERE anio = '".$_SESSION['anio']."' 
                    	AND id_objetivo = '".$dataObjetivos['id']."' AND mes = 1 "); 
                    	while($dataComentarios = mysqli_fetch_array($queryComentarios)){ 
							$comentarios .= $dataComentarios["observacion"]."<br>";
						}
						
						$comentarios_cierre = "";
						$queryComentarios2 = mysqli_query($connect_desempenio,"SELECT * FROM Observaciones_Mes 
                    	WHERE anio = '".$_SESSION['anio']."' 
                    	AND id_objetivo = '".$dataObjetivos['id']."' AND mes = 2 "); 
                    	while($dataComentarios2 = mysqli_fetch_array($queryComentarios2)){ 
							$comentarios_cierre .= $dataComentarios2["observacion"]."<br>";
						}

						echo '
							<tr>
								<td>' . $count . '</td>
								<td>' . $data["documento"] . '</td>
								<td>' . $data["nombre"] . ' ' . $data["nombre_2"] . ' ' . $data["apellidos"] . ' ' . $data["apellidos_2"] . ' </td>
								<td>' . $data["nombre_cargo"] . '</td>
								<td>' . $data["nombre_area"] . '</td>
								<td>'.$dataObjetivos["objetivo"].'</td>
								<td>'.$dataObjetivos["indicador"].'</td>
								<td>'.$dataObjetivos["meta"].'</td>
								<td>'.$dataObjetivos["ponderado"].' %</td>
								<td>'.$txt_periodicidad.'</td>
								<td>'.$txt_tipo.'</td>
								<td>'.$avance_uno.' %</td>
								<td>'.$comentarios.'</td>
								<td></td>
								<td>'.$dataObjetivos["comentario_seguimiento"].'</td>
								<td>'.$avance_uno.' %</td>
								<td>'.$dataObjetivos["created_at"].'</td>
								<td>'.$avance_dos.' %</td>
								<td>'.$comentarios_cierre.'</td>
								<td></td>
								<td></td>
								<td></td>
								<td>' . ($avance_uno + $avance_dos) . ' %</td>
							</tr>
						';

						$count++;
						
						
					}
					
					if($queryObjetivos->num_rows == 0){
						echo '
							<tr>
								<td>' . $count . '</td>
								<td>' . $data["documento"] . '</td>
								<td>' . $data["nombre"] . ' ' . $data["nombre_2"] . ' ' . $data["apellidos"] . ' ' . $data["apellidos_2"] . '</td>
								<td>' . $data["nombre_cargo"] . '</td>
								<td>' . $data["nombre_area"] . '</td>
								<td>' . $dataPadre["nombre"] . '</td>
								<td>' . $dataJefes["documento"] . '</td>
								<td>' . $dataJefes["nombre"] . ' ' . $dataJefes["nombre_2"] . ' ' . $dataJefes["apellidos"] . ' ' . $dataJefes["apellidos_2"] . '</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						';

						$count++;
					}
					
                    
                    

                }
            ?>
            
            
                            
            
        </tbody>
    </table>
</body>
</html>

<script>
function exportarReporte(){
	$("#datos_a_enviar").val( $("#tabla_reporte").eq(0).clone().html() );
	$("#FormularioExportacion").submit();
}
</script>
