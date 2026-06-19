<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_mi_seguimiento").addClass("active_item");
    
    $('.custom-scrollbar').animate({ scrollTop: $('#bt_desempenio_administrar').offset().top - 500 }, 1000);
});
</script>

<?php
    $hoy = date("Y-m-d H:i:s");
    
    $queryValidar = mysqli_query($connect_desempenio,"SELECT * FROM Aprobaciones_Objetivos 
    WHERE anio = '".$_SESSION['anio']."' 
    AND id_empleado = '".$_SESSION['id_user']."' ORDER BY id ASC "); 
    $dataValidar = mysqli_fetch_array($queryValidar);

	$css_edit = "";
	if($_SESSION['anio'] < 2022){
		$css_edit = "display: none";
	}
    
?>

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
<?php if(1 == 1){ ?>
<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12" style="margin-bottom: 20px">
            <table width="100%">
                <tr>
                    <td>
                        <h2>
                            Mi Seguimiento <?php echo $_SESSION["anio"]; ?>
                        </h2>
                        
                    </td>
                    <td align="right">
                        
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-body">
                    
                    <?php
				 	$seguimiento_general = 0;
                    $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
                    WHERE anio = '".$_SESSION['anio']."' 
                    AND id_empleado = '".$_SESSION['id_user']."' ORDER BY id ASC "); 
                    while($data = mysqli_fetch_array($query)){ 
                        $obj_resultados = json_decode($data["obj_meses_resultados"], true);
                        $obj_meses = json_decode($data["obj_meses"], true);
                    ?>

                        Objetivo: <b><?php echo $data["objetivo"] ?></b><br>
                        Indicador: <i><?php echo $data["indicador"] ?></i><br>
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
                                    
                                    $REALIZADO_GLOBAL += $resp_mes;
                                    $META_GLOBAL += $meta_mes;
                                    
                                    $bgcolor = 'style="background-color: #dddbdb; color:#000000"';
                                    if($avance > 0 && $avance <= 49){ $bgcolor = 'style="background-color:#ff0000"'; }
                                    if($avance > 49 && $avance <= 89){ $bgcolor = 'style="background-color:#ffc107"'; }
                                    if($avance > 89){ $bgcolor = 'style="background-color:#008000"'; }
                                    
									if($meta_mes > 0){
                                    echo '
                                        <td align="center">
                                            '.$mes[1].'<br>
                                            <div class="meses" '.$bgcolor.' title="'.$resp_mes.' - '.$meta_mes.'">
                                            
                                            <b>'.round($avance).'%</b>
                                            </div>
                                        </td>
                                    ';
									}
                                    
                                }
                        
                                $AVANCE_GLOBAL = round( ($REALIZADO_GLOBAL/$META_GLOBAL)*100) ;

                                $bgcolor_avance = 'style="background-color: #dddbdb; color:#000000"';
                                if($AVANCE_GLOBAL > 0 && $AVANCE_GLOBAL <= 49){ $bgcolor_avance = 'style="background-color:#ff0000"'; }
                                if($AVANCE_GLOBAL > 49 && $AVANCE_GLOBAL <= 89){ $bgcolor_avance = 'style="background-color:#ffc107"'; }
                                if($AVANCE_GLOBAL > 89){ $bgcolor_avance = 'style="background-color:#008000"'; }
                        
                                
                        
                                
                                ?>
                                <td align="center" title="<?php echo $META_GLOBAL; ?>">
                                    Meta
                                    <div class="meses" style="color: #000000;">
                                        <?php echo $data["meta"]; ?>
                                    </div>
                                </td>
                                <td align="center" title="<?php echo $AVANCE_GLOBAL; ?>">
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
                                
                                <td align="center" width="10">
                                    <a href="<?php echo $url; ?>/?pg=desempenio/objetivo/seguimiento&id=<?php echo $data["id"]; ?>" style="display: none">
                                        <button type="button" class="btn btn-primary btn-sm" title="Seguimiento" style="<?php echo $css_edit; ?>" >
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    
                    <?php } ?>
                    
                </div>
            </div>
            
  			<div class="alert alert-success" role="alert" style="margin-top: 15px" align="center">
			  <h3>Seguimiento general: <?php echo $seguimiento_general; ?>%</h3>
			</div>
            
        </div>
        
    
    </div>
</div>
<?php } else{ ?>
<div class="alert alert-success" role="alert" align="center">
    Sin Objetivos Aprobados
</div>
<?php } ?>
