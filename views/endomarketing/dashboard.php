<script>  
$( document ).ready(function() {
	$('#menuEndomarketing').collapse();
    $("#bt_endo_publicar").addClass("active");
});
</script>



<div class="container">
    <div class="row justify-content-md-center">
		
		<div class="col-md-12" style="margin-bottom: 20px; margin-top: 20px" align="center">
			<h5>Realizar publicación</h5>
		</div>
        
       
        <div class="col-md-3" style="margin-bottom: 20px">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo $url; ?>?pg=endomarketing/publicar/reconocimientos">
                        <div align="center">
                            <i class="bx bx-star iconos_dash" style="color: #5c349e;"></i><br>
                            Reconocimientos
                        </div>
                    </a>
                </div>
            </div>
        </div>
		
		<div class="col-md-3" style="margin-bottom: 20px">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo $url; ?>?pg=endomarketing/publicar/generales&tp=9">
                        <div align="center">
                            <i class="bx bx-news iconos_dash" style="color: #3f51b5;"></i><br>
                            Noticias
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
       
        
        <div class="col-md-3" style="margin-bottom: 20px">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo $url; ?>?pg=endomarketing/publicar/generales&tp=4">
                        <div align="center">
                            <i class="bx bx-book-bookmark iconos_dash" style="color: #e31890;"></i><br>
                            Clasificados
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
      
        <div class="col-md-3" style="margin-bottom: 20px">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo $url; ?>?pg=endomarketing/publicar/generales&tp=5">
                        <div align="center">
                            <i class="bx bx-happy-beaming iconos_dash" style="color: #009688;"></i><br>
                            Nuestra Gente
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3" style="margin-bottom: 20px">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo $url; ?>?pg=endomarketing/publicar/generales&tp=7">
                        <div align="center">
                            <i class="bx bx-gift iconos_dash" style="color: #ffc107;"></i><br>
                            Celebraciones
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3" style="margin-bottom: 20px">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo $url; ?>?pg=endomarketing/publicar/generales&tp=8">
                        <div align="center">
                            <i class="bx bx-spa iconos_dash" style="color: #ff5722;"></i><br>
                            Calidad de vida
                        </div>
                    </a>
                </div>
            </div>
        </div>        
    </div>

</div>

<style>
    .iconos_dash{
        font-size: 40px;
        margin-bottom: 10px;
        margin-top: 10px;
    }
</style>

