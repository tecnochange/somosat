<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
    $("#desplegable_novedades").show();
    $("#bt_novedades_permisos").addClass("active_item");
});
</script>


<?php
$user_log["id_posicion"];
$estado = $_POST["estado"];
$observaciones = $_POST["observaciones"];
$id_Registro = $_POST["id_registro"];
if ($estado) {
    $actualizar_Estado=mysqli_query($connect_nomina, "UPDATE Permisos set estado='$estado', observaciones='$observaciones'  WHERE id='$id_Registro'");
    $ultimoRegistro=mysqli_insert_id($connect_nomina);
/*    $query = mysqli_query($connect_nomina, "SELECT * FROM Vacaciones WHERE id = '" . $ultimoRegistro . "' ");
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
*/
}


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
                  <h3>Permiso</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Novedades</a></li>
                    <li class="breadcrumb-item">Permiso</li> 
                  </ol>
            </div>
            <div class="col-sm-6" align="right">
                <?php if($user_log["role"] == 1 || $user_log['id']==46  || $user_log["role"] == 2){ ?>
                <a href="<?php echo $url; ?>?pg=novedades/permiso/detalle" >
                    <button type="button" class="btn btn-outline-primary">Solicitar Permiso</button> 
                </a> 
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
    <?php if($revision>0){
        ?>
        <!-- Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                  
                <div class="card-body">
                    <div class="e_movil" style="text-align: right; line-height: 14px; color: #004b98;">
                        Deslice la tabla de izquierda a derecha para ver el contenido >>
                    </div>
                    
                    <div class="barra_superior">
                    <div class="container mb-5">
                    <div class="row">
                        <div class="col">
                    <a class="btn btn-primary w-50 d-flex text-center pb-4 " data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Permisos por Revisar 
                    </a>
                    </div>
                    <div class="col">
                    <a class="btn btn-primary w-50 d-flex" data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Permisos Aprobados / Rechazados
                    </a>
                    </div>
                    </div>
                    </div>
                    <div class="collapse" id="collapseExample1">                        
                    <h2 class='text-center'>Permisos por Revisar</h2>
                    
                    <div class="table-responsive">
                    <table id="tabla_maestra" class="display" width="100%" style="font-size: 12px">
                        <thead class="bg-secondary">
                            <tr>
                              <th>#</th>
                              <th>Autorizado por</th>
                              <th>Empleado</th>
                              <th>Fecha Solicitud</th>
                              <th>Tipo</th>                              
                              <th>Radicado</th>
                              <th>Fecha Radicado</th>
                              <th>Soporte</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        $filtro = "";
                        if($user_log["role"] == 2){
                            $filtro = " AND id_empleado = '".$_SESSION['id_user_valentina']."' ";
                        }
                            
                        $query = mysqli_query($connect_nomina,"SELECT * FROM Permisos WHERE id_responsable = '" . $user_log['id_posicion'] . "' ");  
                        while($data = mysqli_fetch_array($query)){ 
                            $estadoRadicado = $data["estado"];
                            if($estadoRadicado==1){
                            
                            //Sentencia para determinar que permiso es
                            $consultaTipoPermiso=mysqli_query($connect_nomina,"SELECT * FROM Lista_Permisos WHERE id='$data[tipo]'");
                            while($tipoPermiso = mysqli_fetch_array($consultaTipoPermiso)){
                                $tipoPermiso1 = $tipoPermiso["nombre"];
                            }


                            $bt_editar = '';
                            if($user_log["role"] == 1 || $user_log["role"] == 2 || $user_log["id"]=46){
                                $bt_editar = '
                                <a href="'.$url.'?pg=novedades/permiso/detalle2 &id='.$data["id"].'" class="btn btn-outline-primary btn-sm" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                ';
                            }
                            
                            $query_username = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE id = '" . $_SESSION['id_user_valentina'] . "' ");
                            while ($data_username = mysqli_fetch_array($query_username)) {
                                $nombre_usuario = $data_username['nombre'];
                                $nombre_usuario2 = $data_username['nombre_2'];
                                $apellido_usuario = $data_username['apellidos'];
                                $apellido_usuario2 = $data_username['apellidos_2'];
                            }                         
                            
                            echo '
                                <tr>
                                    <td>'.$count.'</td>
                                    <td>' . $nombre_usuario . ' ' . $nombre_usuario2 . ' ' . $apellido_usuario . ' ' . $apellido_usuario2 . ' </td>';


                                    $idjefeInmediato = mysqli_query($connect_valentina,"SELECT documento FROM Posiciones WHERE id='".$data['id_empleado']."'");
                                    while ($data2 = mysqli_fetch_array($idjefeInmediato)) {
                                         $id_jefeInmediato = $data2['documento'];   
                                        $idjefeInmediato2 = mysqli_query($connect_valentina,"SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                        //print_r("SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                        while ($data3 = mysqli_fetch_array($idjefeInmediato2)) {
                                             $nombre_jefeInmediato2 = $data3['nombre'].' '.$data3['nombre_2'].' '.$data3['apellidos'].' '.$data3['apellidos_2'];   
                                        }
                                    }

                                    echo '<td>' . $nombre_jefeInmediato2 .'</td>
                                    <td>'.$data["fecha_inicia"].'</td>
                                    <td>'.$tipoPermiso1.'</td>
                                    <td align="center">00'.$data["id"].'</td>
                                    <td align="center">'.$data["created_at"].'</td>';
                                    echo '<td>';
                                    $consulta_adjuntos=mysqli_query($connect_nomina,"SELECT * FROM Multimedia_Documentos WHERE id_publicacion='".$data['id']."'");                                  
                                    while($data4=mysqli_fetch_array($consulta_adjuntos)){
                                        echo '<a href="https://estilocontigo.hr-suite.app/recursos/'.$data4["file"].'">'.$data4["file"].'</a></br>';
                                    };
                                    echo '</td>
                                    <td align="center">';

                                    if ($data["estado"]==1) {
                                        echo '
                                        <form method="post" action="">
                                        <input type="hidden" name="id_registro" value="'.$data["id"].'" " />
                                        <select class="form-control w-100 mb-2 text-center" name="estado" id="estado" required style="width:45%; display:inline">';
                                        if ($user_log["role"] == 1|| $user_log["role"] == 2 || $user_log["id"]=46) {
                                            foreach ($Array_Estado_Permisos as $nivel) {
                                                if ($data["estado"] == $nivel[0]) {
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
                                        <input type="text" name="observaciones" placholder="Observaciones" style="width:100%" value="'.$data["observaciones"].'">
                                        </form>';
                                    }
                                    echo'                                 
                                    </td>
                                    <td  align="center">
                                    '.$bt_editar.'
                                </td>
                            </a>
                                    </td>
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
                    <h2 class='text-center'>Permisos Aprobados / Rechazados</h2>
                    
                    <div class="table-responsive">
                    <table id="tabla_maestra2" class="display" width="100%" style="font-size: 12px">
                        <thead class="bg-secondary">
                            <tr>
                              <th>#</th>
                              <th>Autorizado por</th>
                              <th>Empleado</th>
                              <th>Fecha Solicitud</th>
                              <th>Tipo</th>                              
                              <th>Radicado</th>
                              <th>Fecha Radicado</th>
                              <th>Soporte</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        $filtro = "";
                        if($user_log["role"] == 2){
                            $filtro = " AND id_empleado = '".$_SESSION['id_user_valentina']."' ";
                        }
                            
                        $query = mysqli_query($connect_nomina,"SELECT * FROM Permisos WHERE id_responsable = '" . $user_log['id_posicion'] . "' ");  
                        while($data = mysqli_fetch_array($query)){ 
                            
                            //Sentencia para determinar que permiso es
                            $consultaTipoPermiso=mysqli_query($connect_nomina,"SELECT * FROM Lista_Permisos WHERE id='$data[tipo]'");
                            while($tipoPermiso = mysqli_fetch_array($consultaTipoPermiso)){
                                $tipoPermiso1 = $tipoPermiso["nombre"];
                            }


                            $bt_editar = '';
                            if($user_log["role"] == 1 || $user_log["role"] == 2 || $user_log["id"]=46){
                                $bt_editar = '
                                <a href="'.$url.'?pg=novedades/permiso/detalle2 &id='.$data["id"].'" class="btn btn-outline-primary btn-sm" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                ';
                            }
                            
                            $query_username = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE id = '" . $_SESSION['id_user_valentina'] . "' ");
                            while ($data_username = mysqli_fetch_array($query_username)) {
                                $nombre_usuario = $data_username['nombre'];
                                $nombre_usuario2 = $data_username['nombre_2'];
                                $apellido_usuario = $data_username['apellidos'];
                                $apellido_usuario2 = $data_username['apellidos_2'];
                            }                         
                            
                            echo '
                                <tr>
                                    <td>'.$count.'</td>
                                    <td>' . $nombre_usuario . ' ' . $nombre_usuario2 . ' ' . $apellido_usuario . ' ' . $apellido_usuario2 . ' </td>';


                                    $idjefeInmediato = mysqli_query($connect_valentina,"SELECT documento FROM Posiciones WHERE id='".$data['id_empleado']."'");
                                    while ($data2 = mysqli_fetch_array($idjefeInmediato)) {
                                         $id_jefeInmediato = $data2['documento'];   
                                        $idjefeInmediato2 = mysqli_query($connect_valentina,"SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                        //print_r("SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                        while ($data3 = mysqli_fetch_array($idjefeInmediato2)) {
                                             $nombre_jefeInmediato2 = $data3['nombre'].' '.$data3['nombre_2'].' '.$data3['apellidos'].' '.$data3['apellidos_2'];   
                                        }
                                    }

                                    echo '<td>' . $nombre_jefeInmediato2 .'</td>
                                    <td>'.$data["fecha_inicia"].'</td>
                                    <td>'.$tipoPermiso1.'</td>
                                    <td align="center">00'.$data["id"].'</td>
                                    <td align="center">'.$data["created_at"].'</td>';
                                    echo '<td>';
                                    $consulta_adjuntos=mysqli_query($connect_nomina,"SELECT * FROM Multimedia_Documentos WHERE id_publicacion='".$data['id']."'");                                  
                                    while($data4=mysqli_fetch_array($consulta_adjuntos)){
                                        echo '<a href="https://estilocontigo.hr-suite.app/recursos/'.$data4["file"].'">'.$data4["file"].'</a></br>';
                                    };
                                    echo '</td>
                                    <td align="center">';

                                    if ($data["estado"]==1) {
                                    }
                                    else{
                                        echo '
                                        <input type="hidden" name="id_registro" value="'.$data["id"].'" " />';
                                        
                                        if ($user_log["role"] == 1|| $user_log["role"] == 2 || $user_log["id"]=46) {
                                            foreach ($Array_Estado_Permisos as $nivel) {
                                                if ($data["estado"] == $nivel[0]) {
                                                    $valor=$nivel[0];                                                  
                                                    echo '<input type="text" class="text-center readonly "' . $nivel[0] . '" value=' . $nivel[1] .'>';
                                                } else {
                                                }
                                            }
                                        }
                                        echo '
                                        <label for="observaciones"> Observaciones </label> </br>
                                        <input type="text" readonly name="observaciones" placholder="Observaciones" style="width:100%" value="'.$data["observaciones"].'">';
                                    }
                                    
                                    echo'                                 
                                    </td>
                                    <td  align="center">
                                    '.$bt_editar.'
                                </td>
                            </a>
                                    </td>
                                </tr>
                            ';
                            $count++;
                        }
                        ?>
                            
                            </tbody>
                        </table>
                    </div>
                   
            <!-- Configuration  Ends-->
        <?php 
       // }
        ?>      
                </div>
                
    </div>  
        <!-- Configuration  Starts-->
        <p>
                <a class="btn btn-primary w-100" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Mis Permisos
                </a>
            </p>
            <div class="collapse" id="collapseExample">
            <h2 class='text-center'>Mis Permisos</h2>
                    <div class="table-responsive">
                    <table id="tabla_maestra3" class="display" width="100%" style="font-size: 12px">
                        <thead class="bg-secondary">
                            <tr>
                              <th>#</th>
                              <th>Empleado</th>
                              <th>Autorizado por</th>
                              <th>Fecha Solicitud</th>
                              <th>Tipo</th>                              
                              <th>Radicado</th>
                              <th>Soporte</th>
                              <th>Estado</th>
                              <th>Observaciones</th>
                              <th>Acciones</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        $filtro = "";
                        if($user_log["role"] == 2){
                            $filtro = " AND id_empleado = '".$_SESSION['id_user_valentina']."' ";
                        }
                            
                        $query = mysqli_query($connect_nomina,"SELECT * FROM Permisos  WHERE id_empleado = '" . $user_log['id_posicion'] . "'  ");  
                        while($data = mysqli_fetch_array($query)){ 
                            

                            //Sentencia para determinar que permiso es
                            $consultaTipoPermiso=mysqli_query($connect_nomina,"SELECT * FROM Lista_Permisos WHERE id='$data[tipo]'");
                            while($tipoPermiso = mysqli_fetch_array($consultaTipoPermiso)){
                                $tipoPermiso1 = $tipoPermiso["nombre"];
                            }

                            $bt_editar = '';
                            if($user_log["role"] == 1 || $user_log["role"] == 2 || $user_log["id"]=46){
                                $bt_editar = '
                                <a href="'.$url.'?pg=novedades/permiso/detalle2&id='.$data["id"].'" class="btn btn-outline-primary btn-sm" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                ';
                            }                         
                            $query_username = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE id = '" . $_SESSION['id_user_valentina'] . "' ");
                            while ($data_username = mysqli_fetch_array($query_username)) {
                                $nombre_usuario = $data_username['nombre'];
                                $nombre_usuario2 = $data_username['nombre_2'];
                                $apellido_usuario = $data_username['apellidos'];
                                $apellido_usuario2 = $data_username['apellidos_2'];
                            }
                            echo '
                        <tr>
                            <td>' . $count . '</td>
                            <td>' . $nombre_usuario . ' ' . $nombre_usuario2 . ' ' . $apellido_usuario . ' ' . $apellido_usuario2 . ' </td>';                                   
                            $idjefeInmediato1 = mysqli_query($connect_valentina,"SELECT documento FROM Posiciones WHERE id='".$data['id_responsable']."'");                            
                            while ($data2 = mysqli_fetch_array($idjefeInmediato1)) {
                                $id_jefeInmediato1 = $data2['documento'];   
                                $idjefeInmediato21 = mysqli_query($connect_valentina,"SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato1."'");
                                //print_r("SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
                                while ($data3 = mysqli_fetch_array($idjefeInmediato21)) {
                                     $nombre_jefeInmediato21 = $data3['nombre'].' '.$data3['nombre_2'].' '.$data3['apellidos'].' '.$data3['apellidos_2'];   
                                }
                            }
                            
                            echo '<td>' . $nombre_jefeInmediato21 .'</td>                                  
                                    <td>'.$data["fecha_inicia"].'</td>
                                    <td>'.$tipoPermiso1.'</td>
                                    <td align="center">00'.$data["id"].'</td>';
                                    echo '<td>';
                                    $consulta_adjuntos=mysqli_query($connect_nomina,"SELECT * FROM Multimedia_Documentos WHERE id_publicacion='".$data['id']."'");                                  
                                    while($data4=mysqli_fetch_array($consulta_adjuntos)){
                                        echo '<a href="https://estilocontigo.hr-suite.app/recursos/'.$data4["file"].'">'.$data4["file"].'</a></br>';
                                    };
                                    echo '</td>
                                    <td align="center">
                                    <select class="form-control" name="estado" id="estado" required>';

                                    foreach ($Array_Estado_Permisos as $nivel) {
                                        if ($data["estado"] == $nivel[0]) {
                                            echo '<option value="' . $nivel[0] . '" selected>' . $nivel[1] . '</option>';
                                        } 
                                    }
                                    echo '</select>                                
                                    </td>
                                    </td>
                                    <td align="center">' . $data["observaciones"] . '</td>
                                    <td  align="center">
                                    '.$bt_editar.'
                                </td>
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
    .barra_superior{
        overflow-x: scroll;
        overflow-y:hidden;
        width: 100%;
    }
    .div_content{
        height: 10px;
    }
</style>
                                       
<script>  
    $(document).ready(function() {
        $('#tabla_maestra').DataTable();
        $('.div_content').width( $('#tabla_maestra').width() );
    } );
    
    $(document).ready(function() {
        $('#tabla_maestra1').DataTable();
        $('.div_content').width( $('#tabla_maestra1').width() );
    } );

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