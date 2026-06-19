<?php
    $hoy = date("Y-m-d H:i:s");

    if($_POST["guardar_replicar"] != ""){
        $queryEvalTmp = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_ciclo = '".$_POST["id_ciclo_anterior"]."' ");  
        while($dataEvalTmp = mysqli_fetch_array($queryEvalTmp)){
            mysqli_query($connect_valoracion,"INSERT INTO Evaluadores (id_empresa, anio, id_ciclo, id_empleado, id_evaluador, tipo, created_at) 
            VALUES 
            ('".$_SESSION['id_empresa']."', '".$_SESSION['anio']."', '".$_SESSION['ciclo']."', '".$dataEvalTmp["id_empleado"]."', '".$dataEvalTmp["id_evaluador"]."', '".$dataEvalTmp["tipo"]."', '".$hoy."' ) "); 
        }

        echo '<script> window.location = "'.$url.'?pg=valoracion/arbol"; </script>';
    }
    


    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);

    $queryCicloAnterior = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id != '".$_SESSION['ciclo']."' AND id < '".$_SESSION['ciclo']."'  AND id_empresa = '".$_SESSION['id_empresa']."'  ORDER BY id DESC ");
    $dataCicloAnterior = mysqli_fetch_array($queryCicloAnterior);

?>



<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%" style="margin-bottom: 10px">
                <tr>
                    <td>
                        <h2>Replicar Arbol de Valoración para el año <b><?php echo $_SESSION["anio"]; ?></b> de Ciclo: <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right">
                        <a href="<?php echo $url; ?>?pg=valoracion/arbol">
                        <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </button>
                        </a>
                    </td>
                    
                </tr>
            </table>
        </div>
        
        <?php if( $_SESSION['anio'] != "" ){ ?>
        
        <?php if($queryCicloAnterior->num_rows > 0){ ?>
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-body">
                    <h1>Ciclo Anterior: <b><?php echo $dataCicloAnterior["nombre"]; ?></b></h1>
                    
                    <div>
                        <div style="color: #DD0003; font-size: 18px; margin-bottom: 15px">
                            Procure utilizar este proceso con moderadación.<br>una vez completado deberá realizar los borrados de forma manual en caso de errores humanos como dobles replicas.
                        </div>
                        <form action="" method="post">
                        <input type="hidden" name="guardar_replicar" value="true">
                        <input type="hidden" name="id_ciclo_anterior" value="<?php echo $dataCicloAnterior["id"]; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">
                            Confirmar Replicar Ciclo Anterior
                        </button>
                        </form>
                    </div>
                    
                    <table class="table table-bordered table-sm" style="margin-top: 15px">
                        <thead class="thead-success">
                        <tr>
                            <th scope="col" width="15">#</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Evaluadores</th>
                        </tr>
                        </thead>

                        <tbody id="tabla_lista">
                        <?php
                            $count = 1;
                            $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
                            WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ");  
                            while($data = mysqli_fetch_array($query)){ 
                                
                                $lista_evaluadores = '';
                                $queryJefes = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
                                WHERE id_empleado = '".$data["id"]."' AND id_ciclo = '".$dataCicloAnterior["id"]."'  ");  
                                while($dataJefes = mysqli_fetch_array($queryJefes)){
                                    
                                    $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataJefes["id_evaluador"]."' ");  
                                    $dataEm = mysqli_fetch_array($queryEm);
                                    
                                    $tipo_txt = '';
                                    foreach($array_Tipo_Colaborador as $tipo){
                                        if($tipo[0] == $dataJefes["tipo"]){
                                            $tipo_txt =  $tipo[1];
                                        }
                                    }
                                    
                                    $lista_evaluadores .= ' '.$dataEm["nombre"]." ".$dataEm["apellidos"].' - '.$tipo_txt.'<br>';
                                }
                                
                                if($lista_evaluadores == ""){
                                    $lista_evaluadores = "Sin Evaluadores";
                                }
                                
                                echo '
                                <tr>
                                    <td>'.$count.'</td>
                                    <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                                    <td>
                                        '.$lista_evaluadores.'
                                    </td>

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
        <?php } else{ echo '<div align="center" style="width: 100%;">No hay ciclo anterior</div>'; } ?>
        
        <?php } ?>
    </div>



<script>
  
    $("#bt_val_arbol").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();


    
    
    
    var api = '<?php echo $url; ?>api/valoracion/';
    
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



