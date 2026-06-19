<script>  
$(document).ready(function(){
    $("#bt_formacion_tablero").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
$filtros = "";
if($_POST["fill_inicia"]){
	$filtros .= " AND Cohortes.fecha_evaluacion >= '".$_POST["fill_inicia"]."' ";
}
if($_POST["fill_termina"]){
	$filtros .= " AND Cohortes.fecha_evaluacion <= '".$_POST["fill_termina"]."' ";
}

$array_estudiantes = array();
$queryEstudiante = mysqli_query($connect_valentina,"SELECT * FROM Empleados "); 
while($dataEstudiante = mysqli_fetch_array($queryEstudiante)){ 
    $nombre_estu = $dataEstudiante["nombre"]." ".$dataEstudiante["apellidos"];
    array_push($array_estudiantes, $dataEstudiante );
}

$array_marcas = array();
$queryMarcas = mysqli_query($connect_formacion,"SELECT * FROM Marcas "); 
while($dataMarcas = mysqli_fetch_array($queryMarcas)){ 
    array_push($array_marcas, array( "nombre" => $dataMarcas["nombre"], "cantidad" => 0 ) );
}

$array_proveedores = array();
$queryProv = mysqli_query($connect_formacion,"SELECT * FROM Proveedores "); 
while($dataProv = mysqli_fetch_array($queryProv)){ 
    array_push($array_proveedores, array( "nombre" => $dataProv["nombre"], "cantidad" => 0 ) );
}

$array_tipos = array();
$queryTipo = mysqli_query($connect_valentina,"SELECT * FROM Tipo_Capacitacion WHERE estado = 1 ");
while($dataTipo = mysqli_fetch_array($queryTipo)){
    array_push($array_tipos, array( "id" => $dataTipo["id"], "nombre" => $dataTipo["nombre"], "cantidad" => 0 ) ); 					
}

$array_motivos = array();
foreach($Array_Motivo_Formacion as $motivo){
    array_push($array_motivos, array( "id" => $motivo[0], "nombre" => $motivo[1], "cantidad" => 0 ) );
}

//ARREGLOS 
$array_tabla_estudiantes = array();
$array_evaluados = array();
$array_cursos = array();
$cant_certificados = 0;

$sentencia_cohortes = "
SELECT
    Cohortes.id, 
    Cohortes.id_empleado, 
    Cohortes.id_proceso, 
    Cohortes.fecha_evaluacion, 
    Procesos.nombre AS nombre_proceso, 
    Procesos.anio AS anio_proceso, 
    Procesos.motivo AS motivo, 
    Procesos.tipo_capacitacion AS tipo_capacitacion, 
    Marcas.nombre AS nombre_marca, 
    Proveedores.nombre AS nombre_proveedor 
    
FROM
    Cohortes 
    LEFT JOIN Procesos ON Procesos.id = Cohortes.id_proceso 
    LEFT JOIN Marcas ON Marcas.id = Procesos.id_marca 
    LEFT JOIN Proveedores ON Proveedores.id = Procesos.proveedor 
WHERE
    Cohortes.id > 0 ".$filtros."
    GROUP BY Cohortes.id;
";
$queryCohortes = mysqli_query($connect_formacion, $sentencia_cohortes ); 
while($dataCohortes = mysqli_fetch_array($queryCohortes)){ 
    
    foreach($array_marcas as $key => $marca){
        if( $marca["nombre"] == $dataCohortes["nombre_marca"] ){
            $array_marcas[$key]["cantidad"]++;
        }
    }

    foreach($array_proveedores as $key => $prov){
        if( $prov["nombre"] == $dataCohortes["nombre_proveedor"] ){
            $array_proveedores[$key]["cantidad"]++;
        }
    }

    foreach($array_motivos as $key => $mot){
        if( $mot["id"] == $dataCohortes["motivo"] ){
            $array_motivos[$key]["cantidad"]++;
        }
    }

    foreach($array_tipos as $key => $tip){
        if( $tip["id"] == $dataCohortes["tipo_capacitacion"] ){
            $array_tipos[$key]["cantidad"]++;
        }
    }

    $queryCertificados = mysqli_query($connect_formacion,"SELECT id FROM Certificados 
    WHERE id_cohorte = '".$dataCohortes["id"]."' ");
    $cant_certificados += $queryCertificados->num_rows;
    
    array_push( $array_evaluados, $dataCohortes["id_empleado"] );
    array_push( $array_cursos, $dataCohortes["id_proceso"] );

    $nombre = '';
    foreach( $array_estudiantes as $estudiante ){
        if( $estudiante["id"] == $dataCohortes["id_empleado"] ){
            $nombre = $estudiante["nombre"]." ".$estudiante["apellidos"];
        }
    }

    array_push($array_tabla_estudiantes, array( "nombre" => $nombre, "fecha" => $dataCohortes["fecha_evaluacion"], "curso" => $dataCohortes["nombre_proceso"] ) );
}



$array_evaluados = array_unique($array_evaluados);
$array_cursos = array_unique($array_cursos);

$cant_proveedores = 0;
foreach($array_proveedores as $prov){
    if($prov["cantidad"] > 0){
        $cant_proveedores++; 
    }   
}

$cant_marcas = 0;
foreach($array_marcas as $marca){
    if($marca["cantidad"] > 0){
        $cant_marcas++;
    }   
}


?>

<style>
    .numeros{
        font-size: 40px;
        font-weight: bold;
        color: #00295e;
        font-family: Nunito-Black;
    }
    .titulos{
        font-size: 16px;
        color: #0364ba;
        font-weight: bold;
    }
    .numeros_small{
		font-size: 20px;
		font-weight: bold;
	}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>

<div class="container">

	<form action="" method="post">
	<div class="row">
		<div class="col-md-5" style="margin-bottom: 10px">
        	<label> Fecha de Evaluación Inicia *</label>
        	<input type="date"  class="form-control" name="fill_inicia" value="<?php echo $_POST["fill_inicia"]; ?>" required>
		</div>
		
		<div class="col-md-5" style="margin-bottom: 10px">
        	<label> Fecha de Evaluación Termina *</label>
        	<input type="date"  class="form-control" name="fill_termina" value="<?php echo $_POST["fill_termina"]; ?>" required>
		</div>
		
		<div class="col-md-2" style="margin-bottom: 10px">
        	<label>*</label>
        	<button type="submit" class="btn btn-primary btn-block">
        		Filtrar
        	</button>
		</div>
	</div>
	</form>
	
	<div class="row">

        <div class="col-md-12 mt-3" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-header">
					<h2>TABLERO DE ESTADÍSTICAS ESTUDIANTES</h2>
				</div>
                <div class="card-body">
                    El siguiente tablero incluye es histórico de evaluaciones de los colaboradores. (en el momento de la presentación el colaborador se encontraba activo)
                </div>
			</div>
		</div>

        <div class="col-md-4" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo count($array_evaluados); ?></div>
					<div class="titulos">Evaluados</div>
				</div>
			</div>
		</div>

        <div class="col-md-4" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo count($array_cursos); ?></div>
					<div class="titulos">Cursos/Procesos</div>
				</div>
			</div>
		</div>

        <div class="col-md-4" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $queryCohortes->num_rows; ?></div>
					<div class="titulos">Evaluaciones</div>
				</div>
			</div>
		</div>

        <div class="col-md-4" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $cant_certificados; ?></div>
					<div class="titulos">Certificados Generados</div>
				</div>
			</div>
		</div>

		<div class="col-md-4" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $cant_proveedores; ?></div>
					<div class="titulos">Proveedores</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-4" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="numeros"><?php echo $cant_marcas; ?></div>
					<div class="titulos">Marcas</div>
				</div>
			</div>
		</div>



        <div class="col-md-6" align="center" style="margin-top: 20px" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="titulos">Estudiantes por Motivo</div>
                    <canvas id="distribucion_canvas" style="width:100%; height:400px"></canvas>
                    <script>
                    const data = {
                        labels: [<?php 
                        foreach($array_motivos as $nodo){
                            if($nodo["cantidad"] > 0){
                               echo "'".$nodo["nombre"]."', "; 
                            }   
                        } 
                        ?>],
                        datasets: [
                            {
                            label: 'Estudiantes por Motivo',
                            data: [<?php 
                            foreach($array_motivos as $nodo){
                                if($nodo["cantidad"] > 0){
                                echo $nodo["cantidad"].","; 
                                }   
                            } 
                            ?>], 
                            backgroundColor: ['#00295e', '#ff8300', '#0364ba', '#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba',],
                            }
                        ]
                    };

                    const config = {
                        type: 'doughnut',
                        data: data,
                        options: {
                            responsive: true,
                        },
                    };
                    </script>
				</div>
			</div>
		</div>

        <div class="col-md-6" align="center" style="margin-top: 20px" >
			<div class="card" align="center" style="margin-bottom: 15px">
				<div class="card-body">
					<div class="titulos">Estudiantes por Tipo</div>
                    <canvas id="tipos_canvas" style="width:100%; height:400px"></canvas>
                    <script>
                    const data2 = {
                        labels: [<?php 
                        foreach($array_tipos as $nodo){
                            if($nodo["cantidad"] > 0){
                               echo "'".$nodo["nombre"]."', "; 
                            }   
                        } 
                        ?>],
                        datasets: [
                            {
                            label: 'Estudiantes por Tipo',
                            data: [<?php 
                            foreach($array_tipos as $nodo){
                                if($nodo["cantidad"] > 0){
                                echo $nodo["cantidad"].","; 
                                }   
                            } 
                            ?>], 
                            backgroundColor: ['#00295e', '#ff8300', '#0364ba', '#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba','#00295e', '#ff8300', '#0364ba',],
                            }
                        ]
                    };

                    const config2 = {
                        type: 'doughnut',
                        data: data2,
                        options: {
                            responsive: true,
                        },
                    };
                    </script>
				</div>
			</div>
		</div>

		
















		
	

		
		
		<div class="col-md-6" align="center" style="margin-top: 20px" >
			<div class="card">
				<div class="card-body">
					<h2>Estudiantes por marca</h2>
                    <div style="max-height: 400px; overflow: auto;">
                        <table class="table table-bordered">
                            <tr>
                                <th>Marca</th>
                                <th>Cantidad</th>
                            </tr>
                            <?php
                            foreach($array_marcas as $marca){
                                if($marca["cantidad"] > 0){
                                    echo '
                                    <tr>
                                        <td>'.$marca["nombre"].'</td>
                                        <td>'.$marca["cantidad"].'</td>
                                    </tr>
                                    ';
                                }
                            }
                            ?>
                            
                        </table>
                    </div>
				</div>
			</div>
		</div>

        <div class="col-md-6" align="center" style="margin-top: 20px" >
			<div class="card">
				<div class="card-body">
					<h2>Estudiantes por Proveedor</h2>
                    <div style="max-height: 400px; overflow: auto;">
                        <table class="table table-bordered">
                            <tr>
                                <th>Marca</th>
                                <th>Cantidad</th>
                            </tr>
                            <?php
                            foreach($array_proveedores as $prov){
                                if($prov["cantidad"] > 0){
                                    echo '
                                    <tr>
                                        <td>'.$prov["nombre"].'</td>
                                        <td>'.$prov["cantidad"].'</td>
                                    </tr>
                                    ';
                                }
                            }
                            ?>
                            
                        </table>
                    </div>
				</div>
			</div>
		</div>

        <div class="col-md-12" align="center" style="margin-top: 20px" >
			<div class="card">
				<div class="card-body">
					<h2>Estudiantes</h2>
                    <div style="max-height: 400px; overflow: auto;">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Proceso</th>
                            </tr>
                            <?php
                            foreach($array_tabla_estudiantes as $nodo){

                                    echo '
                                    <tr>
                                        <td>'.$nodo["nombre"].'</td>
                                        <td>'.$nodo["fecha"].'</td>
                                        <td>'.$nodo["curso"].'</td>
                                    </tr>
                                    ';
                                }
                            
                            ?>
                            
                        </table>
                    </div>
				</div>
			</div>
		</div>
		
		
        
		
		
		
		
	</div>

</div>

<script>
    var ctx = document.getElementById('distribucion_canvas').getContext('2d');
    new Chart(ctx, config);

    var ctx2 = document.getElementById('tipos_canvas').getContext('2d');
    new Chart(ctx2, config2);
</script>