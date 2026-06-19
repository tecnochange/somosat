<script>
$(document).ready(function(){    
    $("#bt_adm_jefes").addClass("active_item");
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
?>

<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Jefes</h2></td>
				<td align="right" width="200">
					<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />

				</td>
			</tr>
		</table>
	</div>

	<div class="table-responsive">
    <table class="table" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col">Nombres y Apellidos</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Jefes Asignados</th>
                    <th scope="col" width="30"></th>
                </tr>
                </thead>

                <tbody class="tabla_lista">
                <?php
                    $hoy = date("Y-m-d H:i:s");
                    $count = 1;

                    //COLABORADORES ACTIVOS
                    $array_colaboradores = $ClassColaboradores->lista_colaboradores_nuevo( $connect_valentina, 1 );

                    foreach($array_colaboradores as $data){

                        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
                        $dataCargo = mysqli_fetch_array($queryCargo);
                        
                        
                        $lista_jefes = '';
                        $queryJefes = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_empleado = '".$data["id"]."' ");  
                        while($dataJefes = mysqli_fetch_array($queryJefes)){

                            $colaborador_dep = $ClassColaboradores->colaborador( $connect_valentina, $dataJefes["id_jefe"] );


                            $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataJefes["id_jefe"]."' ");  
                            $dataEm = mysqli_fetch_array($queryEm);
							
							//PARA VALIDAR EL NOMBRE DE PREFERENCIA
							$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataEm["id"]."' " );  
							$dataAdd = mysqli_fetch_array($queryAdd);
							$nombre_completoJ = strtoupper($dataEm["nombre"]." ".$dataEm["nombre_2"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"] );
							if($dataAdd["preferencia"]){
								$nombre_completoJ = strtoupper($dataAdd["preferencia"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"]);
							}
                            
                            $queryCro = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEm["id_cargo"]."' ");  
                            $dataCro = mysqli_fetch_array($queryCro);
                            
                            $lista_jefes .= '
                                <div style="margin-bottom: 10px;">
                                    '.$colaborador_dep[0]["nombre_completo"].' - '.$dataCro["nombre"].'

                                    <button type="button" id="sidebarCollapse" class="btn btn-danger btn-sm" title="Quitar jefe" style=" float: right; font-size: 12px; padding: 3px 5px;" onclick="Elimimar_Jefe('.$dataJefes["id"].')">
                                        <i class="fas fa-times"></i> 
                                    </button>
                                    
                                    <a href="'.$url.'?pg=administrar/jefe/cambiar&id='.$dataJefes["id"].'">
                                    <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" title="Cambiar jefe" style=" float: right; font-size: 12px; padding: 3px 5px; margin-right: 8px;">
                                        <i class="fas fa-edit"></i> 
                                    </button>
                                    </a>
                                    
                                </div>
                            ';
                        }
                        
                        
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre_completo"].'</td>
                            <td>'.$data["cargo_nombre"].'</td>
                            <td>
                                '.$lista_jefes.'
                            </td>
                            <td>
                                <a href="'.$url.'?pg=administrar/jefe/agregar&id='.$data["id"].'">
                                <button type="button" class="btn btn-outline-success btn-sm" title="Asignar jefe">
                                    <i class="fas fa-plus"></i> 
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

    
    
    var api = '<?php echo $url; ?>/api/administrar/';
    
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



