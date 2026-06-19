<script>  
$(document).ready(function(){
    $("#bt_val_competencias").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>

<?php
	$hoy = date("Y-m-d H:i:s");

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["id_informe_indicador"] != ""){

		mysqli_query($connect_valoracion,"UPDATE Competencias_Preguntas SET fortaleza = '".$_POST["fortaleza"]."', oportunidad = '".$_POST["oportunidad"]."' 
        WHERE id = '".$_POST["id_informe_indicador"]."'  ");

		$respuesta = '
			<div class="alert alert-success" role="alert" style="margin-top:8px">
			  Información Guardada.
			</div>
		';
	}

    //TIPOS
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' 
    AND id_ciclo = '".$_SESSION['ciclo']."'  ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' 
    AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}
?>

<?php include("views/valoracion/layouts/ficha_informe_competencia.php"); ?>
<?php echo $respuesta; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Valoración de competencias</li>
    <li class="breadcrumb-item active" aria-current="page"><b>COMPETENCIAS INFORMES</b></li>
  </ol>
</nav>

<div align="right">
    <a href="<?php echo $url; ?>?pg=valoracion/replicas/informes_replicar" style="display: none">
        <button type="button" class="btn btn-warning btn-sm">
            Replicar Ciclo Anterior
        </button>
    </a>
</div>

<ul class="nav nav-tabs">  
  
  <li class="nav-item">
    <a class="nav-link " href="?pg=valoracion/competencias_tipos">Tipos</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="?pg=valoracion/competencias_niveles">Niveles</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="?pg=valoracion/competencias">Competencias</a>
  </li>

  <li class="nav-item">
    <a class="nav-link active" href="?pg=valoracion/competencias_informes">Informes</a>
  </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/competencias_acciones">Acciones de desarrollo</a>
    </li>
  
  
</ul>

<table class="table table-bordered table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
		<th scope="col">Año Lic.</th>
        <th scope="col">Ciclo</th>
        <th scope="col">Tipo</th>
        <th scope="col">Competencia</th>
        <th scope="col">Nivel</th>
        <th scope="col">Indicador</th>
        <th scope="col">Fortaleza</th>
        <th scope="col">Oportunidad de Mejora</th>
		<th scope="col" style="width: 90px; text-align:center">
        </th>
	</tr>
	</thead>
    
	<tbody>
	<?php
		$count = 1;
		$query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE id_empresa = '".$dtEmpleado['id_empresa']."' 
        AND anio = '".$_SESSION['anio']."' AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY id ASC ");
		while($data = mysqli_fetch_array($query)){
            
            $queryCl = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$data['id_ciclo']."' ");
            $dataCl = mysqli_fetch_array($queryCl);
			
			$queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$data["id_competencia"]."' ");
			$dataComp = mysqli_fetch_array($queryComp);

			$text_tipo = '';
			foreach ($arrayTipos as &$tipo) {
				if( $dataComp["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
			}
			
			
			$queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$data["id_nivel_competencia"]."' ");
			$dataNivel = mysqli_fetch_array($queryNivel);
			
			
			$text_nivel = '';
			foreach ($arrayNiveles as &$tipo) {
				if( $dataNivel["id_nivel"] == $tipo["0"] ){ $text_nivel = $tipo["1"]; }
			}
			
			echo '
			<tr>
				<th scope="row">'.$count.'</th>
				<td>'.$_SESSION['anio'].'</td>
                <td>'.$dataCl["nombre"].'</td>
                <td>'.$text_tipo.'</td>
				<td>'.$dataComp["nombre"].'</td>
				<td>'.$text_nivel.'</td>
				<td>'.$data["indicador"].'</td>
				<td>'.$data["fortaleza"].'</td>
				<td>'.$data["oportunidad"].'</td>
				<td align="center">
					<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".modal_informe" onclick="Ficha_Informe('.$data["id"].')">
						<i class="fa fa-edit"></i>
					</button>
				</td>
			</tr>
			';
			
			$count++;
			
		}
	?>
	</tbody>
</table>






















<script>


var api = '<?php echo $url; ?>api/valoracion/';

function Ficha_Informe(id){
	$('#lista_niveles').html('');
	jQuery.ajax({
		url: api+"ficha_informe_indicador.php",
		type:'post',
		data: {id: id, url:"?pg=competencias"},
		}).done(function (resp){
			$("#cont_modal_competencia").html(resp);
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


<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

