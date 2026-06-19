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
                $query = mysqli_query($connect_valentina,"SELECT * FROM aa_tmp_jefe ORDER BY nombre ASC  ");  
                while($data = mysqli_fetch_array($query)){ 
					
					$queryEmpl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE documento = '".$data["DOCUMENTO"]."' ");  
                    $dataEmpl = mysqli_fetch_array($queryEmpl);
					
					
					$queryJefe = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE CONCAT(nombre,' ', apellidos) = '".$data["JEFE"]."' " );  
                    $dataJefe = mysqli_fetch_array($queryJefe);
					
					if($queryJefe->num_rows > 0){
						/*
						mysqli_query($connect_valentina, "INSERT INTO  Jefes (  id_empleado ,  id_jefe ,  created_at ) 
						VALUES 
						( '".$dataEmpl["id"]."', '".$dataJefe["id"]."', '".$hoy."' ) " ); 
						*/
					}
					
					
					
					//mysqli_query($connect_valentina,"UPDATE Empleados SET id_departamento = '".$dataGer["id"]."' 
					//WHERE id = '".$data["id"]."' "); 
					
					/*
					mysqli_query($connect_valentina,"UPDATE Empleados_Copia SET id_nivel_cargo = '".$dataCargo["id"]."', 
					id_area = '".$dataArea["id"]."', id_departamento = '".$dataDep["id"]."' 
					WHERE id = '".$data["id"]."' "); 
					*/
					/*
					mysqli_query($connect_valentina,"UPDATE Empleados_Copia SET id_equipo = '".$dataEquipo["id"]."' 
					WHERE id = '".$data["id"]."' "); 
					*/
   
                    echo '
                        <tr>
                            <td>'.$count.'</td>

                            <td>'.$dataEmpl["nombre"].' '.$dataEmpl["apellidos"].'</td>
                            <td>'.$dataJefe["nombre"].' '.$dataJefe["apellidos"].'  </td>
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



