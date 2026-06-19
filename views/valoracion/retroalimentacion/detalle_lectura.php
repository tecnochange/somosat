<?php
	$hoy = date("Y-m-d H:i:s");
    $id = $_GET["id"];
    $e = $_GET["e"];

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["activar_form"] != ""){
		
		if($_POST["id_registro"] != ""){
            
            mysqli_query($connect_valoracion,"UPDATE Retroalimentacion SET
            retro_fortalezas = '".$_POST["retro_fortalezas"]."', 
            retro_oportunidad = '".$_POST["retro_oportunidad"]."', 
            observaciones = '".$_POST["observaciones"]."' 
            WHERE id = '".$_POST["id_registro"]."'  ");
            
            echo '<script> window.location = "?pg=valoracion/retroalimentacion/detalle_lectura&e='.$e.'&id='.$_POST["id_registro"].'"; </script>';
            
		}
		
        
        $id_tmp = mysqli_insert_id($connect_valoracion);

		
		$respuesta = '
			<div class="alert alert-success" role="alert" style="margin-top:8px">
			  Información Guardada.
			</div>
		';
        
        
	}

    if($_POST["terminar_form"] != ""){
        mysqli_query($connect_valoracion,"UPDATE Retroalimentacion SET
            estado = 3
            WHERE id = '".$_POST["id_registro"]."'  ");
            echo '<script> window.location = "?pg=valoracion/retro_individual"; </script>';
        
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

    $readyonly = '';
    if( $data["estado"] == 3){
        $readyonly = 'readonly';
    }

?>


<div class="container">

	<?php echo $respuesta; ?>

	<nav aria-label="breadcrumb" >
	  <ol class="breadcrumb">
		  <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
		  <li class="breadcrumb-item"><a href="?pg=valoracion/retro_individual">Retroalimentación Individual</a></li>
		  <li class="breadcrumb-item active" aria-current="page">Retroaliamentación</li>
	  </ol>
	</nav>

	<div align="left" style="padding-bottom: 10px">
		<table width="100%">
			<tr>
				<td></td>
				<td align="right">
					<button type="button" class="btn btn-warning btn-sm" onclick="window.print();" style="background-color: #FFC107; border: 0; color: #ffffff; padding: 10px; ">
						<i class="fa fa-print"></i> Imprimir / Descargar
					</button>
				</td>
			</tr>
		</table>

	</div>



	<!-- FICHA -->
	<div class="card" style="margin-bottom: 15px">
		<div class="card-body" align="center">

			<div class="row">
				<div class="col-md-12" align="left">
					Colaborador: <b><?php echo $dataEva["nombre"]." ".$dataEva["apellidos"]; ?></b> <br>
					Fecha: <b><?php echo $data["created_at"]; ?></b> <br>
					Cargo: <b><?php echo $dataCargo["nombre"]; ?></b> <br>

				</div>
			</div>

		</div>
	</div>

	<div class="card" style="margin-bottom: 15px">
		<div class="card-body">

			<form action="" method="post">
			<div class="row">

				<input type="hidden" value="<?php echo $id; ?>" name="id_registro">
				<input type="hidden" name="activar_form" value="true">

				<div class="col-md-12" align="center">
					<h2 style="margin-top: 8px;">
						RETROALIMENTACIÓN PARA EL MEJORAMIENTO (SEGUIMIENTO)
					</h2>
				</div>

				<div class="col-md-6">
					Participar en algún proyecto que hasta el momento no tuve experiencia.<br>
					<textarea class="form-control" name="campo_1" readonly  ><?php echo $data["campo_1"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Capacitación Especifica<br>
					<textarea class="form-control" name="campo_2" readonly  ><?php echo $data["campo_2"]; ?></textarea>
				</div>
				
				<div class="col-md-6">
					Coaching<br>
					<textarea class="form-control" name="campo_3" readonly   ><?php echo $data["campo_3"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Intercambio con colegas de otras empresas para hacer Brenchmarketing<br>
					<textarea class="form-control" name="campo_4" readonly  ><?php echo $data["campo_4"]; ?></textarea>
				</div>



				
				<div class="col-md-6">
					Colaborar algunos días en otras áreas<br>
					<textarea class="form-control" name="campo_5" readonly  ><?php echo $data["campo_5"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Trabajar de la mano con Dirección<br>
					<textarea class="form-control" name="campo_6" readonly  ><?php echo $data["campo_6"]; ?></textarea>
				</div>






				 <div class="col-md-6">
					Participar en congresos, exposiciones, etc. representando a AT<br>
					<textarea class="form-control" name="campo_7" readonly  ><?php echo $data["campo_7"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Tomar contacto con proveedores de AT que hasta el momento no haya contactado.<br>
					<textarea class="form-control" name="campo_8" readonly  ><?php echo $data["campo_8"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Tomar contacto con clientes de AT que hasta el momento no haya contractado<br>
					<textarea class="form-control" name="campo_9" readonly  ><?php echo $data["campo_9"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Recibir feedback de mi equipo de reporte<br>
					<textarea class="form-control" name="campo_10" readonly  ><?php echo $data["campo_10"]; ?></textarea>
				</div>
				<div class="col-md-6">
					Otras: ¿cuáles?<br>
					<textarea class="form-control" name="campo_11" readonly  ><?php echo $data["campo_11"]; ?></textarea>
				</div>
				
				<div class="col-md-12" style="margin-top: 20px"> 
					<h2>Retroalimentación Referente a Colaborador </h2>
				</div>
				<div class="col-md-6">
					Fortalezas<br>
					<textarea class="form-control" name="retro_fortalezas_jefe" readonly ><?php echo $data["retro_fortalezas_jefe"]; ?></textarea>
				</div>

				<div class="col-md-6">
					Áreas de oportunidad<br>
					<textarea class="form-control" name="retro_oportunidad_jefe" readonly ><?php echo $data["retro_oportunidad_jefe"]; ?></textarea>
				</div>

				<div class="col-md-12">
					<h4>Observaciones y comentarios seguimiento</h4>
					<textarea class="form-control" name="observaciones_jefe" readonly ><?php echo $data["observaciones_jefe"]; ?></textarea>
				</div>


				



				<div class="col-md-12" > 
					<h4>Retroalimentación Colaborador a Jefe</h4>

				</div>
				<div class="col-md-6">
					<b>Fortalezas *</b><br>
					<textarea class="form-control" name="retro_fortalezas" <?php echo $readyonly ; ?> required ><?php echo $data["retro_fortalezas"]; ?></textarea>
				</div>

				<div class="col-md-6">
					<b>Áreas de oportunidad *</b><br>
					<textarea class="form-control" name="retro_oportunidad" <?php echo $readyonly ; ?> required ><?php echo $data["retro_oportunidad"]; ?></textarea>
				</div>

				<div class="col-md-12">
					<h4>Observaciones y comentarios seguimiento</h4>
					<textarea class="form-control" name="observaciones" <?php echo $readyonly ; ?> ><?php echo $data["observaciones"]; ?></textarea>
				</div>

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



				<?php if( $data["estado"] == 2 && $_SESSION['role_plataforma'] != 1){ ?>
				<div class="col-md-12" style="margin-top: 20px">
					<button type="submit" class="btn btn-success" >
						Guardar
					</button>
				</div>
				<?php } ?>

			</div>
			</form>


		</div>

		</div>

	
	<?php if( $data["retro_fortalezas"] && $data["retro_oportunidad"] && $data["estado"] == 2  ){ ?>
	<div class="card" style="margin-top: 20px; margin-bottom: 20px">
		<div class="card-body">
			<form action="" method="post">
			<div class="row">

				<input type="hidden" value="<?php echo $id; ?>" name="id_registro">
				<input type="hidden" name="terminar_form" value="true">

				<div class="col-md-12" >
					<button type="submit" class="btn btn-danger btn-block" >
						Terminar y enviar Seguimiento 
					</button>
				</div>

			</div>
			</form>
		</div>
	</div>
	<?php } ?>
	
	
</div>

<style>
    .comentario{
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #e9ecef;
        border-radius: 5px;
        margin-bottom: 11px;
    }
</style>









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
    
    .pagina {
				padding: 0.3cm 1cm;
				background-color:#fff;
				page-break-after: always;
				border-bottom: 1px solid #ccc;
				width:100%;
				margin: 0.5cm auto;
				font-family: sans-serif;
				font-size: 14px;
			}
    
    
    
            @media screen {
			   body { font-size: 10pt }
			}
			@media screen, print {
			   body { line-height: 1.2 }
			}
			
			
			@media print{
				
				body {
					margin: 0;
					padding: 0;
					background-color: #ffffff;
					font-size: 10pt;
					
				}
				* {
					box-sizing: border-box;
					-moz-box-sizing: border-box;
				}
	
				.bt_print{
					display:none;
				}
				
				.pagina {
					border: initial;
					width: initial;
					min-height: initial;
					page-break-after: always;
					font-size:16px;
				}
                
                #sidebar{
                 display: none;
                }
                
                #content{
                    width: 100%;
                }
                #menu_header{
                    display: none;
                }
				
			}
    
    
</style>

