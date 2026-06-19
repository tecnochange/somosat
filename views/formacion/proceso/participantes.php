<script>  
$(document).ready(function(){
    $("#bt_formacion_gestionar").addClass("active_item");
    $("#formacion_menu").addClass("active");
    $('#formacion_menu .collapse').collapse();
});
</script>

<?php 

    include("app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();

	$hoy = date("Y-m-d");
	$id = $_GET["id"];

	if($_POST["id_proceso_cohorte"] != ""){
		foreach ($_POST["empleados"] as &$valor) {
			mysqli_query($connect_formacion,"INSERT INTO Cohortes (id_proceso, id_empleado , estado, created_at) 
			VALUES 
			( '".$id."', '".$valor."', '1', '".$hoy."' ) ");
		}
		echo '<script> location.href = "?pg=formacion/proceso/participantes&id='.$id.'"; </script>';
	}


	


	//INFORMACION DE LA BATERIA
	$queryProceso = mysqli_query($connect_formacion,"SELECT * FROM Procesos 
	WHERE id = '".$id."' ");
	$dataProceso = mysqli_fetch_array($queryProceso);
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
            <input type="hidden" name="id_proceso_cohorte" value="<?php echo $id; ?>" />
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
                            $array_colaboradores = $ClassColaboradores->lista_colaboradores_nuevo( $connect_valentina, 1 );
                            foreach($array_colaboradores as $data){

                                $queryVal = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$data["id"]."' AND id_proceso = '".$id."' ");
                                if( $queryVal->num_rows == 0 ){

                                    echo '
                                        <tr>
                                          <th scope="row">'.$count.'</th>
                                          <td>'.$data["nombre_completo"].' </td>
                                          <td>'.$data["cargo_nombre"].' </td>
                                          <td align="center">
                                            <input type="checkbox" class="chequeado" name="empleados[]" value="'.$data["id"].'">
                                          </td>
                                        </tr>
                                    ';
                                    $count++;
                                }

                            }

                            /*
                            $queryEmple = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 ORDER BY nombre ASC");
                            while($dataEmpl = mysqli_fetch_array($queryEmple)){


                                
                                $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEmpl["id_cargo"]."' ");
                                $dataCargo = mysqli_fetch_array($queryCargo);

                                
                                $queryVal = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$dataEmpl["id"]."' AND id_proceso = '".$id."' ");
                                if( $queryVal->num_rows == 0 ){

                                    echo '
                                        <tr>
                                          <th scope="row">'.$count.'</th>
                                          <td>'.$dataEmpl["nombre"].' '.$dataEmpl["apellidos"].'</td>
                                          <td>'.$dataCargo["nombre"].' </td>
                                          <td align="center">
                                            <input type="checkbox" class="chequeado" name="empleados[]" value="'.$dataEmpl["id"].'">
                                          </td>
                                        </tr>
                                    ';
                                    $count++;
                                }
                            }
                                */
                        ?>
                        </tbody>
                    </table>
                    </div>
                    
                </div>


				<div class="col-md-12" style="margin-top:15px" >
                	<input type="submit" class="btn btn-danger btn-md bnt-block" value="Relacionar a la cohorte"  />
                </div>
        
            </div>
            </form>
            
          </div>
          <div class="modal-footer" id="botones_modal">

          </div>
        </div>
      </div>
</div>




<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=formacion/gestionar">Gestionar Procesos</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Participantes</a></li>
		</ol>
	</nav>

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td>
					<h2>Participantes:  <?php echo $dataProceso["nombre"]; ?></h2>
				</td>
				<td align="right" width="200">
					<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />

				</td>
			</tr>
		</table>
	</div>
	
	<div class="card" style="margin-bottom: 15px">

        <div class="card-body">   
            <div class="row">

                <div class="col-md-12">
					
					Fecha de planificación/ Q: <b><?php echo $dataProceso["fecha_inicia"]; ?></b><br>
					Fecha Termina: <b><?php echo $dataProceso["fecha_termina"]; ?></b><br>
					Fecha de Ejecución: <b><?php echo $dataProceso["created_at"]; ?></b><br>
					Comentarios: <br><b><?php echo $dataProceso["comentarios"]; ?></b>
                </div>
			</div>
		</div>
	</div>
	

	<div class="table-responsive">
    <table class="table">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col">Participante</th>
				<th scope="col">Cargo</th>
				<th scope="col">Certificados</th>
				<th scope="col">Fecha de Evaluación</th>
                <th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                    <input type="button" class="btn btn-danger btn-sm" value="Agregar" data-bs-target="#modal_empleados" data-bs-toggle="modal" style="margin-bottom: 10px"/>
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;
                $query = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_proceso = '".$id."' ");  
                while($data = mysqli_fetch_array($query)){ 

                    $dataParticipante = $ClassColaboradores->colaborador( $connect_valentina, $data["id_empleado"] );
                    
                    //$queryParticipante = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");  
					//$dataParticipante = mysqli_fetch_array($queryParticipante);
					
					//$queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataParticipante[0]["id_cargo"]."' "); 
					//$dataCargo = mysqli_fetch_array($queryCargo);
					
					$select = '<select class="form-control" onchange="CambiarEstado(this, '.$data["id"].' )">
						<option value="">Selecciona..</option>
					';
					foreach($Array_Estado_Procesos as $nivel){
						if($data["estado"] == $nivel[0] ){
							$select .= '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
						}
						else{
							$select .= '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
						}
					}
					$select .= '</select>';	
   
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
						$bt_editar = '
							<a href="'.$url.'?pg=formacion/proceso/detalle_participante&id='.$data["id"].'">
								<button type="button" class="btn btn-success btn-sm" title="Detalle Colaborador">
									<i class="bx bx-file"></i>
								</button>
							</a>
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
                            <td>'.$dataParticipante[0]["nombre_completo"].' </td>
                            <td>'.$dataParticipante[0]["cargo_nombre"].'</td>
							<td>'.$lista_certificados.'</td>
							<td>
								<input type="date" class="form-control" value="'.$data["fecha_evaluacion"].'"  onchange="CambiarFecha(this, '.$data["id"].')" >
							</td>
							<td>'.$select.'</td>
                            <td  align="center">
                                '.$bt_editar.' '.$bt_eliminar.' 
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
	
	function CambiarEstado( elem, id_cohorte ){
		estado = $(elem).val();
		jQuery.ajax({
			url: urls+"formacion/cambiar_estado.php",
			type:'post',
			data: {id_cohorte: id_cohorte, estado: estado,  url:"?pg=administrar/estructura"},
			}).done(function (resp){
				//$("#xscript").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
		);
	}
	
	function CambiarFecha( elem, id_cohorte ){
	fecha = $(elem).val();
	
	jQuery.ajax({
		url: urls+"formacion/cambiar_fecha.php",
		type:'post',
		data: {id_cohorte: id_cohorte, fecha: fecha,  url:"?pg=administrar/estructura"},
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
</script>
