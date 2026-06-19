<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<?php
	$hoy = date("Y-m-d H:i:s");

    if( $_POST["anio"] != "" ){
        $_SESSION['anio'] = $_POST["anio"];
    }
	
	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre"] != ""){
		if($_POST["id_competencia"] != ""){
			mysqli_query($connect_valoracion,"UPDATE Competencias SET nombre = '".$_POST["nombre"]."', id_tipo = '".$_POST["id_tipo"]."',  
			definicion = '".$_POST["definicion"]."' WHERE id = '".$_POST["id_competencia"]."'  ");
		}
		else{
			mysqli_query($connect_valoracion,"INSERT INTO Competencias (id_empresa, anio, nombre, definicion, id_tipo, created_at, update_at) 
			VALUES 
			( '".$_SESSION['id_empresa']."', '".$_SESSION['anio']."', '".$_POST["nombre"]."', '".$_POST["definicion"]."', '".$_POST["id_tipo"]."', '".$hoy."', '".$hoy."' ) ");
			$id_l = mysqli_insert_id($connect);
			
			
			$i = 0;
			foreach ($_POST["id_nivel"] as &$nivel) {
				mysqli_query($connect_valoracion,"INSERT INTO Competencias_Niveles (id_competencia, id_nivel, definicion, created_at, update_at) 
				VALUES 
				('".$id_l."', '".$nivel."', '".$_POST["definicion"][$i]."', '".$hoy."', '".$hoy."' ) ");
				//print_r($nivel." - ". $_POST["definicion"][$i]."<hr>");
				$i++;
			}
			
		}
		$respuesta = '
			<div class="alert alert-success" role="alert" style="margin-top:8px">
			  Información Guardada.
			</div>
		';
	}
	
	//TIPOS
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}
?>

<?php include("views/valoracion/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>


<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Consolidados Comportamientos <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right"> 
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<ul class="nav nav-tabs">  
    
    <li class="nav-item">
        <a class="nav-link  " href="?pg=valoracion/informes/individuales">Individuales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/areas">Area / Procesos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/informes/niveles">Niveles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/informes/organizacion">Organización</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/informes/numericos">Numéricos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/estadisticas">Estadísticas</a>
    </li>
    
</ul>

<div align="center" style="margin: 30px">
    <a href="?pg=valoracion/informes/numericos">
    <button type="button" id="sidebarCollapse" class="btn btn-warning" >
        <i class="fas fa-bell"></i> Consolidados
    </button>
    </a>
    
    <a href="?pg=valoracion/informes/numericos_competencias"> 
        <button type="button" id="sidebarCollapse" class="btn btn-primary" >
                    <i class="fas fa-bell"></i> Competencias
        </button>
    </a>
    
    <a href="?pg=valoracion/informes/comportamientos">
        <button type="button" id="sidebarCollapse" class="btn btn-success" >
            <i class="fas fa-bell"></i> Comportamiento
        </button>
    </a>

</div>


<table class="table table-bordered table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
        <th scope="col">Tipo</th>
        <th scope="col">Nivel</th>
        <th scope="col">Indicador</th>
        <th scope="col">Comportamiento / Pregunta</th>
		<th scope="col">Promedio</th>
	</tr>
	</thead>
    
	<tbody>
	<?php
		$count = 1;
		$query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
		
		while($data = mysqli_fetch_array($query)){
			
			$text_tipo = '';
			foreach ($arrayTipos as &$tipo) {
				if( $data["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
			}
			
			echo '
			<tr>
				<th scope="row">'.$count.'</th>
				<td><b>'.$text_tipo.'</b></td>
				<td colspan="3"><b>'.$data["nombre"].'</b><br>'.$data["definicion"].'</td>
				<td align="center">
					
				</td>
			</tr>
			';
			$count++;
			$queryNiveles = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id_competencia = '".$data["id"]."' ORDER BY id DESC ");
			while($dataNiveles = mysqli_fetch_array($queryNiveles)){
				
				$text_nivel = '';
				foreach ($arrayNiveles as &$nivel) {
					if( $dataNiveles["id_nivel"] == $nivel["0"] ){ $text_nivel = $nivel["1"]; }
				}
				
				$queryPreguntas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE id_nivel_competencia = '".$dataNiveles["id"]."' ORDER BY id DESC ");
				while($dataPreguntas = mysqli_fetch_array($queryPreguntas)){
                    
                    
                    $queryPromedio = mysqli_query($connect_valoracion,"SELECT SUM(calificacion), COUNT(id) FROM Competencias_Respuestas_Comportamientos 
                    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' 
                    AND id_comportamientos = '".$dataPreguntas["id"]."' ");
                    $dataPromedio = mysqli_fetch_array($queryPromedio);
					
					echo '
					<tr>
						<td scope="row"></td>
						<td></td>
						<td><b>'.$text_nivel.'</b></td>
						<td>'.$dataPreguntas["indicador"].'</td>
						<td>'.$dataPreguntas["pregunta"].'</td>
                        <td>'.round(( $dataPromedio["SUM(calificacion)"]/$dataPromedio["COUNT(id)"]),2).'</td>
					</tr>
					';
					
				}
			}
		}
	?>
	</tbody>
</table>




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
    
var Cont_Modal = "";
$( document ).ready(function() {
    Cont_Modal = $("#cont_modal").html();
});


var api = '<?php echo $url; ?>api/valoracion/';

function Ficha_Competencia(id){
	$('#lista_niveles').html('');
	jQuery.ajax({
		url: api+"ficha_competencia.php",
		type:'post',
		data: {id: id },
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

<script>
    $("#bt_val_competencias").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

