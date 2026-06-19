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


<div align="center" style="margin: 10px">
    <a href="?pg=valoracion/informes/comportamientos">
        <button type="button" id="sidebarCollapse" class="btn btn-warning" >
            Consolidado
        </button>
    </a>
    
    <a href="?pg=valoracion/informes/comportamientos_individual"> 
        <button type="button" id="sidebarCollapse" class="btn btn-primary" >
            Individual
        </button>
    </a>

</div>



<?php
    $limite = 100;
    $pag_activa = $_GET["p"];
    if($_GET["p"] == ""){ $pag_activa = 1; }
    $posicion = ($pag_activa-1)*100;

    $filtro = " LIMIT ".$limite." OFFSET ".$posicion." ";

    $queryCount = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
    WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC "); 
    $cant_pagina = ceil($queryCount->num_rows/$limite);

    $anterior = $pag_activa-1;
    $siguiente = $pag_activa+1;

    if($anterior < 1){
        $anterior = 1;
    }
    if($siguiente > $cant_pagina){
        $siguiente = $cant_pagina;
    }

?>

<nav aria-label="Page navigation example" style="margin-top: 15px;">
    <ul class="pagination justify-content-center" >
        <li class="page-item">
          <a class="page-link" href="<?php echo $url.'/?pg=valoracion/informes/numericos&p='.$anterior; ?>">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        
        <?php 
        for ($i = 1; $i <= $cant_pagina; $i++) {
            if($pag_activa == $i){
                echo '
                    <li class="page-item active">
                        <a class="page-link" href="'.$url.'/?pg=valoracion/informes/numericos&p='.$i.'">'.$i.'</a>
                    </li>
                ';
            }
            else{
                echo '
                    <li class="page-item">
                        <a class="page-link" href="'.$url.'/?pg=valoracion/informes/numericos&p='.$i.'">'.$i.'</a>
                    </li>
                ';
            }
        }
        ?>

        <li class="page-item">
          <a class="page-link" href="<?php echo $url.'/?pg=valoracion/informes/numericos&p='.$siguiente; ?>" >
            <span aria-hidden="true">&raquo;</span>
          </a>
    </li>

  </ul>
</nav>




<?php if($_SESSION['anio'] != ""){ ?>
<table class="table table-bordered table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
        <th scope="col">Colaborador</th>
        <th scope="col">Cargo</th>
        <th scope="col">Área</th>
        <th scope="col">Competencia</th>
        <th scope="col">Indicador</th>
		<th scope="col" style="width: 90px; text-align:center">
        	Promedio
        </th>
	</tr>
	</thead>
    
	<tbody>
	<?php
        include("views/valoracion/informes/metodo_ponderacion.php");	
        
        $count = $posicion+1;
        $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
        WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ".$filtro." ");  
        while($data = mysqli_fetch_array($query)){ 
            //DATOS DEL CARGO
            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
            $dataCargo = mysqli_fetch_array($queryCargo);
            
            //DATOS DEL AREA
            $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
            $dataArea = mysqli_fetch_array($queryArea);
            
            $lista_competencias = '';
            $lista_tipos = '';
            $tabla_competencias = '';
            
            $queryCompetencias = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos 
            WHERE id_evaluado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' GROUP BY id_competencia ");
            while($dataCompetencias = mysqli_fetch_array($queryCompetencias)){
                
                $lista_comportamientos = '';
                $lista_promedio = '';
                
                $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataCompetencias["id_competencia"]."' ");
                $dataComp = mysqli_fetch_array($queryComp);

                $count_comp = 1;
                $queryRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos 
                WHERE id_evaluado = '".$data["id"]."' AND id_competencia = '".$dataComp["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' GROUP BY id_comportamientos ");
                while($dataRespuestas = mysqli_fetch_array($queryRespuestas)){
                    
                    $queryComport = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE 
                    id = '".$dataRespuestas["id_comportamientos"]."' ");
                    $dataComport = mysqli_fetch_array($queryComport);
                    
                    $ponderacion_comportamiento = PonderacionNumericaEmpleadoCompetenciaComportamientos( $connect_valoracion, $connect_valentina, $data["id"], $dataComp["id"], $dataRespuestas["id_comportamientos"] );
                    $promedio_comportamiento = $ponderacion_comportamiento["datos"]["total"];
                    
                    
                    $lista_comportamientos .= $dataComport["indicador"].'<br>';
                    $lista_promedio .= $promedio_comportamiento.'<br>';
                }

                $tabla_competencias .= '
                    <tr>
                        <td colspan="4"></td>
                        <td>'.$dataComp["nombre"].'</td>
                        <td>'.$lista_comportamientos.'</td>
                        <td>'.$lista_promedio.'</td>
                    </tr>
                
                ';
                
                
            }
            
            
            echo '
			<tr>
				<th scope="row">'.$count.'</th>
                <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                <td>'.$dataCargo["nombre"].'</td>
                <td>'.$dataArea["nombre"].'</td>
                <td colspan="3"></td>
                
			</tr>
			';
            echo $tabla_competencias;
            $count++;
            
            
  
        }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
            
    
    
    
    
    
    /*
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
				<td colspan="3"><b>'.$data["nombre"].'</b></td>
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
				
                //pregunta es igual a COMPORTAMIENTOS
				$queryPreguntas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE id_nivel_competencia = '".$dataNiveles["id"]."' ORDER BY id DESC ");
				while($dataPreguntas = mysqli_fetch_array($queryPreguntas)){
                    
                    $total_cal = 0;
                    $cant_resp = 0;
                    $queryCal = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos WHERE id_comportamientos = '".$dataPreguntas["id"]."' ");
                    while($dataCalif = mysqli_fetch_array($queryCal)){
                        $total_cal += $dataCalif["calificacion"];
                        $cant_resp++;
                    }
                    
                    $promedio = $total_cal/$cant_resp;
					
					echo '
					<tr>
						<td scope="row"></td>
						<td></td>
						<td><b>'.$text_nivel.'</b></td>
						<td>'.$dataPreguntas["indicador"].'</td>
						<td>'.$dataPreguntas["pregunta"].'</td>
                        <td>'.round($promedio, 2).'</td>
					</tr>
					';
					
				}
			}
		}
        */
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

