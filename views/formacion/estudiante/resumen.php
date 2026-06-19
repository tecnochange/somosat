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
	if($_POST["guardar_certificado"] != ""){
		
		if($_FILES["certificado"]["name"]){
            include("app/controllers/subir_documento.php");
            $archivo = Cargar_Foto_Perfil( $_FILES["certificado"] );
			
			$queryCohortesTmp = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id = '".$id."' ");
            $dataCohortesTmp = mysqli_fetch_array($queryCohortesTmp);

            $sentencia = "
			INSERT INTO Certificados ( id_proceso , id_cohorte,  id_empleado ,  archivo ,  created_at ) 
			VALUES 
			( '".$dataCohortesTmp["id_proceso"]."', '".$id."', '".$dataCohortesTmp["id_empleado"]."', 
			'".$archivo."', '".$hoy."'  )
			";
			
			mysqli_query($connect_formacion, $sentencia);  
            echo '<script> window.location = "?pg=formacion/estudiante/resumen&id='.$id.'";</script>';//para 
		}  
	}

	//INFORMACION DE LA BATERIA
	$queryCohorte = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id = '".$id."' ");
	$dataCohorte = mysqli_fetch_array($queryCohorte);	

	//INFORMACION DE LA BATERIA
	$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$dataCohorte["id_proceso"]."' ");
	$dataProceso = mysqli_fetch_array($queryProceso);

	$txt_estado = "";
	foreach($Array_Estado_Formacion as $estado){
		if($estado[0] == $dataCohorte["estado"]){ $txt_estado = $estado[1]; }
	}
					
	$txt_motivo = "";
	foreach($Array_Motivo_Formacion as $motivo){
		if($motivo[0] == $dataProceso["motivo"]){ $txt_motivo = $motivo[1]; }
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataCohorte["id_empleado"]."' ");
	$data = mysqli_fetch_array($query);	

	$queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");
	$dataCargo = mysqli_fetch_array($queryCargo);	
?>

<div class="container">
 
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/mi_formacion">Mi Formación</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
		</ol>
	</nav>
    
	<?php echo $respuesta; ?>

	<div class="card" style="margin-bottom: 15px">
        
		<form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">   
            <div class="row">

                <div class="col-md-12">
					<h2><?php echo $dataProceso["nombre"]; ?></h2>
					Colaborador: <b><?php echo $data["nombre"]; ?> <?php echo $data["apellidos"]; ?></b><br>
					Cargo: <b><?php echo $dataCargo["nombre"]; ?></b><br>
					Fecha de planificación/ Q: <b><?php echo $dataProceso["fecha_inicia"]; ?></b><br>
					Fecha Termina: <b><?php echo $dataProceso["fecha_termina"]; ?></b><br>
					Motivo: <b><?php echo $txt_motivo; ?></b><br>
					Examen: <b><?php echo $dataProceso["examen"]; ?></b><br>
					Fecha de Ejecución: <b><?php echo $dataProceso["created_at"]; ?></b><br>
					Estado: <b><?php echo $txt_estado; ?></b><br><br>
					
					Comentarios: <br><b><?php echo $dataProceso["comentarios"]; ?></b>
                </div>

				<div class="col-md-12" style="margin-bottom: 10px">
					<label>Cargar Certificado</label>
				</div>
				<div class="col-md-6" style="margin-bottom: 10px">
                    
					<input type="hidden" name="guardar_certificado" value="true">
                    <input class="form-control" type="file" name="certificado" id="certificado"  size="1">
                </div>
                
				
                <div class="col-md-6" style="margin-bottom: 10px">
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
			
			<h2>Certificado</h2>
			
			<table class="table">
				<tr>
					<th>Documento</th>
					<th>Fecha</th>
				</tr>
				<?php
				$queryCertificados = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_cohorte = '".$id."' ORDER BY id ASC ");  
                while($dataCertificado = mysqli_fetch_array($queryCertificados)){

					echo '
					<tr>
						<td>
							<a href="'.$url.'/recursos/'.$dataCertificado["archivo"].'" 	target="_blank">'.$dataCertificado["archivo"].'</a>
						</td>
						<td>'.$dataCertificado["created_at"].'</td>
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
</script>


