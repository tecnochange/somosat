<script>  
$(document).ready(function(){
    $("#bt_formacion_seguimiento").addClass("active_item");
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


<div class="container-fluid">

	<div align="left" class="cabecera_interna">
		<table width="100%">
			<tr>
				<td><h2>Seguimiento</h2></td>
				<td align="right" width="200">
					<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />

				</td>
			</tr>
		</table>
	</div>
	

	<div class="table-responsive">
    <table class="table">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col">Participante</th>
				<th scope="col">Cargo</th>
				<th scope="col"># Procesos</th>
				<th scope="col"># Certificados</th>
                <th scope="col" width="100" align="center">
                    Acciones
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;
                $query = mysqli_query($connect_formacion,"SELECT * FROM Cohortes GROUP BY id_empleado ");  
                while($data = mysqli_fetch_array($query)){ 
                    
                    $queryParticipante = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["id_empleado"]."' ");  
					$dataParticipante = mysqli_fetch_array($queryParticipante);
					
					$queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataParticipante["id_cargo"]."' "); 
					$dataCargo = mysqli_fetch_array($queryCargo);
					
					$queryProcesos = mysqli_query($connect_formacion,"SELECT * FROM Cohortes WHERE id_empleado = '".$data["id_empleado"]."' ");
					
					$queryCertificado = mysqli_query($connect_formacion,"SELECT * FROM Certificados WHERE id_empleado = '".$data["id_empleado"]."' "); 
   
                    $bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                        	 <a href="'.$url.'?pg=formacion/estudiante/detalle&id='.$data["id_empleado"].'">
                                <button type="button" class="btn btn-success btn-sm" title="Detalle Colaborador">
                                    <i class="bx bx-file"></i>
                                </button>
                            </a>
                        ';
                    }
                            
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$dataParticipante["nombre"].' '.$dataParticipante["apellidos"].'</td>
                            <td>'.$dataCargo["nombre"].'</td>
							<td>
								<span class="badge bg-primary">
								'.$queryProcesos->num_rows.'
								</span>
							</td>
							<td>
								<span class="badge bg-success">
								'.$queryCertificado->num_rows.'
								</span>
							</td>
                            <td  align="center">
                                '.$bt_editar.' '.$bt_cargar.'
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
				
			$("#botones_modal").html('<button type="button" class="btn btn-danger" onclick="activar = true; Eliminar_Encuestado('+val+')">Eliminar</button>');
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
