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

    //TIPOS
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' 
    AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY id DESC ");
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

<div align="right" style="display: none">
    <a href="<?php echo $url; ?>?pg=valoracion/replicas/acciones_replicar">
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
    <a class="nav-link " href="?pg=valoracion/competencias_informes">Informes</a>
  </li>
    
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/competencias_acciones">Acciones de desarrollo</a>
    </li>
  
  
</ul>

<table class="table table-bordered table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
		<th scope="col">Tipo</th>
        <th scope="col">Nivel</th>
        <th scope="col">Competencia</th>
        <th scope="col">Accion desarrollo</th>
        <th scope="col">Año Licencia</th>
        <th scope="col">Ciclo</th>
		<th scope="col" style="width: 90px; text-align:center">
            <a href="<?php $url; ?>?pg=valoracion/competencias_acciones_detalle">
            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" title="Crear nueva acción">
            	<i class="fa fa-plus"></i>
            </button>
            </a>
        </th>
	</tr>
	</thead>
    
	<tbody>
	<?php
		$count = 1;
		$query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Acciones WHERE id_empresa = '".$dtEmpleado['id_empresa']."' 
        AND anio = '".$_SESSION['anio']."' AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY id ASC ");
		while($data = mysqli_fetch_array($query)){
            
            $queryCl = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$data['id_ciclo']."' ");
            $dataCl = mysqli_fetch_array($queryCl);
			
			$queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$data["id_competencia"]."' ");
			$dataComp = mysqli_fetch_array($queryComp);

			$text_tipo = '';
			foreach ($arrayTipos as &$tipo) {
				if( $data["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
			}
			
			$text_nivel = '';
			foreach ($arrayNiveles as &$tipo) {
				if( $data["id_nivel"] == $tipo["0"] ){ $text_nivel = $tipo["1"]; }
			}
			
			echo '
			<tr>
				<th scope="row">'.$count.'</th>
				<td>'.$text_tipo.'</td>
				<td>'.$text_nivel.'</td>
                <td>'.$dataComp["nombre"].'</td>
				<td>'.$data["accion"].'</td>
                <td>'.$data["anio"].'</td>
                <td>'.$dataCl["nombre"].'</td>
				<td align="center">
                    <a href="'.$url.'?pg=valoracion/competencias_acciones_detalle&id='.$data["id"].'">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" title="Editar acción">
                        <i class="fa fa-eye"></i>
                    </button>
                    </a>
                    
                    <button type="button" class="btn btn-danger btn-sm" title="Editar acción" onclick="EliminarRegistro('.$data["id"].')">
                        <i class="fa fa-times"></i>
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
var activar = false;
function EliminarRegistro(id){
    
    if(activar == false){
		$("#modal_body").html('Estas a punto de eliminar este registro, esta acción es irreversible ¿Estás seguro?<br><br>');
		$("#modal_body").append('<button type="button" class="btn btn-success" style="margin-right: 10px;" onclick="activar = true; EliminarRegistro('+id+')">Eliminar</button>');
        $("#modal_general").modal("show");
	}
	else{
    
    
	jQuery.ajax({
		url: api+"eliminar_accion.php",
		type:'post',
		data: {id: id, url:"?pg=valoracion/competencias_acciones"},
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

