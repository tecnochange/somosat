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

<table class="table table-sm" >
  <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Competencia</th>
        <th scope="col">Comportamiento / Respuesta</th>
        <th scope="col">Nivel</th>
        <th scope="col">evaluado</th>
        <th scope="col">evaluador</th>
        <th scope="col">tipo evaluador</th>
        <th scope="col">año</th>
        <th scope="col">calificación</th>
    </tr>
  </thead>
    <tbody>
    <?php
 
       
        
        $count = 1;
        //CONSULTAMOS A TODOS LO EMPLEADOS
        $query = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos ");  
        while($data = mysqli_fetch_array($query)){ 

            $queryResp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE id = '".$data["id_respuesta"]."' ");  
            $dataResp = mysqli_fetch_array($queryResp);
            
            $queryComport = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas WHERE id = '".$data["id_comportamientos"]."' ");
            $dataComport = mysqli_fetch_array($queryComport);
            
            /*
            //DATOS DEL CARGO
            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
            $dataCargo = mysqli_fetch_array($queryCargo);
            
            //DATOS DEL AREA
            $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
            $dataArea = mysqli_fetch_array($queryArea);
            
            //METODO PARA OBTENER LA PONDERACION POR EMPLEADO
            $ponderacion_empleado = PonderacionNumericaEmpleado( $connect_valoracion, $connect_valentina, $data["id"]  );
            */

            echo '
                <tr>
                    <td>'.$count.'</td>
                    <td>'.$data["id_competencia"].'</td>
                    <td>'.$dataComport["indicador"].'</td>
                    <td>'.$dataComport["id_nivel_competencia"].'</td>
                    <td>'.$dataResp["id_evaluado"].'</td>
                    <td>'.$dataResp["id_evaluador"].'</td>
                    <td>'.$dataResp["tipo_evaluador"].'</td>
                    <td>'.$dataComport["anio"].'</td>
                    <td>'.$data["calificacion"].'</td>
                    
                </tr>
            ';
            $count++;
            
            /*
            mysqli_query($connect_valoracion,"UPDATE Competencias_Respuestas_Comportamientos SET 
            id_nivel_competencia = '".$dataComport["id_nivel_competencia"]."' ,
            id_evaluado = '".$dataResp["id_evaluado"]."',
            id_evaluador = '".$dataResp["id_evaluador"]."', 
            tipo_evaluador = '".$dataResp["tipo_evaluador"]."', 
            anio = '".$dataComport["anio"]."' 
            WHERE id = '".$data["id"]."' ");  
            */
            
            
            

        }
      
      ?>
      
    
    
  </tbody>
</table>















<script>
  
    $("#bt_val_informes").addClass("active_item");
    
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



