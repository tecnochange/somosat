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

    <title>Fincomercio a tu Lado - Informe Áreas</title>
    
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
                    <h2>Fincomercio - Informe de Áreas</h2>
                    <p>Fecha de generación: <?php echo date("Y-m-d H:i:s"); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col">Área</th>
                <th scope="col"># Cargos</th>
                <th scope="col">Subgerencia</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>

        <tbody>
            
        <?php
            $count = 1;
            $query = mysqli_query($connect_valentina,"SELECT * FROM Areas ORDER BY nombre ASC ");  
                    while($data = mysqli_fetch_array($query)){ 

                        $queryPadre = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE nombre = '".$data["subgerencia"]."' ");  
                        $dataPadre = mysqli_fetch_array($queryPadre);

                        //mysqli_query($connect_valentina,"UPDATE Areas SET padre = '".$dataPadre["id"]."' WHERE id = '".$data["id"]."' ");  

                        $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_area = '".$data["id"]."' ");  

                        $txt_nivel = '';
                        foreach($Array_Jerarquia as $nivel){
                            if($nivel[0] == $data["jerarquia"]){ $txt_nivel = $nivel[1]; }
                        }

                        $txt_estado = '';
                        foreach($Array_Estado as $nivel){
                            if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                        }

                        $bt_editar = 'n/a';
                        if($user_log["role"] == 1){
                            $bt_editar = '
                                <a href="'.$url.'?pg=administrar/area/detalle&id='.$data["id"].'">
                                    <button type="button" class="btn btn-outline-success btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                            ';
                        }

                        echo '
                            <tr>
                                <td>'.$count.'</td>
                                <td>'.$data["nombre"].'</td>
                                <td><b>'.$queryCargos->num_rows.'</b></td>
                                <td>'.$dataPadre["nombre"].'</td>
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
