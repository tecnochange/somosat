<script>  
$(document).ready(function(){
    $("#bt_formacion_marcas").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Gestionar Marcas</h2></td>
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
                <th scope="col">Nombre</th>
                <th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                    <?php if($user_log["role"] == 1){ ?>
                    <a href="<?php echo $url; ?>?pg=formacion/marca/detalle">
                        <button type="button" class="btn btn-warning btn-sm" >
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
                $query = mysqli_query($connect_formacion,"SELECT * FROM Marcas ORDER BY nombre ASC ");  
                while($data = mysqli_fetch_array($query)){ 
                    
                   
                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
                        
                    $bt_editar = '';
					$bt_responsables = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=formacion/marca/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                            </a>
							
                            <button type="button" class="btn btn-danger btn-sm" title="Editar" onclick="Eliminar('.$data["id"].')">
                            	<i class="bx bx-trash"></i>
                            </button>
                        ';
                    }
                            
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].'</td>
                            
                            <td>'.$txt_estado.'</td>
                            <td  align="center">
                                '.$bt_editar.' '.$bt_responsables.'
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
	var api = '<?php echo $url; ?>/api/formacion/';
	var activar = false;
	function Eliminar(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un registro, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Eliminar('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_marca.php",
                type:'post',
                data: {id: id, url:"?pg=formacion/marcas"},
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
    }	
	

$(document).ready(function(){
	$("#buscador").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tabla_lista tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});	
});
</script>
