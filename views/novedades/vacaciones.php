<script>
    $(document).ready(function() {
        $("#novedades_menu").addClass("active");
        $("#desplegable_novedades").show();
        $("#bt_novedades_vacaciones").addClass("active_item");
    });
</script>
<?php
require("app/models/Areas.php");
$ClassAreas = new Areas();
$areas = $ClassAreas->lista($connect_valentina);
$idPosicionEmpleado=$user_log["id_posicion"];
$estado = $_POST["estado"];
$id_Registro = $_POST["id_registro"];
$observaciones = $_POST["observaciones"];
if ($estado) {
    $actualizar_Estado=mysqli_query($connect_nomina, "UPDATE Vacaciones set estado='$estado',  observaciones='$observaciones'  WHERE id='$id_Registro'");
    $ultimoRegistro=mysqli_insert_id($connect_nomina);
    $query = mysqli_query($connect_nomina, "SELECT * FROM Vacaciones WHERE id = '" . $ultimoRegistro . "' ");
    while ($result = mysqli_fetch_array($query)) {
        $estadoSolicitud = $result["estado"];
        $idEmpleadoBuscar = $result["id_empleado"];
        $query2 = mysqli_query($connect_nomina, "SELECT * FROM Empleados WHERE id_posicion = '" . $idEmpleadoBuscar . "' ");
        while ($result2 = mysqli_fetch_array($query2)) {
            $mail = $result2["correo_2"];
            $nombremail = $result2["nombre"].' '.$result2["nombre_2"].' '.$result2["apellidos"].' '.$result2["apellidos_2"];
            include("../../mail/vacaciones_notificacion.php");
        }
    }

}


//OBTENER NOMBRE E ID RESPONSABLE (JEFE INMEDIATO) a partir de la posicion del empleado
/*$jefeInmediato = mysqli_query($connect_valentina,"SELECT id_dep_jerarquica FROM Posiciones WHERE id='".$user_log['id_posicion']."'");
while ($data = mysqli_fetch_array($jefeInmediato)) {
   echo $pos_jefeInmediato = $data['id_dep_jerarquica'];
    $idjefeInmediato = mysqli_query($connect_valentina,"SELECT documento FROM Posiciones WHERE id='".$pos_jefeInmediato."'");
    while ($data2 = mysqli_fetch_array($idjefeInmediato)) {
        $id_jefeInmediato = $data2['documento'];   
        $idjefeInmediato2 = mysqli_query($connect_valentina,"SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
        while ($data3 = mysqli_fetch_array($idjefeInmediato2)) {
            echo $nombre_jefeInmediato = $data3['nombre'].' '.$data3['nombre_2'].' '.$data3['apellidos'].' '.$data3['apellidos_2'];   
        }
    }
}*/


//REVISION DE SI EL PERFIL TIENE EMPLEADOS A CARGO
$revisionSub = mysqli_query($connect_valentina, "SELECT COUNT(*) AS VALOR FROM Posiciones WHERE id_dep_jerarquica='".$user_log["id_posicion"]."'");
while($data=mysqli_fetch_array($revisionSub)){
   $revision= $data["VALOR"];
}



?>

<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Vacaciones</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=novedades/vacaciones">Vacaciones</a></li>
                    <li class="breadcrumb-item">Vacaciones</li>
                </ol>
            </div>
            <div class="col-sm-6" align="right">
                
                    <a href="<?php echo $url; ?>?pg=novedades/vacaciones/detalle">
                        <button type="button" class="btn btn-outline-primary">Solicitar Vacaciones</button>
                    </a>
               
                    <a href="<?php echo $url; ?>/informes/resumen_vacaciones.php?idposicion=<?php echo $idPosicionEmpleado ?>"  >
                        <button type="button" class="btn btn-secondary">Generar Reporte</button>
                    </a>
                               
            </div>           
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <!-- Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="barra_superior">
                    <div class="container mb-5">
                    <div class="row">
                        <div class="col">
                    <a class="btn btn-primary w-50 d-flex text-center pb-4 " data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Vacaciones por Revisar 
                    </a>
                    </div>
                    <div class="col">
                    <a class="btn btn-primary w-50 d-flex" data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Vacaciones Aprobadas / Rechazadas
                    </a>
                    </div>
                    </div>
                    </div>
            <div class="collapse" id="collapseExample1">

        <?php if($revision>0){
        ?>
        <h2 class='text-center'>Vacaciones por Revisar</h2>
                   <div class="table-responsive w-100">
                        <table id="tabla_maestra" class="display" width="100%" style="font-size: 12px">
                            <thead class="bg-secondary">
                                <tr>
                                    <th>#</th>
                                    <th>Autorizado por</th>
                                    <th>Empleado</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Fecha Regreso</th>
                                    <th>Días tomados</th>
                                    <th>Días en dinero</th>
                                    <th>Total días</th>
                                    <th>Radicado</th>
                                    <th>Fecha Radicado</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                $query = mysqli_query($connect_nomina, "SELECT * FROM Vacaciones WHERE id_responsable = '" . $user_log['id_posicion'] . "'ORDER BY estado DESC ");
                                while ($area = mysqli_fetch_array($query)) {
                                    $fecha_inicio = $area["fecha_inicio"];
                                    $fecha_fin = $area["fecha_fin"];
                                    $estadoRadicado = $area["estado"];
                                    if($estadoRadicado==1){
                                    
                                    $bt_editar = '';
                                    if ($user_log["role"] == 1 || $user_log["id"]=46) {
                                        $bt_editar = '
                                <a href="' . $url . '?pg=novedades/vacaciones/detalle2&id=' . $area["id"] . '" class="btn btn-outline-primary btn-sm" title="Ver">
                                    <i class="fa fa-edit"></i>
                                </a>
                                ';}
                                    $query_username = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE id = '" . $_SESSION['id_user_valentina'] . "' ");
                                    while ($data_username = mysqli_fetch_array($query_username)) {
                                        $nombre_usuario = $data_username['nombre'];
                                        $nombre_usuario2 = $data_username['nombre_2'];
                                        $apellido_usuario = $data_username['apellidos'];
                                        $apellido_usuario2 = $data_username['apellidos_2'];
                                    }
                                    $dias_totales = $area["dias_disfrutados"] + $area["dias_dinero"];

                                    echo '
                                <tr>
                                    <td>' . $count . '</td>
                                    <td>' . $nombre_usuario . ' ' . $nombre_usuario2 . ' ' . $apellido_usuario . ' ' . $apellido_usuario2 . ' </td>';

                                    $idjefeInmediato = mysqli_query($connect_valentina,"SELECT documento FROM Posiciones WHERE id='".$area['id_empleado']."'");
                                    while ($data2 = mysqli_fetch_array($idjefeInmediato)) {
                                         $id_jefeInmediato = $data2['documento'];   
                                        $idjefeInmediato2 = mysqli_query($connect_valentina,"SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                        //print_r("SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                        while ($data3 = mysqli_fetch_array($idjefeInmediato2)) {
                                             $nombre_jefeInmediato2 = $data3['nombre'].' '.$data3['nombre_2'].' '.$data3['apellidos'].' '.$data3['apellidos_2'];   
                                        }
                                    }

                                    echo '<td>' . $nombre_jefeInmediato2 .'</td>
                                    <td align="center">' . $area["fecha_inicio"] . '</td>
                                    <td align="center">' . $area["fecha_fin"] . '</td>
                                    <td align="center">' . $area["fecha_regreso"] . '</td>
                                    <td align="center">' . $area["dias_disfrutados"] . '</td>
                                    <td align="center">' . $area["dias_dinero"] . '</td>
                                    <td align="center">' . $dias_totales . '</td>
                                    <td align="center">00'.$area["id"].'</td>
                                    <td align="center">'.$area["created_at"].'</td>
                                    <td align="center">';

                                    if ($area["estado"]==1) {
                                        echo '
                                        <form method="post" action="">
                                        <input type="hidden" name="id_registro" value="'.$area["id"].'" " />
                                        <select class="form-control w-100 mb-2 text-center" name="estado" id="estado" required style="width:45%; display:inline">';
                                        if ($user_log["role"] == 1|| $user_log["role"] == 2 || $user_log["id"]=46) {
                                            foreach ($Array_Estado_Solicitud_Vacaciones as $nivel) {
                                                if ($area["estado"] == $nivel[0]) {
                                                    $valor=$nivel[0];
                                                    echo "el valor es:".$valor;
                                                    echo '<option value="' . $nivel[0] . '" selected>' . $nivel[1] . '</option>';
                                                } else {
                                                    echo '<option value="' . $nivel[0] . '">' . $nivel[1] . '</option>';
                                                }
                                            }
                                        }
                                        echo '</select>
                                        <input class="btn btn-danger" type="submit" value="Radicar">
                                        <label for="observaciones"> Observaciones </label> </br>
                                        <input type="text" name="observaciones" placholder="Observaciones" style="width:100%" value="'.$area["observaciones"].'">
                                        </form>';
                                    }
                                    else{
                                        echo '
                                        <input type="hidden" name="id_registro" value="'.$area["id"].'" " />';
                                        
                                        if ($user_log["role"] == 1|| $user_log["role"] == 2 || $user_log["id"]=46) {
                                            foreach ($Array_Estado_Solicitud_Vacaciones as $nivel) {
                                                if ($area["estado"] == $nivel[0]) {
                                                    $valor=$nivel[0];                                                  
                                                    echo '<input type="text" class="text-center readonly "' . $nivel[0] . '" value=' . $nivel[1] .'>';
                                                } else {
                                                }
                                            }
                                        }
                                        echo '
                                        <label for="observaciones"> Observaciones </label> </br>
                                        <input type="text" readonly name="observaciones" placholder="Observaciones" style="width:100%" value='.$area["observaciones"].'>';
                                    }
                                    
                                    echo'                                 
                                    </td>
                                    <td  align="center">
                                    '.$bt_editar.'
                                </td>
                            </a>
                                    </tr>
                            ';
                                    $count++;
                                }
                            }
                                ?>

                            </tbody>
                        </table>
                    </div>
                   
            <!-- Configuration  Ends-->
        <?php 
        }
        
        ?>
        </div>
        <div class="collapse" id="collapseExample3">

<?php if($revision>0){
?>
<h2 class='text-center'>Vacaciones Aprobadas / Rechazadas</h2>
           <div class="table-responsive">
                <table id="tabla_maestra1" class="display" width="100%" style="font-size: 12px">
                    <thead class="bg-secondary">
                        <tr>
                            <th>#</th>
                            <th>Autorizado por</th>
                            <th>Empleado</th>
                            <th>Fecha Solicitud</th>
                            <th>Días tomados</th>
                            <th>Días en dinero</th>
                            <th>Total días</th>
                            <th>Radicado</th>
                            <th>Fecha Radicado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        $query = mysqli_query($connect_nomina, "SELECT * FROM Vacaciones WHERE id_responsable = '" . $user_log['id_posicion'] . "'ORDER BY estado DESC ");
                        while ($area = mysqli_fetch_array($query)) {
                            $estadoRadicado = $area["estado"];
                            if($estadoRadicado!=1){
                            
                            $bt_editar = '';
                            if ($user_log["role"] == 1 || $user_log["id"]=46) {
                                $bt_editar = '
                        <a href="' . $url . '?pg=novedades/vacaciones/detalle2&id=' . $area["id"] . '" class="btn btn-outline-primary btn-sm" title="Ver">
                            <i class="fa fa-edit"></i>
                        </a>
                        ';}
                            $query_username = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE id = '" . $_SESSION['id_user_valentina'] . "' ");
                            while ($data_username = mysqli_fetch_array($query_username)) {
                                $nombre_usuario = $data_username['nombre'];
                                $nombre_usuario2 = $data_username['nombre_2'];
                                $apellido_usuario = $data_username['apellidos'];
                                $apellido_usuario2 = $data_username['apellidos_2'];
                            }
                            $dias_totales = $area["dias_disfrutados"] + $area["dias_dinero"];

                            echo '
                        <tr>
                            <td>' . $count . '</td>
                            <td>' . $nombre_usuario . ' ' . $nombre_usuario2 . ' ' . $apellido_usuario . ' ' . $apellido_usuario2 . ' </td>';

                            $idjefeInmediato = mysqli_query($connect_valentina,"SELECT documento FROM Posiciones WHERE id='".$area['id_empleado']."'");
                            while ($data2 = mysqli_fetch_array($idjefeInmediato)) {
                                 $id_jefeInmediato = $data2['documento'];   
                                $idjefeInmediato2 = mysqli_query($connect_valentina,"SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                //print_r("SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                while ($data3 = mysqli_fetch_array($idjefeInmediato2)) {
                                     $nombre_jefeInmediato2 = $data3['nombre'].' '.$data3['nombre_2'].' '.$data3['apellidos'].' '.$data3['apellidos_2'];   
                                }
                            }

                            echo '<td>' . $nombre_jefeInmediato2 .'</td>
                            <td align="center">' . $area["fecha_inicio"] . '</td>
                            <td align="center">' . $area["dias_disfrutados"] . '</td>
                            <td align="center">' . $area["dias_dinero"] . '</td>
                            <td align="center">' . $dias_totales . '</td>
                            <td align="center">00'.$area["id"].'</td>
                            <td align="center">'.$area["created_at"].'</td>
                            <td align="center">';

                            if ($area["estado"]==1) {
                                echo '
                                <form method="post" action="">
                                <input type="hidden" name="id_registro" value="'.$area["id"].'" " />
                                <select class="form-control w-100 mb-2 text-center" name="estado" id="estado" required style="width:45%; display:inline">';
                                if ($user_log["role"] == 1|| $user_log["role"] == 2 || $user_log["id"]=46) {
                                    foreach ($Array_Estado_Solicitud_Vacaciones as $nivel) {
                                        if ($area["estado"] == $nivel[0]) {
                                            $valor=$nivel[0];
                                            echo "el valor es:".$valor;
                                            echo '<option value="' . $nivel[0] . '" selected>' . $nivel[1] . '</option>';
                                        } else {
                                            echo '<option value="' . $nivel[0] . '">' . $nivel[1] . '</option>';
                                        }
                                    }
                                }
                                echo '</select>
                                <input class="btn btn-danger" type="submit" value="Radicar">
                                <label for="observaciones"> Observaciones </label> </br>
                                <input type="text" name="observaciones" placholder="Observaciones" style="width:100%" value="'.$area["observaciones"].'">
                                </form>';
                            }
                            else{
                                echo '
                                <input type="hidden" name="id_registro" value="'.$area["id"].'" " />';
                                
                                if ($user_log["role"] == 1|| $user_log["role"] == 2 || $user_log["id"]=46) {
                                    foreach ($Array_Estado_Solicitud_Vacaciones as $nivel) {
                                        if ($area["estado"] == $nivel[0]) {
                                            $valor=$nivel[0];                                                  
                                            echo '<input type="text" class="text-center readonly "' . $nivel[0] . '" value=' . $nivel[1] .'>';
                                        } else {
                                        }
                                    }
                                }
                                echo '
                                <label for="observaciones"> Observaciones </label> </br>
                                <input type="text" readonly name="observaciones" placholder="Observaciones" style="width:100%" value='.$area["observaciones"].'>';
                            }
                            
                            echo'                                 
                            </td>
                            <td  align="center">
                            '.$bt_editar.'
                        </td>
                    </a>
                            </tr>
                    ';
                            $count++;
                        }
                    }
                        ?>

                    </tbody>
                </table>
            </div>
           
    <!-- Configuration  Ends-->
<?php 
}

?>
</div>        
    </div>
        <!-- Configuration  Starts-->
        <p>
                <a class="btn btn-primary w-100" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Mis Vacaciones
                </a>
            </p>
            <div class="collapse" id="collapseExample">
            <h2 class='text-center'>Mis Vacaciones</h2>
                    <div class="table-responsive">
                        <table id="tabla_maestra2" class="display" width="100%" style="font-size: 12px">
                            <thead class="bg-secondary">
                                <tr>
                                    <th>#</th>
                                    <th>Empleado</th>
                                    <th>Autorizado por</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Días tomados</th>
                                    <th>Días en dinero</th>
                                    <th>Total días</th>
                                    <th>Radicado</th>
                                    <th>Fecha Radicado</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                $query = mysqli_query($connect_nomina, "SELECT * FROM Vacaciones WHERE id_empleado = '" . $user_log['id_posicion'] . "' ORDER BY estado ASC");
                                while ($area1 = mysqli_fetch_array($query)) {

                                    $bt_editar = '';
                                    if ($user_log["role"] == 1 || $user_log["id"]=46) {
                                        $bt_editar = '
                                <a href="' . $url . '?pg=novedades/vacaciones/detalle&id=' . $area["id"] . '" class="btn btn-outline-primary btn-sm" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                ';}
                                    $query_username = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE id = '" . $_SESSION['id_user_valentina'] . "' ");
                                    while ($data_username = mysqli_fetch_array($query_username)) {
                                        $nombre_usuario = $data_username['nombre'];
                                        $nombre_usuario2 = $data_username['nombre_2'];
                                        $apellido_usuario = $data_username['apellidos'];
                                        $apellido_usuario2 = $data_username['apellidos_2'];
                                    }
                                    $dias_totales = $area["dias_disfrutados"] + $area["dias_dinero"];

                                    echo '
                                <tr>
                                    <td>' . $count . '</td>
                                    <td>' . $nombre_usuario . ' ' . $nombre_usuario2 . ' ' . $apellido_usuario . ' ' . $apellido_usuario2 . ' </td>';                                   
                                    $idjefeInmediato1 = mysqli_query($connect_valentina,"SELECT documento FROM Posiciones WHERE id='".$area1['id_responsable']."'");
                                    //print_r("SELECT documento FROM Posiciones WHERE id='".$data['id_responsable']."'");
                                    while ($data2 = mysqli_fetch_array($idjefeInmediato1)) {
                                        $id_jefeInmediato1 = $data2['documento'];   
                                        $idjefeInmediato21 = mysqli_query($connect_valentina,"SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato1."'");
                                        //print_r("SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                        while ($data3 = mysqli_fetch_array($idjefeInmediato21)) {
                                             $nombre_jefeInmediato21 = $data3['nombre'].' '.$data3['nombre_2'].' '.$data3['apellidos'].' '.$data3['apellidos_2'];   
                                        }
                                    }
                                    
                                    echo '<td>' . $nombre_jefeInmediato21 .'</td>
                                    <td align="center">' . $area1["fecha_inicio"] . '</td>
                                    <td align="center">' . $area1["dias_disfrutados"] . '</td>
                                    <td align="center">' . $area1["dias_dinero"] . '</td>
                                    <td align="center">' . $area1["total_dias"] . '</td>
                                    <td align="center">00'.$area1["id"].'</td>
                                    <td align="center">'.$area1["created_at"].'</td>
                                    <td align="center">';
                                    
                                    if ($user_log["role"] == 1|| $user_log["role"] == 2 || $user_log["id"]=46) {                                        
                                        foreach ($Array_Estado_Solicitud_Vacaciones as $nivel) {
                                            if ($area1["estado"] == $nivel[0]) {
                                                echo '<input type="text" class="text-center readonly "' . $nivel[0] . '" value=' . $nivel[1] .'>';
                                            } 
                                        }
                                    }                      
                                echo '                                    
                                </a>
                                    </td>
                                    <td align="center">' . $area1["observaciones"] . '</td>
                                </tr>
                            ';
                                    $count++;
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Configuration  Ends-->

    </div>
</div>



<!-- PARA CREAR LA TABLA DINAMICA -->
<style>


    .div_content {
        height: 10px;
    }
</style>

<script>
    $(document).ready(function() {
        $('#tabla_maestra').DataTable();
        $('.div_content').width($('#tabla_maestra').width());
    });

    $(document).ready(function() {
        $('#tabla_maestra1').DataTable();
        $('.div_content').width($('#tabla_maestra1').width());
    });

    $(document).ready(function() {
        $('#tabla_maestra2').DataTable();
        $('.div_content').width( $('#tabla_maestra2').width() );
    } );

    $(document).ready(function() {
        $('#tabla_maestra3').DataTable();
        $('.div_content').width( $('#tabla_maestra3').width() );
    } );    

    $(function(){
        $(".barra_superior").scroll(function(){
            $(".table-responsive").scrollLeft($(".barra_superior").scrollLeft());
        });
        $(".table-responsive").scroll(function(){
            $(".barra_superior").scrollLeft($(".table-responsive").scrollLeft());
        });
    }); 
</script>