<script>  
$(document).ready(function(){
    $("#bt_adm_directorio").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php 
	include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();
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
				<td><h2>Directorio</h2></td>
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
                    <th scope="col" width="150">Foto</th>
                    <th scope="col" >Nombres de preferencia</th>
                    <th scope="col" >Cargo</th>
                    <th scope="col" >Área</th>
                    <th scope="col">Correo</th>
                    <th scope="col" width="130">
                        Acciones
                    </th>
                </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
			//COLABORADORES ACTIVOS
            $count = 1;
			$array_colaboradores = $ClassColaboradores->lista_colaboradores_asc( $connect_valentina, 1 );
			foreach( $array_colaboradores as $data ){
				
                    if(!$data["foto_formal"]){ $data["foto_formal"] = "1.png"; }
   
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td align="center"> <div class="foto" style="background-image: url('.$url.'/recursos/'.$data["foto_formal"].')"></div> </td>                            
                            <td class="align-middle">'.$data["nombre_completo"].'</td>
                            <td class="align-middle">'.$data["cargo_nombre"].'</td>
                            <td class="align-middle">'.$data["area_nombre"].'</td>
                            <td class="align-middle">'.$data["correo"].'</td>
                            <td class="align-middle">
                                <a href="'.$url.'?pg=administrar/colaborador/resumen&id='.$data["id"].'">
                                <button type="button" class="btn btn-success btn-sm" title="Resumen">
                                    Resumen
                                </button>
                                </a>
								<a href="'.$url. '/reportes/colaborador/resumen.php?id='.$data["id"].'" target="_blank">
                                <button type="button" class="btn btn-warning btn-sm" title="Hoja">
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



