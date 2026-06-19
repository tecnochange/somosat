<div class="modal fade" id="modal_general" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    
			<!-- cerrar -->
			<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
                
			</div>
            
            <div class="modal-body" id="modal_body" align="center">
				
            </div>

    
		</div>
	</div>
</div>


<div class="modal fade" id="modal_tooltips" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    
			<!-- cerrar -->
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
			</div>
            
            <div class="modal-body" id="body_tooltips" align="left">
				
            </div>

    
		</div>
	</div>
</div>


<div class="modal fade" id="modal_equipo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    
			<!-- cerrar -->
			<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Equipo de colaboradores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
			</div>
            
            <div class="modal-body" id="body_equipos" align="left">
				
            </div>

    
		</div>
	</div>
</div>


<div class="modal" role="dialog" id="modal_borrar">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Alerta</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="cont_modal_">
            
          </div>
          <div class="modal-footer" id="botones_modal">

          </div>
        </div>
      </div>
</div>

<div class="modal" role="dialog" id="modal_comentar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comentar</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <input type="hidden" name="csrf" value="<?php echo $_SESSION['token']; ?>">
                <div class="modal-body" id="cont_modal_comentar">

                </div>
            </form>
        </div>
    </div>
</div>




