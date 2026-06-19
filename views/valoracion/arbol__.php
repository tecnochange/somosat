
<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Arbol Valoración año <b><?php echo $_SESSION["anio"]; ?></b></h2>
                    </td>
                    <td align="right">
                        <a href="<?php echo $url; ?>?pg=administrar/jefe/agregar">
                        <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" style="display: none" >
                            <i class="fas fa-plus"></i> Arbol valoracion
                        </button>
                        </a>
                        
                        <button type="button" id="sidebarCollapse" class="btn btn-info btn-sm" title="Imprimir o Guardar en PDF" >
                            <i class="fas fa-print"></i>
                        </button>
                        
                    </td>
                </tr>
            </table>
            
        </div>

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
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' AND role > 1 ORDER BY nombre ASC ");  
                    while($data = mysqli_fetch_array($query)){ 
                        
                         
                        
                        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
                        $dataCargo = mysqli_fetch_array($queryCargo);
                        /*
                        mysqli_query($connect_valoracion,"INSERT INTO Perfiles_Cargos (anio, id_empresa, id_cargo, perfiles, created_at) 
                         VALUES 
                         ('".$_SESSION['anio']."', '".$_SESSION['id_empresa']."', '".$data['id_cargo']."', '".$dataCargo['perfil']."', '2022-04-10 10:00:00' )  ");
                        */
                        $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."' ");  
                        $dataArea = mysqli_fetch_array($queryArea);
                        
                        $lista_evaluadores = '';
                        $queryJefes = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
                        WHERE id_empleado = '".$data["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
                        while($dataJefes = mysqli_fetch_array($queryJefes)){
                            $queryEm = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataJefes["id_evaluador"]."' ");  
                            $dataEm = mysqli_fetch_array($queryEm);

                            $tipo_txt = '';
                            foreach($array_Tipo_Colaborador as $tipo){
                                if($tipo[0] == $dataJefes["tipo"]){
                                    $tipo_txt =  $tipo[1];
                                }
                            }
                            
                            $queryEvaluacion = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_evaluador = '".$dataJefes["id_evaluador"]."' AND id_evaluado = '".$data["id"]."' 
                            AND id_ciclo = '".$_SESSION['ciclo']."' AND estado = 2  ");
                            
                            $bt_eliminar = '
                                <button type="button" id="sidebarCollapse" class="btn btn-danger btn-sm" title="Quitar Evaluador" style=" float: right; font-size: 12px; padding: 3px 5px;" onclick="Elimimar_Evaluador('.$dataJefes["id"].')">
                                        <i class="fas fa-times"></i> 
                                </button>
                            ';
                            if($queryEvaluacion->num_rows > 0){
                                $bt_eliminar = '';
                            }
                            
                            $lista_evaluadores .= '
                                <div style="margin-bottom: 10px;" data-value=" '.$dataJefes["id_evaluador"].' - '.$_SESSION['ciclo'].' ">
                                    '.$dataEm["nombre"]." ".$dataEm["apellidos"].' - '.$tipo_txt.'
                                    '.$bt_eliminar.'
                                </div>
                            ';
                        }
                        
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].' '.$data["apellidos"].'</td>
                            <td>'.$dataCargo["nombre"].'</td>
                            <td>'.$dataArea["nombre"].'</td>
                            <td>
                                '.$lista_evaluadores.'
                            </td>
                            
                            <td >
                                <a href="'.$url.'?pg=valoracion/arbol/agregar&id='.$data["id"].'">
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

    
    </div>
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



