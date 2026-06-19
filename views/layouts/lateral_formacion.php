<li class="side-nav-item" id="formacion_menu">
    
    <!-- ESTRUCTURA -->
    <a href="#formacionSubmenu" data-bs-toggle="collapse"  aria-expanded="true" aria-controls="formacionSubmenu" class="side-nav-link">
        <table width="100%">
            <tr>
                <td width="40"><i class="bx bx-book-add icoGroup icon_lateral" style=" margin-right: 7px;"></i></td>
                <td><span class="text_lateral" style="font-weight: bold; color: #ff8300;">Formación</span></td>
                <td width="30" align="right"><i class="bx bx-down-arrow-alt"></i></td>
            </tr>
        </table>
    </a>
    
    <!-- OPCIONES -->
    <ul class="collapse list-unstyled" id="formacionSubmenu">
   
        <?php if( $_SESSION['role_plataforma'] == 1 ){ ?>
			<li class="sub_items" id="bt_formacion_solicitudes"> 
                <a href="<?php echo $url; ?>?pg=formacion/solicitudes">Solicitudes Referentes</a> 
            </li>
            <li class="sub_items" id="bt_formacion_gestionar"> 
                <a href="<?php echo $url; ?>?pg=formacion/gestionar">Gestionar Proceso</a> 
            </li>
			<li class="sub_items" id="bt_formacion_marcas"> 
                <a href="<?php echo $url; ?>?pg=formacion/marcas">Marcas</a> 
            </li>
			<li class="sub_items" id="bt_formacion_proveedores"> 
                <a href="<?php echo $url; ?>?pg=formacion/proveedores">Proveedores</a> 
            </li>
            <li class="sub_items" id="bt_formacion_cohortes"> 
                <a href="<?php echo $url; ?>?pg=formacion/cohortes">Participantes </a> 
            </li>
        <?php } ?>

        <?php if( $_SESSION['role_plataforma'] == 1 || $_SESSION['role_plataforma'] == 5 ){ ?>
			<li class="sub_items" id="bt_formacion_reportes"> 
                <a href="<?php echo $url; ?>?pg=formacion/reportes">Reportes </a> 
            </li>
        <?php } ?>
        
        <?php if( $_SESSION['role_plataforma'] == 1 ){ ?>
            <li class="sub_items" id="bt_formacion_seguimiento" style="display: none"> 
                <a href="<?php echo $url; ?>?pg=formacion/seguimiento">Seguimientos </a> 
            </li>
			<li class="sub_items" id="bt_formacion_alarmas"> 
                <a href="<?php echo $url; ?>?pg=formacion/alarmas_estudiantes">Alarmas</a> 
            </li>
			<li class="sub_items" id="bt_formacion_tablero"> 
                <a href="<?php echo $url; ?>?pg=formacion/tablero_estudiantes">Tablero</a> 
            </li>
        <?php } ?>
		
		<?php if( $_SESSION['role_plataforma'] == 2 ){ ?>
            <li class="sub_items" id="bt_formacion_planificar"> 
                <a href="<?php echo $url; ?>?pg=formacion/planificar">Planificar Formaciones </a> 
            </li>
		
			<li class="sub_items" id="bt_formacion_certificaciones_equipo"> 
                <a href="<?php echo $url; ?>?pg=formacion/certificaciones_equipo">Certificaciones Equipo </a> 
            </li>
        <?php } ?>
		

		<li class="sub_items" id="bt_formacion_mi_formacion"> 
			<a href="<?php echo $url; ?>?pg=formacion/mi_formacion">Mi formación </a> 
		</li>

            
    </ul>
    
</li>




