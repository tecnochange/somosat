<script>  
$(document).ready(function(){
    $("#bt_val_perfiles").addClass("active_item");
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

	//CARGAMOS LOS NIVELES
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos 
    WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' AND id_ciclo = '".$_SESSION['ciclo']."'  ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//CARGAMOS LOS NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles 
    WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}
?>

<?php include("views/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>

<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Perfiles Competencias</h2></td>
            <td align="right" width="200" style="display: none">
            	<a href="<?php echo $url; ?>?pg=valoracion/replicas/perfiles_replicar">
                    <button type="button" class="btn btn-warning btn-sm">
                        Replicar Ciclo Anterior
                    </button>
                </a>
            </td>
        </tr>
    </table>
</div>

<table class="table table-bordered">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
        <th scope="col" style="max-width: 180px">Cargo</th>
        <th scope="col">Tipo de compentecias</th>
        <th scope="col">Competencias</th>
        <th scope="col">Nivel</th>
        <th scope="col">Año Lic.</th>
        <th scope="col">Ciclo</th>
		<th scope="col" style="width: 90px; text-align:center">
        </th>
	</tr>
	</thead>
    
	<tbody>
	<?php
		$count = 1;
		$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos 
         ORDER BY nombre ASC ");
		while($data = mysqli_fetch_array($query)){
            
           
            
            $queryPerfiles = mysqli_query($connect_valoracion,"SELECT * FROM Perfiles_Cargos 
            WHERE id_cargo = '".$data["id"]."' AND id_empresa = '".$_SESSION["id_empresa"]."' AND anio = '".$_SESSION["anio"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
            $dataPerfiles = mysqli_fetch_array($queryPerfiles);

            $perfiles = explode("," , $dataPerfiles["perfiles"] );
            
            $queryCl = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$dataPerfiles['id_ciclo']."' ");
            $dataCl = mysqli_fetch_array($queryCl);
            
            $tipo_list = '';
            $competencia_list = '';
            $nivel_list = '';
            foreach($perfiles as $prf){

                $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$prf."' ");
                $dataNivel = mysqli_fetch_array($queryNivel);

                $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias 
                WHERE id = '".$dataNivel["id_competencia"]."'  ");
                $dataComp = mysqli_fetch_array($queryComp);
                
                $competencia_list .= $dataComp["nombre"]."<br>";
                    
                $text_nivel = '';
				foreach ($arrayNiveles as &$nivel) {
					if( $dataNivel["id_nivel"] == $nivel["0"] ){ $text_nivel = $nivel["1"]; }
				}
                $nivel_list .= $text_nivel."<br>";

                $text_tipo = '';
                foreach ($arrayTipos as &$tipo) {
                    if( $dataComp["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
                }
                $tipo_list .= $text_tipo."<br>";
  
            }
            
          

            echo '
					<tr>
						<td scope="row">'.$count.'</td>
						<td style="max-width: 180px;">'.$data["nombre"].'</td>
						<td>
                            '.$tipo_list .'
                        </td>
						<td style="font-size: 13px;">
                            '.$competencia_list.'
                        </td>
						<td>
                           '.$nivel_list.'
                        </td>
                        <td>'.$dataPerfiles['anio'].'</td>
                        <td>'.$dataCl['nombre'].'</td>
                        <td>
                            <a href="'.$url.'?pg=valoracion/perfiles_detalle&id='.$data["id"].'">
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-cogs"></i>
                            </button>
                            </a>
                        </td>
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

