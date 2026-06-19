<script>  
$(document).ready(function(){
    $("#bt_val_programacion").addClass("active_item");
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
    $id = $_GET["id"];
    $ahora = date("Y-m-d");
	
	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre"] != ""){
		
		if($_POST["id_registro"] != ""){
			mysqli_query($connect_valoracion,"UPDATE Ciclos SET nombre = '".$_POST["nombre"]."', fecha_inicia = '".$_POST["fecha_inicia"]."',  
			fecha_termina = '".$_POST["fecha_termina"]."' WHERE id = '".$_POST["id_registro"]."'  ");
		}
		else{
			mysqli_query($connect_valoracion,"INSERT INTO Ciclos ( id_empresa, anio, nombre, fecha_inicia, fecha_termina, created_at) 
			VALUES 
			( '".$_SESSION['id_empresa']."', '".$_SESSION["anio"]."', '".$_POST["nombre"]."', '".$_POST["fecha_inicia"]."', '".$_POST["fecha_termina"]."', '".$hoy."' ) ");
		}
        
        echo '
        <script>
            window.location = "?pg=valoracion/programacion";
        </script>
        ';
		
		$respuesta = '
			<div class="alert alert-success" role="alert" style="margin-top:8px">
			  Información Guardada.
			</div>
		';
	}


    //PARA VALIDAR EL ULTIMO CICLO
    $mostar = true;

    $queryUltimoCiclo = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION["anio"]."' ORDER BY id DESC ");
	$dataUltimoCiclo = mysqli_fetch_array($queryUltimoCiclo);

    if($dataUltimoCiclo["fecha_termina"] > $ahora ){
        $mostar = false;
    }

    $query = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);

    if($id != ""){
        $mostar = true;
    }



    $queryVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION["anio"]."' AND fecha_termina = '".$data["fecha_termina"]."' ");
	//$data = mysqli_fetch_array($query);

?>



<?php include("views/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>

<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Competencias</li>
  </ol>
</nav>

<div align="left" style="padding: 10px 0px;">
	<table width="100%">
    	<tr>
        	<td><h5 style="margin-top: 8px;">Programar Valoración</h5></td>
            <td align="right">
            </td>
        </tr>
    </table>

</div>


<ul class="nav nav-tabs">  
  
  <li class="nav-item">
    <a class="nav-link active" href="?pg=valoracion/programacion">Ciclo Evaluacion</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="?pg=valoracion/escala">Administrar escala</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link " href="?pg=valoracion/evaluados">Competencias tipo evaluador</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="?pg=valoracion/ponderar">Ponderar evaluación</a>
  </li>

</ul>

<div class="card">
    
    <div class="card-header">
        Crear Ciclos
    </div>
    
    <div class="card-body">
        <?php

        if($mostar == true){
        ?>
        <form action="" method="post">
        <div class="row">
            
            <input type="hidden" value="<?php echo $id; ?>" name="id_registro">
            
               <div class="col-md-4">
                Nombre del Ciclo<br>
                <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>">
            </div>
            
            <div class="col-md-4">
                Fecha Inicio<br>
                <input type="date" class="form-control" name="fecha_inicia" value="<?php echo $data["fecha_inicia"]; ?>">
            </div>
            
            <div class="col-md-4">
                Fecha Fin<br>
                <input type="date" class="form-control" name="fecha_termina" value="<?php echo $data["fecha_termina"]; ?>">
            </div>
            
            
            
            <div class="col-md-12" style="margin-top: 20px">
                <button type="submit" class="btn btn-success" >
                         Guardar
                </button>
            </div>
        
        </div>
        </form>
        <?php } ?>

    </div>
    
</div>


<table class="table table-bordered table-sm" style="margin-top: 20px">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
        <th scope="col">Año</th>
        <th scope="col">Nombre</th>
        <th scope="col">Fecha Inicio</th>
        <th scope="col">Fecha Fin</th>
		<th scope="col" style="width: 90px; text-align:center">
        </th>
	</tr>
	</thead>
    <tbody>
        <?php
        $count = 1;  
        $query = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos 
        WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."'  ");
        while($data = mysqli_fetch_array($query)){
                   echo '
                   <tr>
                        <td scope="col" style="width:50px">'.$count.'</td>
                        <td scope="col">'.$data["anio"].'</td>
                        <td scope="col">'.$data["nombre"].'</td>
                        <td scope="col">'.$data["fecha_inicia"].'</td>
                        <td scope="col">'.$data["fecha_termina"].'</td>
                        <td scope="col" style="width: 90px; text-align:center">
                            <a href="'.$url.'?pg=valoracion/programacion&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                        </th>
                    </tr>
                   ';
        }
        $count++;
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

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

