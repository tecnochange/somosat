	<?php if($_SESSION['role_plataforma'] == 1 ){ ?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/colaboradores">Colaboradores</a></li>
        	<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle Colaborador</a></li>
		</ol>
	</nav>
	<?php } ?>
	<?php if($_SESSION['role_plataforma'] == 2 ){ ?>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/mi_equipo">Mi Equipo</a></li>
        	<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle Colaborador</a></li>
		</ol>
	</nav>
	<?php } ?>