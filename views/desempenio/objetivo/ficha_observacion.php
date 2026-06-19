<div class="modal fade modal_observacion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
    
			<!-- cerrar -->
			<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Observación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
			</div>
            
            <div class="modal-body" id="cont_modal">
				<form action="" method="post">
                	<input type="hidden" name="id_observacion" id="id_observacion" />
                    <input type="hidden" name="mes_observacion" id="mes_observacion" />
					<div class="row">
                        
                        <div class="col-md-12">
                          	<label class="ti_label">Observación mes</label>
                            <textarea class="form-control" name="observacion" required></textarea>
                        </div>
                        
                        <div class="col-md-12" style="margin-top:15px; text-align: right;">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                        
					</div>
				</form>
            </div>

    
		</div>
	</div>
</div>