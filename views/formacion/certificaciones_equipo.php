<script>  
$(document).ready(function(){
    $("#bt_formacion_certificaciones_equipo").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>


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
				<td><h2>Certificaciones Equipo</h2></td>
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
                    <th scope="col" width="70">Foto</th>
                    <th scope="col" >Nombres</th>
                    <th scope="col" >Cargo</th>
                    <th scope="col" >Certificación</th>
					<th scope="col" >Fecha de planificación/ Q</th>
					<th scope="col" >Fecha Termina</th>
					<th scope="col" >Motivo</th>
                    <th scope="col" >Adjuntos</th>
                </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
				$sentencia = "
					SELECT 
					Empleados.id AS id, 
					Empleados.estado AS estado, 
					Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2, 
					Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2, 
					Empleados.correo AS correo, 
					Empleados.role AS role, 
					Empleados.documento AS documento, 
					Empleados.foto_formal AS foto_formal, 
					Cargos.nombre AS cargo_nombre, 
					Areas.nombre AS area_nombre, 
					Gerencias.nombre AS gerencia_nombre,
					ad.preferencia
					FROM Empleados 
					LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
					LEFT JOIN Areas ON Areas.id = Empleados.id_area 
					LEFT JOIN Gerencias ON Gerencias.id = Empleados.id_departamento 
					LEFT JOIN Jefes ON Jefes.id_empleado = Empleados.id 
					RIGHT JOIN Empleados_Adicionales  as ad ON ad.id_empleado = Empleados.id
					WHERE Jefes.id_jefe = '".$user_log["id"]."' 
					ORDER BY Empleados.nombre ASC
				";
                    
                $count = 1;
                $query = mysqli_query($connect_valentina, $sentencia);  
                while($data = mysqli_fetch_array($query)){
					
					if(!$data["foto_formal"]){ $data["foto_formal"] = "1.png"; }
					
					if($data["preferencia"] !== ""){
						$data["nombre_completo"] = strtoupper($data["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
					}else{
						$data["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
					}

					$count = 1;
					$queryCohorte = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$data["id"]."' ");  
					while($dataCohorte = mysqli_fetch_array($queryCohorte)){ 

						$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$dataCohorte["id_proceso"]."' ");
						$dataProceso = mysqli_fetch_array($queryProceso);

						$lista_certificados = "";
						$queryCertificado = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_empleado = '".$data["id"]."' AND id_proceso = '".$dataProceso["id"]."' "); 
						while($dataCertificado = mysqli_fetch_array($queryCertificado)){
							$lista_certificados .= '<div>
								<a href="'.$url.'/recursos/'.$dataCertificado["archivo"].'" 	target="_blank">'.$dataCertificado["archivo"].'</a>
							</div>';
						}

						$txt_estado = "";
						foreach($Array_Estado_Formacion as $estado){
							if($estado[0] == $data["estado"]){ $txt_estado = $estado[1]; }
						}

						$txt_motivo = "";
						foreach($Array_Motivo_Formacion as $motivo){
							if($motivo[0] == $dataProceso["motivo"]){ $txt_motivo = $motivo[1]; }
						}


						$bt_editar = '
						<a href="'.$url.'?pg=formacion/estudiante/resumen&id='.$data["id"].'">
							<button type="button" class="btn btn-success btn-sm" title="Gestionar ">
								<i class="bx bx-file"></i>
							</button>
						</a>
						';


						echo '
							<tr>
								<td>'.$count.'</td>
                            	<td align="center"> <div class="foto" style="background-image: url('.$url.'/recursos/'.$data["foto_formal"].')"></div> </td> 
								
								<td class="align-middle">'.$data["nombre_completo"].'</td>
                            	<td class="align-middle">'.$data["cargo_nombre"].'</td>
								<td>'.$dataProceso["nombre"].'</td>
								<td>'.$dataProceso["fecha_inicia"].'</td>
								<td>'.$dataProceso["fecha_termina"].'</td>
								<td>'.$txt_motivo.'</td>
								<td>'.$lista_certificados.'</td>
							</tr>
						';
						$count++;
					}

                    
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



