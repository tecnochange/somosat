
<?php if($_SESSION['role_plataforma']  == 1){ ?>
<li class="side-nav-item" id="endomarketing_menu">
    
    <!-- ESTRUCTURA -->
    <a href="#endomarketingSubmenu" data-bs-toggle="collapse"  aria-expanded="true" aria-controls="endomarketingSubmenu" class="side-nav-link">
        <table width="100%">
            <tr>
                <td width="40"><i class="bx bx-heart-circle icoGroup icon_lateral" style=" margin-right: 7px;"></i></td>
                <td><span class="text_lateral" style="font-weight: bold; color: #ff8300;">Endomarketing</span></td>
                <td width="30" align="right"><i class="bx bx-down-arrow-alt"></i></td>
            </tr>
        </table>
    </a>
    
    <!-- OPCIONES -->
    <ul class="collapse list-unstyled" id="endomarketingSubmenu">
		
		<li class="sub_items" id="bt_endo_publicar">
            <a href="<?php echo $url; ?>?pg=endomarketing/dashboard">
                <span class="text_lateral">Publicar</span>
            </a>
        </li>
        
        <li class="sub_items" id="bt_endo_publicaciones">
            <a href="<?php echo $url; ?>?pg=endomarketing/publicaciones">
                <span class="text_lateral">Historial</span>
            </a>
        </li>
        
        <li class="sub_items" id="bt_endo_banners">
            <a href="<?php echo $url; ?>?pg=endomarketing/banners">
                <span class="text_lateral">Banners</span>
            </a>
        </li>
                
       
        <li class="sub_items" id="bt_endo_ranking" style="display: none">
            <a href="<?php echo $url; ?>?pg=endomarketing/ranking">
                <span class="text_lateral">Analítica</span>
            </a>
        </li>
   
    </ul>
    
</li>

<?php } ?>