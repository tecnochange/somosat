<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_autorizaciones_equipo").addClass("active_item");
    
    $('.custom-scrollbar').animate({ scrollTop: $('#bt_desempenio_administrar').offset().top - 500 }, 1000);
});
</script>

<?php
	$css_edit = "";
	if($_SESSION['anio'] < 2022){
		$css_edit = "display: none";
	}
?>

<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Autorizaciones <?php echo $_SESSION["anio"]; ?></h2>
                    </td>
                    <td align="right">
                        
                        
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-12">

            <table class="table table-bordered" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col">Colaborador</th>
                    <th scope="col"># Objetivos</th>
                    <th scope="col">Estado</th>
                    <th scope="col">
                        Acciones
                    </th>
                </tr>
                </thead>

                <tbody id="tabla_lista">
                <?php
                    $count = 1;
                    $query = mysqli_query($connect_desempenio,"SELECT * FROM Aprobaciones_Objetivos 
                    WHERE id_jefe = '".$_SESSION['id_user']."' AND anio = '".$_SESSION['anio']."' ");  
                    while($data = mysqli_fetch_array($query)){ 
                        
                        $queryColaborador = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
                        WHERE id = '".$data['id_empleado']."' ");  
                        $dataColaborador = mysqli_fetch_array($queryColaborador);
                        
                        $queryObjetivos = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
                        WHERE id_empleado = '".$data['id_empleado']."' AND anio = '".$_SESSION['anio']."' ");  
                        
                        $txt_estado = "";
                        foreach($Array_Estado_Autorizaciones  as $estado){
                            if($estado[0] == $data["estado"]){
                                $txt_estado = $estado[1];
                            }
                        }

                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$dataColaborador["nombre"].' '.$dataColaborador["apellidos"].'</td>
                            <td>'.$queryObjetivos->num_rows.'</td>
                            <td>'.$txt_estado.'</td>
                            <td>
                                <a href="'.$url.'/?pg=desempenio/objetivo/autorizacion&id='.$data["id"].'">
                                    <button type="button" class="btn btn-success btn-sm" title="Editar" style="'.$css_edit.'"  >
                                        Ver Objetivos
                                    </button>
                                </a>
                            </td>
                        </tr>
                        
                        ';
                        $count++;
                    }
                ?>
                </tbody>
            </table>
            
            
            
        </div>
        
    
    </div>
</div>


