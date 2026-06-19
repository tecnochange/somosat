<script>  
$( document ).ready(function() {
	$('#menuEndomarketing').collapse();
    $("#bt_endo_tools").addClass("active");
});
</script>

<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Herramientas</h2></td>
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
                <th scope="col">Icono</th>
                <th scope="col">Título</th>
				<th scope="col">Link</th>
				<th scope="col">Orden</th>
                <th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                <?php if ($VALIDAR_ROOT["crear"]) { ?>
                    <a href="<?php echo $url; ?>?pg=endomarketing/herramienta/detalle">
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
                $query = mysqli_query($connect_admin,"SELECT * FROM Herramientas ORDER BY titulo ASC ");  
                while($data = mysqli_fetch_array($query)){ 
                    
					$txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
					
					$bt_editar = '
                            <a href="'.$url.'?pg=endomarketing/herramienta/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-outline-success btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                   ';
					
					$bt_eliminar = '
						<button type="button" class="btn btn-danger btn-sm" title="eliminar" onclick="Eliminar_Banner('.$data["id"].')" >
							<i class="fas fa-times"></i>
						</button>
                   ';
 
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td><img src="'.$recursos_hv.'/'.$data["archivo"].'" width="150" > </td>
                            <td>'.$data["titulo"].'</td>
                            <td>'.$data["link"].'</td>
							<td>'.$data["orden"].'</td>
                            <td>'.$txt_estado.'</td>
                            <td  align="center">
                                '.$bt_editar.'
								'.$bt_eliminar.'
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

var api = '<?php echo $url; ?>/api/endomarketing/';
function Eliminar_Banner(id_registro){
	
	
	jQuery.ajax({
		url: api+"eliminar_herramientas.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=endomarketing/herramientas"},
		}).done(function (resp){
			$("#xscript").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
	
}
</script>
