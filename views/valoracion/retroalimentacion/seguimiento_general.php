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
      <li class="breadcrumb-item"><a href="?pg=valoracion/retro_general">Seguimiento Retroalimentación</a></li>
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
                        
                        
                        
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["created_at"].' </td>
                            <td>'.$queryComen->num_rows.'</td>
                            <td>'.$text_estado.'</td>
                            
                            <td align="center">
                                <a href="?pg=valoracion/retroalimentacion/detalle_lectura&e='.$e.'&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
                                    Ver
                                </button>
                                </a>

                                <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" onclick="Cambiar_Estado('.$data["id"].')" >
                                    Editar
                                </button>
                                
                                <button type="button" id="sidebarCollapse" class="btn btn-danger btn-sm" onclick="BorrarRegistro('.$data["id"].')" >
                                    Borrar
                                </button>

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
  
    
    var api = '<?php echo $url; ?>/api/valoracion/';
    
    var activar = false;
    function BorrarRegistro(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar una retroalimentación, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; BorrarRegistro('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_retroalimentacion.php",
                type:'post',
                data: {id: id, url:"?pg=valoracion/retroalimentacion/seguimiento_general&e=<?php echo $e; ?>"},
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
    
    function Cambiar_Estado(id){
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de cambiar el estado de la retroalimentación a En Creación, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Cambiar_Estado('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"cambiar_estado_retroalimentacion.php",
                type:'post',
                data: {id: id, url:"?pg=valoracion/retroalimentacion/seguimiento_general&e=<?php echo $e; ?>"},
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



