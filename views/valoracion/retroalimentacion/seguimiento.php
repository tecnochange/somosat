<?php
    $e = $_GET["e"];
    //EVALUADO
    $queryEvaluado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$e."'");
    $dataEva = mysqli_fetch_array($queryEvaluado);
    
    //CARGO
    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEva["id_cargo"]."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);
?>

<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
      <li class="breadcrumb-item"><a href="?pg=valoracion/retro_individual">Retroalimentación Individual</a></li>
      <li class="breadcrumb-item active" aria-current="page">Seguimiento</li>
  </ol>
</nav>

<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                Colaborador: <b><?php echo $dataEva["nombre"]." ".$dataEva["apellidos"]; ?></b> <br>
                Cargo: <b><?php echo $dataCargo["nombre"]; ?></b> <br>
            </div>
        </div>
        
    </div>
</div>


<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Seguimiento</h2>
                    </td>
                    <td align="right">
                    </td>
                </tr>
            </table>
            
        </div>
        
        <div class="col-md-12">

            <table class="table table-bordered" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Comentarios</th>
                    <th scope="col">Estado</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody id="tabla_lista">
                <?php
                    $count = 1;
                    
                    $query = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion WHERE id_empleado = '".$e."' ");  
                    while($data = mysqli_fetch_array($query)){
                        
                        $text_estado = '';
                        foreach($Array_estado_seguimiento_retro as $estado){
                            if( $estado[0] == $data["estado"] ){ $text_estado = $estado[1]; }
                        }
                        
                        $queryComen = mysqli_query($connect_valoracion,"SELECT * FROM Retroalimentacion_Comentarios  WHERE id_retroalimentacion = '".$data["id"]."' ");  
                        
                        $boton_editar = '';
                        if($data["estado"] == 1){
                            $boton_editar = '
                            <a href="?pg=valoracion/retroalimentacion/detalle&e='.$e.'&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
                                    Ver
                                </button>
                                </a>
                        ';
                        }
                        
                        if($data["estado"] >= 2){
                            $boton_editar = '
                            <a href="?pg=valoracion/retroalimentacion/detalle_lectura&e='.$e.'&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
                                    Ver
                                </button>
                                </a>
                        ';
                        }

                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["created_at"].' </td>
                            <td>'.$queryComen->num_rows.'</td>
                            <td>'.$text_estado.'</td>
                            
                            <td>
                                '.$boton_editar.'
                                
                                <a href="?pg=valoracion/retroalimentacion/comentario&e='.$e.'&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" >
                                    Hacer comentario
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
    
    $("#bt_retro_individual").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();

    
    
    var api = '<?php echo $url; ?>api/administrar/';
    
    var activar = false;
    function Elimimar_Jefe(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un jefe, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Jefe('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_jefe.php",
                type:'post',
                data: {id: id, url:"?pg=administrar/jefes"},
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



