<div class="modal fade modal_funciones" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- cerrar -->
			<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Función</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
			</div>
            
            <div class="modal-body" >
                <form action="" method="post">
                    <div id="modal-body">
                        <label>Que hace</label>
                        <input type="hidden" name="guardar_funcion" value="true">
                        <input type="hidden" name="id_funcion" id="id_funcion">
                        <input type="hidden" name="nombre_cargo" value="<?php echo $data["nombre"]; ?>">
                        <textarea rows="5" class="form-control" name="que_hace" id="que_hace"></textarea>

                        <label>Cómo lo hace</label>
                        <textarea rows="5" class="form-control" name="como_hace" id="como_hace"></textarea>

                        <label>Para qué lo hace</label>
                        <textarea rows="5" class="form-control" name="para_hace" id="para_hace"></textarea>
                    </div>
                    
                    <?php 
                                    if($user_log["role"] == 2 || $user_log["role"] == 5 ){ 
                                        echo '<div class="row">';
                                        include("views/administrar/cargo/autorizaciones.php"); 
                                        echo '</div>';
                                    } 
                                ?>
                    
                    
                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 15px" >
                       Guardar
                    </button>
                </form>
            </div>
    
		</div>
	</div>
</div>


