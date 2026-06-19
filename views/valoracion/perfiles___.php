<?php
	$hoy = date("Y-m-d H:i:s");

	//CARGAMOS LOS NIVELES
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos 
    WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."'  ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//CARGAMOS LOS NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles 
    WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}
?>

<?php include("views/layouts/ficha_competencia.php"); ?>
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



<table class="table table-bordered table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
        <th scope="col" style="max-width: 180px">Cargo</th>
        <th scope="col">Tipo de compentecias</th>
        <th scope="col">Competencias</th>
        <th scope="col">Nivel</th>
        <th scope="col">Año Lic.</th>
		<th scope="col" style="width: 90px; text-align:center">
        </th>
	</tr>
	</thead>
    
	<tbody>
	<?php
		$count = 1;
		$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos 
        WHERE id_empresa = '".$dtEmpleado['id_empresa']."' ORDER BY nombre ASC ");
		while($data = mysqli_fetch_array($query)){
            
            $perfiles = explode("," , $data["perfil"] );
            
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
                
                /*
                if($nivel_list == ""){
                    $nivel_list .= $text_nivel."<br>";
                    
                    $tipo_list .= $text_tipo."<br>";
                }
                */
                
            }
            
            /*
            $queryComps = mysqli_query($connect_valoracion,"SELECT * FROM Competencias ORDER BY id DESC ");
            while($dataComps = mysqli_fetch_array($queryComps)){
            }
            */

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
                        <td>'.$_SESSION['anio'].'</td>
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

