<script>  
$(document).ready(function(){
    $("#bt_formacion_alarmas").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
    $ahora = date("Y-m-d");

	//FUNCION PARA OBTENER LOS AÑOS
	function Dias($fecha){
		$firstDate = $fecha;
		$secondDate = date("Y-m-d");
		$dateDifference = abs(strtotime($secondDate) - strtotime($firstDate));
		
		$dias  = ($dateDifference / ( 60 * 60 * 24));

		return $dias ;
	}
?>

<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Procesos de formación a punto de vencer</h2></td>
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
				<th scope="col">Estudiante</th>
                <th scope="col">Formación</th>
				<th scope="col">Año</th>
                <th scope="col">Fecha de Evaluación </th>
                <th scope="col">Fecha de Vencimiento</th>
				<th scope="col">Validez Meses</th>
                <th scope="col">Días de Validez</th>
				<th scope="col">Estado</th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
			<?php
				$count = 1;
				$queryCohortes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes ORDER BY id DESC "); 
				while($dataCohortes = mysqli_fetch_array($queryCohortes)){ 
					
					$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos 
					WHERE id = '".$dataCohortes["id_proceso"]."' AND validez_meses > 0 ".$filtros." ");  
                	$dataProceso = mysqli_fetch_array($queryProceso);
					
					if($queryProceso->num_rows > 0){
					
						$queryCol = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataCohortes["id_empleado"]."' AND estado = 1 ");  
						$dataCol = mysqli_fetch_array($queryCol);

                        if( $queryCol->num_rows > 0 ){
                            
                        

                            $queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataCol["id"]."' " );  
                            $dataAdd = mysqli_fetch_array($queryAdd);
                            $participante="";
                            if($dataAdd["preferencia"] !== ""){
                                $participante = strtoupper($dataAdd["preferencia"]." ".$dataCol["apellidos"]." ".$dataCol["apellidos_2"]);
                            }else{
                                $participante = strtoupper($dataCol["nombre"].' '.$dataCol["nombre_2"]." ".$dataCol["apellidos"]." ".$dataCol["apellidos_2"]);
                            }

                            $fecha_certificado = "";
                            $lista_certificados = "";
                            $queryCertificado = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_proceso = '".$dataProceso["id"]."' AND id_empleado = '".$dataCohortes["id_empleado"]."' "); 
                            while($dataCertificado = mysqli_fetch_array($queryCertificado)){ 
                                
                                $fecha_certificado = $dataCertificado["fecha_evaluacion"];
                                
                                $lista_certificados .= '<div>
                                <a href="'.$url.'/recursos/'.$dataCertificado["archivo"].'" target="_blank"> 
                                    <button type="button" class="btn btn-warning btn-sm" title="Participantes">
                                            Certificado
                                        </button>
                                </a> 
                                </div>';
                            }
                            
                            $fecha_evaluacion = $dataCohortes["fecha_evaluacion"];

                            $d = new DateTime( $fecha_evaluacion );
                            $d->modify( '+'.$dataProceso["validez_meses"].' month' );
                            $fecha_final = $d->format('Y-m-d');

                            $dia_para_vencer =  Dias($fecha_final);

                            $estado = "Vigente";
                            $bgcolor = "#ffffff";
                            if($ahora > $fecha_final){
                                $estado = "Caducado";
                                $bgcolor = "#EF9A9A";
                                $dia_para_vencer = 'Vencio hace '.$dia_para_vencer.' días';
                            }

                            if(!$dataCohortes["fecha_evaluacion"]){
                                $estado = "Sin Fecha de Evaluación";
                                $bgcolor = "#cccccc";
                                $dia_para_vencer = 'n/a';
                            }
                            
                        
                            echo '
                                <tr bgcolor="'.$bgcolor.'">
                                    <td>'.$count.'</td>
                                    <td>'.$participante.'</td>
                                    <td>'.$dataProceso["nombre"].'</td>
                                    <td>'.$dataProceso["anio"].'</td>
                                    <td>'.$fecha_evaluacion.'</td>
                                    <td>'.$fecha_final.'</td>
                                    <td>'.$dataProceso["validez_meses"].' Meses</td>
                                    <td>'.$dia_para_vencer.' días</td>
                                    <td>'.$estado.'</td>
                                    

                                </tr>

                            ';
                            $count++;
                        }
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
