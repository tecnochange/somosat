<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
    $("#desplegable_novedades").show();
    $("#bt_novedades_reportes").addClass("active_item");
});
</script>

<?php

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://190.60.93.123/NovaWebEstiloAPI/api/vacaciones/'.$user_log["documento"]); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	$response = curl_exec($ch); 
	curl_close($ch);

	$datos_ws = json_decode($response, true);


	
?>


 
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3>Pasivo Vacacional</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estructura</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=novedades/reportes">Reportes</a></li> 
                    <li class="breadcrumb-item">Detalle</li> 
                </ol>
            </div>
        </div>
    </div>
</div>
    
<?php echo $respuesta; ?>

<div class="card">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Pasivo Vacacional</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                    <input type="hidden" name="padre" value="<?php echo $data["padre"]; ?>">
                    
                    <div>
                        Fecha de solicitud: <b><?php echo date("Y-m-d"); ?></b><br>
                        De: <b><?php echo $user_log['nombre']." ".$user_log['nombre_2']." ".$user_log['apellidos']." ".$user_log['apellidos_2']; ?></b><br>
                        Cargo: <b><?php echo $user_log['cargo']; ?></b><br>
                    </div>
					
					<table class="table table-bordered">
						<tr>
							<td>Cargo</td>
							<td>Fecha Salida</td>
							<td>Fecha Entrada</td>
							
							<td>Días Hábiles</td>
							<td>Días No Hábiles</td>
							<td>Días Dinero</td>
						</tr>
						<?php
						foreach($datos_ws as $registros){
    
							
							echo '
							<tr>
								<td>'.$registros["empleado"]["cargo"]["nombre"].'</td>
								<td>'.$registros["fechaSalida"].'</td>
								<td>'.$registros["fechaEntrada"].'</td>
								
								<td>'.$registros["diasHabiles"].'</td>
								<td>'.$registros["diasNoHabiles"].'</td>
								<td>'.$registros["diasEnDinero"].'</td>
							</tr>
							';
						}
						?>
					</table>
                    
                </div>

            </div>
            </form>
        </div> 
        
</div>

<?php 
//print_r($datos_ws[0]);
?>

