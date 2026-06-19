<script>  
$(document).ready(function(){
    $("#bt_adm_administar").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>


    <div align="left" class="cabecera_interna">
        <table width="100%">
            <tr>
                <td><h2>Ciudades</h2></td>
            </tr>
        </table>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/administrar">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/administrar">Administrar</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
        </ol>
    </nav>


    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col">Nombre</th>
					<th scope="col">Departamento</th>
                    <th scope="col">Estado</th>
                    <th scope="col" width="100" align="center">
                        
                            <a href="<?php echo $url; ?>?pg=administrar/administrar/ciudades/detalle">
                            <button type="button" class="btn btn-warning btn-sm" >
                                <i class="fas fa-plus"></i>
                            </button>
                            </a>
                        
                    </th>
                </tr>
            </thead>

            <tbody class="tabla_lista">
                <?php
                    $count = 1;
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Municipios ORDER BY municipio ASC ");  
                    while($data = mysqli_fetch_array($query)){ 

                        $queryDep = mysqli_query($connect_valentina,"SELECT * FROM Departamentos WHERE id_departamento = '".$data["departamento_id"]."' ");
						$dataDep = mysqli_fetch_array($queryDep);

                        $txt_estado = '';
                        foreach($Array_Estado as $nivel){
                            if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                        }

                        $bt_editar = 'n/a';
                        if($user_log["role"] == 1){
                            $bt_editar = '
                                <a href="'.$url.'?pg=administrar/administrar/ciudades/detalle&id='.$data["id_municipio"].'">
                                    <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                        <i class="bx bx-message-square-edit"></i>
                                    </button>
                                </a>
                            ';
                        }

                        echo '
                            <tr>
                                <td>'.$count.'</td>
                                <td>'.$data["municipio"].'</td>
								<td>'.$dataDep["departamento"].'</td>
                                <td>'.$txt_estado.'</td>
                                <td align="center">
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
