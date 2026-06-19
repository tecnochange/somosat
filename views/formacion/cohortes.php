<script>  
$(document).ready(function(){
    $("#bt_formacion_cohortes").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 
	$hoy = date("Y-m-d");

	if($_POST["id_proceso_cohorte"] != ""){
		foreach ($_POST["empleados"] as &$valor) {
			mysqli_query($connect_formacion,"INSERT INTO Cohortes (id_proceso, id_empleado , estado, created_at) 
			VALUES 
			( '".$_SESSION["id_proceso_edit"]."', '".$valor."', '1', '".$hoy."' ) ");
		}
		echo '<script> location.href = "?pg=formacion/cohortes"; </script>';
	}


	if($_POST["id_proceso"]){
		$_SESSION["id_proceso_edit"] = $_POST["id_proceso"];
	}


	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_formacion,"SELECT * FROM Procesos 
	WHERE id = '".$_SESSION["id_proceso_edit"]."' ");
	$data = mysqli_fetch_array($query);
?>



<div class="modal" role="dialog" id="modal_empleados">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Asociar participantes</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="cont_modal">
            
            <form action="" method="post">
            <input type="hidden" name="id_proceso_cohorte" value="<?php echo $_SESSION["id_proceso_edit"]; ?>" />
            <div class="row">
            	
                <div class="col-md-12" style="margin-top:15px" >

                    <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                              <th>#</th>
                              <th>Nombre</th>
                              <th>Cargo</th>
                              <th style="text-align: center;" width="30"><input type="checkbox" onclick="Seleccionar_Todo(this)"></th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                        <?php
                            $count = 1;
                            $queryEmple = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 ORDER BY nombre ASC");
                            while($dataEmpl = mysqli_fetch_array($queryEmple)){
                                
                                $queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataEmpl["id"]."' " );  
                                $dataAdd = mysqli_fetch_array($queryAdd);
                                $participante="";
                                if($dataAdd["preferencia"] !== ""){
                                    $participante = strtoupper($dataAdd["preferencia"]." ".$dataEmpl["apellidos"]." ".$dataEmpl["apellidos_2"]);
                                }else{
                                    $participante = strtoupper($dataEmpl["nombre"].' '.$dataEmpl["nombre_2"]." ".$dataEmpl["apellidos"]." ".$dataEmpl["apellidos_2"]);
                                }
                                

                                $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEmpl["id_cargo"]."' ");
                                $dataCargo = mysqli_fetch_array($queryCargo);

                                
                                $queryVal = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$dataEmpl["id"]."' AND id_proceso = '".$_SESSION["id_proceso_edit"]."' ");
                                if( $queryVal->num_rows == 0 ){
									
									
							
                                    echo '
                                        <tr>
                                          <th scope="row">'.$count.'</th>
                                          <td>'.$participante.'</td>
                                          <td>'.$dataCargo["nombre"].' </td>
                                          <td align="center">
                                            <input type="checkbox" class="chequeado" name="empleados[]" value="'.$dataEmpl["id"].'">
                                          </td>
                                        </tr>
                                    ';
                                    $count++;
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                    </div>
                    
                </div>


				<div class="col-md-12" style="margin-top:15px" >
                	<input type="submit" class="btn btn-danger btn-md bnt-block" value="Relacionar participantes"  />
                </div>
        
            </div>
            </form>
            
          </div>
          <div class="modal-footer" id="botones_modal">

          </div>
        </div>
      </div>
</div>




<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Participantes: <?php echo $data["nombre"]; ?></h2></td>
				<td align="right" width="200">
					<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />

				</td>
			</tr>
		</table>
	</div>
	
	<div style="margin-bottom: 15px">
		<form action="" method="post" id="formulario_filtrar">
                    <select class="form-control" name="id_proceso" onChange="Filtrar()">
                        <option value="0">Seleccione Proceso..</option>
                        <?php
                        $queryProc = mysqli_query($connect_formacion,"SELECT * FROM Procesos ORDER BY nombre ASC ");  
                        while($dataProc = mysqli_fetch_array($queryProc)){
                            if($_SESSION["id_proceso_edit"] == $dataProc["id"] ){
                                echo '<option value="'.$dataProc["id"].'" selected>'.$dataProc["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataProc["id"].'">'.$dataProc["nombre"].' </option>';
                            }
                        }
                        ?>
                    </select>
		</form>
    </div>
	

	<?php if( $_SESSION["id_proceso_edit"] ){ ?>
	<div class="table-responsive">
    <table class="table">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col">Participante</th>
				<th scope="col">Cargo</th>
				<th scope="col">Certificados</th>
                <th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                    <input type="button" class="btn btn-danger btn-sm" value="Agregar" data-bs-target="#modal_empleados" data-bs-toggle="modal" style="margin-bottom: 10px"/>
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;
                $query = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_proceso = '".$_SESSION["id_proceso_edit"]."' ");  
                while($data = mysqli_fetch_array($query)){ 
                    
                    $queryParticipante = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");  
					$dataParticipante = mysqli_fetch_array($queryParticipante);
					
					$queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataParticipante["id_cargo"]."' "); 
					$dataCargo = mysqli_fetch_array($queryCargo);
   
                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
                        
                    $bt_editar = '';
					$bt_responsables = '';
                    if($user_log["role"] == 1){
                        $bt_eliminar = '
                        	<button type="button" class="btn btn-danger btn-sm" title="Eliminar" onclick="Eliminar('.$data["id"].')">
                                    <i class="bx bx-trash"></i>
                            </button>
                        ';
                    }
					
					$lista_certificados = "";
									$queryCertificado = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_empleado = '".$data["id_empleado"]."' AND id_proceso = '".$data["id_proceso"]."' "); 
									while($dataCertificado = mysqli_fetch_array($queryCertificado)){
										$lista_certificados .= '<div>
											<a href="'.$url.'/recursos/'.$dataCertificado["archivo"].'" 	target="_blank">'.$dataCertificado["archivo"].'</a>
										</div>';
									}
                            
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$dataParticipante["nombre"].' '.$dataParticipante["apellidos"].'</td>
                            <td>'.$dataCargo["nombre"].'</td>
							<td>'.$lista_certificados.'</td>
							<td>'.$txt_estado.'</td>
                            <td  align="center">
                                '.$bt_eliminar.' '.$bt_cargar.'
                            </td>
                        </tr>
                        
                    ';
                    $count++;
                }
            ?>
        </tbody>
    </table>
	</div>
	<?php } ?>
	
</div>
<script>  
	$(document).ready(function(){
		$("#buscador").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$(".tabla_lista tr").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});	
	});
	
	function Seleccionar_Todo(val2){
		if( $(val2).prop('checked') == true ){
			$('.chequeado').prop('checked', true);
		}
		else{
			$('.chequeado').prop('checked', false);
		}
	}
	
	function Filtrar(){
		$("#formulario_filtrar").submit();
	}
	
	var urls = "<?php echo $url; ?>/api/";
	var activar = false;
	//GUARDAR ACADEMICO
	function Eliminar(val){	
	
		if(activar == false){
			$("#modal_borrar").modal("show");
	
			$("#cont_modal_").html('Esta a punto de eliminar un colaborador de esta cohorte ¿Esta seguro?');
				
			$("#botones_modal").html('<button type="button" class="btn btn-danger" onclick="activar = true; Eliminar('+val+')">Eliminar</button>');
			$("#botones_modal").append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
		}
		
		else{	
			jQuery.ajax({
				url: urls+"formacion/eliminar_estudiante_cohorte.php",
				type:'post',
				data: {id:val, url:'?pg=formacion/cohortes'},
				}).done(function (resp){
					//$("this").hide();	
					$("#xscript").html(resp);
				})
				.fail(function() {
				})
				.always(function(resp){
				}
			);	
		}
	}
</script>
