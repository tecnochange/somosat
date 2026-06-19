<?php
	$hoy = date("Y-m-d H:i:s");

	
?>

<?php echo $respuesta; ?>

<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Perfiles Competencias</li>
  </ol>
</nav>

<div align="left" style="padding: 10px 0px;">
	<table width="100%">
    	<tr>
        	<td><h5 style="margin-top: 8px;">Perfiles Competencias</h5></td>
            <td align="right">
            	
            </td>
        </tr>
    </table>
    
    
    
</div>



<table class="table table-bordered">
	<thead class="thead-dark">
	
	</thead>
    
	<tbody>
	<?php
		$count = 1;
		$query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias ORDER BY id ASC ");
		while($data = mysqli_fetch_array($query)){
            
            $queryDato = mysqli_query($connect_valentina,"SELECT * FROM Ciclos WHERE anio = '".$data["anio"]."' AND id_empresa = '".$data["id_empresa"]."' ");
		    $dataDato = mysqli_fetch_array($queryDato);
            
            //mysqli_query($connect_valoracion,"UPDATE Competencias_Evaluaciones_New SET id_cargo = '".$dataEval["id_cargo"]."' WHERE id = '".$data["id"]."'");
            
           
           /*
            $objeto_respuestas_tmp = array();
            $queryResp = mysqli_query($connect_valoracion,"SELECT id, observaciones FROM Competencias_Respuestas WHERE id_evaluacion = '".$data["id"]."'  ");
            while($dataResp = mysqli_fetch_array($queryResp)){
                
                $objeto = array();
                $id_nivel_competencia = 0;
                $queryRespComp = mysqli_query($connect_valoracion,"SELECT id_nivel_competencia, id_comportamientos, calificacion  FROM Competencias_Respuestas_Comportamientos 
                WHERE id_respuesta = '".$dataResp["id"]."' ");
                while($dataRespComp = mysqli_fetch_array($queryRespComp)){

                    $id_nivel_competencia = $dataRespComp["id_nivel_competencia"];
                    $respuesta = array(
                        "pregunta" => $dataRespComp["id_comportamientos"],
                        "respuesta" => $dataRespComp["calificacion"] 
                    );
                    array_push($objeto, $respuesta );
                }
                

                $obj_competencia = array(
                    "competencia" => $id_nivel_competencia,
                    "respuestas" => $objeto, 
                    "observaciones" => $dataResp["observaciones"]
                );
                
                array_push($objeto_respuestas_tmp, $obj_competencia);
            }
     
          */
            
           
            
         
            //print_r($objeto_respuestas_tmp);
            //mysqli_query($connect_valoracion,"UPDATE Competencias_Evaluaciones_New SET obj_evaluacion = '".json_encode($objeto_respuestas_tmp)."' WHERE id = '".$data["id"]."'");
            
            
            
            
            

            /*
            mysqli_query($connect_valoracion,"INSERT INTO Competencias_Evaluaciones_New
            (id, id_empresa, anio, id_ciclo, id_evaluado, id_evaluador, tipo_evaluacion, observaciones, promedio, obj_evaluacion, estado, created_at, update_at)
            VALUES 
            ( '".$data["id"]."', '".$data["id_empresa"]."', '".$data["anio"]."',  '".$data["id_ciclo"]."', '".$data["id_evaluado"]."', '".$data["id_evaluador"]."', 
            '".$data["tipo"]."', '".$data["observaciones"]."', '".$data["promedio"]."', '', '".$data["estado"]."', '".$hoy."', '".$hoy."' ) ");
            */

            echo '
					<tr>
						<td>'.$count.'</td>
						<td>'.$data["id_empresa"].'</td>
                        <td>'.$data["nombre"].'</td>
						<td>'.$dataDato["nombre"].'</td>
                        <td>'.$queryDato->num_rows.'</td>
						
					</tr>
            ';
            $count++;
	
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
    $("#bt_val_perfiles").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

