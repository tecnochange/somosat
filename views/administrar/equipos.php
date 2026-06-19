<script>  
$(document).ready(function(){
    $("#bt_adm_equipos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}

    include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();

	$id_equipo = $_GET["e"];
?>

<div class="container-fluid">
	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Equipos</h2></td>
				<td align="right" width="200">
					<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />

				</td>
			</tr>
		</table>
	</div>

	<div class="table-responsive">
    <table class="table">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col" >Equipo</th>
                <th scope="col" >Nombre</th>
                <th scope="col" >Jerarquia</th>
				<th scope="col" >Depende</th>
                <th scope="col" >Estado</th>
                <th scope="col" width="100" align="center">
                    <?php if($user_log["role"] == 1){ ?>
                        <a href="<?php echo $url; ?>?pg=administrar/equipo/asignar&e=<?php echo $id_equipo; ?>">
                        <button type="button" class="btn btn-warning btn-sm" >
                            <i class="fas fa-plus"></i> Asignar
                        </button>
                        </a>
                    <?php } ?>
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;

				$query = mysqli_query($connect_valentina,"SELECT * FROM Organigrama_View 
                WHERE id_equipo = '".$id_equipo."' AND estado = 1 ");  //NIVEL 1
                while($data = mysqli_fetch_array($query)){

                    $colaborador = $ClassColaboradores->colaborador( $connect_valentina, $data["id_empleado"] );

					$queryEquipo = mysqli_query($connect_valentina,"SELECT * FROM Equipos 
                    WHERE id = '".$data["id_equipo"]."' ");  
                    $dataEquipo = mysqli_fetch_array($queryEquipo);
					
					$nombre_depende = "";
					if( $data["id_depende"] > 0){

						$queryDepende = mysqli_query($connect_valentina,"
						SELECT Empleados.id, Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2, Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2 
						FROM Organigrama 
						LEFT JOIN Empleados ON Empleados.id =  Organigrama.id_empleado 
						WHERE Organigrama.id = '".$data["id_depende"]."' ");  
						$dataDepende = mysqli_fetch_array($queryDepende);

                        $colaborador_dep = $ClassColaboradores->colaborador( $connect_valentina, $dataDepende["id"] );
						
						$nombre_depende = $colaborador_dep[0]["nombre_completo"];
					}

                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
                    
                    $bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=administrar/equipo/asignar&id='.$data["id"].'&e='.$id_equipo.'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                            </a>
                        ';
                    }
    
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$dataEquipo["nombre"].'</td>
                            <td>'.$colaborador[0]["nombre_completo"].'</td>
                            <td>'.$data["jerarquia"].'</td>
							<td>'.$nombre_depende.'</td>
							<td>'.$txt_estado.'</td>
                            <td  align="center">
                                 '.$bt_editar.' 
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
