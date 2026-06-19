<script>  
$(document).ready(function(){
    $("#bt_formacion_tablero").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
$filtro = "";
$filtro_solicitudes = "";
$filtro_participantes = "";
$filtro_certificados = "";

if($_POST["fill_inicia"]){
	$filtro .= " AND fecha_inicia >= '".$_POST["fill_inicia"]."' ";
	$filtro_solicitudes .= " AND fecha_inicia >= '".$_POST["fill_inicia"]."' ";
	$filtro_participantes .= " AND fecha_evaluacion >= '".$_POST["fill_inicia"]."' ";
	$filtro_certificados .= " AND created_at >= '".$_POST["fill_inicia"]." 00:00:00' "; 
}
if($_POST["fill_termina"]){
	$filtro .= " AND fecha_termina <= '".$_POST["fill_termina"]."' ";
	$filtro_solicitudes .= " AND fecha_inicia <= '".$_POST["fill_inicia"]."' ";
	$filtro_participantes .= " AND fecha_evaluacion <= '".$_POST["fill_inicia"]."' ";
	$filtro_certificados .= " AND created_at <= '".$_POST["fill_termina"]." 23:00:00' "; 
}



$queryProcesos = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id > 0 ".$filtro." ");
$queryParticipantes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id > 0 ".$filtro_participantes." ");

$queryCertificados = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id > 0 ".$filtro_certificados." ");
$queryMarcas = mysqli_query($connect_formacion,"SELECT * FROM Marcas ");
$queryProveedores = mysqli_query($connect_formacion,"SELECT * FROM Proveedores ");


$count_inv = 0;
$count_aprobados = 0;

$query = mysqli_query($connect_formacion,"SELECT * FROM Solicitudes WHERE id > 0 ".$filtro_solicitudes." ");  
while($data = mysqli_fetch_array($query)){ 
					
	//VALIDAMOS LOS INVITADOS
	//$count_inv = 0;
	//$count_aprobados = 0;
	if($data["colaboradores"]){
		$no_participantes = explode(",", $data["colaboradores"]);
		foreach($no_participantes as $participante){
			$queryVal = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$participante."' AND id_proceso = '".$data["id_proceso"]."' "); 
			if( $queryVal->num_rows > 0 ){
				$count_aprobados++;
			}
			$count_inv++;

		}
	}
}



$dolares_AT = 0;
$pesos_AT = 0;
$euros_AT = 0;

$dolares_Proveedor = 0;
$pesos_Proveedor = 0;
$euros_Proveedor = 0;


$dolares = 0;
$pesos = 0;
$euros = 0;
$carga_horaria = 0;
//obtener el presupuesto de los tableros
$queryProcesosPres = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id > 0 ".$filtro." ORDER BY nombre ASC ");  
while($dataProcesosPres = mysqli_fetch_array($queryProcesosPres)){

	if($dataProcesosPres["costo"] == 1 ){
		$pesos_AT += $dataProcesosPres["valor"];
	}
	if($dataProcesosPres["costo"] == 2 ){
		$dolares_AT += $dataProcesosPres["valor"];
	}
	if($dataProcesosPres["costo"] == 3 ){
		$euros_AT += $dataProcesosPres["valor"];
	}
	
	
	if($dataProcesosPres["divisa_proveedor"] == 1 ){
		$pesos_Proveedor += $dataProcesosPres["costo_proveedor"];
	}
	if($dataProcesosPres["divisa_proveedor"] == 2 ){
		$dolares_Proveedor += $dataProcesosPres["costo_proveedor"];
	}
	if($dataProcesosPres["divisa_proveedor"] == 3 ){
		$euros_Proveedor += $dataProcesosPres["costo_proveedor"];
	}
	
	
	
	
	
	$carga_horaria += $dataProcesosPres["carga_horaria"];
}

?>

<style>
    .numeros{
        font-size: 30px;
        font-weight: bold;
        color: #000000;
    }
    .titulos{
        font-size: 16px;
        color: #0364ba;
        font-weight: bold;
    }
</style>

<script src="https://cdn.plot.ly/plotly-2.12.1.min.js"></script>

<div class="container">

	<form action="" method="post">
	<div class="row">
		<div class="col-md-3" style="margin-bottom: 10px">
        	<label> Fecha de Evaluación Inicia *</label>
        	<input type="date"  class="form-control" name="fill_inicia" value="<?php echo $_POST["fill_inicia"]; ?>" required>
		</div>
		
		<div class="col-md-3" style="margin-bottom: 10px">
        	<label> Fecha de Evaluación Termina *</label>
        	<input type="date"  class="form-control" name="fill_termina" value="<?php echo $_POST["fill_termina"]; ?>" required>
		</div>
		
		<div class="col-md-3" style="margin-bottom: 10px">
        	<label>*</label>
        	<button type="submit" class="btn btn-primary btn-block">
        		Filtrar
        	</button>
		</div>
	</div>
	</form>
	
	<div class="row">

		<div class="col-md-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $queryProcesos->num_rows; ?></div>
					<div class="titulos">Cursos</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $query->num_rows; ?></div>
					<div class="titulos">Solicitudes</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $queryParticipantes->num_rows; ?></div>
					<div class="titulos">Participantes</div>
				</div>
			</div>
		</div>

		
		<div class="col-md-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $count_inv; ?></div>
					<div class="titulos">Invitados</div>
				</div>
			</div>
		</div>
		<div class="col-md-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $count_aprobados; ?></div>
					<div class="titulos">Aprobados</div>
				</div>
			</div>
		</div>
		
		
		<div class="col-md-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $queryCertificados->num_rows; ?></div>
					<div class="titulos">Certificados</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $queryProveedores->num_rows; ?></div>
					<div class="titulos">Proveedores</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $queryMarcas->num_rows; ?></div>
					<div class="titulos">Marcas</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $carga_horaria; ?> Horas</div>
					<div class="titulos">Carga Horaria</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6" >
			<div class="card" align="center" style="margin-bottom: 15px; ">
				<div class="card-body">
					<div class="numeros"><?php echo $carga_horaria*$count_aprobados; ?> Horas</div>
					<div class="titulos">Cantidad de Horas estudiantes</div>
				</div>
			</div>
		</div>
		
		
		
		<style>
			.numeros_small{
				font-size: 20px;
				font-weight: bold;
			}
		</style>

		
		
		<div class="col-md-12" align="center" style="margin-top: 20px" >
			<div class="card">
				<div class="card-body">
					<h2>Presupuestos</h2>
					<table class="table table-bordered">
						<tr>
							<th>Moneda</th>
							<th>Valor AT</th>
							<th>Valor Proveedor</th>
						</tr>
						<tr>
							<td>Euros</td>
							<td><?php echo $euros_AT; ?></td>
							<td><?php echo $euros_Proveedor; ?></td>
						</tr>
						<tr>
							<td>Dolares</td>
							<td><?php echo $dolares_AT; ?></td>
							<td><?php echo $dolares_Proveedor; ?></td>
						</tr>
						<tr>
							<td>Pesos</td>
							<td><?php echo $pesos_AT; ?></td>
							<td><?php echo $pesos_Proveedor; ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div class="col-md-6" align="center" style="margin-top: 20px" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="titulos">Presupuesto AT</div>
					
					<div id='chart_AT'></div>
					<script>
					var dataAT = [{
						values: [<?php echo $pesos_AT; ?>, <?php echo $dolares_AT; ?>, <?php echo $euros_AT; ?> ], 
						labels: [<?php echo $pesos_AT; ?>, <?php echo $dolares_AT; ?>, <?php echo $euros_AT; ?> ],
						colors: ["#00bcd4", "#673ab7", "#cddc39" ], 
						domain: {column: 0},
						hoverinfo: 'label+percent+name',
						hole: .4,
						type: 'pie', 
						automargin: true,
					}];
					var layoutAT = {
					  margin: {"t": 0, "b": 0, "l": 0, "r": 0},
					  showlegend: true,
					   height: 200
					};
					var configAT = {responsive: true}

					$( document ).ready(function() {
						Plotly.newPlot('chart_AT', dataAT, layoutAT, configAT ); 
					});  
					</script>
				</div>
			</div>
		</div>
		
		
		<div class="col-md-6" align="center" style="margin-top: 20px" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="titulos">Presupuesto Proveedor</div>
					
					<div id='chart_Proveedor'></div>
					<script>
					var dataPro = [{
						values: [<?php echo $pesos_Proveedor; ?>, <?php echo $dolares_Proveedor; ?>, <?php echo $euros_Proveedor; ?> ], 
						labels: [<?php echo $pesos_Proveedor; ?>, <?php echo $dolares_Proveedor; ?>, <?php echo $euros_Proveedor; ?> ],
						colors: ["#00bcd4", "#673ab7", "#cddc39" ], 
						domain: {column: 0},
						hoverinfo: 'label+percent+name',
						hole: .4,
						type: 'pie', 
						automargin: true,
					}];
					var layoutPro = {
					  margin: {"t": 0, "b": 0, "l": 0, "r": 0},
					  showlegend: true,
					   height: 200
					};
					var configPro = {responsive: true}

					$( document ).ready(function() {
						Plotly.newPlot('chart_Proveedor', dataPro, layoutPro, configPro ); 
					});  
					</script>

				</div>
			</div>
		</div>
		
		
	</div>


	
	
</div>
<script>  
$(document).ready(function(){
	$("#buscador").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tabla_lista tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});	
});
</script>
