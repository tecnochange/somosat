
<script>  
$(document).ready(function(){
    $("#bt_home").addClass("active_item");
});
</script>

<?php
	$tipo = $_GET["tp"];
	$hoy = date("Y-m-d H:i:s");

	//PARA GUARDAR LOS COMENTARIOS
	if($_POST["id_comentar"] != "" && $_POST["comentario"] != ""){
		mysqli_query($connect_clima,"INSERT INTO Comentarios (id_publicacion, id_user, comentario, nombre_full, created_at) VALUES 
		( '".$_POST["id_comentar"]."', '".$user_log['id']."', '".$_POST["comentario"]."', '".$$user_log['nombre']."".$user_log["apellidos"]."', '".$hoy."' ) ");
		echo '<script>location.href ="?pg=home";</script>';
	}
	
	//PARA MOSTRAR LOS TIPO
	if($_GET["tp"] != "" ){
		$filtro = ' AND tipo = '.$tipo.' ';
	}
	
	//PARA MOSTRAR LOS TIPO
	if($_GET["var"] != "" ){
		$filtro .= ' AND variable = '.$_GET["var"].' ';
	}

	//CONSULTAMOS LAS PUBLICACIONES
	$query = mysqli_query($connect_clima,"SELECT * FROM Publicaciones WHERE estado = 1 AND id_empresa = '".$_SESSION['id_empresa']."' ".$filtro." ORDER BY id DESC ");
?>

<?php
    $queryVacantes = mysqli_query($connect_seleccion,"SELECT * FROM Vacantes"); 
    $queryVacantesPublicas = mysqli_query($connect_seleccion,"SELECT * FROM Vacantes WHERE tipo_vacante = 3 "); 

    $queryCand = mysqli_query($connect_seleccion,"SELECT * FROM Candidatos");
    $queryProcesos = mysqli_query($connect_seleccion,"SELECT * FROM Procesos");
    $queryBaterias = mysqli_query($connect_seleccion,"SELECT * FROM Invitaciones"); // Invitaciones es igual a bateria
?>

<style>
    .mi_card{
        background-color: #828282; 
        height: 100px;
        border-radius: 15px;
        width: 400px;
        display: inline-table;
    }
</style>

<div class="container" style="max-width: 1000px"> 

    <div class="row justify-content-center">
        
        <div class="col-md-12" align="center" >
            <h1 style="color: #00407b"><b>Bienvenido a su plataforma
            de Gestión Humana</b></h1>
            <p style="font-size: 20px">Su generalista virtual para gestión del talento de la organización.</p>
        </div>
        
        <div class="col-md-12" align="center" style="margin-bottom: 20px">
            
            <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos">
                <button type="button" class="btn btn-primary" style="margin-top: 20px">
                    <i class="bx bx-user"></i> Actualizar mis datos
                </button>
            </a>
            
            <a href="<?php echo $url; ?>?pg=valoracion/realizar_valoracion">
                <button type="button" class="btn btn-primary" style="margin-top: 20px">
                    <i class="bx bx-equalizer "></i> Mi Evaluaciones
                </button>
            </a>
            <?php if($user_log["role"] == 1){ ?>
            <a href="<?php echo $url; ?>/?pg=seleccionar_perfil&t=1">
                <button type="button" class="btn btn-primary" style="margin-top: 20px">
                    Administrador 
                </button>
            </a>
            
            <a href="<?php echo $url; ?>?pg=seleccionar_perfil&t=2">
                <button type="button" class="btn btn-primary" style="margin-top: 20px">
                    Referente
                </button>
            </a>
            <?php } ?> 
        </div>

        <div class="col-md-12" align="center">
            
            <div class="swiper-container" style="overflow: hidden; width: 100%; border-radius: 5px">
                <div class="swiper-wrapper">
                        
                        <div class="swiper-slide" >
                            <img src="<?php echo $url; ?>/img/AT-Innovando-Juntos-1.jpg" width="100%" style="border-radius: 10px; box-shadow: 1px 1px 15px rgb(0 0 0 / 20%);">
                        </div>
                        
                        <div class="swiper-slide" >
                            <img src="<?php echo $url; ?>/img/AT-Innovando-Juntos-1.jpg" width="100%" style="border-radius: 10px; box-shadow: 1px 1px 15px rgb(0 0 0 / 20%);">
                        </div>
                        
                </div>
                
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                
                
            </div>
        </div>
        
        <div class="col-md-12" align="center" style="font-size: 12px; color: #cccccc; margin-top: 15px; margin-bottom: 15px">
            Desarrollado por HR Suite 2022 - Change Americas<br>
            <img src="<?php echo $url; ?>/img/logo_hr_suite.png" width="60" style="margin-top: 12px">
        </div>
        
      
      
        
    </div>
</div>

<style>
    .card{
        color: #333;
    } 
    .visible{
        display: block;
    }
</style>


<script>
$( document ).ready(function() {	
	
	var swiper = new Swiper('.swiper-container', {
      effect: "fade",
      pager: true,
	  autoplay: {
    	delay: 4000,
      }
    });
	
});
</script>

        
