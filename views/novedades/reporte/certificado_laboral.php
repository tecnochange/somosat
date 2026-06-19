<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
    $("#desplegable_novedades").show();
    $("#bt_novedades_reportes").addClass("active_item");
});
</script>

<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://190.60.93.123/NovaWebEstiloAPI/api/certificados/'.$user_log["documento"]); 
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
                <h3>Certificación Laboral</h3>
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

<div class="card" style="margin-bottom: 20px">
        
        <div class="card-body">   
            <div class="row">

                <div class="col-md-12">
                    <h2>Solicitud de certificación Laboral</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                    <input type="hidden" name="padre" value="<?php echo $data["padre"]; ?>">
                    
                    <div>
                        Fecha de solicitud: <b><?php echo date("Y-m-d"); ?></b><br>
                        De: <b><?php echo $user_log['nombre']." ".$user_log['nombre_2']." ".$user_log['apellidos']." ".$user_log['apellidos_2']; ?></b><br>
                        Cargo: <b><?php echo $user_log['cargo']; ?></b><br>
                    </div>
                </div>

            </div>

        </div> 
        
</div>


<div class="card">
        
        <div class="card-body">   
            <div class="row">

                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 25px" align="center">
                    <b><?php echo $datos_ws["compania"]["nombre"]; ?></b><br>
                    <b>Nit. <?php echo $datos_ws["compania"]["nit"]; ?></b><br><br>
					
					<div align="left">
						<?php echo $datos_ws["destinatario"]; ?><br><br>
						<?php echo $datos_ws["content"]; ?><br>
						<br>
						<br>
						<br>
					
						

						<?php echo $datos_ws["footer"]; ?><br>

						<?php echo $datos_ws["firma"]["nombre"]; ?><br>
						<?php echo $datos_ws["firma"]["cargo"]; ?><br><br>
						<img src="<?php echo $datos_ws["firma"]["imagen"]; ?>" width="200" style="display: none"><br>
						Documento generado el: <?php echo $datos_ws["fechaActual"]; ?><br>
						<br>
						<br>
						<br>
					</div>
                </div>

                
                
            </div>

        </div> 
        
</div>


