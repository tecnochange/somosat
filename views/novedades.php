<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
});
</script>


<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                  <h3>Novedades</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Novedades</a></li>
                    <li class="breadcrumb-item">Lista</li> 
                  </ol>
            </div>
            <div class="col-sm-6" align="right">
                <a href="<?php echo $url; ?>/informes/reporte_novedades.php" target="_blank" >
                    <button type="button" class="btn btn-secondary">Generar Reporte</button> 
                </a> 
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        
        <!-- Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                  
                <div class="card-body">
                    <div class="e_movil" style="text-align: right; line-height: 14px; color: #004b98;">
                        Deslice la tabla de izquierda a derecha para ver el contenido >>
                    </div>
                    <table id="tabla_maestra" class="display" width="100%" style="font-size: 12px">
                        <thead class="bg-secondary">
                            <tr>
                              <th>#</th>
                              <th>Vista</th>
                              <th>Tipo</th>
                              <th>Modificado por</th>
                              <th>Fecha</th>
                              <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        $query = mysqli_query($connect_valentina,"SELECT Novedades.vista AS vista, Novedades.tipo AS tipo, Novedades.created_at AS created_at, 
                        Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2, Empleados.apellidos AS apellidos, 
                        Empleados.apellidos_2 AS apellidos_2, Novedades.id AS id 
                        FROM Novedades 
                        LEFT JOIN Empleados ON Empleados.id = Novedades.id_colaborador 
                        ORDER BY Novedades.created_at DESC ");
  
                        while($data = mysqli_fetch_array($query)){
                            $bt_editar = '';
                            if($user_log["role"] == 1){
                                $bt_editar = '
                                <a href="'.$url.'?pg=novedad/detalle&id='.$data["id"].'" class="btn btn-outline-primary" title="Detalle">
                                    <i class="fa fa-eye"></i>
                                </a>
                                ';
                            }
                            
                            $txt_tipo = "";
                            foreach($Array_Novedades as $estado){
                                if($estado[0] == $data["tipo"] ){
                                    $txt_tipo = $estado[1];   
                                }
                            }
                            
                            echo '
                                <tr>
                                    <td>'.$count.'</td>
                                    <td>'.$data["vista"].'</td>
                                    <td>'.$txt_tipo.'</td>
                                    <td>'.$data["nombre"].' '.$data["nombre_2"].' '.$data["apellidos"].' '.$data["apellidos_2"].'</td>
                                    <td>'.$data["created_at"].'</td>
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
            </div>
        </div>
        <!-- Configuration  Ends-->
             
    </div>
</div>



<script>  
$(document).ready(function() {
    $('#tabla_maestra').DataTable( {
        "scrollY": '50vh',
        "scrollX": true, 
        "scrollCollapse": true,
    } );
} );
</script>