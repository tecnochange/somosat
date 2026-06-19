<script>  
$(document).ready(function(){
    $("#bt_formacion_solicitudes").addClass("active_item");
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
			( '".$dataCohortesTmp["id_proceso"]."', '".$_POST["id_cohorte"]."', '".$dataCohortesTmp["id_empleado"]."', 
			'".$archivo."', '".$hoy."'  )
			";
			
			mysqli_query($connect_formacion, $sentencia);  
            echo '<script> //window.location = "?pg=formacion/estudiante/detalle&id='.$id.'";</script>';//para 
		}  
	}

	//INFORMACION DE LACOHORTE
	$queryCohorte = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id = '".$id."' ");
	$dataCohorte = mysqli_fetch_array($queryCohorte);	
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
	WHERE id = '".$dataCohorte["id_empleado"]."' ");
	$data = mysqli_fetch_array($query);	

	$queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");
	$dataCargo = mysqli_fetch_array($queryCargo);

	$queryProc = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$dataCohorte["id_proceso"]."' "); 
	$dataProc = mysqli_fetch_array($queryProc);

	$txt_motivo = "";
	foreach($Array_Motivo_Formacion as $motivo){
		if($motivo[0] == $dataProc["motivo"]){ $txt_motivo = $motivo[1]; }
	}

	$txt_costo = "";
	foreach($Array_Moneda_Formacion as $nivel){
		if($dataProc["costo"] == $nivel[0] ){
			$txt_costo = $nivel[1];
		}                      
	}

	$queryMarca = mysqli_query($connect_formacion,"SELECT * FROM Marcas 
	WHERE id = '".$dataProc["id_marca"]."' ");
	$dataMarca = mysqli_fetch_array($queryMarca);
?>

<div class="container">
 
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/solicitudes">Solicitudes Referentes</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/gestionar/seguimiento&id=<?php echo $dataCohorte["id_solicitud"]; ?>">Seguimiento del Plan de formación</a></li>
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
					
					<h2>Seguimiento del Plan de formación: <?php echo $dataProc["nombre"]; ?></h2>
					<div>
						Marca: <b><?php echo $dataMarca["nombre"]; ?></b><br>
						Motivo: <b><?php echo $txt_motivo; ?></b><br> 
						Costo en: <b><?php echo $txt_costo; ?></b><br> 
						El curso termina el: <b><?php echo $dataProc["fecha_termina"]; ?></b><br> 
					</div>
                </div>
				
				
				
				
				<div class="col-md-12" style="margin-bottom: 10px">
                    <label>Cargar Certificado</label>
                    <input class="form-control" type="file" name="certificado" id="certificado"  size="1">
					<input type="hidden" name="id_cohorte" value="<?php echo $id; ?>">
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
					<th>Certificado</th>
					<th>Fecha de cargue</th>
					<th>Acciones</th>
				</tr>
				<?php
				$queryCertificados = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_empleado = '".$dataCohorte["id_empleado"]."' AND id_cohorte = '".$dataCohorte["id"]."' ");  
				while($dataCertificados = mysqli_fetch_array($queryCertificados)){
					
					$bt_eliminar = '';
					if($user_log["role"] == 1){
						$bt_eliminar = '
							<button type="button" class="btn btn-danger btn-sm" title="Eliminar Certificado" onclick="Eliminar('.$dataCertificados["id"].')">
								<i class="bx bx-trash"></i>
							</button>
						';
					}
					
					echo '
					<tr>
						<td>
							<a href="'.$url.'/recursos/'.$dataCertificados["archivo"].'"  target="_blank">'.$dataCertificados["archivo"].'</a>
						</td>
						<td>'.$dataCertificados["created_at"].'</td>
						<td>'.$bt_eliminar.'</td>
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
	
	
var urls = "<?php echo $url; ?>/api/";
	var activar = false;
	//GUARDAR ACADEMICO
	function Eliminar(val){	
	
		if(activar == false){
			$("#modal_borrar").modal("show");
	
			$("#cont_modal_").html('Esta a punto de eliminar es certificado ¿Esta seguro?');
				
			$("#botones_modal").html('<button type="button" class="btn btn-danger" onclick="activar = true; Eliminar('+val+')">Eliminar</button>');
			$("#botones_modal").append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
		}
		
		else{	
			jQuery.ajax({
				url: urls+"formacion/eliminar_certificado.php",
				type:'post',
				data: {id:val, url:'?pg=formacion/gestionar/certificado_detalle&id=<?php echo $id; ?>'},
				}).done(function (resp){
					//$("this").hide();	
					$("#xscript").html(resp);
				})
				.fail(function() {
				})
				.always(function(resp){
				}
			);	
		}
	}
</script>


