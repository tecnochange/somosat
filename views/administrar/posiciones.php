<script>  
$(document).ready(function(){
    $("#bt_adm_posiciones").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Posiciones</h2></td>
            <td align="right" width="200">
            	<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
                
            </td>
        </tr>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-success">
            <tr>
                <th scope="col" width="15">#</th>
                <th scope="col" >Código</th>
                <th scope="col" >Cargo</th>
                <th scope="col" >Nivel</th>
                <th scope="col" >Area</th>
                <th scope="col">Departamento</th>
				<th scope="col">Ocupante</th>
				<th scope="col">Equipos</th>
				<th scope="col">Estado</th>
                <th scope="col" width="100" align="center">
                    Acciones
                    <?php if($user_log["role"] == 1){ ?>
                        <a href="<?php echo $url; ?>?pg=administrar/posicion/detalle" style="display: none">
                        <button type="button" class="btn btn-outline-primary btn-sm" >
                            <i class="fas fa-plus"></i> Crear Posición
                        </button>
                        </a>
                    <?php } ?>
                </th>
            </tr>
        </thead>

        <tbody class="tabla_lista">
            <?php
                $count = 1;
				
				$sentencia = "
					SELECT 
					Posiciones.id AS id, 
					Posiciones.estado AS estado, 
					Cargos_Copia.nombre AS cargo_nombre, 
					Niveles_Cargo.nombre AS nivel_cargo, 
					Areas_Copia.nombre AS area_nombre, 
					Posiciones.id_departamento AS id_departamento 
					FROM Posiciones 
					LEFT JOIN Cargos_Copia ON Cargos_Copia.id = Posiciones.id_cargo 
					LEFT JOIN Niveles_Cargo ON Niveles_Cargo.id = Posiciones.id_nivel_cargo 
					LEFT JOIN Areas_Copia ON Areas_Copia.id = Posiciones.id_area 
					ORDER BY cargo_nombre ASC
				";
				
                $query= mysqli_query($connect_valentina, $sentencia);  
                while($data = mysqli_fetch_array($query)){

					/*
                    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Copia 
                    WHERE nombre = '".$data["cargo"]."' ");  
                    $dataCargo = mysqli_fetch_array($queryCargo);
					
					$queryNivel = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo 
                    WHERE nombre = '".$data["nivel_cargo"]."' ");  
                    $dataNivel = mysqli_fetch_array($queryNivel);
					
					$queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas_New 
                    WHERE nombre = '".$data["area"]."' ");  
                    $dataArea = mysqli_fetch_array($queryArea);
					
					$queryDept = mysqli_query($connect_valentina,"SELECT * FROM Areas_New 
                    WHERE nombre = '".$data["departamento"]."' ");  
                    $dataDept = mysqli_fetch_array($queryDept);
					
					*/
					$ocupantes = "";
					$equipos = "";
					$queryEmpleado = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Copia 
                    WHERE id_posicion = '".$data["id"]."' ");  
                    while($dataEmpleado = mysqli_fetch_array($queryEmpleado)){
						//mysqli_query($connect_valentina,"UPDATE Empleados_Copia SET id_posicion = '".$data["id"]."' WHERE id = '".$dataEmpleado["id"]."' ");
						$ocupantes .= $dataEmpleado["nombre"]." ".$dataEmpleado["nombre_2"]." ".$dataEmpleado["apellidos"]." ".$dataEmpleado["apellidos_2"]."<br>";
						
						$equipos .= $dataEmpleado["EQUIPO"]."<br>";
					}

                    $txt_estado = '';
                    foreach($Array_Estado as $nivel){
                        if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                    }
                    
                    $bt_editar = '';
                    if($user_log["role"] == 1){
                        $bt_editar = '
                            <a href="'.$url.'?pg=administrar/posicion/detalle&id='.$data["id"].'">
                                <button type="button" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="bx bx-message-square-edit"></i>
                                </button>
                            </a>
                        ';
                    }
    
                    echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["id"].'</td>
                            <td>'.$data["cargo_nombre"].'</td>
                            <td>'.$data["nivel_cargo"].'</td>
                            <td>'.$data["area_nombre"].'</td>
							<td>'.$data["departamento_nombre"].'</td>
							
                            <td>'.$ocupantes.'</td>
							<td>'.$equipos.'</td>
							<td>'.$txt_estado.'</td>
							
							
                            <td  align="center">
                                 '.$bt_editar.' 
                            </td>
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
