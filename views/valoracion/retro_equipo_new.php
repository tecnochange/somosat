<script>  
$(document).ready(function(){
    $("#bt_retro_individual").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php
//controlador
$count = 1;
$lista_colaboradores = "";
$queryJefes = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_jefe = '".$_SESSION['id_user']."' ");  
while($dataJefes = mysqli_fetch_array($queryJefes)){
	
	$lista_colaboradores .= '';
	
	$queryEmp = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
	WHERE id = '".$dataJefes['id_empleado']."' ");  
	$dataEmp = mysqli_fetch_array($queryEmp);
                        
	$queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos 
	WHERE id = '".$dataEmp["id_cargo"]."' ");  
	$dataCargo = mysqli_fetch_array($queryCargo);
                        
	$queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas 
	WHERE id = '".$dataCargo["id_area"]."' ");  
	$dataArea = mysqli_fetch_array($queryArea);
	
	$lista_retros = '';
	$queryRetros = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion WHERE id_empleado = '".$dataJefes['id_empleado']."' ");  
	while($dataRetros = mysqli_fetch_array($queryRetros)){
		
		$text_estado = '';
		foreach($Array_estado_seguimiento_retro as $estado){
			if( $estado[0] == $dataRetros["estado"] ){ $text_estado = $estado[1]; }
		}
                        
		$queryComen = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion_Comentarios  WHERE id_retroalimentacion = '".$dataRetros["id"]."' "); 
		
		$boton_editar = '';
		if($dataRetros["estado"] == 1){
			$boton_editar = '
			<a href="?pg=valoracion/retroalimentacion/detalle&e='.$dataRetros["id_empleado"].'&id='.$dataRetros["id"].'">
				<button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
					Ver
				</button>
			</a>
			';
		}
		if($dataRetros["estado"] >= 2){
			$boton_editar = '
				<a href="?pg=valoracion/retroalimentacion/detalle_lectura&e='.$dataRetros["id_empleado"].'&id='.$dataRetros["id"].'">
					<button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
						Ver
					</button>
				</a>
			';
		}
		
		$lista_retroalimentaciones .= '
		<tr>
			<td colspan="3"> </td>
			
			<td>'.$dataRetros["created_at"].'</td>
			<td>'.$queryComen->num_rows.'</td>
			<td>'.$text_estado.'</td>
			<td align="center">
				'.$boton_editar.'
				<a href="?pg=valoracion/retroalimentacion/comentario&e='.$dataRetros["id_empleado"].'&id='.$dataRetros["id"].'">
					<button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" >
						Hacer comentario
					</button>
				</a>
			</td>
		</tr>
		';
	}
	
	$lista_colaboradores .= '
		<tr>
			<td>'.$count.'</td>
			<td>'.$dataEmp["nombre"].' '.$dataEmp["apellidos"].'</td>
			<td>'.$dataArea["nombre"].'</td>
			<td colspan="3"> </td>
			<td align="center">
				<a href="?pg=valoracion/retroalimentacion/detalle&e='.$dataEmp["id"].'">
					<button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
						Nueva Retroalimentación
					</button>
				</a>
			</td>
		</tr>
	';
	$lista_colaboradores .= $lista_retroalimentaciones;
	$count++;
}

?>

<ul class="nav nav-tabs">  
    
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/retro_individual">Retroalimentacion Propia</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/retro_equipo">Retroalimentación equipos</a>
    </li>
</ul>

<div class="container-fluid"> 
    <div class="row">
    
        <div class="col-md-12">
            <table width="100%" >
                <tr>
                    <td>
                        <h2>Retroalimentación Equipo</h2>
                    </td>
                    <td align="right">
                    </td>
                </tr>
            </table>
            
        </div>
        
        <div class="col-md-12">

            <table class="table table-bordered" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col">Colaborador</th>
                    <th scope="col">Area / Proceso</th>
                    <th scope="col">Fecha Retroalimentacion</th>
					<th scope="col"># Comentarios</th>
					<th scope="col">Estado</th>
                    <th scope="col" width="210">Acciones</th>
                </tr>
                </thead>

                <tbody id="tabla_lista">
				<?php echo $lista_colaboradores; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
    
    $("#bt_retro_individual").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();

    
    
    var api = '<?php echo $url; ?>api/administrar/';
    
    var activar = false;
    function Elimimar_Jefe(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un jefe, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Jefe('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_jefe.php",
                type:'post',
                data: {id: id, url:"?pg=administrar/jefes"},
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
    
</script>



