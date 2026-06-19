<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_mis_objetivos").addClass("active_item");
    
    $('.custom-scrollbar').animate({ scrollTop: $('#bt_desempenio_administrar').offset().top - 500 }, 1000);
});
</script>

<?php

    $hoy = date("Y-m-d H:i:s");
    if( $_POST["solicitar_aprobacion"] != "" ){
        if( $_POST["id_registro_aprobacion"] != "" ){
            
            mysqli_query($connect_desempenio,"UPDATE Aprobaciones_Objetivos SET 
            estado = 1 WHERE id = '".$_POST["id_registro_aprobacion"]."' ");
            echo '<script> window.location.href = "?pg=desempenio/objetivos_colaborador&id='.$_POST["id_registro"].'";</script>';
            
        }
        else{
            
            mysqli_query($connect_desempenio,"INSERT INTO Aprobaciones_Objetivos ( anio, id_empleado , id_jefe, estado, created_at) 
            VALUES ( '".$_SESSION['anio']."',  '".$_SESSION['id_user']."', '".$_POST['id_jefe']."', 1, '".$hoy."' )");
            $id_temp = mysqli_insert_id($connect_desempenio);
            echo '<script> window.location.href = "?pg=desempenio/mis_objetivos";</script>';
        }
    }

    $queryJefe = mysqli_query($connect_valentina,"SELECT Empleados.nombre AS nombre_jefe, Empleados.id AS id_jefe 
    FROM Jefes 
    LEFT JOIN Empleados ON Empleados.id = Jefes.id_jefe
    WHERE Jefes.id_empleado = '".$_SESSION['id_user']."' ");
    $dataJefe = mysqli_fetch_array($queryJefe);

    $queryVal = mysqli_query($connect_desempenio,"SELECT * FROM Aprobaciones_Objetivos WHERE id_empleado = '".$_SESSION['id_user']."' AND anio = '".$_SESSION['anio']."' ");
    $dataVal = mysqli_fetch_array($queryVal);

	$css_edit = "";
	if($_SESSION['anio'] < 2022){
		$css_edit = "display: none";
	}

	 $queryPonderado = mysqli_query($connect_desempenio,"SELECT SUM(ponderado) FROM Objetivos_Colaborador 
     WHERE anio = '".$_SESSION['anio']."' AND id_empleado = '".$_SESSION['id_user']."' ORDER BY id ASC "); 
     $dataPonderado = mysqli_fetch_array($queryPonderado);
	
	$alerta = '';
	if($dataPonderado["SUM(ponderado)"] < 100){
		$alerta = '
		<div class="alert alert-warning" role="alert">
		  Debe completar el 100% de los ponderados. En el momento llega a '.$dataPonderado["SUM(ponderado)"].'%
		</div>
		';
	}

	if($dataPonderado["SUM(ponderado)"] > 100){
		$alerta = '
		<div class="alert alert-danger" role="alert">
		  Supera el 100% de los ponderados. En el momento llega a '.$dataPonderado["SUM(ponderado)"].'%
		</div>
		';
	}
	if($dataPonderado["SUM(ponderado)"] == 100){
		$alerta = '
		<div class="alert alert-success" role="alert">
		  100% de los ponderados
		</div>
		';
	}

?>

<!-- CABECERA -->
<div class="container-fluid" >
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Gestión del Desempeño</li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=desempenio/mis_objetivos">Mis Objetivos <?php echo $_SESSION["anio"]; ?></a></li>
                    <li class="breadcrumb-item active">Detalle</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12" style="margin-bottom: 20px">
            <table width="100%">
                <tr>
                    <td>
                        <h2>
                            Mis Objetivos para el <?php echo $_SESSION["anio"]; ?>
                        </h2>
                        
                    </td>
                    <td align="right">
                        <a href="<?php echo $url; ?>/?pg=desempenio/objetivo/detalle" style="<?php echo $css_edit; ?>">
                        <button type="button" class="btn btn-primary" title="Nuevo" >
                            Agregar Nuevo
                        </button>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-12">
			
			<?php echo $alerta; ?>
            
            <?php
            $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
            WHERE anio = '".$_SESSION['anio']."' 
            AND id_empleado = '".$_SESSION['id_user']."' ORDER BY id ASC "); 
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
					<h5><b>Ponderado: <?php echo $data["ponderado"]; ?>%</b></h5>
                    
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
                                    <button type="button" class="btn btn-success btn-sm" title="Editar" style="<?php echo $css_edit; ?>" >
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                            </td>
                            </tr>

                        </table>
                    
                </div>
            </div>
            <?php } ?>
            <?php if($query->num_rows == 0){ ?>
            <div class="alert alert-warning" role="alert" align="center">
                No tiene objetivos creados para el año <?php echo $_SESSION['anio']; ?><br>
                <h3>Antes de crear sus objetivos tenga en cuenta lo siguiente:</h3>
                <h6>
                    Recuerde que las metas y objetivos que plantea deben cumplir con los siguientes requerimientos:<br><br>

                    Específicos: Concreto y lo entienden con claridad todos los involucrados.<br>
                    Medibles: Es posible cuantificar los avances periódicos y total del objetivo.<br>
                    Alcanzables: Es ambicioso pero realista.<br>
                    Relevantes: Esta alineado con los Objetivos de la Organización.<br>
                    Basados en el Tiempo: Se puede lograr durante el periodo de evaluación.<br>
                </h6>
            </div>
            <?php } ?>
            

            <!-- APROBACION OBJETIVOS -->
            <?php if($query->num_rows > 0 && $queryVal->num_rows == 0 ){ ?>
            <form action="" method="post">
                
                <input type="hidden" name="solicitar_aprobacion" value="true">
                <input type="hidden" name="id_jefe" value="<?php echo $dataJefe["id_jefe"]; ?>">

                <?php if($queryJefe->num_rows > 0){ ?>
                <button type="submit" class="btn btn-danger btn-block" title="Editar"  style="margin-top: 20px">
                    Enviar para Aprobación a <?php echo $dataJefe["nombre_jefe"]; ?>
                </button>
                <?php } else{ ?>
                
                <div class="alert alert-danger" role="alert" align="center">
                  Sin Jefe Asignado
                </div>

                <?php } ?>
                
            </form>
            <?php } ?>
            
        </div>
        
    
    </div>
</div>



<script>
    

    
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



