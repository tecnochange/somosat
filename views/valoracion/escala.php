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
	
	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre_n_1"] != ""){
		
		if($_POST["id_registro"] != ""){
			mysqli_query($connect_valoracion,"UPDATE Escalas SET 
            nombre_n_1 = '".$_POST["nombre_n_1"]."', descripcion_n_1 = '".$_POST["descripcion_n_1"]."', 
            nombre_n_2 = '".$_POST["nombre_n_2"]."', descripcion_n_2 = '".$_POST["descripcion_n_2"]."', 
            nombre_n_3 = '".$_POST["nombre_n_3"]."', descripcion_n_3 = '".$_POST["descripcion_n_3"]."', 
            nombre_n_4 = '".$_POST["nombre_n_4"]."', descripcion_n_4 = '".$_POST["descripcion_n_4"]."'  
            WHERE id = '".$_POST["id_registro"]."'  ");
		}
		else{
			mysqli_query($connect_valoracion,"INSERT INTO Escalas ( id_empresa, anio, 
            nombre_n_1, descripcion_n_1, 
            nombre_n_2, descripcion_n_2, 
            nombre_n_3, descripcion_n_3, 
            nombre_n_4, descripcion_n_4,
            created_at) 
			VALUES 
			( '".$_SESSION['id_empresa']."', '".$_SESSION["anio"]."', 
            '".$_POST["nombre_n_1"]."', '".$_POST["descripcion_n_1"]."', 
            '".$_POST["nombre_n_2"]."', '".$_POST["descripcion_n_2"]."', 
            '".$_POST["nombre_n_3"]."', '".$_POST["descripcion_n_3"]."', 
            '".$_POST["nombre_n_4"]."', '".$_POST["descripcion_n_4"]."', 
            '".$hoy."' ) ");
		}
        
        echo '
            <script> window.location = "'.$url.'/?pg=valoracion/escala&id='.$id.'"; </script>
        ';

	}
	
	
	$query = mysqli_query($connect_valoracion,"SELECT * FROM Escalas WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' ");
	$data = mysqli_fetch_array($query);
		
?>



<?php include("views/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>

<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Administrar Escala</li>
  </ol>
</nav>

<div align="left" style="padding: 10px 0px;">
	<table width="100%">
    	<tr>
        	<td><h5 style="margin-top: 8px;"><i class="fas fa-users"></i> Administrar Escala</h5></td>
            <td align="right">
            	
            </td>
        </tr>
    </table>

</div>


<ul class="nav nav-tabs">  
  
  <li class="nav-item">
    <a class="nav-link " href="?pg=valoracion/programacion">Ciclo Evaluacion</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link active" href="?pg=valoracion/escala">Administrar Escala</a>
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
        Administrar escala
    </div>
    
    <div class="card-body">
        
        <form action="" method="post">
            <input type="hidden" name="id_registro" value="<?php echo $data["id"];  ?>">
        <table width="100%">
        
            <tr>
                <td width="25%" bgcolor="#FF7173" align="center" style="font-size: 25px; padding: 20px; font-weight: bold">
                    1
                </td>
                <td width="25%" bgcolor=" #FFC03A" align="center" style="font-size: 25px; padding: 20px; font-weight: bold">
                    2
                </td>
                <td width="25%" bgcolor=" #2ADAFF" align="center" style="font-size: 25px; padding: 20px; font-weight: bold">
                    3
                </td>
                <td width="25%" bgcolor=" #B5FF87" align="center" style="font-size: 25px; padding: 20px; font-weight: bold">
                    4
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control titu" placeholder="Ingresar Nombre..." name="nombre_n_1" value="<?php echo $data["nombre_n_1"]; ?>" required>
                    <textarea class="form-control" placeholder="Ingresar descripción..." rows="7" name="descripcion_n_1" required><?php echo $data["descripcion_n_1"]; ?></textarea>
                </td>
                <td>
                    <input type="text" class="form-control titu"  placeholder="Ingresar Nombre..." name="nombre_n_2" value="<?php echo $data["nombre_n_2"]; ?>" required>
                    <textarea class="form-control" placeholder="Ingresar descripción" rows="7" name="descripcion_n_2" required><?php echo $data["descripcion_n_2"]; ?></textarea>
                </td>
                <td>
                    <input type="text" class="form-control titu"  placeholder="Ingresar Nombre..." name="nombre_n_3" value="<?php echo $data["nombre_n_3"]; ?>" required>
                    <textarea class="form-control" placeholder="Ingresar descripción" rows="7" name="descripcion_n_3" required><?php echo $data["descripcion_n_3"]; ?></textarea>
                </td>
                <td>
                    <input type="text" class="form-control titu"  placeholder="Ingresar Nombre..." name="nombre_n_4" value="<?php echo $data["nombre_n_4"]; ?>" required>
                    <textarea class="form-control" placeholder="Ingresar descripción" rows="7" name="descripcion_n_4" required><?php echo $data["descripcion_n_4"]; ?></textarea>
                </td>
            </tr>
        </table>

        <button type="submit" class="btn btn-success btn-block" style="margin-top: 20px" >
             Guardar
        </button>
        </form>
        
    </div>
    
</div>


<style>
    .titu{
        font-weight: bold;
        text-align: center;
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

