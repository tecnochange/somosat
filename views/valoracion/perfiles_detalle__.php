<?php
	$hoy = date("Y-m-d H:i:s");
    $id = $_GET["id"];

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["actualizar"] != ""){
        
        $peril = '';
        foreach($_POST["niveles"] as $perfiles){
            if($peril == ""){
                $peril = $perfiles;
            }
            else{
                 $peril .= ",".$perfiles;
            }
        }
		
        mysqli_query($connect_valentina,"UPDATE Cargos SET perfil = '".$peril."' WHERE id = '".$id."'  ");

		$respuesta = '
			<div class="alert alert-success" role="alert" style="margin-top:8px">
			  Información actualizada.
			</div>
		';
	}
    
	
	//CARGAMOS LOS NIVELES
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$dtEmpleado['id_empresa']."' ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//CARGAMOS LOS NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$dtEmpleado['id_empresa']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}

    $queryC = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$id."' ");
	$dataC = mysqli_fetch_array($queryC);
    $perfiles = explode("," , $dataC["perfil"] );

?>

<?php include("views/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>

<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo $url; ?>?pg=valoracion/perfiles">Perfiles Competencias</a></li>
    <li class="breadcrumb-item active" aria-current="page">Competencias</li>
  </ol>
</nav>

<h1><?php echo $dataC["nombre"]; ?></h1>

<form action="" method="post">
    <input type="hidden" name="actualizar"  value="true">
    
    
<table class="table table-bordered table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
        <th scope="col">Tipo</th>
        <th scope="col">Competencia</th>
        <th scope="col">Nivel</th>
        <th scope="col">Año Lic.</th>
	</tr>
	</thead>
    
	<tbody>
	<?php
		$count = 1;
		$query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias 
        WHERE id_empresa = '".$dtEmpleado['id_empresa']."' ORDER BY id DESC ");
		while($data = mysqli_fetch_array($query)){
			
			$text_tipo = '';
			foreach ($arrayTipos as &$tipo) {
				if( $data["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
			}

            $lista_niveles = '';
			$queryNiveles = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles 
            WHERE id_competencia = '".$data["id"]."' ORDER BY id_nivel DESC ");
			while($dataNiveles = mysqli_fetch_array($queryNiveles)){
				
				$text_nivel = '';
				foreach ($arrayNiveles as &$nivel) {
					if( $dataNiveles["id_nivel"] == $nivel["0"] ){ $text_nivel = $nivel["1"]; }
				}
                
                $checkbox = '<input type="checkbox" class="checkbox comp_'.$data["id"].'" name="niveles[]" value="'.$dataNiveles["id"].'" onClick="SelectCheck(this, '.$data["id"].')" >';
                foreach($perfiles as $prf){
                    if($prf == $dataNiveles["id"]){
                        $checkbox = '<input type="checkbox" class="checkbox comp_'.$data["id"].'" name="niveles[]" value="'.$dataNiveles["id"].'" checked onClick="SelectCheck(this, '.$data["id"].')" >';
                    }
                }

                $lista_niveles .= $text_nivel." ".$checkbox;
               
			}
            
            if($data["anio"] == $_SESSION['anio'] ){
                echo '
                    <tr>
                        <td scope="row">'.$count.'</td>
                        <td>'.$text_tipo.'</td>
                        <td>'.$data["nombre"].'</td>
                        <td>'. $lista_niveles.'</td>
                        <td>'.$_SESSION['anio'].'</td>
                    </tr>
                ';
            }
            else{
                echo '
                    <tr style="visibility: collapse;" >
                        <td scope="row">'.$count.'</td>
                        <td>'.$text_tipo.'</td>
                        <td>'.$data["nombre"].'</td>
                        <td>'. $lista_niveles.'</td>
                        <td>'.$_SESSION['anio'].'</td>
                    </tr>
                ';
            }
            $count++;
		}
	?>
	</tbody>
</table>



<button type="submit" class="btn btn-success btn-block" style="margin-bottom: 30px" >
     Actualizar
</button>
</form>



<style>
    .checkbox{
        width: 22px; 
        height: 22px;
        margin-right: 20px;
    }
</style>


<script>
    function SelectCheck(elem, id){
        
        estado = $(elem).prop('checked') ;
        if(estado == true){
            //$(".comp_"+id).removeAttr('checked');
            //$(".comp_"+id).prop('disabled', !this.checked);
            //event.preventDefault();
            $(".comp_"+id).prop('checked',false);
            $(elem).prop('checked',true);
        }
        else{
            $(".comp_"+id).prop('checked',false);
        }
    }
</script>








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

