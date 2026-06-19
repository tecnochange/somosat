<li class="side-nav-item" id="valoracion_menu">
    
    <!-- ESTRUCTURA -->
    <a href="#valoracionSubmenu" data-bs-toggle="collapse"  aria-expanded="true" aria-controls="valoracionSubmenu" class="side-nav-link">
        <table width="100%">
            <tr>
                <td width="40"><i class="bx bx-equalizer icoGroup icon_lateral" style=" margin-right: 7px;"></i></td>
                <td><span class="text_lateral" style="font-weight: bold; color: #ff8300;">Feedback</span></td>
                <td width="30" align="right"><i class="bx bx-down-arrow-alt"></i></td>
            </tr>
        </table>
    </a>
    
    <!-- OPCIONES -->
    <ul class="collapse list-unstyled" id="valoracionSubmenu">
            
        <div style="padding: 10px;" > 
            <form action="?pg=valoracion/realizar_valoracion" method="post">
				<input type="hidden" name="csrf" value="<?php echo $_SESSION['token']; ?>">
                <select class="form-control form-control-sm" name="anio_select" style="font-weight: bold;" onChange="Carga_Ciclos(this.value)">
                    <option value="">Selecciona Año...</option>
                    <?php 
                        $queryAnios = mysqli_query($connect_valentina,"SELECT * FROM Licencias_Empresas 
                        WHERE id_empresa = 1 ");
                        while($dataAnios = mysqli_fetch_array($queryAnios)){
                            if($dataAnios["anio"] == $_SESSION['anio']){ 
                                echo '<option value="'.$dataAnios["anio"].'" selected>'.$dataAnios["anio"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataAnios["anio"].'">'.$dataAnios["anio"].'</option>';
                            }
                        }
                    ?>
                </select>
                    
                    
                <select class="form-control form-control-sm" name="ciclo_select" id="ciclo_select" style=" margin-top: 10px;">
                        <option value="">Selecciona Ciclo...</option>
                        <?php 

                        if( !$_SESSION['ciclo'] ){
                            $actual_momento = date("Y-m-d");

                            $queryValClos = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos 
                            WHERE id_empresa = '".$_SESSION['id_empresa']."' AND 
                            fecha_inicia <= '".$actual_momento."' AND fecha_termina >= '".$actual_momento."' AND anio = '".$_SESSION['anio']."'  ");
                            $dataValClos = mysqli_fetch_array($queryValClos);
                            if($queryValClos->num_rows > 0){
                                $_SESSION['ciclo'] = $dataValClos["id"];
                            }
                        }
                        
                        $ciclo_select = false;
                        $queryClos = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos 
                        WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' ");
                        while($dataClos = mysqli_fetch_array($queryClos)){
                            if($dataClos["id"] == $_SESSION['ciclo']){
                                echo '<option value="'.$dataClos["id"].'" selected>'.$dataClos["nombre"].'</option>';
                                $ciclo_select = true;
                            }
                            else{
                                echo '<option value="'.$dataClos["id"].'">'.$dataClos["nombre"].'</option>';
                            }
                        }
                        
                        if($queryClos->num_rows == 0 ){ $_SESSION['ciclo'] = ""; }
                        if($ciclo_select == false){ $_SESSION['ciclo'] = ""; }
                        
                        ?>
                </select>
                <button type="submit" class="btn btn-success btn-sm btn-block" style=" margin-top: 10px; width: 100%;">
                    Seleccionar
                </button>
            </form>
        </div>
          
            
        
        <li class="sub_items" id="bt_val_realizar"> 
              <a href="<?php echo $url; ?>?pg=valoracion/realizar_valoracion">Realizar Valoración </a> 
         </li>
        
            
        <?php if( $_SESSION['role_plataforma'] == 1 ){ ?>
            <li class="sub_items" id="bt_val_competencias"> 
                <a href="<?php echo $url; ?>?pg=valoracion/competencias">Competencias / Comportarmientos </a> 
            </li>
        <?php } ?>
            
        <?php if( $_SESSION['role_plataforma'] == 1){ ?>
            <li class="sub_items" id="bt_val_perfiles"> 
                <a href="<?php echo $url; ?>?pg=valoracion/perfiles">Perfiles Competencias </a> 
            </li>
        <?php } ?>
            
        <?php if( $_SESSION['role_plataforma'] == 200 ){ ?>
            <li class="sub_items" id="bt_val_perfiles"> 
                <a href="<?php echo $url; ?>?pg=valoracion/perfiles_jefe">Perfiles Competencias. </a> 
            </li>
        <?php } ?>
            
        <?php if( $_SESSION['role_plataforma']  ==300){ ?>
            <li class="sub_items" id="bt_val_perfiles"> 
                <a href="<?php echo $url; ?>?pg=valoracion/perfiles_usuario">Perfiles Competencias. </a> 
            </li>
        <?php } ?>
            
            
        <?php if( $_SESSION['role_plataforma'] == 1){ ?>
            <li class="sub_items" id="bt_val_programacion"> 
                <a href="<?php echo $url; ?>?pg=valoracion/programacion">Programación Valoración </a> 
            </li>
        <?php } ?>
        
        <?php if( $_SESSION['role_plataforma'] == 1){ ?>
            <li class="sub_items" id="bt_val_arbol"> 
                <a href="<?php echo $url; ?>?pg=valoracion/arbol">Arbol Valoración </a> 
            </li>
        <?php } ?>
            
        <?php if( $_SESSION['role_plataforma'] == 1 || $_SESSION['role_plataforma'] == 2 ){ ?>
            <li class="sub_items" id="bt_val_seguimiento"> <a href="<?php echo $url; ?>?pg=valoracion/seguimiento">Seguimiento / Formularios</a> </li>
        <?php } ?>
            
            
        <?php if( $_SESSION['role_plataforma'] == 1){ ?>
			<li class="sub_items" id="bt_val_informes"> <a href="<?php echo $url; ?>?pg=valoracion/informes/individuales">Administrar Informes</a> </li>
        <?php } ?>
            
            
        <?php if($_SESSION['role_plataforma'] == 2 || $_SESSION['role_plataforma'] == 3 ){ ?>
            <li class="sub_items" id="bt_val_informes"> <a href="<?php echo $url; ?>?pg=valoracion/informes_propios">Informes Propios / Equipo</a> </li>
		<?php } ?>
		
		<?php if($_SESSION['role_plataforma'] == 2 || $_SESSION['role_plataforma'] == 3 ){ ?>
            <li class="sub_items" id="bt_retro_individual"> 
                <a href="<?php echo $url; ?>?pg=valoracion/retro_individual">Retroalimentación Individual / Equipo </a> 
            </li>
		<?php } ?>
            
		<?php if($_SESSION['role_plataforma'] == 1  ){ ?>
            <li class="sub_items" id="bt_retro_individual"> 
                <a href="<?php echo $url; ?>?pg=valoracion/retro_general">Seguimiento Retroalimentación</a> 
            </li>
		<?php } ?> 

            
    </ul>
    
</li>





<script>
    function Carga_Ciclos(anio){
        jQuery.ajax({
                url: "<?php echo $url; ?>/api/valoracion/cargar_ciclos.php",
                type:'post',
                data: {anio: anio, id_empresa: <?php echo $_SESSION["id_empresa"]; ?> },
                }).done(function (resp){
                    $("#ciclo_select").html(resp);
                })
                .fail(function(resp) {
                    console.log(resp);
                })
                .always(function(resp){
                }
        );
        
    }
</script>


<li class="side-nav-item" id="mejora_menu" style="display: none">
    
    <!-- ESTRUCTURA -->
    <a href="#mejoraSubmenu" data-bs-toggle="collapse"  aria-expanded="true" aria-controls="mejoraSubmenu" class="side-nav-link">
        <table width="100%">
            <tr>
                <td width="40"><i class="bx bx-trip icoGroup icon_lateral" style=" margin-right: 7px;"></i></td>
                <td><span class="text_lateral" style="font-weight: bold; color: #ff8300;">Mejora Continua</span></td>
                <td width="30" align="right"><i class="bx bx-down-arrow-alt"></i></td>
            </tr>
        </table>
    </a>
    
    <!-- OPCIONES -->
    <ul class="collapse list-unstyled" id="mejoraSubmenu">
            
              
            
    </ul>
    
</li>






