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
	if($_POST["nombre"] != ""){
		
		if($_POST["id_tipo"] != ""){
			mysqli_query($connect_valoracion,"UPDATE Tipos SET nombre = '".$_POST["nombre"]."' WHERE id = '".$_POST["id_tipo"]."'  ");
		}
		else{
			mysqli_query($connect_valoracion,"INSERT INTO Tipos (id_empresa, anio, id_ciclo, nombre, created_at, update_at) 
			VALUES 
			( '".$dtEmpleado['id_empresa']."', '".$_SESSION['anio']."', '".$_SESSION['ciclo']."', '".$_POST["nombre"]."', '".$hoy."', '".$hoy."' ) ");
		}
		
		$respuesta = '
			<div class="alert alert-success" role="alert" style="margin-top:8px">
			  Información Guardada.
			</div>
		';
	}

?>

<?php include("views/valoracion/layouts/ficha_tipo.php"); ?>
<?php echo $respuesta; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Valoración de competencias</li>
    <li class="breadcrumb-item active" aria-current="page"><b>TIPOS COMPETENCIAS</b></li>
  </ol>
</nav>

<div align="right" style="display: none">
    <a href="<?php echo $url; ?>?pg=valoracion/replicas/tipo_replicar">
        <button type="button" class="btn btn-warning btn-sm">
            Replicar Ciclo Anterior
        </button>
    </a>
</div>

<ul class="nav nav-tabs">  
  <li class="nav-item">
    <a class="nav-link active" href="?pg=valoracion/competencias_tipos">Tipos</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link " href="?pg=valoracion/competencias_niveles">Niveles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="?pg=valoracion/competencias">Competencias</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="?pg=valoracion/competencias_informes">Informes</a>
  </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/competencias_acciones">Acciones de desarrollo</a>
    </li>
  
  
</ul>


<?php if($_SESSION['anio'] != ""){ ?>
<table class="table table-bordered">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
		<th scope="col">Tipo</th>
        <th scope="col">Año Licencia</th>
        <th scope="col">Ciclo</th>
		<th scope="col" style="width: 45px;">
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target=".modal_tipo" onclick="Seter_Ficha()" title="Crear">
            	<i class="fa fa-plus"></i>
            </button>
        </th>
	</tr>
	</thead>
    
	<tbody>
	<?php
		$count = 1;
		$query = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' 
        AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY nombre DESC ");
		while($data = mysqli_fetch_array($query)){
			
            $queryCl = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$data['id_ciclo']."' ");
            $dataCl = mysqli_fetch_array($queryCl);
			
			echo '
			<tr>
				<th scope="row">'.$count.'</th>
				<td>'.$data["nombre"].'</td>
                <td>'.$data["anio"].'</td>
                <td>'.$dataCl["nombre"].'</td>
				<td align="center">
					<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".modal_tipo" onclick="Ficha_Tipo('.$data["id"].')">
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
<?php } ?>





















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

var Cont_Modal = $("#cont_modal").html();
var api = '<?php echo $url; ?>api/valoracion/';

function Ficha_Tipo(id){
	jQuery.ajax({
		url: api+"ficha_tipo.php",
		type:'post',
		data: {id: id, url:"?pg=competencias_tipo"},
		}).done(function (resp){
			$("#cont_modal").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}

function Seter_Ficha(){
	$("#cont_modal").html( Cont_Modal );
}  
</script>



<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

