<?php
    session_start();
    //VALIDACION DE SESION
    if($_SESSION['id_user_valentina'] == ""){
        header('Location: log.php' );
    }

    include("../app/models/connect.php");
    include("../app/models/library.php");

    $hoy = date("Y-m-d H:i:s");

    $qryEmpleado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION['id_user_valentina']."' ");
    $dtEmpleado = mysqli_fetch_array($qryEmpleado);

    $qryAdicionales = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
    $dtAdicionales = mysqli_fetch_array($qryAdicionales);

    $qryEditar = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Editar WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
    $dtEditar = mysqli_fetch_array($qryEditar);

    $qryPerfiles = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
    $dtPerfiles = mysqli_fetch_array($qryPerfiles);

    $qryPreferencias = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
    $dtPreferencias = mysqli_fetch_array($qryPreferencias);

    $qryEmergencia = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Emergencia WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
    $dtEmergencia = mysqli_fetch_array($qryEmergencia);
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

    <title>Fincomercio a tu Lado - Cargos</title>
    
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
                    <h2>Fincomercio - Informe de Cargos</h2>
                    <p>Fecha de generación: <?php echo date("Y-m-d H:i:s"); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col" >Cargo</th>
                <th scope="col" >Código</th>
                <th scope="col">Nivel</th>
                <th scope="col">Gerencia</th>
                <th scope="col">Área</th>
                <th scope="col">No. Colaboradores</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>

        <tbody>
            
        <?php
            $count = 1;
            $query = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                while($data = mysqli_fetch_array($query)){
					
					$querySub = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE nombre = '".$data["subgerencia"]."' ");  
                    $dataSub = mysqli_fetch_array($querySub);
					
					//mysqli_query($connect_valentina, "UPDATE Posiciones SET id_subgerencia = '".$dataSub["id"]."' WHERE id = '".$data["id"]."' " ); 
					
					
					$senticia_pos = "INSERT INTO Posiciones ( id_cargo ,  id_area ,  id_nivel ,  id_compania ,  id_centro_costos ,  id_subgerencia ,  estado , created_at ) 
					VALUES 
					( '".$data["id"]."', '".$data["id_area"]."', '".$data["id_nivel"]."', 1, 0, 0, 1, '".$hoy."'  )";
					
					//print_r($senticia_pos);
					
					//mysqli_query($connect_valentina, $senticia_pos ); 
					
					
					
                    
                    $id_nivel = 0;
                    foreach($Array_Nivel_Cargo as $nivel){
                        if($nivel[1] == $data["nivel_jerarquico"]){
                            $id_nivel = $nivel[0];
                        }
                    }

                    $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE nombre = '".$data["area"]."' ");  
                    $dataArea = mysqli_fetch_array($queryArea);
                    
                    $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE cargo = '".$data["nombre"]."' ");  
                    
                    
                    //mysqli_query($connect_valentina,"UPDATE Cargos SET id_nivel = '".$id_nivel."' WHERE id = '".$data["id"]."' ");
                    
                    
                    $queryNivel = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo WHERE id = '".$data["id_nivel"]."' ");  
                    $dataNivel = mysqli_fetch_array($queryNivel);
                    
                    $queryGerencia = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data["id_gerencia"]."' ");  
                    $dataGerencia = mysqli_fetch_array($queryGerencia);

                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
                        
                    $bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=administrar/cargo/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </a>
                        ';
                    }
    
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].'</td>
                            <td>'.$data["codigo"].'</td>
                            <td>'.$data["nivel_jerarquico"].'</td>
                            <td>'.$data["subgerencia"].'</td>
                            <td>'.$data["area"].'</td>
                            <td>'. $queryEmpleados->num_rows.'</td>
                            <td>'.$txt_estado.'</td>
                            
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
