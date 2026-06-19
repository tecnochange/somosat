<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_seguimiento").addClass("active_item");
});
</script>

<?php
    $filtro = " WHERE estado = 1 ";
    if($_POST["id_cargo_fill"] != ""){
        $filtro .= " AND emp.id_cargo = '".$_POST["id_cargo_fill"]."' ";
    }

    $mes_actual = date("n");
    if( $_SESSION["anio"] < date("Y") ){
        $mes_actual = 13;
    }

	include("app/models/Collaborators.php");
	$ClassCollaborators = new Collaborators();
	$colaboradores = $ClassCollaborators->lista_colaboradores($connect_valentina, 1);

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

<!-- CABECERA -->
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Gestión del Desempeño</li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=desempenio/mis_objetivos">Seguimiento <?php echo $_SESSION["anio"]; ?></a></li>
                    <li class="breadcrumb-item active">Detalle</li>
                </ol>
            </div>
        </div>
    </div>
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
                            Seguimiento Individual <?php echo $_SESSION["anio"]; ?>
                        </h2>
                        
                    </td>
                    <td align="right">
                        
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-12">
            
            <?php
			foreach($colaboradores as $dataEmpleados){

				$permitir_fila = true;
				if($_POST["id_cargo_fill"]){
					$permitir_fila = false;
					if($_POST["id_cargo_fill"] == $dataEmpleados["id_cargo"] ){
						$permitir_fila = true;
					}
				}
				
				if($permitir_fila == true){
            ?> 

                <div class="card ficha_colaborador" style="margin-bottom: 15px">
                    <div class="card-body">
                        <a href="<?php echo $url; ?>?pg=desempenio/objetivo/detalle&e=<?php echo $dataEmpleados["id"]; ?>">
                            <button type="button" class="btn btn-primary btn-sm"  style="float: right;">
                                Cargar
                            </button>
                        </a>
                        
                        <h4><?php echo $dataEmpleados["nombre_completo"]." ".$dataEmpleados["id_cargo"]; ?></h4>
                        
                        <?php
                        //CONSULTAMOS LOS OBJETIVOS DE CADA EMPLEADO
                        $seguimiento_general = 0;
                        $avance_anual = 0;
                        $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
                        WHERE anio = '".$_SESSION['anio']."' 
                        AND id_empleado = '".$dataEmpleados["id"]."' ORDER BY id ASC "); 
                        while($data = mysqli_fetch_array($query)){ 
                            $obj_resultados = json_decode($data["obj_meses_resultados"], true);
                            $obj_meses = json_decode($data["obj_meses"], true);
                        ?>
                            Objetivo: <b><?php echo $data["objetivo"]; ?></b><br>
                            Indicador: <i><?php echo $data["indicador"]; ?></i><br>
                            Fecha de Cumplimiento: <?php echo $data["fecha_cumplimiento"]; ?>
                            <h5><b>Ponderado: <?php echo $data["ponderado"]; ?>%</b></h5>
                            <table class="tabla_anios">
                                <tr>
                                    <?php 
                                    $META_GLOBAL = 0;
                                    $REALIZADO_GLOBAL = 0;
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
                                        
                                        $REALIZADO_GLOBAL += $resp_mes;
                                        $META_GLOBAL += $meta_mes; 

                                        $bgcolor = 'style="background-color: #dddbdb; color:#000000"';
                                        if($avance > 0 && $avance <= 49){ $bgcolor = 'style="background-color:#ff0000"'; }
                                        if($avance > 49 && $avance <= 89){ $bgcolor = 'style="background-color:#ffc107"'; }
                                        if($avance > 89){ $bgcolor = 'style="background-color:#008000"'; }
                                        
                                        if($mes_actual < $mes[0] || $mes[0] == 1  ){
                                            $bgcolor = 'style="background-color: #ffffff; color:#000000"';
                                        }
                                        
                                        if($meta_mes > 0){
                                        echo '
                                            <td align="center">
                                                '.$mes[1].'
                                                <div class="meses" '.$bgcolor.'>
                                                    <b>'.round($avance).'%</b>
                                                </div>
                                            </td>
                                        ';
                                        }
                                        
                                    }
                                    
                                    $AVANCE_GLOBAL = round( ($REALIZADO_GLOBAL/$META_GLOBAL)*100) ;
                            
                                    //$avance_anual = $avance_mensual/12;
                                    $bgcolor_avance = 'style="background-color: #dddbdb; color:#000000"';
                                    if($AVANCE_GLOBAL > 0 && $AVANCE_GLOBAL <= 49){ $bgcolor_avance = 'style="background-color:#ff0000"'; }
                                    if($AVANCE_GLOBAL > 49 && $AVANCE_GLOBAL <= 89){ $bgcolor_avance = 'style="background-color:#ffc107"'; }
                                    if($AVANCE_GLOBAL > 89){ $bgcolor_avance = 'style="background-color:#008000"'; }
                            
                                    
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
                                            <b><?php echo round($AVANCE_GLOBAL); ?>%</b>
                                        </div>
                                    </td>
                                    <?php
                                        $seguimiento_general += round($AVANCE_GLOBAL*$data["ponderado"]/100);
                                    ?>
                                    <td align="center" title="<?php echo $AVANCE_GLOBAL; ?>">
                                        Ponderado
                                        <div class="meses" <?php echo $bgcolor_avance; ?> >
                                            <b><?php echo round($AVANCE_GLOBAL*$data["ponderado"]/100); ?>%</b>
                                        </div>
                                    </td>
                                    <td align="center">
                                        <a href="<?php echo $url; ?>/?pg=desempenio/objetivo/seguimiento&id=<?php echo $data["id"]; ?>">
                                            <button type="button" class="btn btn-primary btn-sm" title="Seguimiento" >
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </a>
                                        <a href="<?php echo $url; ?>/?pg=desempenio/objetivo/detalle&id=<?php echo $data["id"]; ?>">
                                            <button type="button" class="btn btn-primary btn-sm" title="Editar" >
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        
                        <?php } ?>
                        
                        <?php if($query->num_rows == 0){ ?>
                        <div>Sin Objetivos</div>
                        <?php } ?>
                        
                        <div class="alert alert-success" role="alert" style="margin-top: 15px" align="center">
                        <h3>Seguimiento general: <?php echo $seguimiento_general; ?>%</h3>
                        </div>
                        
                    </div>
                </div>
            
            <?php } } ?>
  
            
        </div>
        
    
    </div>
</div>

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


document.getElementById('buscador').addEventListener('keydown', function(event) { 
        
    if (event.key === 'Enter') {
        event.preventDefault(); // Evita que el Enter envíe el formulario
        // Aquí puedes hacer otras acciones, como enfocar otro input
        //console.log('Se presionó Enter en el input, se previno el envío.');
    }
});
    
</script>

