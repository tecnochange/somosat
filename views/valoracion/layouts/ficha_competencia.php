<div class="modal fade modal_competencia" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
    
			<!-- cerrar -->
			<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ficha Competencia</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
			</div>
            
            <div class="modal-body" id="cont_modal_comp">
				<form action="" method="post">
                	<input type="hidden" name="id_competencia" />
					<div class="row">
                        
                        <div class="col-md-6">
                          	<label class="ti_label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                          	<label class="ti_label">Tipo.</label>
                            <select class="form-control" name="id_tipo"  required>
                            	<option value="">Selecciona...</option>
                                <?php
								$queryTipo = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY id ASC ");
								while($dataTipo = mysqli_fetch_array($queryTipo)){
									echo '<option value="'.$dataTipo["id"].'">'.$dataTipo["nombre"].'</option>';
								}
								?>
                            </select>
                        </div>
                        <div class="col-md-12">
                          	<label class="ti_label">Definición</label>
                            <textarea class="form-control" name="definicion" required placeholder="Ingrese definición..." rows="5"></textarea>
                        </div>
                        <div class="col-md-12" style="margin-top:15px; text-align: right;">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                        
					</div>
				</form>
            </div>

    
		</div>
	</div>
</div>
