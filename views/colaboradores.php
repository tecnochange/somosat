<?php 
    $array_equipo = array();
    $queryPosEquipo = mysqli_query($connect_valentina,"SELECT *  FROM Posiciones 
    WHERE id = '".$user_log["id_posicion"]."' OR id_dep_jerarquica = '".$user_log["id_posicion"]."' OR id_dep_funcional = '".$user_log["id_posicion"]."' ");  
    while($dataPosEquipo = mysqli_fetch_array($queryPosEquipo)){
        
        array_push($array_equipo, $dataPosEquipo["id"] );

        $queryPosEquipoL2 = mysqli_query($connect_valentina,"SELECT *  FROM Posiciones 
        WHERE id_dep_jerarquica = '".$dataPosEquipo["id"]."' OR id_dep_funcional = '".$dataPosEquipo["id"]."' ");  
        while($dataPosEquipoL2 = mysqli_fetch_array($queryPosEquipoL2)){
            array_push($array_equipo, $dataPosEquipoL2["id"] );
        }

    }
    $array_equipo = array_unique($array_equipo);
?>


<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
});
</script>

<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                  <h3>Colaboradores</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estructura</a></li>
                    <li class="breadcrumb-item">Colaboradores</li> 
                  </ol>
            </div>
            <div class="col-sm-6" align="right">
                <?php if($user_log["role"] == 1 || $user_log["role"] == 7){ ?>
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/editar">
                <button type="button" class="btn btn-outline-primary">
                    Crear Colaborador
                </button>
                </a>
                
                <a href="<?php echo $url; ?>?pg=administrar/loads/cargar_colaboradores">
                <button type="button" class="btn btn-primary">
                    Csv
                </button>
                </a>
                
                <a href="<?php echo $url; ?>/informes/base_informacion_personal_empleados.php" target="_blank" >
                    <button type="button" class="btn btn-secondary">Generar Reporte</button> 
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- export-->
<form action="app/models/exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar"  />
</form>

<div class="container-fluid">
    <div class="row">
        
        <!-- Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                  
                <div class="card-body">
                    <div class="e_movil" style="text-align: right; line-height: 14px; color: #004b98;">
                        Deslice la tabla de izquierda a derecha para ver el contenido >>
                    </div>
                    <div class="barra_superior">
                        <div class="div_content"></div>
                    </div>
                    
                    <div class="table-responsive">
                    <table id="tabla_maestra" class="display" width="100%" style="font-size: 12px">
                        <thead class="bg-secondary">
                            <tr>
                                <th scope="col" width="15">#</th>
                                <th scope="col" width="150">Nombres</th>
                                <th scope="col" width="150">Cargo</th>
                                <th scope="col" width="150">Documento</th>
                                <th scope="col" width="150">Role</th>
                                <th scope="col" width="150">Estado</th>
                                <th scope="col" width="100">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($user_log["role"] == 1 || $user_log['role'] == 5 || $user_log['role'] == 7 || $user_log['role'] == 9){
                            $_SESSION["id_colaborador_edit"] = "";

                            require("app/models/Colaboradores.php");
                            $ClassColaboradores = new Colaboradores();
                            $colaboradores = $ClassColaboradores->lista($connect_valentina);

                            $count = 1;
                            foreach($colaboradores as $colaborador){

                                //CARGO
                                $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$colaborador["id_cargo"]."' ");
                                $dataCargo = mysqli_fetch_array($queryCargo);

                                echo '
                                    <tr>
                                        <td>'.$count.'</td>
                                        <td>'.$colaborador["nombre"].' '.$colaborador["nombre_2"].' '.$colaborador["apellidos"].' '.$colaborador["apellidos_2"].'</td>
                                        <td>'.$dataCargo["nombre"].' - '.$colaborador["id_posicion"].'</td>
                                        <td>'.$colaborador["documento"].'</td>
                                        <td>'.$colaborador["role_txt"].'</td>
                                        <td>'.$colaborador["estado_txt"].'</td>
                                        <td>
                                                <a href="'.$url.'?pg=administrar/colaborador/editar&id='.$colaborador["id"].'" class="btn btn-outline-primary btn-sm " title="Editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="'.$url.'?pg=administrar/colaborador/detalle&id='.$colaborador["id"].'" class="btn btn-primary btn-sm" title="Ver">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                        </td>
                                    </tr>
                                ';
                                $count++;
                            }
                        }
                        ?> 
                            
                            
                            
                        <?php
                        if($user_log["role"] == 2){
                            $count = 1;
                            $queryPosiciones = mysqli_query($connect_valentina,"SELECT *  FROM Posiciones ");  
                            while($dataPosicion = mysqli_fetch_array($queryPosiciones)){
                                
                                $permitir = false;
                                foreach($array_equipo as $id_pos){
                                    if($id_pos == $dataPosicion["id"]){
                                        $permitir = true;
                                    }
                                }
                                
                                if($permitir == true){
                                
                                    //CARGO
                                    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataPosicion["id_cargo"]."' ");
                                    $dataCargo = mysqli_fetch_array($queryCargo);

                                    //EMPLEADO
                                    $queryEmpleado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_posicion = '".$dataPosicion["id"]."' ");
                                    $dataEmpleado = mysqli_fetch_array($queryEmpleado);

                                    $txt_role = '';
                                    foreach($Array_Role as $role){
                                        if($role[0] == $dataEmpleado["role"]){  $txt_role = $role[1]; }
                                    }

                                    $txt_estado = '';
                                    foreach($Array_Estado_Colaborador  as $estado){
                                        if($estado[0] == $dataEmpleado["estado"]){  $txt_estado = $estado[1]; }
                                    }

                                    if($queryEmpleado->num_rows > 0){

                                        echo '
                                            <tr>
                                                <td>'.$count.'</td>
                                                <td>'.$dataEmpleado["nombre"].' '.$dataEmpleado["nombre_2"].' '.$dataEmpleado["apellidos"].'</td>
                                                <td>'.$dataCargo["nombre"].'</td>
                                                <td>'.$dataEmpleado["documento"].'</td>
                                                <td>'.$txt_role.'</td>
                                                <td>'.$txt_estado.'</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="'.$url.'?pg=administrar/colaborador/detalle&id='.$dataEmpleado["id"].'" class="btn btn-primary btn-sm" title="Ver">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        ';
                                        $count++;
                                    }
                                    
                                }

                            }

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
    
    $(function(){
        $(".barra_superior").scroll(function(){
            $(".table-responsive").scrollLeft($(".barra_superior").scrollLeft());
        });
        $(".table-responsive").scroll(function(){
            $(".barra_superior").scrollLeft($(".table-responsive").scrollLeft());
        });
    }); 
</script>


<script>  
function exportarReporte(){
	$("#datos_a_enviar").val( $("<div>").append( $("#basic-1").eq(0).clone()).html());
	$("#FormularioExportacion").submit();
}
    
</script>

















