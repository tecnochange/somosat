<style>
.icon_lateral{
    border-radius: 30px;
    color: #ffffff;
    /*
    background-color: #c0e83e;
    padding: 5px;
    border: 2px solid #5c349e;
    */
}
</style>


<div style="padding: 10px; padding-top: 15px; padding-bottom: 15px; font-weight: bold;" align="center">
    <img src="<?php echo $url; ?>/img/LOGO_DE_AT1.png" height="100">
	<div>
		<?php echo $txt_role; ?>
	</div>
</div>

<ul class="list-group list-unstyled" style="margin-top: 10px;">
    <li id="bt_home">
        <a href="<?php echo $url; ?>?pg=home/muro">
            <i class="bx bx-home icoLat icoGroup icon_lateral"></i> <span class="text_lateral">Inicio</span>
        </a>
    </li>
</ul>


<ul class="list-group list-unstyled">
    <?php include("views/layouts/lateral_administrativo.php"); ?>
</ul>

<ul class="list-group list-unstyled" style="display: none">
    <?php //include("views/layouts/lateral_novedades.php"); ?>
</ul>

<ul class="list-group list-unstyled">
    <?php include("views/layouts/lateral_valoracion.php"); ?>
</ul> 

<ul class="list-group list-unstyled">
    <?php include("views/layouts/lateral_desempenio.php"); ?>
</ul> 

<ul class="list-group list-unstyled">
    <?php include("views/layouts/lateral_formacion.php"); ?>
</ul> 
<?php if ($_SESSION['role_plataforma'] == 1) { ?>
<ul class="list-group list-unstyled">
    <?php include("views/layouts/lateral_endomarketing.php"); ?>
</ul> 

<ul class="list-group list-unstyled">
    <?php include("views/layouts/lateral_asistente.php"); ?>
</ul> 

<?php } ?>


<ul class="list-group list-unstyled">
    <li id="bt_cuenta">
        <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos">
            <i class="bx bx-user icoLat icoGroup"></i> <span class="text_lateral">Mi Cuenta</span>
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
        padding-left: 20px !important;
    }
    .sub_items:hover{
        background-color: #00b49f;
    }
    .active_item{
        color: #ffffff;
		background-color: #0000004d;
		font-weight: bold;
		margin: 0px 6px;
		border-radius: 30px;
		border: 2px solid #ff8300;
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





