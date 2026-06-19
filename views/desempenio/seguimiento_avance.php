<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_seguimiento_avance").addClass("active_item");
});
</script>

<?php
    $filtro = " WHERE estado = 1 ";
    if($_POST["id_cargo_fill"] != ""){
        $filtro .= " AND id_cargo = '".$_POST["id_cargo_fill"]."' ";
    }

	if($_SESSION['anio'] < 2022){
		$filtro .= " AND id_area_2021 != '' ";
	}
?>

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


<?php
$array_reporte_general = array();
$con_objetivos = 0;

//AUTORIZACIONES
$queryAutorizaciones = mysqli_query($connect_desempenio,"SELECT * FROM Aprobaciones_Objetivos WHERE anio = '".$_SESSION["anio"]."' "); 

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
            
            
            $nodo = array(
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

    $bgcolor = '';
    if($promedio > 0 && $promedio <= 30){ $bgcolor = 'style="background-color:#ffccbc"'; }
    if($promedio > 30 && $promedio <= 60){ $bgcolor = 'style="background-color:#ffc107"'; }
    if($promedio > 60){ $bgcolor = 'style="background-color:#8bc34a"'; }

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
if($promedio_general > 0 && $promedio_general <= 30){ $color_general = '#ffccbc'; }
if($promedio_general > 30 && $promedio_general <= 60){ $color_general = '#ffc107'; }
if($promedio_general > 60){ $color_general = '8bc34a'; }

?>

<style>
    .numeros{
        font-size: 30px;
        font-weight: bold;
        color: #03a9f4;
    }
</style>


<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12" style="margin-bottom: 20px">
            <table width="100%">
                <tr>
                    <td>
                        <h2>
                            Seguimiento Avance <?php echo $_SESSION["anio"]; ?>
                        </h2>
                        
                    </td>
                    <td align="right">
                        
                    </td>
                </tr>
            </table>
        </div>
        <!-- FICHA -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h4>Colaboradores</h4>
                    <div class="numeros"><?php echo $queryEmpleados->num_rows; ?></div>
                </div>
            </div>
        </div>
        <!-- FICHA -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h4>Con Objetivos</h4>
                    <div class="numeros"><?php echo $con_objetivos; ?></div>
                </div>
            </div>
        </div>
        <!-- FICHA -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h4>Sin Objetivos</h4>
                    <div class="numeros"><?php echo ($queryEmpleados->num_rows)-$con_objetivos; ?></div>
                </div>
            </div>
        </div>
        
        <!-- FICHA -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h4>Autorizaciones</h4>
                    <div class="numeros"><?php echo $queryAutorizaciones->num_rows; ?></div>
                </div>
            </div>
        </div>
        
        
        
        
        
        <!-- FICHA -->
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-body">
                    <h4>Detalle</h4>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th>Colaborador</th>
                            <th>Cargo</th>
                            <th>Seguimientos</th>
                            <th>Objetivos Individuales</th>
           
                        </tr>
                    
                        <tbody class="tabla_lista">
                        <?php
	
                        //CONSUTAMOS A TODOS LOS EMPLEADOS
                        $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados ".$filtro." ORDER BY nombre ASC "); 
                        while($dataEmpleados = mysqli_fetch_array($queryEmpleados)){

                            $queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataEmpleados["id"]."' " );  
                            $dataAdd = mysqli_fetch_array($queryAdd);

                            $colaborador = "";
                            if($dataAdd["preferencia"] !== ""){
                                $colaborador = strtoupper($dataAdd["preferencia"]." ".$dataEmpleados["apellidos"]." ".$dataEmpleados["apellidos_2"]);
                            }else{
                                $colaborador = strtoupper($dataEmpleados["nombre"].' '.$dataEmpleados["nombre_2"]." ".$dataEmpleados["apellidos"]." ".$dataEmpleados["apellidos_2"]);
                            }
                            
							
							if($_SESSION['anio'] < 2022){
								$queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEmpleados["id_cargo_2021"]."' "); 
								$dataCargos = mysqli_fetch_array($queryCargos);
							}
							else{
								$queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEmpleados["id_cargo"]."' "); 
								$dataCargos = mysqli_fetch_array($queryCargos);
							}
                            
                            $bt_editar = '';
                            if($user_log["role"] == 1){
                                $bt_editar = '
                                    <a href="'.$url.'?pg=administrar/cargo/detalle&id='.$cargo["id"].'">
                                        <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>
                                ';
                            }
                            
                            $asuntos_firmas = 0;
                            $cultura_organizacional = 0;

                            $puntaje_objetivos = 0;
                            $avance_anual = 0;
                            //CONSULTAMOS TODOS LOS OBJETIVOS
                            $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
                            WHERE anio = '".$_SESSION['anio']."' 
                            AND id_empleado = '".$dataEmpleados["id"]."' ORDER BY id ASC "); 
                            
                            while($data = mysqli_fetch_array($query)){ 
                                
                                
                                if( $data["asunto_firma_puntaje"] ){
                                    $asuntos_firmas = $data["asunto_firma_puntaje"];
                                }
                                
                                if( $data["cultura_organizacional_puntaje"] ){
                                    $cultura_organizacional = $data["cultura_organizacional_puntaje"];
                                }


                                $obj_resultados = json_decode($data["obj_meses_resultados"], true);
                                $obj_meses = json_decode($data["obj_meses"], true);

                                
                                
                                $avance_mensual = 0;
                                $meses_total = 0;
                                
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
                                            if($meta["meta"] > 0){
                                                $meses_total++;
                                            }
                                            
                                        }
                                    }
                                    $avance = ($resp_mes/$meta_mes)*100;
                                    
                                    if( is_nan($avance) ){ $avance = 0; }
                                    if( is_infinite($avance) ){ $avance = 100; }
                                    
                                    $avance_mensual += $avance; 
                                    
                                }
                                
                                
                                if($data["puntaje_final_objetivos"]){
                                    $avance_anual += $data["puntaje_final_objetivos"];
                                }
                                else{
                                   $avance_anual += $avance_mensual/$meses_total; 
                                   //$avance_anual += $avance_mensual/$meses_total; 
                                }

                            }
                            
                            if($query->num_rows > 0){
                                $avance_anual = round($avance_anual/$query->num_rows);
                                
                            }
                            
                            $bgcolor = '';
                            if($avance_anual <= 0 ){ $bgcolor = 'style="color:#9d9d9d"'; }
                            if($avance_anual > 0 && $avance_anual <= 30){ $bgcolor = 'style="color:#ff0000"'; }
                            if($avance_anual > 30 && $avance_anual <= 60){ $bgcolor = 'style="color:#ffc107"'; }
                            if($avance_anual > 60){ $bgcolor = 'style="color:#008000"'; }
                            
                            
                            $total = $avance_anual+$asuntos_firmas+$cultura_organizacional;
                            
                            
                        ?>
                            <tr>
                                <td><?php echo $colaborador;?></td>
                                <td><?php echo $dataCargos["nombre"]; ?></td>
                                <td><?php echo $meses_total; ?></td>
                                <td align="center">
                                    <b <?php echo $bgcolor; ?> >
                                        <i class="fa fa-star" ></i> <?php echo $avance_anual; ?>% 
                                    </b>
                                </td>

                                
                            </tr>

                        <?php } ?>
                        </tbody>
                    </table>

                    
                    
                    
           
                    
                    
                    
                </div>
            </div>
        </div>
        
    
    </div>
</div>



<script>  
function Filtro(texto){
    texto = texto.toLowerCase();
    if(texto.length > 3 || texto.length == 0){
        

		$(".tabla_lista tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(texto) > -1)
		});
    }
}
</script>





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
    }
</style>


