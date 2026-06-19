<?php
	$hoy = date("Y-m-d H:i:s");
    $id = $_GET["id"];
    $e = $_GET["e"];

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["activar_form"] != ""){
		
		if($_POST["id_registro"] != ""){
			
			$sentenia = "
			UPDATE Retroalimentacion SET campo_1 = '".$_POST["campo_1"]."', campo_2 = '".$_POST["campo_2"]."', campo_3 = '".$_POST["campo_3"]."', campo_4 = '".$_POST["campo_4"]."', campo_5 = '".$_POST["campo_5"]."', campo_6 = '".$_POST["campo_6"]."', campo_7 = '".$_POST["campo_7"]."', campo_8 = '".$_POST["campo_8"]."', campo_9 = '".$_POST["campo_9"]."', campo_10 = '".$_POST["campo_10"]."', campo_11 = '".$_POST["campo_11"]."', retro_fortalezas_jefe = '".$_POST["retro_fortalezas_jefe"]."' , retro_oportunidad_jefe = '".$_POST["retro_oportunidad_jefe"]."',  observaciones_jefe = '".$_POST["observaciones_jefe"]."'   
			WHERE id = '".$_POST["id_registro"]."'
			";
            
            mysqli_query($connect_valoracion, $sentenia);
            
			$respuesta = '
				<div class="alert alert-success" role="alert" style="margin-top:8px">
				  Información Guardada.
				</div>
			';
		}
		else{
			$sentencia = "
			INSERT INTO Retroalimentacion ( id_jefe , id_empleado , campo_1, campo_2, campo_3, campo_4, campo_5, campo_6, campo_7, campo_8, campo_9, campo_10, campo_11, retro_fortalezas_jefe , retro_oportunidad_jefe,  observaciones_jefe , estado, created_at ) 
			VALUES 
			( '".$_SESSION['id_user']."' , '".$e."' , '".$_POST["campo_1"]."', '".$_POST["campo_2"]."', '".$_POST["campo_3"]."', '".$_POST["campo_4"]."', '".$_POST["campo_5"]."', '".$_POST["campo_6"]."', '".$_POST["campo_7"]."', '".$_POST["campo_8"]."', '".$_POST["campo_9"]."', '".$_POST["campo_10"]."', '".$_POST["campo_11"]."', 
			'".$_POST["retro_fortalezas_jefe"]."', '".$_POST["retro_oportunidad_jefe"]."', '".$_POST["observaciones_jefe"]."', 1, '".$hoy."' )
			";

            mysqli_query($connect_valoracion, $sentencia);
            $id_tmp = mysqli_insert_id($connect_valoracion);
            echo '<script> window.location = "?pg=valoracion/retroalimentacion/detalle&e='.$e.'&id='.$id_tmp.'"; </script>';
			
		}

		
	}

    if($_POST["terminar_form"] != ""){
		mysqli_query($connect_valoracion,"UPDATE Retroalimentacion SET
		estado = 2
		WHERE id = '".$_POST["id_registro"]."'  ");
		echo '<script> window.location = "?pg=valoracion/retro_equipo"; </script>';
        
    }

	//EVALUADO
    $queryEvaluado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$e."'");
    $dataEva = mysqli_fetch_array($queryEvaluado);
    
    //CARGO
    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEva["id_cargo"]."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);

    //EVALUADO
    $query = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion WHERE id = '".$id."'");
    $data = mysqli_fetch_array($query);

?>


<?php include("views/layouts/ficha_competencia.php"); ?>

<div class="container">

	<?php echo $respuesta; ?>

	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		  <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
		  <li class="breadcrumb-item"><a href="?pg=valoracion/retro_individual">Retroalimentación Individual</a></li>
		  <li class="breadcrumb-item active" aria-current="page">Retroaliamentación</li>
	  </ol>
	</nav>

	<!-- FICHA -->
	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="center">

			<div class="row">
				<div class="col-md-12" align="left">
					Colaborador: <b><?php echo $dataEva["nombre"]." ".$dataEva["apellidos"]; ?></b> <br>
					Cargo: <b><?php echo $dataCargo["nombre"]; ?></b> <br>
					Fecha: <b><?php echo $data["created_at"]; ?></b> <br>
				</div>
			</div>

		</div>
	</div>

	<div class="card">


		<div class="card-body">

			<form action="" method="post">
			<div class="row">

				<input type="hidden" value="<?php echo $id; ?>" name="id_registro">
				<input type="hidden" name="activar_form" value="true">

				<div class="col-md-12" align="center">
					<h2 style="margin-top: 8px;">
						RETROALIMENTACIÓN PARA EL MEJORAMIENTO (CREACIÓN)
					</h2>
				</div>

				<div class="col-md-6">
					Participar en algún proyecto que hasta el momento no tuve experiencia.<br>
					<textarea class="form-control" name="campo_1" required  ><?php echo $data["campo_1"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Capacitación Especifica<br>
					<textarea class="form-control" name="campo_2" required ><?php echo $data["campo_2"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Coaching<br>
					<textarea class="form-control" name="campo_3" required  ><?php echo $data["campo_3"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Intercambio con colegas de otras empresas para hacer Brenchmarketing<br>
					<textarea class="form-control" name="campo_4" required ><?php echo $data["campo_4"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Colaborar algunos días en otras áreas<br>
					<textarea class="form-control" name="campo_5"  ><?php echo $data["campo_5"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Trabajar de la mano con Dirección<br>
					<textarea class="form-control" name="campo_6"  ><?php echo $data["campo_6"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Participar en congresos, exposiciones, etc. representando a AT<br>
					<textarea class="form-control" name="campo_7"  ><?php echo $data["campo_7"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Tomar contacto con proveedores de AT que hasta el momento no haya contactado.<br>
					<textarea class="form-control" name="campo_8"  ><?php echo $data["campo_8"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Tomar contacto con clientes de AT que hasta el momento no haya contractado<br>
					<textarea class="form-control" name="campo_9"  ><?php echo $data["campo_9"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Recibir feedback de mi equipo de reporte<br>
					<textarea class="form-control" name="campo_10"  ><?php echo $data["campo_10"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Otras: ¿cuáles?<br>
					<textarea class="form-control" name="campo_11"  ><?php echo $data["campo_11"]; ?></textarea>
				</div>

				
				
				

				<div class="col-md-12" style="margin-top: 20px"> 
					<h2>Retroalimentación Referente a Colaborador (CREACIÓN) </h2>
				</div>
				<div class="col-md-6">
					Fortalezas<br>
					<textarea class="form-control" name="retro_fortalezas_jefe" <?php echo $readyonly ; ?> ><?php echo $data["retro_fortalezas_jefe"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Áreas de oportunidad<br>
					<textarea class="form-control" name="retro_oportunidad_jefe" <?php echo $readyonly ; ?> ><?php echo $data["retro_oportunidad_jefe"]; ?></textarea>
				</div>

				<div class="col-md-12">
					<h4>Observaciones y comentarios seguimiento</h4>
					<textarea class="form-control" name="observaciones_jefe" <?php echo $readyonly ; ?> ><?php echo $data["observaciones_jefe"]; ?></textarea>
				</div>










				
				
				
				
				
				
				
				

				<?php if($id){ ?>
				<div class="col-md-12" style="margin-top: 10px">
				   <h4>Comentarios</h4>
					<div>
					<?php
					   $queryComen = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion_Comentarios  WHERE id_retroalimentacion = '".$id."' "); 
						while($dataComent = mysqli_fetch_array($queryComen)){
							echo '
								<div class="comentario">
									'.$dataComent["comentario"].'
								</div>
							';
						}
						?>
					</div>

				</div>
				<?php } ?>

				<style>
					.comentario{
						border: 1px solid #ccc;
						padding: 10px;
						background-color: #e9ecef;
						border-radius: 5px;
						margin-bottom: 11px;
					}
				</style>




				<div class="col-md-12" style="margin-top: 20px">
					<button type="submit" class="btn btn-success" >
						Guardar
					</button>
				</div>

			</div>
			</form>


		</div>

	</div>

	
	<?php if( $id ){ ?>
	<div class="card" style="margin-top: 20px; margin-bottom: 20px">
		<div class="card-body">
			<form action="" method="post">
			<div class="row">

				<input type="hidden" value="<?php echo $id; ?>" name="id_registro">
				<input type="hidden" name="terminar_form" value="true">

				<div class="col-md-12" >
					<button type="submit" class="btn btn-danger btn-block" >
						Terminar y enviar retroalimentacion al colaborador
					</button>
				</div>

			</div>
			</form>
		</div>
	</div>
	<?php } ?>
	
</div>



<script>
$(document).ready(function(){
	
	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		
		$(".myTable").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
			$(this).next(".insumos").toggle($(this).text().toLowerCase().indexOf(value) > -1);
			//$(this).next(".insumos").toggle();
			//$(this).parent().next().hide();
		});
		
		$(".name_fil_off").parent().show();
		
	});
	
});


var api = 'https://wandtalent.com/seleccion/superadmin/api/';

function Ficha_Competencia(id){
	$('#lista_niveles').html('');
	jQuery.ajax({
		url: api+"ficha_competencia.php",
		type:'post',
		data: {id: id, url:"?pg=competencias"},
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

function Seter_Ficha (){
	
	$('[name="nombre"]').val( "" );
	$('[name="definicion"]').val( "" );
	$('[name="id_tipo"]').val( "" );
	
	$('[name="id_competencia"]').val( "" );
	
}
</script>

<script>
    $("#bt_retro_individual").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>


<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

