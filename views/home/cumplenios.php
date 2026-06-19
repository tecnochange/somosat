<?php if($user_log["role"] == 1){ ?>
<div class="card" style="margin-bottom: 15px">
	
	<div class="card-header gradient_change" align="center">
		<h5 style="color: #ffffff">
			¿Que perfil desea utilizar?
		</h5>
	</div>
	
	<div class="card-body">
		<a href="<?php echo $url; ?>?pg=seleccionar_perfil&t=1">
			<button type="button" class="btn btn-dark btn-sm w-100 m-1" >Administrador</button>
		</a>
		<a href="<?php echo $url; ?>?pg=seleccionar_perfil&t=2">
			<button type="button" class="btn btn-dark btn-sm w-100 m-1">Líder</button>
		</a>
	</div>
	
</div>
<?php } ?>


<div class="card" style="margin-bottom: 15px">
	
	<div class="card-header gradient_change" align="center">
		<h5 style="color: #ffffff">
			Tareas / Eventos
			<a href="<?php echo $url; ?>?pg=tareas/tarea/detalle">
				<i class="bx bx-plus-circle" style="float: right; color: #ffffff; font-size: 22px;"></i>
			</a>
		</h5>
	</div>
	
	<div class="list-group list-group-flush border-bottom scrollarea">
		<?php
		$count = 1;
		foreach($tareas as $tarea){
			if($tarea["status"] == 0){
				if($count <= 8){
					echo '
					<a href="'.$url.'?pg=tareas/tarea/detalle&id='.$tarea["id"].'" class="list-group-item list-group-item-action py-2 lh-tight" aria-current="true">
						<div class="d-flex w-100 align-items-center justify-content-between">
							<strong class="mb-1">'.$tarea["title"].'</strong>
							<small>'.$tarea["date"].'</small>
						</div>
					</a>
					';
				}
				$count++;
			}
		}
		?>
		
		<a href="<?php echo $url; ?>?pg=tareas/listas" class="list-group-item py-2 lh-tight" style="text-align: right">
			<button type="button" class="btn btn-dark btn-sm">Ver todas las tareas</button>
		</a>
	</div>
	
</div>


<div class="card" style="margin-bottom: 15px">
	
	<div class="card-header gradient_change" align="center">
		<h5 style="color: #ffffff">Cumpleaños del mes</h5>
	</div>
	
	<div class="list-group list-group-flush border-bottom scrollarea">
		
		<div class="list-group-item list-group-item-action py-3 lh-tight">
			<div class="d-flex w-100 align-items-center">
				<strong class="mb-6">
					<img src="https://i.imgur.com/hczKIze.jpg" class="foto_menu_lateral">
				</strong>
				<strong class="mb-6 mb-1">
					Mauricio Huertas<br>
					<small>10 de Marzo</small>
				</strong>
			</div>
		</div>
		
		<div class="list-group-item list-group-item-action py-3 lh-tight">
			<div class="d-flex w-100 align-items-center">
				<strong class="mb-6">
					<img src="https://i.imgur.com/hczKIze.jpg" class="foto_menu_lateral">
				</strong>
				<strong class="mb-6 mb-1">
					William Sosa<br>
					15 de Marzo
				</strong>
			</div>
		</div>

	</div>
	
</div>