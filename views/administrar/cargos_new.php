<script>  
$(document).ready(function(){
    $("#bt_adm_puestos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Cargos</h2></td>
            <td align="right" width="200">
            	<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
                
            </td>
        </tr>
    </table>
</div>

<style>
    .datos{
        font-weight: bold;
        text-align: center;
    }
</style>

<div class="table-responsive">
    <table class="table table-bordered" style="font-size: 12px;">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col">Cargo</th>
                <th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                    Acciones
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;
                $query = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Copia ORDER BY nombre ASC ");  
                while($data = mysqli_fetch_array($query)){ 

                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
                        
                    $bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=administrar/cargo/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                            </a>
                        ';
                    }
    
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].'</td>
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
