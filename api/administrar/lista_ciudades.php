<option value="">Selecciona...</option>
<?php
	include("../../app/models/connect.php");
    

	$queryEncuestas = mysqli_query($connect_valentina,"SELECT * FROM Municipios WHERE id_municipio <= 1100 AND departamento_id  = '".$_POST["id_dep"]."' ORDER BY  municipio ASC ");
	while($dataEncuestas = mysqli_fetch_array($queryEncuestas)){
         echo '<option value="'.$dataEncuestas["id_municipio"].'">'.$dataEncuestas["municipio"].'</option>';
        
	}
?>

