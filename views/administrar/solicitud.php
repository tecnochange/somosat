<?php
	$queryAsis = mysqli_query($connect,"SELECT id FROM Asistentes ");
	$queryActv = mysqli_query($connect,"SELECT id FROM Agenda ");
	$querySpe = mysqli_query($connect,"SELECT id FROM Conferencistas ");
	$queryNuevos = mysqli_query($connect,"SELECT id FROM Asistentes WHERE origen = 2 ");

	$completo = 0;
	$queryPreregistro = mysqli_query($connect,"SELECT * FROM Asistentes WHERE origen = 1 ");
	while($dataPreregistro = mysqli_fetch_array($queryPreregistro)){
		
		if($dataPreregistro["nombre"] != "" && $dataPreregistro["correo"] != "" && $dataPreregistro["pais"] != "" && $dataPreregistro["ciudad"] != "" && $dataPreregistro["celular"] != "" && $dataPreregistro["especialidad"] != "" &&  $dataPreregistro["eps"] != "" && $dataPreregistro["tratamientos"] != "" && $dataPreregistro["acepto"] != ""){
			$completo ++;
		}
	}


?>

<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <h2>Administrar Estructura</h2>
        </div>
    
    </div>
</div>


<script>
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>



