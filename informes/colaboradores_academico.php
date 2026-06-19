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

    <title>Fincomercio a tu Lado - Colaboradores Planta</title>
    
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
                    <h2>Fincomercio - Informe de Planta: Colaboradores Académico</h2>
                    <p>Fecha de generación: <?php echo date("Y-m-d H:i:s"); ?></p>
                </td>
            </tr>
            <tr>
                <th>#</th>
                <th>Identificación</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Area</th>
                <th>Título Obtenido</th>
                <th>Nivel de formación</th>
                <th>Área del conocimiento</th>
                <th>Entidad que otorga</th>
                <th>Fecha del Título</th>
                <th>Matricula o Tarjeta Profesional</th>
                <th>En Curso</th>
                <th>Estudia Actualmente</th>
            </tr>
        </thead>

        <tbody>
            
        <?php
            $count = 1;
            $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico GROUP BY id_empleado  ");
            while($data = mysqli_fetch_array($query)){
                
                $queryEmpleado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");
                $dataEmpleado = mysqli_fetch_array($queryEmpleado); 
                
                $queryAcademico = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico WHERE id_empleado = '".$data["id_empleado"]."'  ");
                while($dataAcademico = mysqli_fetch_array($queryAcademico)){
                    
                    echo '
                    <tr>
                        <td>'.$count.'</td>
                        <td>'.$dataEmpleado["documento"].'</td>
                        <td>'.$dataEmpleado["nombre"].'</td>
                        <td>'.$dataEmpleado["cargo"].'</td>
                        <td>'.$dataEmpleado["area"].'</td>
                        <td>'.$dataAcademico["titulo"].'</td>
                        <td>'.$dataAcademico["nivel"].'</td>
                        <td>'.$dataAcademico["area_conocimiento"].'</td>
                        <td>'.$dataAcademico["entidad"].'</td>
                        <td>'.$dataAcademico["fecha_titulo"].'</td>
                        <td>'.$dataAcademico["tarjeta_profecional"].'</td>
                        <td>'.$dataAcademico["en_curso"].'</td>
                        <td>'.$dataAcademico["estudia_actualmente"].'</td>
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
	$("#datos_a_enviar").val( $("<div>").append( $("#tabla_reporte").eq(0).clone()).html());
	$("#FormularioExportacion").submit();
}
</script>




