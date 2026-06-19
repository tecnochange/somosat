<script>  
$(document).ready(function(){
    $("#bt_val_programacion").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php
	$hoy = date("Y-m-d H:i:s");

    if( $_POST["anio"] != "" ){
        $_SESSION['anio'] = $_POST["anio"];
    }

	if($_POST["id_tipo"] != ""){
        
        foreach( $_POST["id_tipo"] as $tipo ){
            $auto = $_POST["auto_".$tipo];
            $jefe = $_POST["jefe_".$tipo];
            $par = $_POST["par_".$tipo];
            $subalterno = $_POST["subalterno_".$tipo];
            $cliente = $_POST["cliente_".$tipo];
            
            $queryValidate = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' AND id_tipo_competencia = '".$tipo."' ");
            if($queryValidate->num_rows > 0){
                
                $dataValidate = mysqli_fetch_array($queryValidate);
                
                mysqli_query($connect_valoracion,"UPDATE Ponderar_Evaluaciones SET  
                auto = '".$auto."', jefe = '".$jefe."', par = '".$par."', subalterno = '".$subalterno."', cliente = '".$cliente."' 
                WHERE id = '".$dataValidate["id"]."' ");
                
            }
            else{
                mysqli_query($connect_valoracion,"INSERT INTO Ponderar_Evaluaciones (id_empresa, anio, id_tipo_competencia, 
                auto, 	jefe, par, subalterno, 	cliente, created_at) 
                VALUES 
                ( '".$_SESSION['id_empresa']."', '".$_SESSION['anio']."', '".$tipo."', 
                '".$auto."',  '".$jefe."', '".$par."', '".$subalterno."', '".$cliente."', '".$hoy."' ) ");
            } 
        }
		
	}


    if($_POST["terminar_conf"] != ""){
		mysqli_query($connect_valoracion,"UPDATE Ponderar_Evaluaciones SET  estado = 3 
        WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' ");
        echo '<script> window.location = "'.$url.'?pg=valoracion/ponderar"; </script>';
    }
?>



<?php echo $respuesta; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Valoración de competencias</li>
    <li class="breadcrumb-item active" aria-current="page"><b>PONDERAR</b></li>
  </ol>
</nav>



<ul class="nav nav-tabs">  
  
  <li class="nav-item">
    <a class="nav-link " href="?pg=valoracion/programacion">Ciclo Evaluacion</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="?pg=valoracion/escala">Administrar escala</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="?pg=valoracion/evaluados">Competencias tipo evaluador</a>
  </li>

  <li class="nav-item">
    <a class="nav-link active" href="?pg=valoracion/ponderar">Ponderar evaluación</a>
  </li>

</ul>

<form action="" method="post">
<table class="table table-bordered table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
		<th scope="col">Tipo Evaluación</th>
        <th scope="col">Auto</th>
        <th scope="col">Jefe</th>
        <th scope="col">Par</th>
        <th scope="col">Colaborador</th>
        <th scope="col">Cliente</th>
	</tr>
	</thead>
    
	<tbody>
	<?php
        $ver_editar = true;
		$count = 1;
		$query = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Lista ");
		while($data = mysqli_fetch_array($query)){
			
            $queryValidate = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' AND id_tipo_competencia = '".$data["id"]."' ");
            $dataValidate = mysqli_fetch_array($queryValidate);
            
            $ckeck_auto = '';
            $ckeck_jefe = '';
            $ckeck_par = '';
            $ckeck_subalterno = '';
            $ckeck_cliente = '';

            if( $data["auto"] == "on" ){ 
                $ckeck_auto = '<input type="number" class="checkbox" name="auto_'.$data["id"].'" value="'.$dataValidate["auto"].'" > ' ;  
            }
            if( $data["jefe"] == "on" ){  
                $ckeck_jefe = '<input type="number" class="checkbox" name="jefe_'.$data["id"].'" value="'.$dataValidate["jefe"].'" > ' ; 
            }
            if( $data["par"] == "on" ){  
                $ckeck_par = '<input type="number" class="checkbox" name="par_'.$data["id"].'" value="'.$dataValidate["par"].'" > ' ; 
            }
            if( $data["subalterno"] == "on" ){  
                $ckeck_subalterno = '<input type="number" class="checkbox" name="subalterno_'.$data["id"].'" value="'.$dataValidate["subalterno"].'" > ' ; 
            }
            if( $data["cliente"] == "on" ){  
                $ckeck_cliente = '<input type="number" class="checkbox" name="cliente_'.$data["id"].'" value="'.$dataValidate["cliente"].'" > ' ; 
            }
            
            $alert = '';
            $cien = $dataValidate["auto"]+$dataValidate["jefe"]+$dataValidate["par"]+$dataValidate["subalterno"]+$dataValidate["cliente"];
            if( $cien != 100 ){
                $alert = '#ffb4b4';
            }
            
            
            if($dataValidate["estado"] == 3){
                $ver_editar = false;
            }
            
			echo '
			<tr>
				<th scope="row">'.$count.'</th>
				<td bgcolor="'.$alert.'">
                    '.$data["nombre"].' <input type="hidden" name="id_tipo[]"  value="'.$data["id"].'">
                </td>
                <td bgcolor="'.$alert.'">'.$ckeck_auto.'</td>
                <td bgcolor="'.$alert.'">'.$ckeck_jefe.'</td>
                <td bgcolor="'.$alert.'">'.$ckeck_par.'</td>
                <td bgcolor="'.$alert.'">'.$ckeck_subalterno.'</td>
                <td bgcolor="'.$alert.'">'.$ckeck_cliente.'</td>
			</tr>
			';
			$count++;
					
		}
	?>
	</tbody>
</table>

<?php if($ver_editar == true){ ?>
<button type="submit" class="btn btn-success btn-block">
    Guardar
</button>

    
</form>

<form action="" method="post">
    <input type="hidden" name="terminar_conf" value="true">
    <button type="submit" class="btn btn-danger btn-sm" style="margin-top: 15px">
        Terminar Programación
    </button>
</form>
<?php } else{ ?>

<script>
    $(".checkbox").attr("disabled", true);
</script>

<?php } ?>


<style>
    .checkbox{
        width: 100px;
        height: 22px;
    }
</style>





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

