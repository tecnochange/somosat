<script>
    $(document).ready(function () {
        $("#bt_muro").addClass("active");
        $("#mod_home").addClass("active_qa");
    });
</script>

<?php
//CONTROLLER
include("app/models/Tareas.php");
$ClassTareas = new Tareas();
$tareas = $ClassTareas->mis_tareas($_POST, $user_log["id"], $connect_admin);
?>

<div class="container">
    <div class="row">
		
		<div class="col-md-6" >
			<div style="margin-bottom: 15px;">
				<div id="banner_general" class="carousel slide" data-bs-ride="carousel" style="border-radius: 10px; overflow: hidden;">
					<div class="carousel-inner">
					<?php 
						$query = mysqli_query($connect_endomarketing,"SELECT * FROM Banners 
						WHERE estado = 1 ORDER BY id DESC ");  
						$first = true;
						while($data = mysqli_fetch_array($query)){ ?>
							<div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
								<img <?php echo 'src="'.$url.'/resources/muro/'.$data['imagen'].'"' ?> class="d-block w-100" alt="Banner 1">
							</div>
						<?php $first = false; } ?>
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#banner_general" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#banner_general" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</div>
            <?php include("views/home/layouts/publicaciones.php"); ?>
        </div>
		
        <div class="col-md-6">
			
			<div class="sticky-md-top alto_accesos" >
			
				<div class="card" style="margin-bottom: 15px">
					<div class="card-body">
						<div class="d-flex flex-row align-items-center">
							<div style="background-image: url(<?php echo $user_log["foto"]; ?>); width: 80px; height: 80px;"
								 class="foto_menu_lateral">
							</div>
							<div class="d-flex flex-column">
								Bienvenido<br>
								<h3 class="has__text__orange mb-0"><?php echo $user_log["nombre"] . " " . $user_log["apellidos"]; ?></h3>
								<span class="has__text__gray__level__tree"><?php echo $user_log["nombre_cargo"]; ?></span>
							</div>
						</div>
						</table>
					</div>
				</div>

				<div class="card" style="margin-bottom: 15px">
					<div class="card-body" align="center">

						<a href="<?php echo $url; ?>?pg=home/muro&p=3">
							<i class="bx bx-star iconos_dash" style="background-color: #5c349e;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reconocimientos"></i>
						</a>

						<a href="<?php echo $url; ?>?pg=home/muro&p=9">
							<i class="bx bx-news iconos_dash" style="background-color: #3f51b5;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Noticias"></i>
						</a>

						<a href="<?php echo $url; ?>?pg=home/muro&p=4">
							<i class="bx bx-book-bookmark iconos_dash" style="background-color: #e31890;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clasificados"></i>
						</a>

						<a href="<?php echo $url; ?>?pg=home/muro&p=5">
							<i class="bx bx-happy-beaming iconos_dash" style="background-color: #009688;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nuestra Gente"></i>
						</a>

						<a href="<?php echo $url; ?>?pg=home/muro&p=7">
							<i class="bx bx-gift iconos_dash" style="background-color: #ffc107;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Celebraciones"></i>
						</a>

						<a href="<?php echo $url; ?>?pg=home/muro&p=8">
							<i class="bx bx-spa iconos_dash" style="background-color: #ff5722;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Calidar de Vida"></i>
						</a>


					</div>
				</div>

				<div class="card" style="margin-bottom: 15px">
					<div class="card-body" align="center">

						<h4>Accesos directos</h4>
						<div>
							<a href="<?php echo $url; ?>/?pg=endomarketing/dashboard">
							<button type="button" class="btn btn-light mb-2">
								Publicar
							</button>
							</a>
							<a href="<?php echo $url; ?>?pg=estructura/directorio">
							<button type="button" class="btn btn-light mb-2">
								Directorio
							</button>
							</a>
							<a href="<?php echo $url; ?>?pg=estructura/estructura_areas" >
							<button type="button" class="btn btn-light mb-2">
								Organigrama
							</button>
							</a>
							
						</div>
					</div>
				</div>

				
		
			</div>
        </div>
		


    </div>


</div>

<style>
	.iconos_dash{
		font-size: 27px;
		margin: 10px 6px;
		color: #ffffff !important;
		padding: 4px;
		border-radius: 10px;
		transition: 0.5s all;
	}
	.iconos_dash:hover{
		transform: rotate(360deg);
    	
	}
	.alto_accesos{
		top: 80px; 
		height: 85vh; 
		overflow: auto;
	}
	
	@media (max-width: 768px) {
		.alto_accesos{ 
			height: auto; 
			overflow: auto;
		}
		.iconos_dash {
			margin: 10px 2px;
		}
    }
	
	
</style>