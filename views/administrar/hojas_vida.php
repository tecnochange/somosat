<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Hojas de Vida</h2>
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
                    <a href="<?php echo $url; ?>?pg=administrar/colaboradores" class="nav-link " >Colaboradores </a>
                  </li>

                  <li class="nav-item">
                    <a href="<?php echo $url; ?>?pg=administrar/hojas_vida" class="nav-link active">Hojas de vida</a>
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
                    $count = 1;
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado = 1 ORDER BY nombre ASC  ");  
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
                                
                                <a href="'.$url.'?pg=administrar/colaborador/detalle_hoja&id='.$data["id"].'">
                                <button type="button" id="sidebarCollapse" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-file"></i>
                                </button>
                                </a>
                            </td>
                        </tr>
                        
                        ';
                        $count++;
                    }
                    
                    
                    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE estado =  2 ORDER BY nombre ASC  ");  
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



