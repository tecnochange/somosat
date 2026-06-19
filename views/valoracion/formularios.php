<script>  
$(document).ready(function(){
    $("#bt_val_seguimiento").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

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
        RIGHT JOIN Empleados_Adicionales  as ad ON ad.id_empleado = Empleados.id 
		WHERE Empleados.estado = 1 
        ORDER BY Empleados.nombre ASC
	";
                    
	$array_colaboradores = array();
	$query = mysqli_query($connect_valentina, $sentencia);  
	while($data = mysqli_fetch_array($query)){ 
		$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' " );  
		$dataAdd = mysqli_fetch_array($queryAdd);
		
        $nombre = $data["nombre"].' '.$data["nombre_2"].' '.$data["apellidos"].' '.$data["apellidos_2"];
		
        if($dataAdd["preferencia"]){
			$nombre = $dataAdd["preferencia"].' '.$data["apellidos"].' '.$data["apellidos_2"];
		}
		$data["nombre"] = $nombre;
		array_push($array_colaboradores, $data );
	}
	foreach ($array_colaboradores as $key => $row) {
		$aux[$key] = $row['nombre'];
	}
	array_multisort($aux, SORT_ASC, $array_colaboradores);
?>

<?php 
    $terminadas = 0;
    $en_proceso = 0;
    $pendientes = 0;
    $TABLA_GENERAL = "";

    $count = 1;
	foreach($array_colaboradores as $data){
    //$query = mysqli_query($connect_valentina,"SELECT Empleados.id AS id, Empleados.nombre AS nombre, Empleados.apellidos AS apellidos 
    //FROM Empleados 

    //WHERE Empleados.estado = 1 ORDER BY Empleados.nombre ASC ");  
    //while($data = mysqli_fetch_array($query)){ 
            
            $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data["id_area"]."' ");  
            $dataArea = mysqli_fetch_array($queryArea);
            
            $lista_reportes = '';
            $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
            WHERE id_evaluador = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' AND anio = '".$_SESSION['anio']."' ");  
            while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
                
                $queryEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  
                anio = '".$dataCicloVal["anio"]."' AND id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  
                tipo_evaluacion = '".$dataEvaluadores["tipo"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
                $dataEvaluacion = mysqli_fetch_array($queryEvaluaciones);
                
                $queryEvaluado = mysqli_query($connect_valentina,"SELECT Empleados.nombre AS nombre, Empleados.apellidos AS apellidos, Cargos.nombre AS nombre_cargo, ad.preferencia
                FROM Empleados 
                LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
                INNER JOIN Empleados_Adicionales as ad 
                on ad.id_empleado = Empleados.id
                WHERE Empleados.id = '".$dataEvaluadores["id_empleado"]."' ");  
                $dataEvaluado = mysqli_fetch_array($queryEvaluado);

                if($dataEvaluado['preferencia']){
                    $nombreEvaluado = $dataEvaluado["preferencia"].' '.$dataEvaluado["apellidos"].' '.$dataEvaluado["apellidos_2"];
                }else{
                    $nombreEvaluado = $dataEvaluado["nombre"].' '.$dataEvaluado["nombre_2"].' '.$dataEvaluado["apellidos"].' '.$dataEvaluado["apellidos_2"];
                }

                $promedio = "n/a";
                $botones_generales = "";
                
                $tipo_txt = '';
                foreach($array_Tipo_Colaborador as $tipo){
                    if($tipo[0] == $dataEvaluadores["tipo"]){
                        $tipo_txt =  $tipo[1];
                    }
                }
                
                $txt_estado = "Sin iniciar";
                if($queryEvaluaciones->num_rows > 0){
                    if($dataEvaluacion["estado"] == 1){
                        $txt_estado = 'En Proceso ';
                        $color_estado = '#00bcd4 ';
                        $en_proceso++;
                    }

                    if($dataEvaluacion["estado"] == 2){
                        $txt_estado = 'Terminada';
                        $color_estado = '#3ce663 ';
                        $terminadas++;
                        $promedio = $dataEvaluacion["promedio"];
                        
                        $botones_generales = '
                            <a href="'.$url.'?pg=valoracion/evaluacion&id='.$dataEvaluacion["id"].'">
                                <button type="button" class="btn btn-success btn-sm" title="Detalle">
                                    <i class="fas fa-eye"></i> 
                                </button>
                            </a>

                            <button type="button" class="btn btn-info btn-sm" title="Reactivar Evaluación" onclick="Reactivar_Evaluacion('.$dataEvaluacion["id"].')">
                                <i class="fas fa-retweet"></i> 
                            </button>

                            <button type="button" class="btn btn-danger btn-sm" title="Eliminar Evaluación" onclick="Elinar_Evaluacion('.$dataEvaluacion["id"].', '.$dataEvaluacion["id_evaluado"].', '.$dataEvaluacion["id_evaluador"].', '.$dataEvaluacion["tipo"].' )">
                                <i class="fas fa-trash"></i> 
                            </button>

                        '; 
                    }  
                }
                else{
                    $pendientes++;
                }
                
                

                $lista_reportes .= '
                <tr>
                    <td colspan="4" style="border-color: #fafafa;"></td>
                    <td style="border-color: #fafafa;">'.$tipo_txt.'</td>
                    <td style="border-color: #fafafa;">'.$nombreEvaluado.'</td>
                    <td style="border-color: #fafafa;">'.$dataEvaluado["nombre_cargo"].'</td>
                    <td style="border-color: #fafafa;">'.$promedio.'</td>
                    <td style="border-color: #fafafa;" align="center" >
                        '.$botones_generales.'
                    </td>
                </tr>
                        
                ';
            }
            
            $TABLA_GENERAL .= '
            <tr>
                <td>'.$count.'</td>
                <td class="align-middle">'.$data["nombre"].'</td>
                <td class="align-middle">'.$data["cargo_nombre"].'</td>
                <td class="align-middle">'.$data["area_nombre"].'</td>
                <td colspan="5">
                </td>        
            </tr>
            ';
            $TABLA_GENERAL .= $lista_reportes;
            
            
            $count ++;
    }
        
?>

<div class="container-fluid"> 
    <div class="row">
    
        <div class="col-md-12">
            <h2>Seguimiento Evaluadores del <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
        </div>
    </div>
</div>


<ul class="nav nav-tabs">  
    <li class="nav-item">
        <a class="nav-link  " href="?pg=valoracion/seguimiento">Seguimiento Valoración</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/formularios">Formularios Valoración</a>
    </li>
</ul>



<table class="table table-hover table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" width="15">#</th>
        <th scope="col">Nombre Evaluador</th>
        <th scope="col">Cargo</th>
        <th scope="col">Área/Proceso</th>
        <th scope="col">Tipo de Valoración que realiza</th>
        <th scope="col">Persona a la que realiza la valoración</th>
        <th scope="col">Cargo</th>
        <th scope="col">Promedio</th>
        <th scope="col" style="min-width: 120px !important;">Acciones</th>
	</tr>
	</thead>
    
	<tbody>
    <?php echo $TABLA_GENERAL; ?>
	</tbody>
</table>



<script>
  
    var api = '<?php echo $url; ?>/api/valoracion/';
    
    var activar = false;
    function Elimimar_Evaluador(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un evaluador, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Evaluador('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_evaluador.php",
                type:'post',
                data: {id: id, url:"?pg=valoracion/arbol"},
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
    
    function Reactivar_Evaluacion(id){
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de reactivar este formulario, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Reactivar_Evaluacion('+id+')"> Reactivar Formulario </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"reactivar_formulario_new.php",
                type:'post',
                data: {id: id, url:"?pg=valoracion/formularios"},
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
    
    
    function Elinar_Evaluacion(id, id_evaluado, id_evaluador, tipo){
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de borrar este formulario, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elinar_Evaluacion('+id+', '+id_evaluado+', '+id_evaluador+', '+tipo+', )"> Eliminar Formulario </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_formulario_new.php",
                type:'post',
                data: {id: id, id_evaluado: id_evaluado, id_evaluador: id_evaluador,  id_tipo: tipo, url:"?pg=valoracion/formularios"},
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



