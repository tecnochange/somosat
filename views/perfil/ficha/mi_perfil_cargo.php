<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_cargos").addClass("active_item");
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	//if($_SESSION['role_plataforma']  != 1){
		//echo ' <script> window.location = "?pg=home"; </script> ';
	//}
?>

<?php
	if($_GET["id"]){
        $_SESSION["id_cargo_edit"] = $_GET["id"];
    }

	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	$queryEmp = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$user_log["id"]."'  ");
	$dataEmp = mysqli_fetch_array($queryEmp);
	$id_cargo = $dataEmp["id_cargo"];



	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$id_cargo."'  ");
	$data = mysqli_fetch_array($query);	

    $queryDescriptivo = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Descriptivo WHERE id_cargo = '".$id_cargo."'  ");
    $dataDescriptivo = mysqli_fetch_array($queryDescriptivo);
?>

<!-- CABECERA -->
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Mi Perfil de Cargo</h3>
                
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    
                    
                    
                    <!-- CONTENIDO FORMULARIO -->
                    <!-- CONTENIDO FORMULARIO -->
                    <!-- CONTENIDO FORMULARIO -->
                    <!-- CONTENIDO FORMULARIO -->
                    <!-- CONTENIDO FORMULARIO -->
                    <div class="tab-content" id="top-tabContent">
                        <div class="tab-pane fade show active" id="top-configuracion" role="tabpanel" aria-labelledby="top-configuracion-tab">
                     
                            <!-- FORMULARIO -->
                            <form action="" method="post">
                            <input type="hidden" name="id_registro" value="<?php echo $_SESSION["id_cargo_edit"]; ?>">
                            <input type="hidden" name="id_registro_adicional" value="<?php echo $dataDescriptivo["id"]; ?>">
                            <input type="hidden" name="nombre_cargo" value="<?php echo $data["nombre"]; ?>">
                            <div class="row">
								
								
								<div class="col-md-4" style="margin-bottom: 10px">
									<label>Nombre del Cargo</label><br>
									<?php echo $data["nombre"]; ?>
								</div>

								<div class="col-md-4" style="margin-bottom: 10px">
									<label>Área</label><br>
									<?php
										$queryDep = mysqli_query($connect_valentina,"SELECT * FROM Areas ORDER BY nombre ASC ");  
										while($dataDep = mysqli_fetch_array($queryDep)){
											if($data["id_area"] == $dataDep["id"] ){
												echo $dataDep["nombre"];
											}
										}
									?>
								</div>

								<div class="col-md-4" style="margin-bottom: 10px">
									<label>Departamento</label><br>
										<?php
										$queryGerencia = mysqli_query($connect_valentina,"SELECT * FROM Gerencias ORDER BY nombre ASC ");  
										while($dataJer = mysqli_fetch_array($queryGerencia)){
											if($data["id_gerencia"] == $dataJer["id"] ){
												echo $dataJer["nombre"];
											}
											
										}
										?>
								</div>

								<div class="col-md-4" style="margin-bottom: 10px">
									<label>Tipo</label><br>
									<?php
										foreach($Array_Tipo as $nivel){
											if($data["tipo"] == $nivel[0] ){
												echo $nivel[1];
											}
										}
									?>
								</div>

								<div class="col-md-4" style="margin-bottom: 10px">
									<label>Liderazgo</label><br>
									<?php
										foreach($Array_liderazgo as $nivel){
											if($data["liderazgo"] == $nivel[0] ){
												echo $nivel[1];
											}
										}
										?>
								</div>
								
                                
								
								
								
								
								
								
								
								
								
								
								
                                <div class="col-md-12" style="text-align: center">
                                    <h5><b>Descripción del cargo</b></h5>
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 30px">
                                    <label>Objetivo del cargo</label>
                                </div>

                                <div class="col-md-12" style="margin-bottom: 10px">
									<?php echo nl2br($dataDescriptivo["proposito"]); ?>
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <label>Descripción de Tareas</label>
                                </div>

                                <div class="col-md-12" style="margin-bottom: 10px">
                                    <?php echo nl2br( $dataDescriptivo["decisiones_tomar"] ); ?>
                                </div>

                                <div class="col-md-12" style="margin-top: 10px;" align="center">
                                    <h5><b>Formación requerida</b></h5>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px; margin-top: 30px">
                                    <div class="titulos_rojo">Curricular</div>
                                    <?php echo nl2br( $dataDescriptivo["nivel_educativo"] ); ?>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px; margin-top: 30px">
                                    <div class="titulos_rojo">Idiomas</div>
                                    <?php echo nl2br( $dataDescriptivo["nivel_educativo_avanzado"] ); ?>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Conocimientos específicos</div>
                                    <?php echo nl2br( $dataDescriptivo["titulos_requeridos"] ); ?>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <div class="titulos_rojo">Se valorará:</div>
                                    <?php echo nl2br( $dataDescriptivo["titulos_avanzado_requeridos"] ); ?>
                                </div>

                                
                                
                                <div class="col-md-12" style="margin-top: 40px;" align="center">
                                    <h5><b>Experiencia requerida</b></h5>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Experiencia </label><br>
                                    <?php echo nl2br( $dataDescriptivo["experiencia_total_años"]); ?>
                                </div>

                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Otros requisitos</label><br>
                                    <?php echo nl2br( $dataDescriptivo["experiencia_total_area"] ); ?>
                                </div>
                                
                                <div class="col-md-12" style="margin-top: 40px;" align="center">
                                    <h5><b>Competencias requeridas</b></h5>
                                </div>


                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Genéricas para trabajar en AT (ADN)</label><br>
                                    <?php echo nl2br( $dataDescriptivo["experiencia_especifica_anios"] ); ?>
                                </div>
                                
                                <div class="col-md-6" style="margin-bottom: 10px">
                                    <label>Específicas para el cargo</label><br>
                                    <?php echo nl2br( $dataDescriptivo["experiencia_específica_areas"] ); ?>
                                </div>
                                
                                
                            </div>
                            </form>
                            <!-- FIN DEL FORMULARIO -->

                      </div>

                      
                    </div>
                  </div>
            </div>
            
        </div>
    </div>
</div>

<style>
	label{
		font-weight: bold;
	}
</style>

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

