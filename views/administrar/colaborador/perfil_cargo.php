<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_cargos").addClass("active_item");
});
</script>

<?php
	
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

    //COLABORADOR
	$queryTmp = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_GET["id"]."'  ");
	$dataTmp = mysqli_fetch_array($queryTmp);	

   
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataTmp["id_cargo"]."'  ");
	$data = mysqli_fetch_array($query);	

    $queryDescriptivo = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Descriptivo WHERE id_cargo = '".$dataTmp["id_cargo"]."'  ");
    $dataDescriptivo = mysqli_fetch_array($queryDescriptivo);
?>

<!-- CABECERA -->
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Mi Perfil Cargo</h3>
            </div>
        </div>
    </div>
</div>
          

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">

					<div class="row">
                                
						<div class="col-md-12" style="text-align: center">
							<h5><b>Descripción del cargo</b></h5>
						</div>
                                
						<div class="col-md-12" style="margin-top: 30px">
							<h5>Objetivo del cargo</h5>
						</div>

						<div class="col-md-12" style="margin-bottom: 10px">
							<b><?php echo nl2br( $dataDescriptivo["proposito"] ); ?></b>
						</div>
                                
						<div class="col-md-12" style="margin-top: 10px;">
							<h5>Descripción de Tareas</h5>
						</div>

						<div class="col-md-12" style="margin-bottom: 10px">
							<b><?php echo nl2br( $dataDescriptivo["decisiones_tomar"]); ?></b>
						</div>

 
						<div class="col-md-12" style="margin-top: 10px;">
							<h5>Formación requerida</h5>
						</div>
                                
						<div class="col-md-6" style="margin-bottom: 10px; margin-top: 30px">
							<div class="titulos_rojo">Curricular</div>
							<b><?php echo nl2br($dataDescriptivo["nivel_educativo"]); ?></b>
						</div>
                                
						<div class="col-md-6" style="margin-bottom: 10px; margin-top: 30px">
							<div class="titulos_rojo">Idiomas</div>
							<b><?php echo nl2br($dataDescriptivo["nivel_educativo_avanzado"]); ?></b>
						</div>

						<div class="col-md-6" style="margin-bottom: 10px">
							<div class="titulos_rojo">Conocimientos específicos</div>
							<b><?php echo nl2br($dataDescriptivo["titulos_requeridos"]); ?></b>
						</div>

						<div class="col-md-6" style="margin-bottom: 10px">
							<div class="titulos_rojo">Se valorará:</div>
							<b><?php echo nl2br($dataDescriptivo["titulos_avanzado_requeridos"]); ?></b>
						</div>

                                
                                
						<div class="col-md-12" style="margin-top: 40px;">
							<h5>Experiencia requerida</h5>
						</div>
                                
						<div class="col-md-6" style="margin-bottom: 10px">
							<label>Experiencia </label><br>
							<b><?php echo $dataDescriptivo["experiencia_total_años"]; ?></b>
						</div>

						<div class="col-md-6" style="margin-bottom: 10px">
							<label>Otros requisitos</label><br>
							<b><?php echo $dataDescriptivo["experiencia_total_area"]; ?></b>
						</div>
                                
						<div class="col-md-12" style="margin-top: 40px;">
							<h5>Competencias requeridas</h5>
						</div>


						<div class="col-md-6" style="margin-bottom: 10px">
							<label>Genéricas para trabajar en AT (ADN)</label><br>
							<b><?php echo $dataDescriptivo["experiencia_especifica_anios"]; ?></b>
						</div>
                                
						<div class="col-md-6" style="margin-bottom: 10px">
							<label>Específicas para el cargo</label><br>
							</b><?php echo $dataDescriptivo["experiencia_específica_areas"]; ?></b>
						</div>

                      </div>
                      

                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
function Borrar(){
    $("#id_funcion").val("");
    $("#que_hace").val("");
    $("#como_hace").val("");
    $("#para_hace").val("");
}
    
var api = '<?php echo $url; ?>/api/administrar/';   
    
function DatosFuncion(id_funcion){
    jQuery.ajax({
			url: api+"funcion_cargo.php",
			type:'post',
			data: {id_funcion: id_funcion, },
			}).done(function (resp){
				$("#modal-body").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
    );
} 
    
function DatosResponsabilidadesSG(id_resp){
    jQuery.ajax({
			url: api+"reponsabilidades_sg.php",
			type:'post',
			data: {id_resp: id_resp },
			}).done(function (resp){
				$("#descripcion_responsabilidades_sg").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
    );
} 
</script>
