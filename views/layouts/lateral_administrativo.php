<li class="side-nav-item" id="administrativo_menu">
    
    <!-- ESTRUCTURA -->
    <a href="#adminSubmenu" data-bs-toggle="collapse"  aria-expanded="true" aria-controls="adminSubmenu" class="side-nav-link">
        <table width="100%">
            <tr>
                <td width="40"><i class="bx bx-group icoGroup icon_lateral" style=" margin-right: 7px;"></i></td>
                <td><span class="text_lateral" style="font-weight: bold; color: #ff8300;">Estructura</span></td>
                <td width="30" align="right"><i class="bx bx-down-arrow-alt"></i></td>
            </tr>
        </table>
    </a>
    
    <!-- OPCIONES -->
    <ul class="collapse list-unstyled" id="adminSubmenu">
		
		<li class="sub_items" id="bt_adm_directorio">
            <a href="<?php echo $url; ?>?pg=administrar/directorio">
                <span class="text_lateral"> Directorio</span>
            </a>
        </li>
		
		<li class="sub_items" id="bt_adm_organigrama">
            <a href="<?php echo $url; ?>?pg=administrar/estructura_equipos">
                <span class="text_lateral">Organigrama</span>
            </a>
        </li>
		
		<?php if($_SESSION['role_plataforma']  == 1){ ?>
		<li class="sub_items" id="bt_adm_equipos">
            <a href="<?php echo $url; ?>?pg=administrar/equipos_lista">
                <span class="text_lateral">Equipos</span>
            </a>
        </li>
		<li class="sub_items" id="bt_adm_puestos">
            <a href="<?php echo $url; ?>?pg=administrar/cargos">
                <span class="text_lateral">Cargos</span>
            </a>
        </li>
		<li class="sub_items" id="bt_adm_areas">
            <a href="<?php echo $url; ?>?pg=administrar/areas">
                <span class="text_lateral">Áreas</span>
            </a>
        </li>
		<li class="sub_items" id="bt_adm_gerencias">
            <a href="<?php echo $url; ?>?pg=administrar/gerencias">
                <span class="text_lateral">Departamentos</span>
            </a>
        </li>
		<li class="sub_items" id="bt_adm_colaboradores">
            <a href="<?php echo $url; ?>?pg=administrar/colaboradores">
                <span class="text_lateral"> Colaboradores</span>
            </a>
        </li>
		<li class="sub_items" id="bt_adm_jefes"> 
            <a href="<?php echo $url; ?>?pg=administrar/jefes">
                <span class="text_lateral">Jefes</span>
            </a> 
        </li>
		<li class="sub_items" id="bt_adm_alertas"> 
            <a href="<?php echo $url; ?>?pg=administrar/alertas">
                <span class="text_lateral">Alertas</span>
            </a> 
        </li>
        <li class="sub_items" id="bt_adm_administar"> 
            <a href="<?php echo $url; ?>?pg=administrar/administrar">
                <span class="text_lateral">Administrar</span>
            </a> 
        </li>
        <li class="sub_items" id="bt_adm_dashboard"> 
            <a href="<?php echo $url; ?>?pg=administrar/dashboard">
                <span class="text_lateral">Tablero</span>
            </a> 
        </li>
        
		<?php } ?>
		
		
		<?php if( $_SESSION['role_plataforma']  == 2 ){ ?>
		<li class="sub_items" id="bt_adm_directorio">
            <a href="<?php echo $url; ?>?pg=administrar/mi_equipo">
                <span class="text_lateral"> Mi Equipo</span>
            </a>
        </li>
		<?php } ?>
		
		<li class="sub_items" id="bt_adm_directorio">
            <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos">
                <span class="text_lateral"> Mis Datos</span>
            </a>
        </li>
		
		<li class="sub_items" id="bt_adm_mi_perfil">
            <a href="<?php echo $url; ?>?pg=perfil/ficha/mi_perfil_cargo">
                <span class="text_lateral"> Mi Perfil de Cargo</span>
            </a>
        </li>
		
		<?php if( $_SESSION['role_plataforma']  == 1 ){ ?>
		<li class="sub_items" id="bt_adm_ingresos">
            <a href="<?php echo $url; ?>?pg=administrar/ingresos">
                <span class="text_lateral"> Ingresos</span>
            </a>
        </li>
		<li class="sub_items" id="bt_adm_alta">
            <a href="<?php echo $url; ?>?pg=administrar/altas">
                <span class="text_lateral"> Bajas</span>
            </a>
        </li>
		<?php } ?>

            
    </ul>
    
</li>

