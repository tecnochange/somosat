<script>  
$(document).ready(function(){
    $("#bt_formacion_gestionar").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre"] != ""){

		if($_POST["id_registro"] != ""){
			$sentencia = "
			UPDATE Procesos SET  
			nombre = '".$_POST["nombre"]."', tipo_capacitacion = '".$_POST["tipo_capacitacion"]."', id_marca = '".$_POST["id_marca"]."', 
			interno_externo = '".$_POST["interno_externo"]."', vence = '".$_POST["vence"]."', fecha_alarma = '".$_POST["fecha_alarma"]."', 
			motivo = '".$_POST["motivo"]."', carga_horaria = '".$_POST["carga_horaria"]."', 
			requiere_actividad = '".$_POST["requiere_actividad"]."', cual = '".$_POST["cual"]."', 
			costo = '".$_POST["costo"]."', valor = '".$_POST["valor"]."', descripcion = '".$_POST["descripcion"]."', 
			proveedor = '".$_POST["proveedor"]."', divisa_proveedor = '".$_POST["divisa_proveedor"]."', costo_proveedor = '".$_POST["costo_proveedor"]."', reembolsable = '".$_POST["reembolsable"]."',
			cupos = '".$_POST["cupos"]."', 
			certificado_insignia = '".$_POST["certificado_insignia"]."', fecha_inicia = '".$_POST["fecha_inicia"]."', 
			fecha_termina = '".$_POST["fecha_termina"]."', anio = '".$_POST["anio"]."',  
			validez_meses = '".$_POST["validez_meses"]."', 
			comentarios = '".$_POST["comentarios"]."', 
			estado = '".$_POST["estado"]."' 
			WHERE  id = '".$_POST["id_registro"]."'
			";

			mysqli_query($connect_formacion, $sentencia);
  
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
		}
		else{
			$sentencia = "
			INSERT INTO Procesos ( nombre , tipo_capacitacion,  id_marca , interno_externo , vence , fecha_alarma , motivo ,  carga_horaria , requiere_actividad , cual , costo , valor, descripcion , proveedor , divisa_proveedor, costo_proveedor, reembolsable, cupos ,  certificado_insignia , fecha_inicia , fecha_termina , anio, validez_meses, comentarios , estado , created_at ) 
			VALUES 
			( '".$_POST["nombre"]."', '".$_POST["tipo_capacitacion"]."', '".$_POST["id_marca"]."', '".$_POST["interno_externo"]."', '".$_POST["vence"]."', '".$_POST["fecha_alarma"]."', '".$_POST["motivo"]."', '".$_POST["carga_horaria"]."',  '".$_POST["requiere_actividad"]."', '".$_POST["cual"]."', '".$_POST["costo"]."', '".$_POST["valor"]."',  '".$_POST["descripcion"]."', '".$_POST["proveedor"]."', '".$_POST["divisa_proveedor"]."', '".$_POST["costo_proveedor"]."', '".$_POST["reembolsable"]."', 
			'".$_POST["cupos"]."', '".$_POST["certificado_insignia"]."', 
			'".$_POST["fecha_inicia"]."', '".$_POST["fecha_termina"]."', '".$_POST["anio"]."', '".$_POST["validez_meses"]."', '".$_POST["comentarios"]."', 
			'".$_POST["estado"]."', '".$hoy."' )
			";
			mysqli_query($connect_formacion, $sentencia);  
			
			//print_r($sentencia);
			
            echo '<script> window.location = "?pg=formacion/gestionar";</script>';//para evitar reinsersion  
		}
        
        
	}

	if($_POST["eliminar_formacion"]){
		$queryValSol = mysqli_query($connect_formacion,"SELECT * FROM Solicitudes WHERE id_proceso = '".$id."' ");
		$queryValCohortes = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_proceso = '".$id."' ");
		
		if($queryValSol->num_rows == 0 && $queryValCohortes->num_rows == 0 ){
			mysqli_query($connect_formacion, " DELETE FROM Procesos WHERE id = '".$id."' "); 
			mysqli_query($connect_formacion, " DELETE FROM Cohortes WHERE id_proceso = '".$id."' "); 
			
			echo '<script> window.location = "?pg=formacion/gestionar";</script>';//para evitar reinsersion
		}
		else{
			$respuesta = '
                <div class="alert alert-danger" role="alert">
                    ¡LO SENTIMOS ESTE PROCESO YA TIENE SOLICITUDES Y PARTICIPANTES RELACIONADOS!
                </div>
            ';
			
		}
		
	}

	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
?>

<div class="container">
 
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/gestionar">Gestionar Procesos</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
		</ol>
	</nav>
    
	<?php echo $respuesta; ?>

	<div class="card">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Proceso</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Nombre de la capacitación *</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>" required>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Tipo capacitación *</label>
                    <select class="form-control" name="tipo_capacitacion" id="tipo_capacitacion" required>
                        <option value="">Selecciona..</option>
						<?php
						$queryTipo = mysqli_query($connect_valentina,"SELECT * FROM Tipo_Capacitacion WHERE estado = 1 ");
						while($dataTipo = mysqli_fetch_array($queryTipo)){
							if($data["tipo_capacitacion"] == $dataTipo["id"] ){
                                echo '<option value="'.$dataTipo["id"].'" selected>'.$dataTipo["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataTipo["id"].'">'.$dataTipo["nombre"].'</option>';
                            }
						}
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Marca *</label>
                    <select class="form-control" name="id_marca" id="id_marca" required>
                        <option value="">Selecciona..</option>
                        <?php
						$queryMarca = mysqli_query($connect_formacion,"SELECT * FROM Marcas WHERE estado = '1' ");
						while($dataMarca = mysqli_fetch_array($queryMarca)){
							if($data["id_marca"] == $dataMarca["id"] ){
                                echo '<option value="'.$dataMarca["id"].'" selected>'.$dataMarca["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataMarca["id"].'">'.$dataMarca["nombre"].'</option>';
                            }
						}
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Interno/externo *</label>
                    <select class="form-control" name="interno_externo" id="interno_externo" required>
                        <option value="">Selecciona..</option>
                        <?php
						foreach($Array_Interno_Externo as $nivel){
                            if($data["interno_externo"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>¿Vence? *</label>
                    <select class="form-control" name="vence" id="vence" required>
                        <option value="">Selecciona..</option>
                        <?php
						foreach($Lista_Si_No as $nivel){
                            if($data["vence"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label>Fecha Alarma (Opcional)</label>
                    <input type="date" class="form-control" name="fecha_alarma" value="<?php echo $data["fecha_alarma"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Motivo *</label>
                    <select class="form-control" name="motivo" id="motivo" required>
                        <option value="">Selecciona..</option>
                        <?php
						foreach($Array_Motivo_Formacion as $nivel){
                            if($data["motivo"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Carga Horaria (En horas)</label>
                    <input type="number" class="form-control" name="carga_horaria" value="<?php echo $data["carga_horaria"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Requiere de actividad *</label>
                    <select class="form-control" name="requiere_actividad" id="requiere_actividad" required>
                        <option value="">Selecciona..</option>
                        <?php
						foreach($Lista_Si_No as $nivel){
                            if($data["requiere_actividad"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>¿Cual? (Si la opción anterior fué SI indique cual)</label>
                    <input type="text" class="form-control" name="cual" value="<?php echo $data["cual"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Moneda AT *</label>
                    <select class="form-control" name="costo" id="costo" required>
                        <option value="">Selecciona..</option>
                        <?php
						foreach($Array_Moneda_Formacion as $nivel){
                            if($data["costo"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Presupuesto AT</label>
                    <input type="number" class="form-control" name="valor" value="<?php echo $data["valor"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Proveedor *</label>
                    <select class="form-control" name="proveedor" id="proveedor" required>
                        <option value="">Selecciona..</option>
                        <?php
						$queryMarca = mysqli_query($connect_formacion,"SELECT * FROM Proveedores WHERE estado = '1' ");
						while($dataMarca = mysqli_fetch_array($queryMarca)){
							if($data["proveedor"] == $dataMarca["id"] ){
                                echo '<option value="'.$dataMarca["id"].'" selected>'.$dataMarca["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataMarca["id"].'">'.$dataMarca["nombre"].'</option>';
                            }
						}
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Moneda Proveedor *</label>
                    <select class="form-control" name="divisa_proveedor" id="divisa_proveedor" required>
                        <option value="">Selecciona..</option>
                        <?php
						foreach($Array_Moneda_Formacion as $nivel){
                            if($data["divisa_proveedor"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Costo Proveedor</label>
                    <input type="number" class="form-control" name="costo_proveedor" value="<?php echo $data["costo_proveedor"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Reembolsable</label>
                    <input type="text" class="form-control" name="reembolsable" value="<?php echo $data["reembolsable"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Cantidad de personas que requiere</label>
                    <input type="number" class="form-control" name="cupos" value="<?php echo $data["cupos"]; ?>">
                </div>
				
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Genera Certificados / Insignias *</label>
                    <select class="form-control" name="certificado_insignia" id="certificado_insignia" required>
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Certificado_Insignia as $nivel){
                            if($data["certificado_insignia"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        
                        ?>
                    </select>
                </div>
				
				
				
				

                
				<div class="col-md-4" style="margin-bottom: 10px; display:none" >
                    <label>Fecha Inicia</label>
                    <input type="date" class="form-control" name="fecha_inicia" value="<?php echo $data["fecha_inicia"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px; display:none">
                    <label>Fecha Termina</label>
                    <input type="date" class="form-control" name="fecha_termina" value="<?php echo $data["fecha_termina"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Año</label>
                    <input type="text" class="form-control" name="anio" value="<?php echo $data["anio"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Validez en meses</label>
                    <input type="number" class="form-control" name="validez_meses" value="<?php echo $data["validez_meses"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Estado *</label>
                    <select class="form-control" name="estado" id="estado" required>
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Estado as $nivel){
                            if($data["estado"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                            
                        }
                        
                        ?>
                    </select>
                </div>
				
				<div class="col-md-12" style="margin-bottom: 10px">
                    <label>Descripción</label>
					<textarea class="form-control" name="descripcion"><?php echo $data["descripcion"]; ?></textarea>
                </div>
				
				
				<div class="col-md-12" style="margin-bottom: 10px">
                    <label>Comentarios</label>
					<textarea class="form-control" name="comentarios"><?php echo $data["comentarios"]; ?></textarea>
                </div>
                
                

                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Guardar
                    </button>
                </div>

            </div>
            </form>
        </div> 
        
	</div>
	<?php if($_SESSION['role_plataforma']  == 1){ ?>
	<div align="right">
	<form action="" method="post" id="form_eliminar">
		<input type="hidden" name="eliminar_formacion" value="true">
		<button type="button" class="btn btn-sm" onClick="Elimimar_Proceso()" >
        	<i class="fas fa-check"></i> Eliminar
        </button>
	</form>
	</div>
	<?php } ?>
</div>

<script>
	var activar_del_pro = false;
	function Elimimar_Proceso(){
		
		if(activar_del_pro == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar este proceso, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar_del_pro = true; Elimimar_Proceso()"> Confirmar </button>');  
        }
        else{
			$("#form_eliminar").submit();
		}
	}
	

    var api = '<?php echo $url; ?>/estilocontigo.app/api/administrar/';

    function CargarNivelJerarquia(id){
        /*
        $('#jerarquia').html('');
        jQuery.ajax({
            url: api+"cargar_niveles_jerarquia.php",
            type:'post',
            data: {id: id},
            }).done(function (resp){
                $("#jerarquia").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp){
            }
        );
        */
    }
    
    var activar = false;
    function Elimimar_Area(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un área, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Area('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_area.php",
                type:'post',
                data: {id: id, url:"?pg=administrar/estructura"},
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

