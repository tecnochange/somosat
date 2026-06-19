<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

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
                        <h2>Consolidados Competencias <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
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
        <a class="nav-link " href="?pg=valoracion/informes/estadisticas">Estadísticas</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link  " href="?pg=valoracion/informes/individuales">Individuales</a>
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
        <a class="nav-link active" href="?pg=valoracion/informes/numericos">Numéricos</a>
    </li>
    
    
</ul>


<div align="center" style="margin: 30px">
    <a href="?pg=valoracion/informes/numericos">
    <button type="button" id="sidebarCollapse" class="btn btn-warning" >
        <i class="fas fa-bell"></i> Consolidados
    </button>
    </a>
    
    <a href="?pg=valoracion/informes/numericos_competencias"> 
        <button type="button" id="sidebarCollapse" class="btn btn-primary" >
                    <i class="fas fa-bell"></i> Competencias
        </button>
    </a>
    
    <a href="?pg=valoracion/informes/comportamientos">
        <button type="button" id="sidebarCollapse" class="btn btn-success" >
            <i class="fas fa-bell"></i> Comportamiento
        </button>
    </a>

</div>


<?php
    $limite = 30;
    $pag_activa = $_GET["p"];
    if($_GET["p"] == ""){ $pag_activa = 1; }
    $posicion = ($pag_activa-1)*$limite;

    $filtro = " LIMIT ".$limite." OFFSET ".$posicion." ";

    $queryCount = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
    WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC "); 
    $cant_pagina = ceil($queryCount->num_rows/$limite);

    $anterior = $pag_activa-1;
    $siguiente = $pag_activa+1;

    if($anterior < 1){
        $anterior = 1;
    }
    if($siguiente > $cant_pagina){
        $siguiente = $cant_pagina;
    }

?>

<nav aria-label="Page navigation example" style="margin-top: 15px;">
    <ul class="pagination justify-content-center" >
        <li class="page-item">
          <a class="page-link" href="<?php echo $url.'/?pg=valoracion/informes/numericos_competencias&p='.$anterior; ?>">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        
        <?php 
        for ($i = 1; $i <= $cant_pagina; $i++) {
            if($pag_activa == $i){
                echo '
                    <li class="page-item active">
                        <a class="page-link" href="'.$url.'/?pg=valoracion/informes/numericos_competencias&p='.$i.'">'.$i.'</a>
                    </li>
                ';
            }
            else{
                echo '
                    <li class="page-item">
                        <a class="page-link" href="'.$url.'/?pg=valoracion/informes/numericos_competencias&p='.$i.'">'.$i.'</a>
                    </li>
                ';
            }
        }
        ?>

        <li class="page-item">
          <a class="page-link" href="<?php echo $url.'/?pg=valoracion/informes/numericos_competencias&p='.$siguiente; ?>" >
            <span aria-hidden="true">&raquo;</span>
          </a>
    </li>

  </ul>
</nav>

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Cargo</th>
      <th scope="col">Area</th>
        <th scope="col">Competencias</th>
        <th scope="col">Promedios</th>

    </tr>
  </thead>
    <tbody>
    <?php
        include("views/valoracion/informes/metodo_ponderacion.php");
        
        $count = $posicion+1;
        $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
        WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1  ORDER BY nombre ASC ".$filtro."  ");  
        while($data = mysqli_fetch_array($query)){ 
            
            //DATOS DEL CARGO
            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
            $dataCargo = mysqli_fetch_array($queryCargo);
            
            //DATOS DEL AREA
            $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
            $dataArea = mysqli_fetch_array($queryArea);
            
            //VARIABLES
            $lista_competencias = '';
            $lista_promedios = '';
            $perfiles = explode("," , $dataCargo["perfil"] );
            
            //OBTENEMOS LOS COMPETENCIAS
            //OBTENEMOS LOS COMPETENCIAS
            //OBTENEMOS LOS COMPETENCIAS
            $queryCompetencias = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas 
            WHERE id_evaluado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' GROUP BY id_competencia ");
            while($dataCompetencias = mysqli_fetch_array($queryCompetencias)){
                
                /*
                $promedio_comp_empleado = 0;
                $queryCompet = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas 
                WHERE id_evaluado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' AND id_competencia = '".$dataCompetencias["id"]."' ");
                while($dataCompet = mysqli_fetch_array($queryCompet)){
                    
                    
                    
                }
                */
                
                $queryPromedios = mysqli_query($connect_valoracion,"SELECT SUM(calificacion), COUNT(id) FROM Competencias_Respuestas_Comportamientos 
                WHERE id_evaluado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' 
                AND id_competencia = '".$dataCompetencias["id_competencia"]."' ");
                $dataPromedios = mysqli_fetch_array($queryPromedios);
                $general_competencia = round(($dataPromedios["SUM(calificacion)"]/$dataPromedios["COUNT(id)"]),2);
                $promedio_comp_empleado + $general_competencia;
                
                

                //NOMBRE DE LA COMPETENCIA
                $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataCompetencias["id_competencia"]."' ");
                $dataComp = mysqli_fetch_array($queryComp);
                
                /*
                $queryPromedios = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos 
                WHERE id_evaluado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' AND id_respuesta = '".$dataCompetencias["id"]."' ");
                $dataPromedios = mysqli_fetch_array($queryPromedios);
                $general_competencia = round(($dataPromedios["SUM(calificacion)"]/$dataPromedios["COUNT(id)"]),2);
*/
                
                $lista_competencias .= $dataComp["nombre"].' <br>';
                //$lista_promedios .= round($ponderacion_empleado["datos"]["total"] , 2)."<br>";
                $lista_promedios .= $general_competencia."<br>";

            }
            
            if($lista_competencias == ""){
                $lista_competencias = "N.T.";
            }
            
            if($lista_promedios == ""){
                $lista_promedios = "N.T.";
            }
 
            echo '
                <tr>
                    <td>'.$count.'</td>
                    <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                    <td>'.$dataCargo["nombre"].'</td>
                    <td>'.$dataArea["nombre"].'</td>      
                    <td>
                        '.$lista_competencias.'<br>
                    </td>
                    <td>
                        '.$lista_promedios.'
                    </td>
                </tr>
            ';
        
            $count++;

 
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



