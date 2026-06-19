<script>  
$(document).ready(function(){
    $("#bt_val_informes").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php

    $arrayEvaluadores = array();
	$queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
	while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
		array_push($arrayEvaluadores, $dataEvaluadores );
	}

    //CARGAMOS COMPETENCIAS EVALUACIONES
	$arrayCompetencias_Evaluaciones = array();
	$queryCompetencias_Evaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
	while($dataCompetencias_Evaluaciones = mysqli_fetch_array($queryCompetencias_Evaluaciones)){
		array_push($arrayCompetencias_Evaluaciones, $dataCompetencias_Evaluaciones );
	}

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

    include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();

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
        <a class="nav-link " href="?pg=valoracion/informes_propios">Informes Propios</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/informes_equipo">Informes Equipo</a>
    </li>
    
</ul>



<table class="table table-sm" >
  <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Evaluado</th>
        <th scope="col" style="width: 80px;">Cargo</th>
        <th scope="col">Area</th>
        <th scope="col">Evaluadores</th>
        <th scope="col">Evaluaciones</th>
        <th scope="col">Promedio general</th>
        <th scope="col">Tipo</th>
        <th scope="col">Acciones</th>
    </tr>
  </thead>
    <tbody>
    <?php
        include("views/valoracion/informes/funciones.php");
        
        $count = $posicion+1;
        
       // $queryEquipo = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_jefe = '".$user_log['id']."' AND id_empresa = '".$_SESSION['id_empresa']."' ");  
       // while($dataEquipo = mysqli_fetch_array($queryEquipo)){ 
            
            //CONSULTAMOS A TODOS LOS EMPLEADOS DE ESTA EMPRESA
            $query = mysqli_query($connect_valentina,"SELECT 
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
					WHERE Jefes.id_jefe = '".$_SESSION["id_user"]."' AND Empleados.estado = 1 
					ORDER BY Empleados.nombre ASC ".$filtro." ");  
            while($data = mysqli_fetch_array($query)){ 

                $colaborador = $ClassColaboradores->colaborador( $connect_valentina, $data["id"] );

                $queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' " );  
                $dataAdd = mysqli_fetch_array($queryAdd);
                //$nombre = $data["nombre"].' '.$data["nombre_2"].' '.$data["apellidos"].' '.$data["apellidos_2"];
                if($dataAdd["preferencia"]){
                    $nombres = $dataAdd["preferencia"];
                }else{
                    $nombres = $data["nombre"].' '.$data["nombre_2"];
                }
                $data["nombres_completo"] = $nombres;
                array_push($array_colaboradores, $data );

                //VALIDAMOS SI TIENE TODAS LAS EVALUACIONES Y EVALUADORES
                $VALIDACION = PromedioGeneralEvaluado( $data["id"], $connect_valoracion, $connect_valentina);
                $id_cargo = $VALIDACION["id_cargo"];
                $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$id_cargo."' ");
                $dataCargo = mysqli_fetch_array($queryCargo);

                $bt_acciones = '
                <a href="?pg=valoracion/informes/informe_consolidado&e='.$data["id"].'" target="_blank">
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

                if($VALIDACION["no_evaluadores_evaluacion"]  == 0){
                    $bt_acciones = 'Evaluaciones pendientes';
                }

                $txt_area = '';
                foreach($arrayAreas as $area){
                    if( $area["id"] == $dataCargo["id_area"] ){
                        $txt_area = $area["nombre"];
                    }
                }

                echo '
                <tr>
                    <td>'.$count.'</td>
                    <td>'.$colaborador[0]["nombre_completo"].'</td>
                    <td>'.$colaborador[0]["cargo_nombre"].'</td>
                    <td>'.$colaborador[0]["area_nombre"].'</td>
                    <td align="center">'.$VALIDACION["no_evaluadores"].'</td>
                    <td align="center">'.$VALIDACION["no_evaluadores_evaluacion"].'</td>
                    <td align="center">'.round( $VALIDACION["promedio"],1).'</td>
                    <td>'.$VALIDACION["tipo_ponderacion"].'</td>
                    <td>'.$bt_acciones.'</td>
                </tr>
                ';
                $count++;
            }
            
            
     //   }
        
        
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













































