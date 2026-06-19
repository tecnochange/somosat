<style>
	.tarjeta{
		height: 95%;
	}
</style>

<div class="container" align="center" style="max-width: 900px">
	
	
	<div class="row justify-content-center">
		
		<?php if( $_SESSION['role_plataforma'] == 1 ){ ?>
		<div class="col-md-12" align="right">
			<a href="<?php echo $url; ?>?pg=asistentes/asistentes">
				<button class="btn btn-primary  " style="margin-bottom: 15px">
					Gestionar Bots
				</button>
			</a>
		</div>
		<?php } ?>
		
		<div class="col-md-12" align="center" >
			<h2>Asistentes Gpts</h2>
			<p>Power by ChatGpt</p>
		</div>
		

		<?php
		$query = mysqli_query($connect_asistente,"SELECT * FROM Asistente WHERE id_empresa = '".$user_log["id_empresa"]."' ");
		while($data = mysqli_fetch_array($query)){

			$imagen = $url.'resources/'.$data["archivo"];

			echo '
			<div class="col-md-4" style="margin-bottom: 15px">
				<a href="'.$url.'?pg=asistentes/bot&id='.$data["id"].'">
				<div class="card tarjeta">
					<div class="card-body">
						<img src="'.$imagen.'" width="40%">
						<div style="margin-top: 10px;">
							<h3>'.$data["titulo_menu"].'</h3>
						</div>
						
						<button class="btn btn-success w-100 " style="margin-bottom: 15px">
							Ingresar
						</button>
						
					</div>
				</div>
				</a>
			</div>
			';
		}
		?>
		
		
		
	</div>
	

</div> 

  