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
			mysqli_query($connect_valoracion,"INSERT INTO Ciclos ( 	id_empresa, anio, nombre, fecha_inicia, fecha_termina, created_at) 
			VALUES 
			( '".$_SESSION['id_empresa']."', '".$dtLic["anio"]."', '".$_POST["nombre"]."', '".$_POST["fecha_inicia"]."', '".$_POST["fecha_termina"]."', '".$hoy."' ) ");
			
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

    $queryUltimoCiclo = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id_empresa = '".$_SESSION['id_empresa']."' ORDER BY id DESC ");
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
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND fecha_termina = '".$data["fecha_termina"]."' ");
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
        	<td><h5 style="margin-top: 8px;">Programar Anterior</h5></td>
            <td align="right">
            </td>
        </tr>
    </table>

</div>





<table class="table table-bordered table-sm" style="margin-top: 20px">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width:50px">#</th>
        <th scope="col">Empresa</th>
        <th scope="col">Año</th>
        <th scope="col">Ciclo</th>
        <th scope="col">Empleado</th>
        <th scope="col">Evaluador</th>
        <th scope="col">Tipo</th>
        <th scope="col">Fecha</th>
	</tr>
	</thead>
    <tbody>
        <?php
        $count = 1;  
        $query = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_ciclo = '4'  ");
        while($data = mysqli_fetch_array($query)){
            
            $now = date("Y-m-d H:i:s");
            /*
            mysqli_query($connect_valoracion,"INSERT INTO Evaluadores (id_empresa, anio, id_ciclo, id_empleado, id_evaluador, tipo, created_at) 
            VALUES 
            ( '".$data["id_empresa"]."', '".$data["anio"]."', '7', '".$data["id_empleado"]."', '".$data["id_evaluador"]."', 
            '".$data["tipo"]."', '".$now."' )  ");
            */
            
            echo '
                   <tr>
                        <td scope="col" style="width:50px">'.$count.'</td>
                        <td scope="col">'.$data["id_empresa"].'</td>
                        <td scope="col">'.$data["anio"].'</td>
                        <td scope="col">'.$data["id_ciclo"].'</td>
                        <td scope="col">'.$data["id_empleado"].'</td>
                        <td scope="col">'.$data["id_evaluador"].'</td>
                        <td scope="col">'.$data["tipo"].'</td>
                        <td scope="col">'.$data["created_at"].'</td>
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
    $("#bt_val_programacion").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>


<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

