<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Administrar Hoja de Vida</h2>
                    </td>
                    <td align="right">
                        <?php if($dtEmpleado["role"] == 1){ ?>
                        <a href="<?php echo $url; ?>?pg=administrar/cargos/detalle">
                        <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
                            <i class="fas fa-plus"></i> Crear Cargo
                        </button>
                        </a>

                        <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" >
                            <i class="fas fa-plus"></i> Cargar CSV
                        </button>
                        <?php } ?>
                        
                        <button type="button" id="sidebarCollapse" class="btn btn-info btn-sm" title="Descargar Excel" >
                            <i class="fas fa-download"></i>
                        </button>
                        
                    </td>
                </tr>
            </table>  
        </div>
        
      
        
        
        
        
       
        
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-body">
                    Proximamente...
                </div>
            </div>
        </div>
        
    
    </div>
</div>





            
          



<script>
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>



