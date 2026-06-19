<script>  
$(document).ready(function(){
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<style>
	.foto{
		width: 60px;
		height: 60px;
		background-size: cover;
		background-position: center;
		border-radius: 100px;
	}
</style>

<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Directorio</h2></td>
            <td align="right" width="200">
            	<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
            </td>
        </tr>
    </table>
</div>

<div class="table-responsive">
    
    <table class="table" style="margin-top: 15px">
       
        <tbody class="tabla_lista">
            <?php
                $hoy = date("Y-m-d H:i:s");  
                $count = 1;
                $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales  ");  
                while($data = mysqli_fetch_array($query)){ 
					
					$queryAnt = mysqli_query($connect_valentina,"SELECT * FROM Empleados__27_oct WHERE id = '".$data["id_empleado"]."' ");  
                    $dataAnt = mysqli_fetch_array($queryAnt);
					
					
					$queryNew = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE documento = '".$dataAnt["documento"]."' " );  
                    $dataNew = mysqli_fetch_array($queryNew);
					
					
					//mysqli_query($connect_valentina, "UPDATE Empleados_Adicionales SET id_empleado = '".$dataNew["id"]."' WHERE id = '".$data["id"]."' " );
					
					
                    echo '
                        <tr>
                            <td>'.$count.'</td>

                            <td>'.$dataAnt["id"].'  - '.$dataAnt["nombre"].' '.$dataAnt["apellidos"].'</td>
                            <td>'.$dataNew["id"].'  - '.$dataNew["nombre"].' '.$dataNew["apellidos"].'  </td>
                    </tr>
                    ';
                    $count++;
                }
            ?>
        </tbody>
    </table>
    
</div>


<script>
$(document).ready(function(){
	$("#buscador").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tabla_lista tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});	

});
</script>



