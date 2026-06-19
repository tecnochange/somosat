<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<?php
//SIEMPRE DEBE EXIXSTIR UN CICLO SELECCIONADO
if( $_SESSION['ciclo'] != "" ){
    
    $pendiente = 0;
    $en_proceso = 0;
    $terminado = 0;

    $lista_empleados = '';
        
    $count = 1;
    $count_eval = 0;
    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ");  
    while($data = mysqli_fetch_array($query)){ 
                        
        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
        $dataCargo = mysqli_fetch_array($queryCargo);
                        
        $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
        $dataArea = mysqli_fetch_array($queryArea);
                        
        $lista_evaluadores = '';
        $lista_reportes = '';
        $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
        WHERE id_empleado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
        while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
            
            $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_evaluador"]."' ");  
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
            
            if($queryEval->num_rows > 0){
                $dataEval = mysqli_fetch_array($queryEval);
                
                if($dataEval["estado"] == 1){
                    $bt_editar = 'En Proceso ';
                    $color_estado = '#00bcd4 ';
                    $en_proceso++;
                }
                
                if($dataEval["estado"] == 2){
                    $bt_editar = 'Terminada';
                    $color_estado = '#3ce663 ';
                    $terminado++;
                }
            }
            
            
                            
            
            
            $lista_reportes .= '
                        <tr>
                            <td colspan="4" style="border-color: #fafafa;"></td>
                            <td style="border-color: #fafafa;">'.$tipo_txt.'</td>
                            <td style="border-color: #fafafa;">'.$dataEm["nombre"].' '.$dataEm["apellidos"].'</td>
                            <td style="border-color: #fafafa;" align="center" bgcolor="'.$color_estado.'" >
                                '.$bt_editar.'
                            </td>
                        </tr>
                        
            ';
            $count_eval++;
        }
        
        
        
    
        $lista_empleados .= '
            <tr>
                <td>'.$count.'</td>
                <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                <td>'.$dataCargo["nombre"].'</td>
                <td>'.$dataArea["nombre"].'</td>
                <td colspan="4">
                         
                </td>        
            </tr>
        ';
        
        $count++;
        
        $lista_empleados .= $lista_reportes;
    
    }
                        
                        
            
    $pendiente =  $count_eval-($en_proceso+$terminado);       
        
        
}
        
 
        
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
        <a class="nav-link active " href="?pg=valoracion/seguimiento">Seguimiento Valoración</a>
    </li>
  
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/formularios">Formularios Valoración</a>
    </li>

</ul>




<div class="row">
    <div class="col-md-4">
        <div style="background-color: #3ce663; font-size: 20px; padding: 10px;" align="center">
            <div>Evaluaciones terminadas</div>
            <div><?php echo $terminado; ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background-color: #00bcd4; font-size: 20px; padding: 10px;" align="center">
            <div>Evaluaciones en proceso</div>
            <div><?php echo $en_proceso; ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background-color: #ffbeba; font-size: 20px; padding: 10px;" align="center">
            <div>Evaluaciones Pendientes</div>
            <div><?php echo $pendiente; ?></div>
        </div>
    </div>
</div>



<table class="table table-hover table-sm">
	<thead class="thead-dark">
	<tr>
		<th scope="col" width="15">#</th>
        <th scope="col">Nombre Colaborador</th>
        <th scope="col">Cargo</th>
        <th scope="col">Área/Proceso</th>
        <th scope="col">Tipo de Valoración</th>
        <th scope="col">Persona que lo evalúa</th>
        <th scope="col" width="30">Estado</th>
	</tr>
	</thead>
    
	<tbody>
	    <?php echo $lista_empleados; ?>
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
    
</script>



