<?php
	$hoy = date("Y:m:d H:i:s");
	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["base_parse"] != "" && $_POST["id_encuesta"] != ""){ 
	
		$porciones = json_decode( $_POST["base_parse"] ) ;		
		foreach ($porciones as &$valor) {
			mysqli_query($connect,"INSERT INTO Encuestados (id_encuesta , nombre, apellidos, correo, cedula, rol, area, estado) 
			VALUES 
			('".$_POST["id_encuesta"]."', '".$valor["0"]."', '".$valor["1"]."', '".$valor["2"]."', '".$valor["3"]."', '".$valor["4"]."', '".$valor["5"]."', 0 ) ");
		} 
		echo '<script> location.href = "https://wandtalent.com/clima/?pg=encuestados&id='.$_POST["id_encuesta"].'"; </script>';
	}
?>





<script>

//PRIMER PASO
function Cargar_Base_Datos(){

    if( $('#file_base_datos').val() == ""  ){
		$("#PopUp").show();
		$("#parrafo_info").html('<img src="img/icono_advertencia_amarillo.png" width="30"/><br>');
		$("#parrafo_info").append( alertasText['alert_sel_archivo']+".<br>");
		$("#parrafo_info").append('<input type="button" data-role="none" value="Ok" class="bt_verde" onclick="Ocultar_PopUp()">');
    }
    else{
		
		$('#file_base_datos').parse({
			config: {
			delimiter: ";",
			complete: pintar_tabla
        },
			before: function(file, inputElem){
				//data_csv(file, inputElem);
				//console.log("Parsing file...", file);
				//console.log(inputElem);
			},
			error: function(err, file){
				console.log("ERROR:", err, file);
			},
			complete: function(result){
				//console.log("Done with all files");
				//console.log(result);
				
				$("#archivo_cargado_tmp").html("");
				
			}
        });
    }
}



//RONDAS 2
function pintar_tabla(results){
	
	$("#table_validar").html("");
	data = results.data;
	cont = 1
	for(i=0;i<data.length;i++){
		
		$("#table_validar").append('<tr>');
		$("#table_validar").append('<td>'+cont+'</td>');
		$("#table_validar").append('<td>'+data[i][0]+'</td>');
		$("#table_validar").append('<td>'+data[i][1]+'</td>');
		$("#table_validar").append('<td>'+data[i][2]+'</td>');
		$("#table_validar").append('<td>'+data[i][3]+'</td>');
		$("#table_validar").append('<td>'+data[i][4]+'</td>');
		$("#table_validar").append('<td>'+data[i][5]+'</td>');		
		$("#table_validar").append('</tr>');
		cont++;	
	}
	
	$("#base_parse").val( JSON.stringify(data)  );	
}

</script>

<?php
	//CONSULTAMOS LOS DATOS DE LA ASIGNACION
	$queryE = mysqli_query($connect,"SELECT * FROM Encuestas WHERE id = '".$_GET["id"]."' ");
	$dataE = mysqli_fetch_array($queryE);
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
		<li class="breadcrumb-item"><a href="?pg=encuestados&id=<?php echo $_GET["id"]; ?>">Encuestados</a></li>
        <li class="breadcrumb-item">Cargar Base de datos</li>
	</ol>

    <table width="100%">
    	<tr>
        	<td><h2 style="color: #2196f3;">Encuesta: <?php echo $dataE["nombre"]; ?></h2></td>
            <td align="right">
            	
            </td>
        </tr>
    </table>
    
	<div class="alert alert-danger" role="alert">
		Debe cargar una base de datos en archivo CSV separados por comas. descargue el archivo <a href="recursos/formato_encuestados.csv" target="_blank">aquí</a>
	</div>
    
    
    <!-- FILTRO EMPRESA -->
    <form action="" method="post" >
    <div class="row">
    	<div class="col-md-12" >
        	<label>Archivo CSV</label>
			<input class="form-control" id="file_base_datos" type="file" accept=".csv" >
            <input type="button" class="btn btn-primary btn-md btn-block" value="Validar" style="margin-top:15px" onclick="Cargar_Base_Datos()"  />
		</div>
    </div>
    </form>
    
    
	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Correo</th>
                  <th>Cédula</th>
                  <th>Rol</th>
                  <th>Área o Proceso</th>
                </tr>
			</thead>
			<tbody id="table_validar">
			
			</tbody>
		</table>
	</div>
    
    
    <!-- FILTRO EMPRESA -->
    <form action="" method="post" >
    <div class="row">
    	<div class="col-md-12" >
        	<input name="id_encuesta" type="hidden" value="<?php echo $_GET["id"]; ?>" />
            <input id="base_parse" name="base_parse" type="hidden" />
            <input type="submit" class="btn btn-primary btn-md btn-block" value="Cargar" style="margin-top:15px" onclick="Cargar_Base_Datos()"  />
		</div>
    </div>
    </form>
    
    
</main>

<script>
	$(document).ready(function(){
	  $("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#myTable tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	  });
	});
</script>