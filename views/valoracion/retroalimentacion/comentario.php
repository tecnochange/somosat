<?php
	$hoy = date("Y-m-d H:i:s");
    $id = $_GET["id"];
    $e = $_GET["e"];

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["activar_form"] != ""){
		
		
			
        mysqli_query($connect_valoracion,"INSERT INTO Retroalimentacion_Comentarios ( 	
            id_retroalimentacion, id_empleado, 
            comentario, 
            created_at) 
			VALUES 
			( '".$id."', 
            '".$e."', 
            '".$_POST["comentario"]."', 
            '".$hoy."' ) ");

        echo '<script> window.location = "?pg=valoracion/retro_individual"; </script>';
			
		

	}



	//EVALUADO
    $queryEvaluado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$e."'");
    $dataEva = mysqli_fetch_array($queryEvaluado);
    
    //CARGO
    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEva["id_cargo"]."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);

    //EVALUADO
    $query = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion WHERE id = '".$id."'");
    $data = mysqli_fetch_array($query);

?>


<?php include("views/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>

<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
      <li class="breadcrumb-item"><a href="?pg=valoracion/retro_individual">Retroalimentación Individual</a></li>
      <li class="breadcrumb-item active" aria-current="page">Comentario</li>
  </ol>
</nav>

<div align="left" style="padding: 10px 0px;">
	<table width="100%">
    	<tr>
        	<td></td>
            <td align="right">
            </td>
        </tr>
    </table>

</div>

<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                Colaborador: <b><?php echo $dataEva["nombre"]." ".$dataEva["apellidos"]; ?></b> <br>
                Fecha: <b><?php echo $data["created_at"]; ?></b> <br>
                Cargo: <b><?php echo $dataCargo["nombre"]; ?></b> <br>
            </div>
        </div>
        
    </div>
</div>

<div class="card" style="margin-bottom: 15px">
	
    <div class="card-body">
        
        <form action="" method="post">
        <div class="row">
            
            <input type="hidden" value="<?php echo $id; ?>" name="id_registro">
            <input type="hidden" name="activar_form" value="true">
            
            <div class="col-md-12">
                <h5 style="margin-top: 8px;">
                    Comentarios
                </h5>
            </div>

           
            <div class="col-md-12">
                Ingresar comentario<br>
                <textarea class="form-control" name="comentario" ></textarea>
            </div>

            <div class="col-md-12" style="margin-top: 20px">
                <button type="submit" class="btn btn-success" >
                    Guardar Comentario
                </button>
            </div>
        
        </div>
        </form>
 
        
    </div>
    
</div>

<div class="card">
	<div class="card-body">
		<h4>Comentarios</h4>
		<?php
			$queryComen = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion_Comentarios  WHERE id_retroalimentacion = '".$id."' "); 
			while($dataComent = mysqli_fetch_array($queryComen)){
				echo '
								<div class="comentario">
									'.$dataComent["comentario"].'
								</div>
							';
			}
		?>

	</div>
</div>

<style>
    .comentario{
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #e9ecef;
        border-radius: 5px;
        margin-bottom: 11px;
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

</script>

<script>
    $("#bt_retro_individual").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>


<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

