<script>  
$(document).ready(function(){
    $("#bt_adm_areas").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Departamentos</h2></td>
            <td align="right" width="200">
            	<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
                
            </td>
            <td align="right" width="40">   
                <button type="button" class="btn btn-info btn-sm" title="Descargar Excel" >
                    <i class="fas fa-download"></i>
                </button>
            </td>
        </tr>
    </table>
</div>


<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Área padre</th>
                <th scope="col"># Cargos</th>
                <th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                    <?php if($user_log["role"] == 1){ ?>
                    <a href="<?php echo $url; ?>?pg=administrar/area/detalle">
                        <button type="button" class="btn btn-outline-primary btn-sm" >
                            <i class="fas fa-plus"></i> Crear
                        </button>
                    </a>
                    <?php } ?>
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;
                $query = mysqli_query($connect_valentina,"SELECT * FROM Departamentos ORDER BY nombre ASC ");  
                while($data = mysqli_fetch_array($query)){ 
                    
                    $queryPadre = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data["padre"]."' ");  
                    $dataPadre = mysqli_fetch_array($queryPadre);
                    $txt_padre = $dataPadre["nombre"];
                    if($queryPadre->num_rows == 0){
                        $txt_padre = "N/a";
                    }
                   
                    $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_departamento = '".$data["id"]."' ");  
                    
                    $txt_nivel = '';
                    foreach($Array_Jerarquia as $nivel){
                        if($nivel[0] == $data["jerarquia"]){ $txt_nivel = $nivel[1]; }
                    }
                        
                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
                        
                    $bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=administrar/area/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-outline-success btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                        ';
                    }
                            
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].'</td>
                            <td>'.$txt_padre.'</td>
                            <td>'.$queryCargos->num_rows.'</td>
                            
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
