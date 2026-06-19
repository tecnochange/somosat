<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<div class="container-fluid"> 
    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Seguimiento Valoración <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right">
                        
                        
                    </td>
                </tr>
            </table>
            
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
        <th scope="col">Nombre Colaborador</th>
        <th scope="col">Cargo</th>
        <th scope="col">Área/Proceso</th>
        <th scope="col">Tipo de Valoración que realiza</th>
        <th scope="col">Persona a la que realiza la valoración</th>
        <th scope="col">Cargo</th>
        <th scope="col" style="min-width: 120px !important;">Acciones</th>
	</tr>
	</thead>
    
	<tbody>
	<?php
        
    $count = 1;
    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ");  
    while($data = mysqli_fetch_array($query)){ 
                        
        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
        $dataCargo = mysqli_fetch_array($queryCargo);
                        
        $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
        $dataArea = mysqli_fetch_array($queryArea);
                        
        $lista_evaluadores = '';
        $lista_reportes = '';
        $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
        WHERE id_evaluador = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
        while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
            
            $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_empleado"]."' ");  
            $dataEm = mysqli_fetch_array($queryEm);
            
            $queryCar = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEm["id_cargo"]."' ");  
            $dataCar = mysqli_fetch_array($queryCar);
            
            $tipo_txt = '';
            foreach($array_Tipo_Colaborador as $tipo){
                if($tipo[0] == $dataEvaluadores["tipo"]){
                    $tipo_txt =  $tipo[1];
                }
            }
            
            $bt_editar = '
            Pendiente 
            ';

            $color_estado = '#ffbeba ';
            
            $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  
            anio = '".$dataCicloVal["anio"]."' AND 
            id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND  
            id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  
            tipo = '".$dataEvaluadores["tipo"]."' AND
            id_ciclo = '".$_SESSION['ciclo']."' ");
            $dataEval = mysqli_fetch_array($queryEval);
            
            if($queryEval->num_rows > 0){                
                if($dataEval["estado"] == 1){
                    $bt_editar = 'En Proceso ';
                    $color_estado = '#00bcd4 ';
                }
                
                if($dataEval["estado"] == 2){
                    $bt_editar = 'Terminada';
                    $color_estado = '#3ce663 ';
                }
            }
            
            
            $botones_generales = ''; 

            if($dataEval["estado"] == 2){
                $botones_generales = '
                    <a href="'.$url.'?pg=valoracion/seguimiento/detalle&e='.$dataEval["id"].'">
                        <button type="button" class="btn btn-success btn-sm" title="Detalle">
                            <i class="fas fa-eye"></i> 
                        </button>
                    </a>
                    
                    <button type="button" class="btn btn-info btn-sm" title="Reactivar Evaluación" onclick="Reactivar_Evaluacion('.$dataEval["id"].')">
                        <i class="fas fa-retweet"></i> 
                    </button>
                    
                    <button type="button" class="btn btn-danger btn-sm" title="Eliminar Evaluación" onclick="Elinar_Evaluacion('.$dataEval["id"].', '.$dataEval["id_evaluado"].', '.$dataEval["id_evaluador"].', '.$dataEval["tipo"].' )">
                        <i class="fas fa-trash"></i> 
                    </button>
                    
                '; 
            }              
            
            //if($dataEval["estado"] == 2){
                $lista_reportes .= '
                <tr>
                    <td colspan="4" style="border-color: #fafafa;"></td>
                    <td>'.$tipo_txt.'</td>
                    <td>'.$dataEm["nombre"].' '.$dataEm["apellidos"].'</td>
                    <td>'.$dataCar["nombre"].'</td>
                    <td>
                        '.$botones_generales.'
                    </td>
                </tr>            
                ';
            //}
        }
        
        
        
        
        echo '
            <tr>
                <td>'.$count.'</td>
                <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                <td>'.$dataCargo["nombre"].'</td>
                <td>'.$dataArea["nombre"].'</td>
                <td colspan="4">
                </td>        
            </tr>
        ';

        echo $lista_reportes;
        $count++;
        
    
    }  
	?>
	</tbody>
</table>


















<script>
  
    $("#bt_val_seguimiento").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();


    
    
    
    var api = '<?php echo $url; ?>api/valoracion/';
    
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
                url: api+"reactivar_formulario.php",
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
                url: api+"eliminar_formulario.php",
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



