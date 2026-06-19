<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_scaling_up").addClass("active_item");
    
    $('.custom-scrollbar').animate({ scrollTop: $('#bt_desempenio_administrar').offset().top - 500 }, 1000);
});
</script>

<?php
    $filtro = " ";
    $filtro_general = " WHERE id > 0 ";
    if($_POST["id_cargo_fill"] != ""){
        $filtro .= " AND id_cargo = '".$_POST["id_cargo_fill"]."' ";
        $filtro_general .= " AND id_cargo = '".$_POST["id_cargo_fill"]."' ";
    }



    $mes_actual = date("n")-1;

?>


<?php include("views/desempenio/ficha_observaciones.php"); ?>

<div class="container-fluid"> 
    <form action="" method="post">
    <div class="row">
        
        <div class="col-md-4" style="margin-bottom: 20px">
            <input class="form-control" type="text" placeholder="Búsqueda por colaborador..." id="buscador" onKeyUp="Filtro(this.value)" />
        </div>
    
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
</style>

<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12" style="margin-bottom: 20px">
            <table width="100%">
                <tr>
                    <td>
                        <h2>
                            Scaling UP COEX <?php echo $_SESSION["anio"]; ?>
                        </h2>
                        
                    </td>
                    <td align="right">
                        
                    </td>
                </tr>
            </table>
        </div>
        
<?php
$array_reporte_general = array();
$con_objetivos = 0;

//CONSUTAMOS A TODOS LOS EMPLEADOS Y SUS PROMEDIOS POR MES
$queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados ".$filtro_general." ORDER BY nombre ASC "); 
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
        
        
        
        <!-- FICHA -->
        <div class="col-md-12" style="display: none">
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
        
        
        
        <div class="col-md-12">
            
            <?php
            //CONSUTAMOS A TODOS LOS EMPLEADOS
            $queryCoex = mysqli_query($connect_desempenio,"SELECT * FROM Coex "); 
            while($dataCoex = mysqli_fetch_array($queryCoex)){ 
                
                $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataCoex["id_empleado"]."' ".$filtro." "); 
                $dataEmpleados = mysqli_fetch_array($queryEmpleados); 
                if($queryEmpleados->num_rows > 0){
                
            ?>
            
            <div class="card ficha_colaborador">
                <div class="card-body">
                    
                    <h4><?php echo $dataEmpleados["nombre"]; ?></h4>
                    
                    <?php
                    //CONSULTAMOS LOS OBJETIVOS DE CADA EMPLEADO
                    $avance_anual = 0;
                    $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
                    WHERE anio = '".$_SESSION['anio']."' 
                    AND id_empleado = '".$dataEmpleados["id"]."' ORDER BY id ASC "); 
                    while($data = mysqli_fetch_array($query)){ 
                        $obj_resultados = json_decode($data["obj_meses_resultados"], true);
                        $obj_meses = json_decode($data["obj_meses"], true);
                    ?>
                        Objetivo: <b><?php echo $data["objetivo"]; ?></b><br>
                        Indicador: <i><?php echo substr($data["indicador"],0,300); ?></i><br>
                        Fecha de Cumplimiento: <?php echo $data["fecha_cumplimiento"]; ?>
                    
                        <table class="tabla_anios">
                            <tr>
                                <?php 
                                $avance_mensual = 0;
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
                                    $avance_mensual += $avance; 
                                    
                                    $bgcolor = 'style="background-color: #dddbdb; color:#000000"';

                                    if($avance >= 0 && $avance <= 49){ $bgcolor = 'style="background-color:#ff0000"'; }
                                    if($avance > 49 && $avance <= 89){ $bgcolor = 'style="background-color:#ffc107"'; }
                                    if($avance > 89){ $bgcolor = 'style="background-color:#008000"'; }
                                    
                                    
                                    
                                    if( ( $mes_actual > $mes[0] || $mes[0] == 1) && $avance == 0 ){
                                        $bgcolor = 'style="background-color: #ffffff; color:#000000"';
                                    }
                                    
                                    if( $mes_actual > $mes[0]  ){
                                        //$bgcolor = 'style="background-color: #ffffff; color:#000000"';
                                    }
                                    
                                    //if( $avance == 0 && $mes_actual < $mes[0] && $meta_mes > 0  ){ $bgcolor = 'style="background-color:#ff0000"';}
                                    
                                    echo '
                                        <td align="center">
                                            '.$mes[1].'
                                            <div class="meses" '.$bgcolor.'>
                                                <b>'.round($avance).'%</b>
                                            </div>
                                        </td>
                                    ';
                                    
                                }
                        
                                $avance_anual = $avance_mensual/12;
                                $bgcolor_avance = 'style="background-color: #dddbdb; color:#000000"';
                                if($avance_anual > 0 && $avance_anual <= 49){ $bgcolor_avance = 'style="background-color:#ff0000"'; }
                                if($avance_anual > 49 && $avance_anual <= 89){ $bgcolor_avance = 'style="background-color:#ffc107"'; }
                                if($avance_anual > 89){ $bgcolor_avance = 'style="background-color:#008000"'; }
                        
                                
                                ?>
                                <td align="center" >
                                    Meta
                                    <div class="meses" style="color: #000000;">
                                        <b><?php echo $data["meta"]; ?></b>
                                    </div>
                                </td>
                                <td align="center">
                                    Avance
                                    <div class="meses" <?php echo $bgcolor_avance; ?> >
                                        <b><?php echo round($avance_anual); ?>%</b>
                                    </div>
                                    
                                    
                                </td>
                                <td align="center">
                                    Acciones<br>
                                    <a href="<?php echo $url; ?>/?pg=desempenio/objetivo/seguimiento&id=<?php echo $data["id"]; ?>">
                                        <button type="button" class="btn btn-primary btn-sm" title="Seguimiento" >
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    
                                    <button type="button" class="btn btn-primary btn-sm" title="Observaciones" onclick="Observaciones(<?php echo $data["id"]; ?>)" >
                                        <i class="fa fa-comments"></i>
                                    </button>
                                    
                                    <a href="<?php echo $url; ?>/?pg=desempenio/objetivo/detalle&id=<?php echo $data["id"]; ?>">
                                        <button type="button" class="btn btn-primary btn-sm" title="Editar" >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>
                                    
                                </td>
                            </tr>
                        </table>
                    
                    <?php }} ?>
                    
                    <?php if($query->num_rows == 0){ ?>
                    <div>Sin Objetivos</div>
                    <?php } ?>
                    
                </div>
            </div>
            
            <?php } ?>
  
            
        </div>
        
    
    </div>
</div>

<script>
var api = '<?php echo $url; ?>/api/desempenio/';
    
function Observaciones(id_objetivo){
    $(".modal_observacion").modal("show");
    
    jQuery.ajax({
                url: api+"ver_observaciones_objetivo.php",
                type:'post',
                data: {id_objetivo: id_objetivo},
                }).done(function (resp){
                    $("#cont_modal").html(resp);
                })
                .fail(function(resp) {
                    console.log(resp);
                })
                .always(function(resp){
                }
            );

    
    
}
</script>

<script>  
function Filtro(texto){
    texto = texto.toLowerCase();
    if(texto.length > 3 || texto.length == 0){
        $(".ficha_colaborador h4").filter(function() {
            console.log($(this).text().toLowerCase().indexOf(texto));

            $(this).parent().parent().toggle( $(this).text().toLowerCase().indexOf(texto) > -1  ); 

        });
    }  
}
</script>
