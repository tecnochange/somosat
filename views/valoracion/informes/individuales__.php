<script>
    $("#bt_val_informes").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<?php
    //CARGAMOS LOS NIVELES
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos  ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//CARGAMOS LOS NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}

?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Informes Individuales</h2>
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
        <a class="nav-link active " href="?pg=valoracion/informes/individuales">Individuales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/areas">Area / Procesos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/informes/niveles">Niveles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/informes/organizacion">Organización</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/numericos">Numéricos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/estadisticas">Estadísticas</a>
    </li>
</ul>



<table class="table table-sm" >
  <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Evaluado</th>
        <th scope="col" style="width: 80px;">Cargo</th>
        <th scope="col">Area</th>
        <th scope="col">Promedio general</th>
        <th scope="col"></th>
    </tr>
  </thead>
    <tbody>
    <?php
 
        include("views/valoracion/informes/metodo_ponderacion.php");
        
        $count = 1;
        //CONSULTAMOS A TODOS LO EMPLEADOS
        $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ");  
        while($data = mysqli_fetch_array($query)){ 
            
            $permitir = true;
            $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_empleado = '".$data['id']."'  "); 
            while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
                    $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  anio = '2021' AND id_evaluado = '".$data['id']."' AND  id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  tipo = '".$dataEvaluadores["tipo"]."' AND estado = 2 ");
                    if($queryEval->num_rows == 0){
                        $permitir = false;
                    }
            }
            
            
            //DATOS DEL CARGO
            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
            $dataCargo = mysqli_fetch_array($queryCargo);
            
            //DATOS DEL AREA
            $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
            $dataArea = mysqli_fetch_array($queryArea);
            
            //METODO PARA OBTENER LA PONDERACION POR EMPLEADO
            $ponderacion_empleado = PonderacionNumericaEmpleado( $connect_valoracion, $connect_valentina, $data["id"]  );
            
            //print_r($ponderacion_empleado);
            //echo "<br>";
            
            $txt_promedio = $ponderacion_empleado["datos"]["total"];
            $tabla = '';
            foreach( $ponderacion_empleado["tabla"] as $fila ){
                
                
                if( $fila[2] == 'N.T.'){ $txt_promedio = 'En Proceso'; }
                
                
                $tipo_txt = '';
                foreach($array_Tipo_Colaborador as $tipo){
                    if($tipo[0] == $fila[0]){ 
                            $tipo_txt = $tipo[1];
                    }
                }
                
                $tabla .= '
                    <tr>
                        <td colspan="4"></td>
                        <td>'.$tipo_txt.'</td>
                        <td>'.$fila[1].'</td>
                        <td>'.$fila[2].'</td>
                        <td></td>
                    </tr>
                ';
                
            }
            
            $bt_acciones = '
                    <a href="?pg=valoracion/informes/informe_consolidado&e='.$data["id"].'">
                            <button type="button" class="btn btn-success btn-sm" style="border-radius: 30px; margin: 3px; ">
                                Consolidado
                            </button>
                    </a>
                    
                    <a href="?pg=valoracion/informes/informe_evaluadores&e='.$data["id"].'" target="_blank">
                            <button type="button" class="btn btn-warning btn-sm" style="border-radius: 30px; margin: 3px; ">
                                Evaluadores
                            </button>
                    </a>
                        
            ';
            
            if($txt_promedio == 'En Proceso' || $txt_promedio == 0 ){ $bt_acciones = ''; }
            
            
            if($permitir == false){
                    $bt_acciones = 'Evaluaciones pendientes';
                    $txt_promedio = 0;
            }
            

            echo '
                <tr>
                    <td>'.$count.'</td>
                    <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                    <td>'.$dataCargo["nombre"].'</td>
                    <td>'.$dataArea["nombre"].'</td>      
                    <td title="'.$ponderacion_empleado["datos"]["tipo"].'">
                        <b>'.$txt_promedio.'</b>
                    </td>
                    <td>
                        '.$bt_acciones.'
                    </td>
                </tr>
            ';
            $count++;

        }
      
      ?>
      
    
    
  </tbody>
</table>















<script>

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



