<div style="padding: 10px; padding-top: 15px; padding-bottom: 5px; color: #8f8f8f; font-weight: bold;" align="center">
    <img src="<?php echo $url; ?>/img/logo_hr_suite.png" width="50">
</div>

<ul class="list-unstyled">
    <li id="bt_home">
        <a href="<?php echo $url; ?>?pg=home">
            <i class="bx bx-home icoLat"></i>Inicio
        </a>
    </li> 
    
    <li id="bt_estructura">
        <a href="<?php echo $url; ?>?pg=home">
            <i class="bx bx-home icoLat"></i>Estructura
        </a>
    </li> 
    
    <li id="bt_atraccion">
        <a href="<?php echo $url; ?>?pg=home">
            <i class="bx bx-home icoLat"></i>Atracción
        </a>
    </li> 
    
    <li id="bt_compensacion">
        <a href="<?php echo $url; ?>?pg=home">
            <i class="bx bx-home icoLat"></i>Compensación
        </a>
    </li> 
    
    <li id="bt_aprendizaje">
        <a href="<?php echo $url; ?>?pg=home">
            <i class="bx bx-home icoLat"></i>Plataforma de aprendizaje
        </a>
    </li> 
    
</ul>


<style>
    
    .visible{
        /*display: none;*/
    }
    
    .tx_menu{
        margin-left: 10px;
    }
    .sub_items{
        padding-left: 15px !important;
    }
    .active_item{
        color: #000000;
        background-color: #00000033;
    }
    .show{
        
    }
    .list-unstyled{
        transition: 0.5s all;
    }
    .active{
        display: block;
    }
</style>

<script>
$('#seleccion_menu .collapse').collapse();
</script>




