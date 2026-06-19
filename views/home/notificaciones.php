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


<div class="card" style="margin-bottom: 15px">
	
	<div class="card-header gradient_change" align="center">
		<h5 style="color: #ffffff"><b>Notificaciones</b></h5>
	</div>
	
	<div class="list-group list-group-flush border-bottom scrollarea">
		<a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
			<div class="d-flex w-100 align-items-center justify-content-between">
				<strong class="mb-1">Nueva publicación</strong>
				<small>15 de Abril</small>
			</div>
			<div class="col-10 mb-1 small">
				Se ha realizado una nueva publicación en el muro
			</div>
		</a>
		<a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
			<div class="d-flex w-100 align-items-center justify-content-between">
				<strong class="mb-1">Solicitud aprobada</strong>
				<small>30 de enero</small>
			</div>
			<div class="col-10 mb-1 small">
				Su solicitud de vacaciones fué sido aprobada
			</div>
		</a>
		<a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
			<div class="d-flex w-100 align-items-center justify-content-between">
				<strong class="mb-1">Evaluaciones próximas a vencer</strong>
				<small>10 de enero</small>
			</div>
			<div class="col-10 mb-1 small">
				En los próximos días vence el plazo para realizar las evaluaciones de competencias.
			</div>
		</a>
		<a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
			<div class="d-flex w-100 align-items-center justify-content-between">
				<strong class="mb-1">Nueva Publicación</strong>
				<small>1 de enero</small>
			</div>
			<div class="col-10 mb-1 small">
				Se ha realizado una nueva publicación en el muro
			</div>
		</a>
		<a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
			<div class="d-flex w-100 align-items-center justify-content-between">
				<strong class="mb-1">Tarea Asignada</strong>
				<small>15 de diciembre</small>
			</div>
			<div class="col-10 mb-1 small">
				Tiene una nueva tarea asignada
			</div>
		</a>
		<a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
			<div class="d-flex w-100 align-items-center justify-content-between">
				<strong class="mb-1">Tarea Asignada</strong>
				<small>14 de diciembre</small>
			</div>
			<div class="col-10 mb-1 small">
				Tiene una nueva tarea asignada
			</div>
		</a>
		<a href="<?php echo $url; ?>?pg=tareas/listas" class="list-group-item py-2 lh-tight" style="text-align: right">
			<button type="button" class="btn btn-dark btn-sm">Ver todas las notificaciones</button>
		</a>
	</div>
	
	
		
				

		
		
		
</div>