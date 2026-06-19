<script>
$(document).ready(function(){    
    $("#bt_adm_alertas").addClass("active_item");
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

	$ahora = date("Y-m-d");
	//FUNCION PARA OBTENER LOS AÑOS
	function Anios($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));

		$years  = floor($dateDifference / (365 * 60 * 60 * 24));
		$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

		$decimal2 = ($months*30+$days)/365;
		$decimal2 = round($decimal2, 1);
		$parte2 = explode(".", $decimal2);

		return ($years.".".$parte2[1]." años");
	}

	//FUNCION PARA OBTENER LOS AÑOS
	function Dias($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
		
		$dias  = floor($dateDifference / ( 60 * 60 * 24));

		return $dias ;
	}



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
		RIGHT JOIN Empleados_Adicionales  as ad ON ad.id_empleado = Empleados.id
		WHERE Empleados.estado = 1 
	";
                    
	$array_colaboradores = array();
	$query = mysqli_query($connect_valentina, $sentencia);  
	while($data = mysqli_fetch_array($query)){ 
		
		$data["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
		
		$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' " );  
		$dataAdd = mysqli_fetch_array($queryAdd);
				
		if($data["preferencia"]){
			$data["nombre_completo"] = strtoupper($dataAdd["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
		}
		array_push($array_colaboradores, $data );
	}

	foreach ($array_colaboradores as $key => $row) {
		$aux[$key] = $row['nombre_completo'];
	}

	array_multisort($aux, SORT_ASC, $array_colaboradores);
?>

<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Informe Alertas de Vencimiento </h2></td>
            <td align="right" width="200">
            	<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
                
            </td>
			<td align="right" width="50">
				<a href="<?php echo $url; ?>//informes/alertas.php" target="_blank">
					<button type="button" id="sidebarCollapse" class="btn btn-info btn-sm" title="Descargar Excel" >
                            <i class="fas fa-download"></i>
					</button>
				</a> 
			</td>
			
        </tr>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-bordered" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col">Nombres y Apellidos</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Fecha de Vencimiento Documento de Identidad</th>
                    <th scope="col">Fecha de Vencimiento Pasaporte</th>
                    <th scope="col">Fecha de Vencimiento Caja Profesional</th>
                    <th scope="col">Fecha de Vencimiento Carné de Salud</th>
                    <th scope="col">Fecha de Vencimiento Aptitud Física</th>
                    <th scope="col">Fecha de Vencimiento Libreta de Conducir</th>
                </tr>
                </thead>

                <tbody class="tabla_lista">
                <?php
                    $hoy = date("Y-m-d H:i:s");
                    $count = 1;
                    //$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 ORDER BY nombre ASC ");  
                   // while($data = mysqli_fetch_array($query)){ 

					$array_colaboradores = $ClassColaboradores->lista_colaboradores_nuevo( $connect_valentina, 1 );
					foreach($array_colaboradores as $data ){

                        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
                        $dataCargo = mysqli_fetch_array($queryCargo);
                        
                        $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' ");
	                    $dataInforma = mysqli_fetch_array($queryInforma);
                        
                        $queryPerfil = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$data["id"]."' ");
	                    $dataPerfil = mysqli_fetch_array($queryPerfil);
                       
                        
                        $queryJefe = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE codigo_posicion = '".$dataPosicionJefe["codigo"]."' ");  
                        $dataJefe = mysqli_fetch_array($queryJefe);
						
						
						
						//VALIDACION DE ALERTAS
						//VALIDACION DE ALERTAS
						//VALIDACION DE ALERTAS
						$alertas_doc = $dataInforma["fecha_vencimiento"];

						// FECHA DOCUMENTO
						if($dataInforma["fecha_vencimiento"]){
							$dia_documento =  Dias($dataInforma["fecha_vencimiento"]);
							if( $dataInforma["fecha_vencimiento"] < $ahora){

								$alertas_doc = '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_documento.' días.<br>
									'.$dataInforma["fecha_vencimiento"].'
								</div>';
							}
							if( $dataInforma["fecha_vencimiento"] >= $ahora){
								if($dia_documento < 31){
									$alertas_doc = '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_documento.' días.<br>
										'.$dataInforma["fecha_vencimiento"].'
									</div>';
								}

							}
						}

						$alertas_pass = $dataInforma["fecha_vencimiento_p"];
						// FECHA DOCUMENTO
						if($dataInforma["fecha_vencimiento_p"]){
							$dia_pasaporte =  Dias( $dataInforma["fecha_vencimiento_p"] );
							if( $dataInforma["fecha_vencimiento_p"] < $ahora){

								$alertas_pass = '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_pasaporte.' días.<br>
									'.$dataInforma["fecha_vencimiento_p"].'
								</div>';
							}
							if( $dataInforma["fecha_vencimiento_p"] >= $ahora){
								if($dia_pasaporte < 15){
									$alertas_pass = '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_pasaporte.' días.<br>
										'.$dataInforma["fecha_vencimiento_p"].'
									</div>';
								}

							}
						}

						$alertas_caja = $dataInforma["fv_docu"];
						// FECHA CAJA PROFESIONAL
						if($dataInforma["fv_docu"]){
							$dia_caja =  Dias( $dataInforma["fv_docu"] );
							if( $dataInforma["fv_docu"] < $ahora){

								$alertas_caja = '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_caja.' días.<br>
									'.$dataInforma["fv_docu"].'
								</div>';
							}
							if( $dataInforma["fv_docu"] >= $ahora){
								if($$dia_caja < 15){
									$alertas_caja = '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_caja.' días.<br>
										'.$dataInforma["fv_docu"].'
									</div>';
								}

							}
						}
						
						
						$alertas_salud = $dataPerfil["car_salud"];
						// FECHA CAJA PROFESIONAL
						if($dataPerfil["car_salud"]){
							$dia_salud =  Dias( $dataPerfil["car_salud"] );
							if( $dataPerfil["car_salud"] < $ahora){

								$alertas_salud = '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_salud.' días.<br>
									'.$dataPerfil["car_salud"].'
								</div>';
							}
							if( $dataPerfil["car_salud"] >= $ahora){
								if($dia_salud < 15){
									$alertas_salud = '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_salud.' días.<br>
										'.$dataPerfil["car_salud"].'
									</div>';
								}

							}
						}
						
						$alertas_fisica = $dataPerfil["apt_fisica"];
						// FECHA CAJA PROFESIONAL
						if($dataPerfil["apt_fisica"]){
							$dia_fisica =  Dias( $dataPerfil["apt_fisica"] );
							if( $dataPerfil["apt_fisica"] < $ahora){

								$alertas_fisica = '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_fisica.' días.<br>
									'.$dataPerfil["apt_fisica"].'
								</div>';
							}
							if( $dataPerfil["apt_fisica"] >= $ahora){
								if($dia_fisica < 15){
									$alertas_fisica = '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_fisica.' días.<br>
										'.$dataPerfil["apt_fisica"].'
									</div>';
								}

							}
						}
						
						$alertas_libreta = $dataPerfil["fecha_libreta"];
						// FECHA CAJA PROFESIONAL
						if($dataPerfil["fecha_libreta"]){
							$dia_libreta =  Dias( $dataPerfil["fecha_libreta"] );
							if( $dataPerfil["fecha_libreta"] < $ahora){

								$alertas_libreta = '
								<div class="alert alert-danger" role="alert">
									Venció hace '.$dia_libreta.' días.<br>
									'.$dataPerfil["fecha_libreta"].'
								</div>';
							}
							if( $dataPerfil["fecha_libreta"] >= $ahora){
								if($dia_libreta < 15){
									$alertas_libreta = '
									<div class="alert alert-warning" role="alert">
										Vence en '.$dia_libreta.' días.<br>
										'.$dataPerfil["fecha_libreta"].'
									</div>';
								}

							}
						}
                        
                        
                        
                            
                        
                        
                        
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre_completo"].'</td>
                            <td>'.$data["cargo_nombre"].'</td>
                            <td>'.$alertas_doc.'</td>
                            <td>'.$alertas_pass.'</td>
                            <td>'.$alertas_caja.'</td>
                            <td>'.$alertas_salud.'</td>
                            <td>'.$alertas_fisica.'</td>
                            <td>'.$alertas_libreta.'</td>
                        </tr>
                        
                        ';
                        $count++;
                    };
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
