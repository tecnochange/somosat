<li class="side-nav-item" id="asistente_menu">
    
    <!-- ESTRUCTURA -->
    <a href="#asistenteSubmenu" data-bs-toggle="collapse"  aria-expanded="true" aria-controls="asistenteSubmenu" class="side-nav-link">
        <table width="100%">
            <tr>
                <td width="40"><i class="bx bx bx-show icoGroup icon_lateral" style=" margin-right: 7px;"></i></td>
                <td><span class="text_lateral" style="font-weight: bold; color: #ff8300;">Agente IA</span></td>
                <td width="30" align="right"><i class="bx bx-down-arrow-alt"></i></td>
            </tr>
        </table>
    </a>
    
    <!-- OPCIONES -->
    <ul class="collapse list-unstyled" id="asistenteSubmenu">
		
		<li class="sub_items" id="bt_agente_preguntas">
            <a href="<?php echo $url; ?>?pg=asistentes/preguntas">
                <span class="text_lateral">Guiones</span>
            </a>
        </li>
        
        <li class="sub_items" id="bt_agente_ayuda">
            <a href="<?php echo $url; ?>?pg=ayuda">
                <span class="text_lateral">Chat</span>
            </a>
        </li>
   
   
    </ul>
    
</li>


