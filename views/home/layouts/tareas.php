<div class="card" style="margin-bottom: 15px">
	
	<div class="card-body">

		<h4>
			Mis Tareas / Eventos
			<a href="<?php echo $url; ?>?pg=home/tarea/detalle">
				<i class="bx bx-plus-circle has__text__gray__level__tree" style="float: right; font-size: 22px;"></i>
			</a>
		</h4>

		<div class="list-group list-group-flush border rounded-3 scrollarea">
			<?php
			$count = 1;
			foreach ($tareas as $tarea) {
				if ($tarea["estado"] == 0) {
					if ($count <= 8) {
						echo '
						<a href="' . $url . '?pg=home/tarea/detalle&id=' . $tarea["id"] . '" class="list-group-item list-group-item-action py-2 lh-tight" aria-current="true">
							<div class="d-flex w-100 align-items-center justify-content-between">
								<div class="mb-1">' . $tarea["titulo"] . '</div>
								<small>' . $tarea["fecha"] . '</small>
							</div>
						</a>
						';
					}
					$count++;
				}
			}
			?>

			<a href="<?php echo $url; ?>?pg=home/mis_tareas" class="list-group-item py-2 lh-tight"
			   style="text-align: right">
				<button type="button" class="btn btn-primary btn-sm">Ver todas las tareas</button>
			</a>
		</div>
	</div>
</div>