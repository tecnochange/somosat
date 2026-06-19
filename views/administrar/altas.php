<script>  
$(document).ready(function(){
    $("#bt_adm_alta").addClass("active_item");
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

	include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();
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
				<td><h2>Bajas</h2></td>
				<td align="right" width="300">
                     <a href="<?php echo $url; ?>/informes/bajas.php" target="_blank">
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
					<th scope="col" >Fecha de inactivación</th>
					<th scope="col" >Observaciones</th>
					<th scope="col" >Motivo del retiro</th>
					<th scope="col" >Acciones</th>
                </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
				$count = 1;
				$sentencia = "SELECT * FROM Empleados WHERE fecha_inactivacion != '' AND estado = 2 ORDER BY fecha_inactivacion DESC;";
                $query = mysqli_query($connect_valentina, $sentencia);  
                while($data = mysqli_fetch_array($query)){ 

					$colaborador = $ClassColaboradores->colaborador( $connect_valentina, $data["id"] );

                    echo '
                    <tr>
                    	<td class="align-middle">'.$colaborador[0]["nombre_completo"].'</td>
                    	<td class="align-middle">'.$data["fecha_inactivacion"].'</td>
                    	<td class="align-middle">'.$data["observaciones_inactivacion"].'</td>
                    	<td class="align-middle">'.$data["motivo_retiro"].'</td>
                    	<td class="align-middle">
							<a href="'.$url.'?pg=administrar/colaborador/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
							</a>
                    	</td>
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



