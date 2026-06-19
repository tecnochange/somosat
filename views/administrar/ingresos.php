<script>  
$(document).ready(function(){
    $("#bt_adm_ingresos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
      $_SESSION["id_colaborador_edit"] = "";
?>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>

<style>
	.foto{
		width: 60px;
		height: 60px;
		background-size: cover;
		background-position: center;
		border-radius: 100px;
	}
</style>

<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Ingresos</h2></td>
				<td align="right" width="300">
                     <a href="<?php echo $url; ?>/informes/ingresos.php" target="_blank">
                        <button type="button" id="sidebarCollapse" class="btn btn-info btn-sm" title="Descargar Excel" >
                            <i class="fas fa-download"></i>
                        </button>
                    </a>                   
				</td>
                
                
			</tr>
		</table>
	</div>


	<!-- ACTIVOS -->
	<div class="table-responsive">
    <table class="table" style="margin-top: 15px">
        <thead class="thead-success">
                <tr>
                    <th scope="col" >Colaborador</th>
                    <th scope="col" >Fecha</th>
                    <th scope="col" >Hora</th>
                </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
			
				$sentencia = "
					SELECT Logs.fecha AS fecha, Logs.hora AS hora, Empleados.nombre AS nombre, 
					Empleados.nombre_2 AS nombre_2, Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2, 
					ea.preferencia  
					FROM Logs 
					LEFT JOIN Empleados ON Logs.id_empleado = Empleados.id
					LEFT JOIN Empleados_Adicionales AS ea ON Logs.id_empleado = ea.id_empleado
					ORDER BY Logs.id DESC
				";
                    
                $count = 1;
                $query = mysqli_query($connect_valentina, $sentencia);  
                while($data = mysqli_fetch_array($query)){    
					$colaborador = "";
					if($data["preferencia"] !== "" ){
						$colaborador = $data["preferencia"].' '.$data["apellidos"].' '.$data["apellidos_2"];
					}else{
						$colaborador = $data["nombre"].' '.$data["nombre_2"].' '.$data["apellidos"].' '.$data["apellidos_2"];
					}
                    echo '
                        <tr>
                            <td class="align-middle">'.$colaborador.'</td>
                            <td class="align-middle">'.$data["fecha"].'</td>
                            <td class="align-middle">'.$data["hora"].'</td>
                    </tr>
                    ';
                    $count++;
                }
            ?>
        </tbody>
    </table>
    
	</div>
	

	
</div>

<script>
$(document).ready(function(){
	$("#buscador").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tabla_lista tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});	

});
</script>



