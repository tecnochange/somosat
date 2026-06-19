<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_autorizaciones").addClass("active_item");
    
    $('.custom-scrollbar').animate({ scrollTop: $('#bt_desempenio_administrar').offset().top - 500 }, 1000);
});
</script>

<?php

    $hoy = date("Y-m-d H:i:s");
    $id = $_GET["id"];

    if( $_POST["guardar_estado"] != "" ){
        mysqli_query($connect_desempenio,"UPDATE Aprobaciones_Objetivos SET 
        estado = '".$_POST["estado"]."', observacion = '".$_POST["observacion"]."' WHERE id = '".$id."' ");

        echo '<script> window.location.href = "?pg=desempenio/autorizaciones";</script>';
    }

    $queryAprobacion = mysqli_query($connect_desempenio,"SELECT * FROM Aprobaciones_Objetivos WHERE id = '".$id."' ");
    $dataAprobacion = mysqli_fetch_array($queryAprobacion);

    $queryColaborador = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
    WHERE id = '".$dataAprobacion['id_empleado']."' ");  
    $dataColaborador = mysqli_fetch_array($queryColaborador);                
?>

<!-- CABECERA -->
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Gestión del Desempeño</li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=desempenio/autorizaciones">Autorizaciones</a></li>
                    <li class="breadcrumb-item active">Detalle</li>
                </ol>
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
                        <h2>
                            <?php echo $dataColaborador["nombre"]." ".$dataColaborador["apellidos"]; ?><br>
                            Objetivos de Desempeño para el <?php echo $_SESSION["anio"]; ?>
                        </h2>
                        
                    </td>
                    <td align="right">
                        
                        
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-12">
            
            <?php
            $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
            WHERE anio = '".$dataAprobacion['anio']."' 
            AND id_empleado = '".$dataAprobacion['id_empleado']."' ORDER BY id ASC "); 
            while($data = mysqli_fetch_array($query)){ 
                $obj_meses = json_decode($data["obj_meses"], true); 
            ?>
            
            <div class="card">
                <div class="card-body">
                    
                    <div><b>Objetivo: <?php echo $data["objetivo"]; ?></b></div>
                    <div><b>Indicador:</b> <?php echo $data["indicador"]; ?></div>
                    <div><b>Fecha de Cumplimiento:</b> <?php echo $data["fecha_cumplimiento"]; ?></div>
                    <div><b>Fórmula:</b> <?php echo $data["formula"]; ?></div>
                    <div><b>Fuentes:</b> <?php echo $data["fuente"]; ?></div>
                    
                    <table class="table table-bordered" width="100%" style="margin-top: 15px">
                        <tr>
                            <?php
                            foreach($Array_Meses as $mes){

                                $meta_mes = 0;

                                foreach($obj_meses as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $meta_mes = $meta["meta"];
                                    }
                                }


                                echo '
                                    <td align="center">
                                        '.$mes[1].'<br>
                                        <b>'.$meta_mes.'</b>
                                    </td>
                                ';
                            }
                            ?>
                            <td align="center">
                                Meta<br><b><?php echo $data["meta"]; ?></b>
                            </td>
                            <td align="center">
                            <a href="<?php echo $url; ?>/?pg=desempenio/objetivo/detalle&id=<?php echo $data["id"]; ?>">
                                    <button type="button" class="btn btn-success btn-sm" title="Editar" >
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                            </td>
                            </tr>

                        </table>
                    
                </div>
            </div>
            <?php } ?>

            <!-- ESTADO DE APROBACIÓN -->
            <?php if($dataAprobacion["estado"] == 1 ){ ?>
            <form action="" method="post">
                
                <input type="hidden" name="guardar_estado" value="true">
                <select class="form-control" name="estado" style="margin-top: 20px">
                    <option value="">Selecciona...</option>
                    <option value="2">Aprobar</option>
                    <option value="3">Rechazar</option>
                </select>
                
                <textarea placeholder="Ingresar observación (opcional)..." class="form-control" name="observacion" style="margin-top: 10px"></textarea>

                <button type="submit" class="btn btn-success btn-block" title="Editar"  style="margin-top: 10px; margin-bottom: 25px">
                    Guardar
                </button>
                
            </form>
            <?php } ?>
            
        </div>
        
    
    </div>
</div>



<script>
    
    $("#bt_desempenio_informes").addClass("active_item");
    
    $("#desempenio_menu").addClass("active");
    $('#desempenio_menu .collapse').collapse();

    
    
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



