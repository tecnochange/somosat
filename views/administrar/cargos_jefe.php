<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Administrar Cargos</h2>
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
        
        <ul class="nav nav-tabs">
              <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/cargos" class="nav-link active" >Inventario Cargos</a>
              </li>
              
              <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/cargos_estructura" class="nav-link">Estructura Cargos</a>
              </li>
        </ul>
        
        
        
        
        
       
        
        <div class="col-md-12">
            
    
            <table class="table table-bordered" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col" width="150">Cargo</th>
                    <th scope="col" width="150">Nivel del Cargo</th>
                    <th scope="col" width="150">Cargo reporte</th>
                    <th scope="col" width="150">Área</th>
                    <th scope="col" width="150">Estado</th>
                    <th scope="col" width="100"></th>
                </tr>
                </thead>

                <tbody id="tabla_lista">
                <?php
                    
                    $lista_cargos = array();
                    
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_area = '".$dtCargo["id_area"]."' ORDER BY nombre ASC ");
                    while($data = mysqli_fetch_array($query)){
                        
                        array_push($lista_cargos, $data["id"] );
                        
                        $queryReporte1 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$data["id"]."' ");  
                        while($dataReporte1 = mysqli_fetch_array($queryReporte1)){
                            
                            array_push($lista_cargos, $dataReporte1["id"] );
                            
                            $queryReporte2 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataReporte1["id"]."' ");  
                            while($dataReporte2 = mysqli_fetch_array($queryReporte2)){
                                
                                array_push($lista_cargos, $dataReporte2["id"] );
                                
                                $queryReporte3 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataReporte2["id"]."' ");  
                                while($dataReporte3 = mysqli_fetch_array($queryReporte3)){
                                    
                                    array_push($lista_cargos, $dataReporte3["id"] );
                                    
                                    $queryReporte4 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataReporte3["id"]."' ");  
                                    while($dataReporte4 = mysqli_fetch_array($queryReporte4)){
                                        
                                        array_push($lista_cargos, $dataReporte4["id"] );
                                        
                                        $queryReporte5 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataReporte4["id"]."' ");  
                                        while($dataReporte5 = mysqli_fetch_array($queryReporte5)){
                                            
                                            array_push($lista_cargos, $dataReporte5["id"] );
                                            
                                            $queryReporte6 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataReporte5["id"]."' ");  
                                            while($dataReporte6 = mysqli_fetch_array($queryReporte1)){
                                                    
                                                array_push($lista_cargos, $dataReporte6["id"] );    
                                                
                                                $queryReporte7 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataReporte6["id"]."' ");  
                                                while($dataReporte7 = mysqli_fetch_array($queryReporte7)){
                                                        array_push($lista_cargos, $dataReporte7["id"] );

                                                }
                                                
                                            }

                                        }

                                    }    
                                    
                                }
                                

                            }
                        
                        }
                        
                        
                    }
                    
                $count = 1;
                foreach($lista_cargos as $cargo){
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id = '".$cargo."' ORDER BY nombre ASC ");  
                    while($data = mysqli_fetch_array($query)){ 
                        
                        $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data["id_area"]."' ");  
                        $dataArea = mysqli_fetch_array($queryArea);
                        
                        $queryReporte = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["padre"]."' ");  
                        $dataReporte = mysqli_fetch_array($queryReporte);
                        
                        $txt_nivel = '';
                        foreach($Array_Nivel_Cargo as $nivel){
                            if($nivel[0] == $data["nivel_cargo"]){ $txt_nivel = $nivel[1]; }
                        }
                        
                        $txt_estado = '';
                        foreach($Array_Estado as $nivel){
                            if($nivel[0] == $data["estado"]){ $txt_estado = $nivel[1]; }
                        }
                        
                        $bt_editar = '';
                        if($dtEmpleado["role"] == 1){
                            $bt_editar = '
                                <a href="'.$url.'?pg=administrar/cargos/detalle&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                </a>
                            ';
                        }
                            
                        
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].'</td>
                            <td>'.$txt_nivel.'</td>
                            <td>'.$dataReporte["nombre"].'</td>
                            <td>'.$dataArea["nombre"].'</td>
                            <td>'.$txt_estado.'</td>
                            <td>
                                '.$bt_editar.'
                                <a href="'.$url.'?pg=administrar/cargos/descriptivos&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-info btn-sm" title="Descriptivo">
                                    <i class="fas fa-plus"></i>
                                </button>
                                </a>
                                
                            </td>
                        </tr>
                        
                        ';
                        $count++;
                    }
                }
                ?>
                </tbody>
            </table>

        </div>
        
    
    </div>
</div>





            
          



<script>
    $("#bt_adm_cargos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>



