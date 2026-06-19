<script>  
$(document).ready(function(){
    $("#bt_adm_dashboard").addClass("active_item");
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
    $queryEmpleado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 "); 
	// $queryInactivos = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 2 "); 
    $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE estado = 1"); 
    $queryAreas = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE estado = 1");
	$queryGerencias = mysqli_query($connect_valentina,"SELECT * FROM Gerencias WHERE estado = 1");  
	$queryEquipos = mysqli_query($connect_valentina,"SELECT * FROM Equipos WHERE estado = 1");

    $anio_actual = date("Y");
    $arrayFechas = array();
    $arraycantidad = array();

	//EDADES
	$queryFechasNace = mysqli_query($connect_valentina,"SELECT YEAR(fecha_nacimiento) 
	FROM Empleados_Adicionales 
	LEFT JOIN Empleados ON Empleados.id = Empleados_Adicionales.id_empleado 
	WHERE Empleados.estado = 1 
	ORDER BY fecha_nacimiento DESC  ");
    while($dataSol = mysqli_fetch_array($queryFechasNace)){
        array_push($arrayFechas, ($anio_actual-$dataSol["YEAR(fecha_nacimiento)"]) );
        array_push($arraycantidad, $dataSol["COUNT(id)"] );
    }

	$promedio_edad = 0;
	$count_promedio_edad = 0;
	foreach($arrayFechas as $edad){
		if($edad >= 18 && $edad <= 70){
			$promedio_edad += $edad;
			$count_promedio_edad++;
		}
	}

	$promedio_edad = round($promedio_edad/$count_promedio_edad);

	$arrayFechasHijos = array();
    $arraycantidadHijos = array();

	//EDADES HIJOS
	$queryFechasNaceHijos = mysqli_query($connect_valentina,"SELECT YEAR(fecha_nacimiento) 
	FROM Empleados_Familiares 
	LEFT JOIN Empleados ON Empleados.id = Empleados_Familiares.id_empleado 
	WHERE Empleados.estado = 1 AND Empleados_Familiares.parentezco = 'Hijo'  
	ORDER BY fecha_nacimiento DESC  ");
    while($dataFechasNaceHijos = mysqli_fetch_array($queryFechasNaceHijos)){
        array_push($arrayFechasHijos, ($anio_actual-$dataFechasNaceHijos["YEAR(fecha_nacimiento)"]) );
        //array_push($arraycantidadHijos, $dataFechasNaceHijos["COUNT(id)"] );
    }

	//print_r($arraycantidadHijos);

    //basicos
    $array_basicos = array();
    $array_tipo_contrato = array();


    $queryBasico = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1  ");
    while($dataBasico = mysqli_fetch_array($queryBasico)){
        array_push($array_basicos, $dataBasico );
        array_push($array_tipo_contrato, $dataBasico["tipo_contrato"] );
    }
    $array_tipo_contrato = array_unique($array_tipo_contrato);
    

    //academicos
    $array_academico = array();
    $queryAcademico = mysqli_query($connect_valentina,"SELECT Empleados_Academico.nivel FROM Empleados_Academico 
	LEFT JOIN Empleados ON Empleados.id = Empleados_Academico.id_empleado 
	WHERE Empleados.estado = 1 
	");
     while($dataAcademico = mysqli_fetch_array($queryAcademico)){
        array_push($array_academico, $dataAcademico);
    } 

	//nacionalidad
    $array_nacionalidad = array();
    $queryNacionalidad = mysqli_query($connect_valentina,"SELECT Empleados_Adicionales.nacionalidad FROM Empleados_Adicionales 
	LEFT JOIN Empleados ON Empleados.id = Empleados_Adicionales.id_empleado 
	WHERE Empleados.estado = 1
	");
     while($dataNacionalidad = mysqli_fetch_array($queryNacionalidad)){
        array_push($array_nacionalidad, $dataNacionalidad);
    } 

    //adicionales
    $array_adicionales = array();
    $queryAdicionales = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales 
	LEFT JOIN Empleados ON Empleados.id = Empleados_Adicionales.id_empleado 
	WHERE Empleados.estado = 1 
	");
    while($dataAdicionales = mysqli_fetch_array($queryAdicionales)){
        array_push($array_adicionales, $dataAdicionales );
    }

	$colores = array("#00bcd4", "#673ab7", "#cddc39", "#607d8b", "#e91e63", "#ff9800", "#ffeb3b", "#3f51b5");
	//ESTA FUNCION DEVUELVE LA INFORMACION ORDENADA DE LOS DATOS: LISTO PARA USAR EN CHARTJS
    function Obtener_Datos_Edad($array_lista, $campo){
        global $arrayFechas;
        global $colores;
        
        $label = "[";
        $data = "[";
        $color = "[";
        $n = 0;
        foreach($array_lista as $edades){
            $rangos = explode(",", $edades[2]);
			
            $count = 0;
            foreach($arrayFechas as $edad){
                if($edad >= $rangos[0] && $edad  <= $rangos[1]  ){
                   $count++; 
                }
            }
            $label .= "'".$edades[1]."',";
            $data .= "'".$count."',";
            $color .= "'".$colores[$n]."',";
            $n++;
        }
        $label .= "]";
        $data .= "]";
        $color .= "]";
        
        return array(
            "labels" => $label, 
            "datos" => $data, 
            "color" => $color
        );
    }

	//ESTA FUNCION DEVUELVE LA INFORMACION ORDENADA DE LOS DATOS: LISTO PARA USAR EN CHARTJS
    function Obtener_Datos_Edad_Hijo($array_lista, $campo){
        global $arrayFechas;
        global $colores;
        
        $label = "[";
        $data = "[";
        $color = "[";
        $n = 0;
		
		for ($i = 18; $i <= 60; $i++) {

            $count = 0;
            foreach($arrayFechas as $edad){
                if($edad == $i ){
                   $count++; 
                }
            }
            $label .= "'".$i." años',";
            $data .= "'".$count."',";
            $color .= "'".$colores[$n]."',";
            $n++;
        
		}
		/*
        foreach($array_lista as $edades){
            $rangos = explode(",", $edades[2]);
			
            $count = 0;
            foreach($arrayFechas as $edad){
                if($edad >= $rangos[0] && $edad  <= $rangos[1]  ){
                   $count++; 
                }
            }
            $label .= "'".$edades[1]."',";
            $data .= "'".$count."',";
            $color .= "'".$colores[$n]."',";
            $n++;
        }
		*/
		
		
        $label .= "]";
        $data .= "]";
        $color .= "]";
        
        return array(
            "labels" => $label, 
            "datos" => $data, 
            "color" => $color
        );
    }




?>

<style>
    .numeros{
        font-size: 30px;
        font-weight: bold;
        color: #0364ba;
    }
    .titulos{
        font-size: 16px;
        color: #0364ba;
        font-weight: bold;
    }
</style>

<script src="https://cdn.plot.ly/plotly-2.12.1.min.js"></script>

<div class="container">
    
    <div class="row">

        <div class="col-md-12 text-center" style="margin-bottom: 15px">
            <h2>Tablero</h2>
        </div>
    
        <div class="col-md-6" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="numeros"><?php echo $queryEmpleado->num_rows; ?></div>
                    <div class="titulos">Empleados Activos</div>
                </div>
            </div>
        </div>
		
		<div class="col-md-3" style="margin-bottom: 15px; display: none">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="numeros"><?php echo $queryInactivos->num_rows; ?></div>
                    <div class="titulos">Empleados Inactivos</div>
                </div>
            </div>
        </div>
		
		<div class="col-md-3" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="numeros"><?php echo $queryFechasNace->num_rows; ?></div>
                    <div class="titulos">Con Datos Actualizados</div>
                </div>
            </div>
        </div>
		
		<div class="col-md-3" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="numeros"><?php echo $promedio_edad; ?></div>
                    <div class="titulos">Promedio Edad</div>
                </div>
            </div>
        </div>
		
		
		

         <div class="col-md-3" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="numeros"><?php echo $queryCargos->num_rows; ?></div>
                    <div class="titulos">Cargos</div>
                </div>
            </div>
        </div>

        <div class="col-md-3" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="numeros"><?php echo $queryAreas->num_rows; ?></div>
                    <div class="titulos">Áreas</div>
                </div>
            </div>
        </div>
		
		<div class="col-md-3" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="numeros"><?php echo $queryGerencias->num_rows; ?></div>
                    <div class="titulos">Departamentos</div>
                </div>
            </div>
        </div>
		
		<div class="col-md-3" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="numeros"><?php echo $queryEquipos->num_rows; ?></div>
                    <div class="titulos">Equipos</div>
                </div>
            </div>
        </div>
		
		
        
		<?php
            $datos_ordenados = Obtener_Datos_Edad($Array_Rangos_Edad, "edad");
        ?>
        <div class="col-md-8" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    <div class="titulos">Edades</div>
                    <div id='chart_edad'></div>
                </div>
            </div>
        </div>
		<script>
		var data4 = [{
			values: <?php echo $datos_ordenados["datos"]; ?>,
			labels: <?php echo $datos_ordenados["labels"]; ?>, 
        	colors: <?php echo $datos_ordenados["color"]; ?>, 
			domain: {column: 0},
			hoverinfo: 'label+percent+name',
			hole: .4,
			type: 'pie', 
			automargin: true,
        }];
		var layout4 = {
          margin: {"t": 0, "b": 0, "l": 0, "r": 0},
          showlegend: true,
           height: 200
		};
		var config4 = {responsive: true}
            
        $( document ).ready(function() {
            Plotly.newPlot('chart_edad', data4, layout4, config4 ); 
        });  
        </script>
        
        

        <?php 
        $queryMaculino = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE genero = 1 "); 
        $queryFemenino = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE genero = 2 "); 
        ?>
        
        
        <div class="col-md-4" style="margin-bottom: 15px">
            <div class="card" style="height: 100%;">
                <div class="card-body" align="center">
                    <div class="titulos">Género</div>
					<div id='char_genero'></div>
                </div>
            </div>
        </div>
		<script>
		var data = [{
			values: [<?php echo $queryMaculino->num_rows; ?>, <?php echo $queryFemenino->num_rows; ?>],
			labels: ['Masculino <?php echo $queryMaculino->num_rows; ?>', 'Femenino <?php echo $queryFemenino->num_rows; ?>' ], 
        	colors: [ '8bc34a', '03A9F4' ], 
			domain: {column: 0},
			hoverinfo: 'label+percent+name',
			hole: .4,
			type: 'pie', 
			automargin: true,
        }];
		var layout = {
          margin: {"t": 0, "b": 0, "l": 0, "r": 0},
          showlegend: false,
           height: 200
		};
		var config = {responsive: true}
            
        $( document ).ready(function() {
            Plotly.newPlot('char_genero', data, layout, config ); 
        });  
        </script>
		
		
		
        
        
        
		
		
		<style>
            .barra_avance{
                width: 100%;  
            }
			.porcentaje_realizadas{
                background-color: #00295e;
				height: 20px;
				color: #ffffff;
				border-radius: 10px 0px 0px 10px;
				min-width: 24px;
				text-align: right;
				padding: 0px 7px;
            }
            .porcentaje_enproceso{
                background-color: #c9e5ff;
				height: 20px;
				border-radius: 0px 10px 10px 0px;
            }
            .numeros{
                margin: 3px 8px;
                color: #000000;
                font-weight: bold;
            }
        </style>
        
        <!-- ESTADO CIVIL -->
        <div class="col-md-4" style="margin-bottom: 15px">
            <div class="card" style="height: 100%;">
                <div class="card-body" align="center">
                    <div class="titulos">Estado Civil</div>
                    
                    <table width="100%" >
                        <?php
                        $total = count($array_adicionales);
                        foreach($Array_Estado_Civil as $tipo){ 
                            $cont = 0;
                            foreach($array_adicionales as $datos){
                                if($tipo[0] == $datos["estado_civil"]){
                                    $cont++;
                                }
                            }
                            $porcentaje = ($cont*100)/$total;
                            echo '
                            <tr>
                                <td>'.$tipo[1].'</td>
                                <td width="60%">
                                    <div class="barra_avance">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 6px;">
                                            <tr>
                                                <td class="porcentaje_realizadas" style=" width: '.$porcentaje.'%; "> 
                                                    '.$cont.'
                                                <td>
                                                <td class="porcentaje_enproceso" style=" width: '.(100-$porcentaje).'%; "> 
                                                        '.$texto_enproceso.'  
                                                <td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            ';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- NIVEL ACADEMICO -->
        <div class="col-md-4" style="margin-bottom: 15px">
            <div class="card" style="height: 100%;">
                <div class="card-body" align="center">
                    <div class="titulos">Nivel Académico</div>
                    
                    <table width="100%" >
                        <?php
						foreach($Array_Nivel_Formacion as $formacion){
							$cont = 0;
							foreach($array_academico as $dato){
								if($formacion[1] == $dato["nivel"]){
									$cont++;
								}
							}
							$porcentaje = ($cont*100)/$total;
							echo '
                            <tr>
                                <td>'.$formacion[1].'</td>
                                <td width="60%">
                                    <div class="barra_avance">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 6px;">
                                            <tr>
                                                <td class="porcentaje_realizadas" style=" width: '.$porcentaje.'%; "> 
                                                    '.$cont.'
                                                <td>
                                                <td class="porcentaje_enproceso" style=" width: '.(100-$porcentaje).'%; "> 
                                                <td>
                                            </tr>
                                        </table>

                                    </div>
                                </td>
                            </tr>
                            ';
						}
                        ?>
                    </table>
                    
                </div>
            </div>
        </div>
		
		
		<!-- NIVEL ACADEMICO -->
        <div class="col-md-4" style="margin-bottom: 15px">
            <div class="card" style="height: 100%;">
                <div class="card-body" align="center">
                    <div class="titulos">Nacionalidad</div>
                    
                    <table width="100%" >
                        <?php
						$queryNodo = mysqli_query($connect_valentina,"SELECT * FROM Nacionalidad 
						ORDER BY nombre DESC ");  
                        while($dataNodo = mysqli_fetch_array($queryNodo)){
							$cont = 0;
							foreach($array_nacionalidad as $dato){
								if($dataNodo["id"] == $dato["nacionalidad"]){
									$cont++;
								}
							}
							$porcentaje = ($cont*100)/$total;
							echo '
                            <tr>
                                <td>'.$dataNodo["nombre"].'</td>
                                <td width="70%">
                                    <div class="barra_avance">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 6px;">
                                            <tr>
                                                <td class="porcentaje_realizadas" style=" width: '.$porcentaje.'%; "> 
                                                    '.$cont.'
                                                <td>
                                                <td class="porcentaje_enproceso" style=" width: '.(100-$porcentaje).'%; "> 
                                                <td>
                                            </tr>
                                        </table>

                                    </div>
                                </td>
                            </tr>
                            ';
						}
						
                        ?>
                    </table>
                    
                </div>
            </div>
        </div>
		
		
		
		
		
		<?php
            $datos_ordenados = Obtener_Datos_Edad_Hijo($arrayFechas, "edad");
        ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
        <!-- FICHA 3--> 
		<div class="col-md-12" style="text-align:center; margin-top:15px; margin-bottom: 20px">
			<div class="card" >
				<div class="card-body">
					<div style="height: 300px">
						<h4 class="my-0 font-weight-normal"><b>Promedio de Edades</b></h4>
						<canvas id="PieVar_1" width="390" height="300"></canvas>
					</div>
					
				</div>
			</div>
		</div>
    
		<script>
		var config = {
			type: 'line',
			data: {
				labels: <?php echo $datos_ordenados["labels"]; ?>,
				datasets: [{
					label: 'Cantidad empleados',
					backgroundColor: "#e91e63",
					borderColor: "#0096db",
					pointRadius:3,
					pointHoverRadius:12,
					data: <?php echo $datos_ordenados["datos"]; ?>,
					fill: false,
					}
				]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				title: {
					display: false,
					text: ''
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Edades'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'No. Colaboradores'
						}
					}]
				}
			}
		};

		var ctx = document.getElementById('PieVar_1').getContext('2d');
		window.myLine = new Chart(ctx, config);
		</script>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
        
        <!-- personas por equipos -->
        <div class="col-md-6" style="margin-bottom: 15px">
            <div class="card" style="height: 100%;">
                <div class="card-body" align="center">
                    <div class="titulos">Colaboradores por Equipo</div>
                
                
                	<div style="height: 460px; overflow: auto;">
                        <table class="table">
                            <thead class="thead-success">
                                <tr>
                                    <th scope="col" width="15">#</th>
                                    <th scope="col">Equipo</th>
                                    <th scope="col"># Colaboradores</th>
                                </tr>
                            </thead>

                            <tbody class="tabla_lista">
                                <?php
                                    $count = 1;
                                    $queryCar = mysqli_query($connect_valentina,"SELECT * FROM Equipos ORDER BY nombre ASC   ");  
                                    while($dataCar = mysqli_fetch_array($queryCar)){ 

										$sentenciaOrganigrama = "
                                        SELECT
                                            Organigrama.*
                                        FROM
                                            Organigrama 
                                            LEFT JOIN Empleados ON Empleados.id = Organigrama.id_empleado
                                        WHERE
                                            Organigrama.id_equipo = '".$dataCar["id"]."' AND Organigrama.estado = 1 AND Empleados.estado = 1
                                            GROUP BY Empleados.id
                                        ";
										$queryEmpleados = mysqli_query($connect_valentina, $sentenciaOrganigrama ); 
	
                                        echo '
                                            <tr>
                                                <td>'.$count.'</td>
                                                <td>'.$dataCar["nombre"].'</td>
                                                <td><b>'.$queryEmpleados->num_rows.'</b></td>
                                            </tr>

                                        ';
                                        $count++;
                                    }
                                ?>
                            </tbody>
                        </table>
                	</div>
                </div>
            </div>
        </div>

        <!-- personas por areas -->
        <div class="col-md-6" style="margin-bottom: 15px">
            <div class="card" style="height: 100%;">
                <div class="card-body" align="center">
                    <div class="titulos">Colaboradores por Área</div>
                </div>
                
                <div style="height: 460px; overflow: auto;">
                        <table class="table">
                            <thead class="thead-success">
                                <tr>
                                    <th scope="col" width="15">#</th>
                                    <th scope="col">Área</th>
									<th scope="col">Departamento</th>
                                    <th scope="col"># Colaboradores</th>
                                </tr>
                            </thead>

                            <tbody class="tabla_lista">
                                <?php
                                    $count = 1;
                                    $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas  ");  
                                    while($dataArea = mysqli_fetch_array($queryArea)){ 
										
										$queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_area = '".$dataArea["id"]."' AND estado = 1 "); 
										
										$queryDep = mysqli_query($connect_valentina,"SELECT * FROM Gerencias WHERE id = '".$dataArea["id_gerencia"]."'  ");  
                                    	$dataDep = mysqli_fetch_array($queryDep); 
	
                                        echo '
                                            <tr>
                                                <td>'.$count.'</td>
                                                <td>'.$dataArea["nombre"].'</td>
												<td>'.$dataDep["nombre"].'</td>
                                                <td><b>'.$queryEmpleados->num_rows.'</b></td>
                                            </tr>

                                        ';
                                        $count++;
                                    }
                                ?>
                            </tbody>
                        </table>
                </div>
                
            </div>
        </div>
        
        
		
        
        
        
    </div>
    
</div>



