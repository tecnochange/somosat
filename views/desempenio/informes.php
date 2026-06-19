<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_informes").addClass("active_item");
    
    $('.custom-scrollbar').animate({ scrollTop: $('#bt_desempenio_administrar').offset().top - 500 }, 1000);
});
</script>

<?php
    $filtro = " WHERE id > 0 ";
    if($_POST["id_cargo_fill"] != ""){
        $filtro .= " AND id_cargo = '".$_POST["id_cargo_fill"]."' ";
    }
?>


<?php
$array_reporte_general = array();
$con_objetivos = 0;

//CONSUTAMOS A TODOS LOS EMPLEADOS Y SUS PROMEDIOS POR MES
$queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados ".$filtro." ORDER BY nombre ASC "); 
while($dataEmpleados = mysqli_fetch_array($queryEmpleados)){
    
    $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
    WHERE anio = '".$_SESSION['anio']."' 
    AND id_empleado = '".$dataEmpleados["id"]."' ORDER BY id ASC "); 
    while($data = mysqli_fetch_array($query)){ 
        $obj_resultados = json_decode($data["obj_meses_resultados"], true);
        $obj_meses = json_decode($data["obj_meses"], true);
        
        foreach($Array_Meses as $mes){
            $meta_mes = 0;
            foreach($obj_meses as $meta){
                if($meta["mes"] == $mes[0]){
                    $meta_mes = $meta["meta"];
                }
            }

            $resp_mes = 0;
            foreach($obj_resultados as $meta){
                if($meta["mes"] == $mes[0]){
                    $resp_mes = $meta["meta"];
                }
            }
            $avance = ($resp_mes/$meta_mes)*100;
            if( is_nan($avance) ){ $avance = 0; }
            if( is_infinite($avance) ){ $avance = 100; }
            
            
            $nodo = array(
                "id_empleado" => $dataEmpleados["id"],
                "id_cargo" => $dataEmpleados["id_cargo"],
                "mes" => $mes[0],
                "resultado" => round($avance)
            );
            
            array_push($array_reporte_general, $nodo);

        }
        
    }
    
    if($query->num_rows > 0){ $con_objetivos++; }   
}


$array_consolidado = array();
$promedio_general = 0;
//JUNTAMOS LAS CIFRAS
foreach($Array_Meses as $mes){
                                    
    $count = 0;
    $resultados_mes = 0;
    foreach($array_reporte_general as $resultado){
        if($resultado["mes"] == $mes[0]){
            $resultados_mes += $resultado["resultado"];
            $count++;
        }
    }
                                    
    $promedio = $resultados_mes/$count;
    if( is_nan($promedio) ){ $promedio = 0; }

    $bgcolor = 'style="background-color: #dddbdb; color:#000000"';
    if($promedio > 0 && $promedio <= 49){ $bgcolor = 'style="background-color:#ff0000"'; }
    if($promedio > 49 && $promedio <= 89){ $bgcolor = 'style="background-color:#ffc107"'; }
    if($promedio > 89){ $bgcolor = 'style="background-color:#008000"'; }

    array_push($array_consolidado, array(
        "mes" => $mes[0], 
        "mes_txt" => $mes[1], 
        "promedio" => round($promedio)
    ) );
    
    $promedio_general += round($promedio);
}

$promedio_general = $promedio_general/12;
$promedio_general = round($promedio_general);
$porcentaje_avance = $promedio_general;
if($porcentaje_avance > 100){ $porcentaje_avance = 100; }

$color_general = "";
$color = "#000000";
if($promedio_general > 0 && $promedio_general <= 49){ $color_general = '#ff0000'; $color = "#ffffff"; }
if($promedio_general > 49 && $promedio_general <= 89){ $color_general = '#ffc107'; $color = "#ffffff"; }
if($promedio_general > 89){ $color_general = '008000'; $color = "#ffffff"; }

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>


<style>
    .tabla_anios{
        margin-top: 6px;
        margin-bottom: 20px;
        width: 100%;
    }
    .meses{
        margin: 3px;
        border-radius: 10px;
        padding: 3px 0px;
        color: #ffffff;
        border: 1px solid #c3c3c3;
    }
    .numeros{
        font-size: 30px;
        font-weight: bold;
        color: #03a9f4;
    }
</style>

<div class="container-fluid"> 
    <form action="" method="post">
    <div class="row">
    
        <div class="col-md-4" style="margin-bottom: 20px">
            <select class="form-control" name="id_cargo_fill" style="font-weight: bold;">
                <option value="">Selecciona...</option>
                <?php
                
                    $queryCargosFill = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC "); 
                    while($dataCargosFill = mysqli_fetch_array($queryCargosFill)){ 
                        if($_POST["id_cargo_fill"] == $dataCargosFill["id"] ){
                            echo '<option value="'.$dataCargosFill["id"].'" selected >'.$dataCargosFill["nombre"].'</option>';
                        }
                        else{
                            echo '<option value="'.$dataCargosFill["id"].'">'.$dataCargosFill["nombre"].'</option>';
                        }
                    }
                ?>
            </select>
            
        </div>
        
        <div class="col-md-4" style="margin-bottom: 20px">
            <button type="submit" class="btn btn-primary" title="Nuevo">
                Filtrar
            </button>
        </div>
        
    </div>
    </form>
    
</div>

<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12" style="margin-bottom: 20px">
            <table width="100%">
                <tr>
                    <td>
                        <h2>
                            Informes General de Gestión del Desempeño <?php echo $_SESSION["anio"]; ?>
                        </h2>
                        
                    </td>
                    <td align="right">
                        
                    </td>
                </tr>
            </table>
        </div>
        <!-- FICHA -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Colaboradores</h4>
                    <div class="numeros"><?php echo $queryEmpleados->num_rows; ?></div>
                </div>
            </div>
        </div>
        <!-- FICHA -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Con Objetivos</h4>
                    <div class="numeros"><?php echo $con_objetivos; ?></div>
                </div>
            </div>
        </div>
        <!-- FICHA -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Sin Objetivos</h4>
                    <div class="numeros"><?php echo ($queryEmpleados->num_rows)-$con_objetivos; ?></div>
                </div>
            </div>
        </div>
        <!-- FICHA -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Porcentaje de Avance año</h4>
                    
                    <div style="width: 100%; background-color: #E9E9E9; border-radius: 30px;">
                        <div style=" background-color: <?php echo $color_general; ?>; color:<?php echo $color; ?>; width: <?php echo $promedio_general; ?>%; text-align: center; font-weight: bold; padding: 5px; border-radius: 30px;"  >
                            <?php echo $promedio_general; ?>%
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- FICHA -->
        <div class="col-md-12">
            
            <div class="card">
            
                <div class="card-body">
                    
                    <h4>Consolidado por mes</h4>
                    
                    <table class="table table-bordered">
                            <tr>
                                <?php 
                                
                                foreach($array_consolidado as $mes){
                                    
                                    $promedio = $mes["promedio"];
                                    
                                    $bgcolor = 'style="background-color: #dddbdb; color:#000000"';
                                    if($promedio > 0 && $promedio <= 30){ $bgcolor = 'style="background-color:#ff0000"'; }
                                    if($promedio > 30 && $promedio <= 60){ $bgcolor = 'style="background-color:#ffc107"'; }
                                    if($promedio > 60){ $bgcolor = 'style="background-color:#008000"'; }
                                    
                                    echo '
                                        <td align="center">
                                            '.$mes["mes_txt"].'
                                            <div class="meses" '.$bgcolor.'>
                                            <b>'.$promedio.'%</b>
                                            </div>
                                        </td>
                                    ';
                                }

                                ?>

                            </tr>
                    </table>
                    
                </div>

            </div>
  
            
        </div>
        <!-- END FICHA -->
        
        <!-- FICHA -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Resumen por Cargos</h4>
                    
                    <?php 
                    $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC "); 
                    while($dataCargos = mysqli_fetch_array($queryCargos)){ 
                        
                        $array_consolidado = array();
                        $promedio_general = 0;
                        //JUNTAMOS LAS CIFRAS
                        foreach($Array_Meses as $mes){

                            $count = 0;
                            $resultados_mes = 0;
                            foreach($array_reporte_general as $resultado){
                                if($resultado["mes"] == $mes[0] && $resultado["id_cargo"] == $dataCargos["id"] ){ ////////////////////////////////
                                    $resultados_mes += $resultado["resultado"];
                                    $count++;
                                }
                            }

                            $promedio = $resultados_mes/$count;

                            $bgcolor = '';
                            if($promedio > 0 && $promedio <= 30){ $bgcolor = 'style="background-color:#ff0000"'; }
                            if($promedio > 30 && $promedio <= 60){ $bgcolor = 'style="background-color:#ffc107"'; }
                            if($promedio > 60){ $bgcolor = 'style="background-color:#008000"'; }

                            array_push($array_consolidado, array(
                                "mes" => $mes[0], 
                                "mes_txt" => $mes[1], 
                                "promedio" => round($promedio)
                            ) );

                            $promedio_general += round($promedio);
                        }

                        $promedio_general = $promedio_general/12;
                        $promedio_general = round($promedio_general);
                        $porcentaje_avance = $promedio_general;
                        if($porcentaje_avance > 100){ $porcentaje_avance = 100; }

                        $color_general = "";
                        if($promedio_general > 0 && $promedio_general <= 49){ $color_general = '#ff0000'; }
                        if($promedio_general > 49 && $promedio_general <= 89){ $color_general = '#ffc107'; }
                        if($promedio_general > 89){ $color_general = '#008000'; }
                        
                        if( is_nan($promedio_general) ){
                            $promedio_general = 0;
                        }
                        
                    ?>
                    
                    <div style="margin-top: 10px"><?php echo $dataCargos["nombre"]; ?></div>
                    <div style="width: 100%; background-color: #E9E9E9; border-radius: 30px;">
                        <div style=" background-color: <?php echo $color_general ?>; width: <?php echo $promedio_general; ?>%; text-align: center; font-weight: bold; padding: 5px; border-radius: 30px; color:"  >
                            <?php echo $promedio_general; ?>%
                        </div>
                    </div>
                    
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        
    
    </div>
</div>



