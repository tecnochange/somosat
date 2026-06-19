<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
    $("#desplegable_novedades").show();
    $("#bt_novedades_licencias").addClass("active_item");
});
</script>
<?php
    require("app/models/Areas.php");
    $ClassAreas = new Areas();
    $areas = $ClassAreas->lista($connect_valentina);
?>

<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                  <h3>Licencias</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estructura</a></li>
                    <li class="breadcrumb-item">Licencias</li> 
                  </ol>
            </div>
            <div class="col-sm-6" align="right">
                <?php if($user_log["role"] == 1){ ?>
                <a href="<?php echo $url; ?>?pg=novedades/licencia/detalle" >
                    <button type="button" class="btn btn-outline-primary">Solicitar Licencias</button> 
                </a> 
                <?php } ?>
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
                    
                    <div class="barra_superior">
                        <div class="div_content"></div>
                    </div>
                    
                    <div class="table-responsive">
                    <table id="tabla_maestra" class="display" width="100%" style="font-size: 12px">
                        <thead class="bg-secondary">
                            <tr>
                              <th>#</th>
                              <th>Colaborador</th>
                              <th>Fecha Solicitud</th>
                              <th>Tipo</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        $query = mysqli_query($connect_novedades,"SELECT * FROM Vacaciones WHERE id_colaborador = '".$_SESSION['id_user_valentina']."' ");  
                        while($data = mysqli_fetch_array($query)){ 
                            
                            $bt_editar = '';
                            if($user_log["role"] == 1 ){
                                $bt_editar = '
                                <a href="'.$url.'?pg=administrar/area/detalle&id='.$area["id"].'" class="btn btn-outline-primary btn-sm" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                ';
                            }
                            
                            echo '
                                <tr>
                                    <td>'.$count.'</td>
                                    <td>'.$area["nombre"].'</td>
                                    <td>'.$area["nombre_padre"].'</td>
                                    <td>'.$area["codigo"].'</td>
                                    <td>'.$area["nivel"].'</td>
                                    <td>'.$queryCargos->num_rows.'</td>

                                    <td>'.$area["estado"].'</td>
                                    <td  align="center">
                                        '.$bt_editar.'
                                        <a href="'.$url.'?pg=administrar/area/resumen&id='.$area["id"].'" class="btn btn-secondary btn-sm" title="Resumen">
                                    <i class="fa fa-eye"></i>
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
        </div>
        <!-- Configuration  Ends-->
             
    </div>
</div>



<!-- PARA CREAR LA TABLA DINAMICA -->
<style>
    .barra_superior{
        overflow-x: scroll;
        overflow-y:hidden;
        width: 100%;
    }
    .div_content{
        height: 10px;
    }
</style>
                                       
<script>  
    $(document).ready(function() {
        $('#tabla_maestra').DataTable();
        $('.div_content').width( $('#tabla_maestra').width() );
    } );
    
    $(function(){
        $(".barra_superior").scroll(function(){
            $(".table-responsive").scrollLeft($(".barra_superior").scrollLeft());
        });
        $(".table-responsive").scroll(function(){
            $(".barra_superior").scrollLeft($(".table-responsive").scrollLeft());
        });
    }); 
</script>