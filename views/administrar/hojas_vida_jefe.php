<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Hojas de vida</h2>
                    </td>
                    <td align="right">
                        <?php if($dtEmpleado["role"] == 1){ ?>
                        <a href="<?php echo $url; ?>?pg=administrar/colaborador/detalle">
                        <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
                            <i class="fas fa-plus"></i> Crear Colaborador
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
            
            <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a href="<?php echo $url; ?>?pg=administrar/colaboradores_jefe" class="nav-link " >Colaboradores </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo $url; ?>?pg=administrar/hojas_vida_jefe" class="nav-link active">Hojas de vida</a>
                  </li>
                <li class="nav-item">
                    <a href="<?php echo $url; ?>?pg=administrar/hv_propia_jefe_" class="nav-link">HV Propia</a>
                </li>
            </ul>

            <table class="table table-bordered" style="margin-top: 15px">
                <thead class="thead-success">
                <tr>
                    <th scope="col" width="15">#</th>
                    <th scope="col" width="150">Nombres</th>
                    <th scope="col" width="150">Apellidos</th>
                    <th scope="col" width="150">Cargo</th>
                    <th scope="col" width="150">Correo</th>
                    <th scope="col" width="150">Cedula</th>
                    <th scope="col" width="150">Role</th>
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
 
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_empresa = '".$_SESSION['id_empresa']."' AND estado = 1 AND id_cargo = '".$cargo."' ORDER BY nombre ASC  ");  
                    while($data = mysqli_fetch_array($query)){ 
                        
                        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
                        $dataCargo = mysqli_fetch_array($queryCargo);
                        
                        $txt_role = '';
                        foreach($Array_Role as $role){
                            if($role[0] == $data["role"]){  $txt_role = $role[1]; }
                        }
                        
                        $txt_estado = '';
                        foreach($Array_Estado  as $estado){
                            if($estado[0] == $data["estado"]){  $txt_estado = $estado[1]; }
                        }
                        
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].'</td>
                            <td>'.$data["apellidos"].'</td>
                            <td>'.$dataCargo["nombre"].'</td>
                            <td>'.$data["correo"].'</td>
                            <td>'.$data["cedula"].'</td>
                            <td>'.$txt_role.'</td>
                            <td>'.$txt_estado.'</td>
                            <td>
                                
                                <a href="'.$url.'?pg=administrar/colaborador/detalle&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-file"></i>
                                </button>
                                </a>
                               
                            </td>
                        </tr>
                        
                        ';
                        $count++;
                    }
                    
                    /*
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_empresa = '".$_SESSION['id_empresa']."' AND estado =  2 AND  id_cargo = '".$cargo."' ORDER BY nombre ASC  ");  
                    while($data = mysqli_fetch_array($query)){ 
                        
                        $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");  
                        $dataCargo = mysqli_fetch_array($queryCargo);
                        
                        $txt_role = '';
                        foreach($Array_Role as $role){
                            if($role[0] == $data["role"]){  $txt_role = $role[1]; }
                        }
                        
                        $txt_estado = '';
                        foreach($Array_Estado  as $estado){
                            if($estado[0] == $data["estado"]){  $txt_estado = $estado[1]; }
                        }
                        
                        echo '
                        <tr>
                            <td>'.$count.'</td>
                            <td>'.$data["nombre"].'</td>
                            <td>'.$data["apellidos"].'</td>
                            <td>'.$dataCargo["nombre"].'</td>
                            <td>'.$data["correo"].'</td>
                            <td>'.$data["cedula"].'</td>
                            <td>'.$txt_role.'</td>
                            <td>'.$txt_estado.'</td>
                            <td>
                                
                                <a href="'.$url.'?pg=administrar/colaborador/detalle&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                </a>
                                
                                <a href="'.$url.'?pg=administrar/colaborador/hoja_vida&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" title="Hoja de Vida">
                                    <i class="fas fa-eye"></i> 
                                </button>
                                </a>
                            </td>
                        </tr>
                        
                        ';
                        $count++;
                    }
                    */
                    
                }
                    
                ?>
                </tbody>
            </table>
            
            
            
        </div>
        
    
    </div>
</div>

         



<script>
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>



