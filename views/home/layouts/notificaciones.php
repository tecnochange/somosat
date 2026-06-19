<?php
include("app/models/Notificaciones.php");
$ClassNotificaciones = new Notificaciones();
$notificaciones = $ClassNotificaciones->mis_notificaciones($user_log["id"], $connect_admin);
?>


<div class="card" style="margin-bottom: 15px; display: none">
	
	<div class="card-body">

		<h3 class="title__name__page">Notificaciones</h3>

		<div class="list-group list-group-flush border rounded border-1 scrollarea">
			<?php
			$count = 1;
			foreach ($notificaciones as $notificacion) {
				?>
				<a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
					<div class="d-flex w-100 align-items-center justify-content-between">
						<small><b><?php echo $notificacion["created_at"]; ?></b></small>
					</div>
					<div class="col-10 mb-1 small">
						<?php echo $notificacion["mensaje"]; ?>
					</div>
				</a>
			<?php } ?>

			<a href="<?php echo $url; ?>?pg=home/mis_notificaciones" class="list-group-item py-2 lh-tight"
			   style="text-align: right">
				<button type="button" class="btn btn-primary btn-sm">Ver todas las notificaciones</button>
			</a>
		</div>
		
	</div>
</div>

<?php include("views/home/layouts/cumplenios.php"); ?>