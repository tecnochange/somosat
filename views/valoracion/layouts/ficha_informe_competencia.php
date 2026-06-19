<div class="modal fade modal_informe" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
    
			<!-- cerrar -->
			<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ficha Informe</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
			</div>
            
            <div class="modal-body" id="cont_modal_competencia">
				<form action="" method="post">
                	<input type="hidden" name="id_informe_indicador" />
					<div class="row">
                        
                        <div class="col-md-12">
                          	<h5 id="nombre_indicador">...</h5>

                        </div>
                        

                        <div class="col-md-12">
                          	<label class="ti_label">Fortaleza</label>
                            <textarea class="form-control" name="fortaleza" required placeholder="Ingrese..." rows="3"></textarea>
                        </div>
                        
                        <div class="col-md-12">
                          	<label class="ti_label">Oportunidad de mejora</label>
                            <textarea class="form-control" name="oportunidad" required placeholder="Ingrese..." rows="3"></textarea>
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
