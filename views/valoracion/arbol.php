<script>  
$(document).ready(function(){
    $("#bt_val_arbol").addClass("active_item");
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}

    include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();
?>

<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<?php
	//include("app/models/Collaborators.php");
	//$ClassCollaborators = new Collaborators();
	//$colaboradores = $ClassCollaborators->lista_colaboradores($connect_valentina, 1);
?>

<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Arbol de Valoración <b><?php echo $_SESSION["anio"]; ?></b> Ciclo: <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    
                    <td align="right" style="display: none">
                        <a href="<?php echo $url; ?>?pg=valoracion/replicas/arbol_replicar">
                        <button type="button" class="btn btn-warning btn-sm">
                            Replicar Ciclo Anterior
                        </button>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        
        <?php if( $_SESSION['ciclo'] != "" ){ ?>
        <div class="col-md-12">

            <table class="table table-bordered" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Área/Proceso</th>
                    <th scope="col">Evaluadores</th>
                    <th scope="col" width="30"></th>
                </tr>
                </thead>

                <tbody id="tabla_lista">
                <?php
                $count = 1;
                $array_colaboradores = $ClassColaboradores->lista_colaboradores_nuevo( $connect_valentina, 1 );
				foreach($array_colaboradores as $colaborador){
					
					$lista_evaluadores = '';
					$queryJefes = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
					WHERE id_empleado = '".$colaborador["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' AND anio = '".$_SESSION['anio']."' ");  
					while($dataJefes = mysqli_fetch_array($queryJefes)){
                            $queryEm = mysqli_query($connect_valentina,"SELECT emp.id, emp.nombre, emp.nombre_2, emp.apellidos, emp.apellidos_2, ad.preferencia FROM Empleados as emp 
                            INNER JOIN Empleados_Adicionales as ad 
                            on ad.id_empleado = emp.id 
                            WHERE emp.id = '".$dataJefes["id_evaluador"]."' ");  
                            $dataEm = mysqli_fetch_array($queryEm);

                            if($dataEm["preferencia"]){
                                $nombreCompletoEmp = $dataEm["preferencia"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"];
                            }else{
                                $nombreCompletoEmp = $dataEm["nombre"]." ".$dataEm["nombre_2"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"];
    
                            }

                            $tipo_txt = '';
                            foreach($array_Tipo_Colaborador as $tipo){
                                if($tipo[0] == $dataJefes["tipo"]){
                                    $tipo_txt =  $tipo[1];
                                }
                            }
                            
                            $queryEvaluacion = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE id_evaluador = '".$dataJefes["id_evaluador"]."' AND id_evaluado = '".$colaborador["id"]."' 
                            AND id_ciclo = '".$_SESSION['ciclo']."' AND estado = 2  ");
                            
                            $bt_eliminar = '
                                <button type="button" id="sidebarCollapse" class="btn btn-danger btn-sm" title="Quitar Evaluador - Sin Evaluaciones" style=" float: right; font-size: 12px; padding: 3px 5px;" onclick="Elimimar_Evaluador('.$dataJefes["id"].')">
                                        <i class="fas fa-times"></i> 
                                </button>
                            ';
                            if($queryEvaluacion->num_rows > 0){
                                $bt_eliminar = '';
                            }
                            
                            $lista_evaluadores .= '
                                <div style="margin-bottom: 10px;" data-value=" '.$dataJefes["id_evaluador"].' - '.$_SESSION['ciclo'].' ">
                                    '.$nombreCompletoEmp.' - '.$tipo_txt.'
                                    '.$bt_eliminar.'
                                </div>
                            ';
					}
                        
					echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td class="align-middle">'.$colaborador["nombre_completo"].'</td>
                            <td class="align-middle">'.$colaborador["cargo_nombre"].'</td>
                            <td class="align-middle">'.$colaborador["area_nombre"].'</td>
                            <td>
                                '.$lista_evaluadores.'
                            </td>
                            
                            <td >
                                <a href="'.$url.'?pg=valoracion/arbol/agregar&id='.$colaborador["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" title="Asignar avaluador">
                                    <i class="fas fa-plus"></i> 
                                </button>
                                </a>
                            </td>
                        </tr>
                        
					';
					$count++;
				}
                ?>
                </tbody>
            </table>
            
            
            
        </div>
        <?php }else{ ?>
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                Para realizar este proceso primero debe seleccionar un año y ciclo.
            </div>
        </div>
        <?php } ?>
    
    </div>
</div>



<script>
    var api = '<?php echo $url; ?>/api/valoracion/';
    
    var activar = false;
    function Elimimar_Evaluador(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un evaluador, ESTO ELIMINARÁ LAS EVALUACIONES QUE REALIZÓ EL EVALUADOR. esta acción es irreversible ¿está seguro?<br><br>');
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



