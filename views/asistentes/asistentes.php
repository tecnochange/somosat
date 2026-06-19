<script>
    $(document).ready(function () {
        $("#mod_home").addClass("active");
    });
</script>



<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
    		<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=asistentes/dashboard">Tablero</a></li>
    		<li class="breadcrumb-item active" aria-current="page">Gestionar Asistentes</li>
		</ol>
	</nav>

    <div class="d-flex justify-content-between ">
        <div class="mb-1">
            <h2>Gestionar Asistentes Inteligentes (IA)</h2>
        </div>

        <div class="mb-1" align="right">
            <a href="<?php echo $url; ?>?pg=asistentes/asistente/detalle">
                <button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 6px">Nuevo</button>
            </a>

        </div>
    </div>
	
	

    <div class="table-responsive">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" width="60">#</th>
                        <th scope="col">Asistente</th>
                        <th scope="col">Nombre del Menú</th>
                        <th scope="col">Estado</th>
                        <th scope="col" width="180">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 1;
					$query = mysqli_query($connect_asistente,"SELECT * FROM Asistente WHERE id_empresa = '".$user_log["id_empresa"]."' ");
					while($data = mysqli_fetch_array($query)){
						
						$txt_estado = '';
						foreach ($Array_Estado as $solicitud) {
							if ($solicitud[0] == $data["estado"]) {
								$txt_estado = $solicitud[1];
							}
						}
						
                        echo '
						<tr>
							<td>' . $count . '</td>
							<td>' . $data["nombre"] . '</td>
							<td>' . $data["titulo_menu"] . '</td>
							<td>' . $txt_estado . '</td>
							<td>
								<a href="' . $url . '?pg=asistentes/asistente/detalle&id=' . $data["id"] . '">
								<button type="button" class="btn btn-success btn-sm">
									<i class="bx bx-edit " title="Editar"></i>
								</button>
								</a>
							</td>
						</tr>
						';
						 $count++;
                    }
                    ?>


                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>