<script>  
$(document).ready(function(){
    $("#bt_adm_colaboradores").addClass("active_item");
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

<?php
    include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();

	$_SESSION["id_colaborador_edit"] = "";
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
				<td><h2>Colaboradores</h2></td>
				<td align="right" width="300">
					<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
                     <a href="<?php echo $url; ?>//informes/colaboradores_planta.php" target="_blank">
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
                    <th scope="col" width="15">#</th>
                    <th scope="col" >Nombres</th>
                    <th scope="col" >Cargo</th>
                    <th scope="col" >Área</th>
                    <th scope="col" >Departamento</th>
                    <th scope="col" >Correo</th>
                    <th scope="col" >Documento</th>
                    <th scope="col" >Role</th>
                    <th scope="col" >Estado</th>
                    <th scope="col" width="100">
                        <a href="<?php echo $url; ?>?pg=administrar/colaborador/detalle">
							<button type="button" class="btn btn-warning btn-sm btn-block" title="Editar">
								Crear
							</button>
                        </a>
                        
                    </th>
                </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                //COLABORADORES ACTIVOS
                $array_colaboradores = $ClassColaboradores->lista_colaboradores_nuevo( $connect_valentina, 1 );

                $count = 1;
				foreach($array_colaboradores as $data){
	
                    $txt_role = '';
                    foreach($Array_Role as $role){
                        if($role[0] == $data["role"]){  $txt_role = $role[1]; }
                    }
                        
                    $txt_estado = '';
                    foreach($Array_Estado  as $estado){
                        if($estado[0] == $data["estado"]){  $txt_estado = $estado[1]; }
                    }
                    
                    if(!$data["foto_formal"]){ $data["foto_formal"] = "1.png"; }
   
                    echo '
                        <tr>
                            <td class="align-middle">'.$count.'</td>
                                                    
                            <td class="align-middle">'.$data["nombre_completo"].'</td>
                            <td class="align-middle">'.$data["cargo_nombre"].'</td>
                            <td class="align-middle">'.$data["area_nombre"].'</td>
                            <td class="align-middle">'.$data["gerencia_nombre"].'</td>
                            <td class="align-middle">'.$data["correo"].'</td>
                            <td class="align-middle">'.$data["documento"].'</td>
                            <td class="align-middle">'.$txt_role.'</td>
                            <td class="align-middle">'.$txt_estado.'</td>
                            <td class="align-middle">
                                
                                <a href="'.$url.'?pg=administrar/colaborador/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                                </a>
                            
                                <a href="'.$url. '/reportes/colaborador/resumen.php?id='.$data["id"].'" target="_blank">
                                <button type="button" class="btn btn-success btn-sm" title="Resumen">
                                    <i class="fa fa-eye"></i> 
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
	
	
	<!-- INACTIVOS -->
	<div class="table-responsive">
    <table class="table" style="margin-top: 15px">
        <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col" >Nombres</th>
                    <th scope="col" >Cargo</th>
                    <th scope="col" >Área</th>
                    <th scope="col" >Departamento</th>
                    <th scope="col" >Correo</th>
                    <th scope="col" >Documento</th>
                    <th scope="col" >Role</th>
                    <th scope="col" >Estado</th>
                    <th scope="col" width="100">
                    </th>
                </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                //COLABORADORES INACTIVOS
                $array_colaboradores_inactivos = $ClassColaboradores->lista_colaboradores_nuevo( $connect_valentina, 2 );    
                $count = 1;
                foreach($array_colaboradores_inactivos as $data){
 
                    $txt_role = '';
                    foreach($Array_Role as $role){
                        if($role[0] == $data["role"]){  $txt_role = $role[1]; }
                    }
                        
                    $txt_estado = '';
                    foreach($Array_Estado  as $estado){
                        if($estado[0] == $data["estado"]){  $txt_estado = $estado[1]; }
                    }
                    
                    if(!$data["foto_formal"]){ $data["foto_formal"] = "1.png"; }
   
                    echo '
                        <tr>
                            <td class="align-middle">'.$count.'</td>
                                                      
                            <td class="align-middle">'.$data["nombre"].' '.$data["nombre_2"].' '.$data["apellidos"].' '.$data["apellidos_2"].'</td>
                            <td class="align-middle">'.$data["cargo_nombre"].'</td>
                            <td class="align-middle">'.$data["area_nombre"].'</td>
                            <td class="align-middle">'.$data["gerencia_nombre"].'</td>
                            <td class="align-middle">'.$data["correo"].'</td>
                            <td class="align-middle">'.$data["documento"].'</td>
                            <td class="align-middle">'.$txt_role.'</td>
                            <td class="align-middle" style="background-color: #ff9e97;">'.$txt_estado.'</td>
                            <td class="align-middle">
                                
                                <a href="'.$url.'?pg=administrar/colaborador/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                                </a>
                            
                                <a href="'.$url. '/reportes/colaborador/resumen.php?id='.$data["id"].'" target="_blank">
                                <button type="button" class="btn btn-success btn-sm" title="Resumen">
                                    <i class="fa fa-eye"></i> 
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



