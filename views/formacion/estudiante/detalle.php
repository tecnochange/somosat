<script>  
$(document).ready(function(){
    $("#bt_formacion_seguimiento").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["id_cohorte"] != ""){
		
		if($_FILES["certificado"]["name"]){
            include("app/controllers/subir_documento.php");
            $archivo = Cargar_Foto_Perfil( $_FILES["certificado"] );
			
			$queryCohortesTmp = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id = '".$_POST["id_cohorte"]."' ");  
            $dataCohortesTmp = mysqli_fetch_array($queryCohortesTmp);

            $sentencia = "
			INSERT INTO Certificados ( id_proceso , id_cohorte,  id_empleado ,  archivo ,  created_at ) 
			VALUES 
			( '".$dataCohortesTmp["id_proceso"]."', '".$_POST["id_cohorte"]."', '".$id."', 
			'".$archivo."', '".$hoy."'  )
			";
			
			mysqli_query($connect_formacion, $sentencia);  
            echo '<script> //window.location = "?pg=formacion/estudiante/detalle&id='.$id.'";</script>';//para 
		}  
	}
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);	

	$queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");
	$dataCargo = mysqli_fetch_array($queryCargo);	
?>

<div class="container">
 
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/gestionar">Seguimiento</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
		</ol>
	</nav>
    
	<?php echo $respuesta; ?>

	<div class="card" style="margin-bottom: 15px">
        
		<form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">   
            <div class="row">

                <div class="col-md-12">
                    <h2><?php echo $data["nombre"]; ?> <?php echo $data["apellidos"]; ?></h2>
					<p>
						Cargo: <?php echo $dataCargo["nombre"]; ?><br>
					</p>
                </div>
				
				
				<div class="col-md-6" style="margin-bottom: 10px">
                    <label>Relacionar Proceso</label>
                    <select class="form-control" name="id_cohorte" required>
                        <option value="">Selecciona..</option>
                        <?php
						$queryCohortesLista = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$id."' ORDER BY id ASC ");  
						while($dataCohortesLista = mysqli_fetch_array($queryCohortesLista)){

							$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$dataCohortesLista["id_proceso"]."' ");  
							$dataProceso = mysqli_fetch_array($queryProceso);
							
							echo '<option value="'.$dataCohortesLista["id"].'">'.$dataProceso["nombre"].' </option>';
							
						}
                        ?>
                    </select>
                </div>
				
				<div class="col-md-6" style="margin-bottom: 10px">
                    <label>Cargar Certificado</label>
                    <input class="form-control" type="file" name="certificado" id="certificado"  size="1">
                </div>
                
				
                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Cargar Certificado
                    </button>
                </div>

            </div>
        </div> 
		</form>
		
	</div>
	
	
	
	<div class="card">
        
        <div class="card-body"> 
			
			<h2>Lista de Procesos</h2>
			
			<table class="table">
				<tr>
					<th>Proceso</th>
					<th>Fecha de Finalización</th>
					<th>Certificados</th>
					<th>Fecha</th>
					<th>Estado</th>
				</tr>
				<?php
				$queryCohortes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$id."' ORDER BY id ASC ");  
                while($dataCohortes = mysqli_fetch_array($queryCohortes)){
					
					$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$dataCohortes["id_proceso"]."' ");  
                	$dataProceso = mysqli_fetch_array($queryProceso);

					$select = '<select class="form-control" onchange="CambiarEstado(this, '.$dataCohortes["id"].' )">
                        <option value="">Selecciona..</option>
					';
                    foreach($Array_Estado_Procesos as $nivel){
                    	if($dataCohortes["estado"] == $nivel[0] ){
                    		$select .= '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                    	}
                    	else{
                    		$select .= '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                    	}
                    }
                    $select .= '</select>';	

					
					$lista_certificados = "";
					$queryCertificados = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_empleado = '".$id."' AND id_cohorte = '".$dataCohortes["id"]."' ");  
					while($dataCertificados = mysqli_fetch_array($queryCertificados)){
						$lista_certificados .= '<div><a href="'.$url.'/recursos/'.$dataCertificados["archivo"].'" target="_blank">'.$dataCertificados["archivo"]."</a></div>";
					}
					
					echo '
					<tr>
						<td>'.$dataProceso["nombre"].'</td>
						<td>'.$dataProceso["fecha_termina"].'</td>
						<td>'.$lista_certificados.'</td>
						<td>
							<input type="date" class="form-control" value="'.$dataCohortes["fecha_evaluacion"].'"  onchange="CambiarFecha(this, '.$dataCohortes["id"].')" >
						</td>
						<td>'.$select.'</td>
					</tr>
					';
				}
				?>
				
			</table>
		</div>
		
	</div>
	
</div>



<script>
var api = '<?php echo $api; ?>/';
function CambiarEstado( elem, id_cohorte ){
	estado = $(elem).val();
	
	jQuery.ajax({
		url: api+"formacion/cambiar_estado.php",
		type:'post',
		data: {id_cohorte: id_cohorte, estado: estado,  url:"?pg=administrar/estructura"},
		}).done(function (resp){
			$("#xscript").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
	
function CambiarFecha( elem, id_cohorte ){
	fecha = $(elem).val();
	
	jQuery.ajax({
		url: api+"formacion/cambiar_fecha.php",
		type:'post',
		data: {id_cohorte: id_cohorte, fecha: fecha,  url:"?pg=administrar/estructura"},
		}).done(function (resp){
			$("#xscript").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
	

</script>


