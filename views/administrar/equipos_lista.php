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
				<th scope="col" ># Integrantes Activos</th>
                <th scope="col" >Estado</th>
                <th scope="col" width="100" align="center">
                    <?php if($user_log["role"] == 1){ ?>
                        <a href="<?php echo $url; ?>?pg=administrar/equipo/detalle">
                        <button type="button" class="btn btn-warning btn-sm" >
                            <i class="fas fa-plus"></i> Nuevo
                        </button>
                        </a>
                    <?php } ?>
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;

				$query = mysqli_query($connect_valentina,"SELECT * FROM Equipos 
                 ORDER BY nombre ASC ");  //NIVEL 1
                while($data = mysqli_fetch_array($query)){
					
					$queryMiembros = mysqli_query($connect_valentina," SELECT * FROM Organigrama WHERE id_equipo = '".$data["id"]."' AND estado = 1 ");  //NIVEL 1

                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
                    
                    $bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=administrar/equipo/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                            </a>
							<a href="'.$url.'?pg=administrar/equipos&e='.$data["id"].'">
                                <button type="button" class="btn btn-success btn-sm" title="Integrantes">
                                    <i class="bx bx-user"></i>
                                </button>
                            </a>
                        ';
                    }
    
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].'</td>
                            <td><b>'.$queryMiembros->num_rows.'</b></td>
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
