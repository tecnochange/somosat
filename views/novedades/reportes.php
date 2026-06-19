<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
    $("#desplegable_novedades").show();
    $("#bt_novedades_reportes").addClass("active_item");
});
</script>



<!-- PORTADA -->
<div class="container">
    
    <div class="row">
            
        <div class="col-md-3">
            <div class="card">
                <div class="card-body" align="center">
                    <a href="<?php echo $url; ?>?pg=novedades/reporte/certificado_laboral" >
                    <button type="submit" class="btn btn-primary" >
                        <i class="fa fa-check"></i> Certificado Laboral
                    </button>
                    </a>
                </div>
            </div>
        </div>  
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body" align="center">
                    <a href="<?php echo $url; ?>?pg=novedades/reporte/comprobantes" >
                    <button type="submit" class="btn btn-primary" >
                        <i class="fa fa-check"></i> Comprobante de Pago
                    </button>
                    </a>
                </div>
            </div>
        </div>  
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body" align="center">
                    <a href="<?php echo $url; ?>?pg=novedades/reporte/ingresos" >
                    <button type="submit" class="btn btn-primary" >
                        <i class="fa fa-check"></i> Ingresos y Retenciones
                    </button>
                    </a>
                </div>
            </div>
        </div> 
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body" align="center">
                    <a href="<?php echo $url; ?>?pg=novedades/reporte/vacaciones" >
                    <button type="submit" class="btn btn-primary" >
                        <i class="fa fa-check"></i> Vacaciones
                    </button>
                    </a>
                    
                </div>
            </div>
        </div> 
                  
    </div>

</div>


