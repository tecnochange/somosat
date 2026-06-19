<script>  
$(document).ready(function(){
    $("#bt_adm_areas").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
$pagina_inicio = file_get_contents('http://changedev.valentinagth.com/ftp_talento_viva/Base_Organizacion_NuevatelMay22.csv');

?>


<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Validar Arhivo</h2></td>
            <td align="right" width="200">
            	<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
                
            </td>
            <td align="right" width="40">   
                
            </td>
        </tr>
    </table>
</div>




<div class="card">
    <div class="card-body">
    
        <?php
        echo $pagina_inicio;
        ?>
    </div>
</div>