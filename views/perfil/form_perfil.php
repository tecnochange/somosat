<div class="card custom-card" style="margin-bottom: 30px">
                
    <div class="card-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.15);">
        Mi Cuenta
    </div>
                
    <div class="card-body">
        <div align="center">
            <h4><?php echo $user_log["nombre"]." ".$user_log["nombre_2"]." ".$user_log["apellidos"]." ".$user_log["apellidos_2"]; ?></h4>
            <p><?php echo $cargo_user; ?></p>
        </div>
                    
    </div>
                
    <div class="bt_mi_perfil">
        <a href="<?php echo $url; ?>/?pg=perfil/detalle">
            <i class="ti-user icon1"></i> Mi Perfil
        </a>
    </div>
    
    <div class="bt_mi_perfil" >
        <a href="<?php echo $url; ?>/?pg=perfil/cambiar_pass">
            <i class="ti ti-alert icon1"></i> Cambiar contraseña
        </a>
    </div>

    <div class="bt_mi_perfil">
        <a href="<?php echo $url; ?>/app/controllers/close_sesion.php">
            <i class="ti-power-off icon1"></i> Cerrar Sesión
        </a>
    </div>
                
</div>