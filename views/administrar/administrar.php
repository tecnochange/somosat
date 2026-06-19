<script>  
$(document).ready(function(){
    $("#bt_adm_administar").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>


<div align="left" class="cabecera_interna" style="margin-bottom: 15px">
    <table width="100%">
        <tr>
            <td><h2>Administrar </h2></td>
        </tr>
    </table>
</div>

<div class="container">
    
    <div class="row ">
    
        <div class="col-md-4" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/afap/afap">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Afap
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/nivel_cargo/nivel_cargo">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Nivel del Cargo
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/prestador_salud/prestador_salud">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Prestador de Salud
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-4" style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/emergencia_medica/emergencia_medica">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Emergencia Médica
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4"  style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/tipo_documento/tipo_documento">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Tipo de Documento
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4"  style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/archivos_adjuntos/archivos_adjuntos">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Archivos Adjuntos
                        </button>
                    </a>
                </div>
            </div>
        </div>
		
		<div class="col-md-4"  style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/nacionalidades/nacionalidad">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Nacionalidad
                        </button>
                    </a>
                </div>
            </div>
        </div>
		
		<div class="col-md-4"  style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/idiomas/lista">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Idiomas
                        </button>
                    </a>
                </div>
            </div>
        </div>
		
		<div class="col-md-4"  style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/ciudades/lista">
                        <button type="submit" class="btn btn-primary btn-block" >
                           Ciudad de Residencia
                        </button>
                    </a>
                </div>
            </div>
        </div>
		
		<div class="col-md-4"  style="margin-bottom: 15px">
            <div class="card">
                <div class="card-body" align="center">
                    
                    <a href="<?php echo $url; ?>?pg=administrar/administrar/tipo_cap/lista">
                        <button type="submit" class="btn btn-primary btn-block" >
                            Tipo Capacitación
                        </button>
                    </a>
                </div>
            </div>
        </div>
        


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
</script>



