<?php
    $txt_role = '';
    foreach($Array_Role as $role){
        if($role[0] == $dtEmpleado["role"]){  $txt_role = $role[1]; }
    }
?>


<style>
    .min_foto_perfil{
        width: 50px;
        height: 50px;
        background-image: url('<?php echo $user_log['foto']; ?>');
        background-size: cover;
        border-radius: 50%;
        display: inline-table;
        border: 2px solid #00b49f;
        background-repeat: no-repeat;
        display: block;
    }
    
    @media (max-width: 768px) {
        .min_foto_perfil{
            width: 35px;
            height: 35px;
            border: 2px solid rgb(255 230 230);
            float: left;
        }
        .cargo_lat{
            display: none;
        }
        .name_lat{
            width: 86%;
        }
    }
    
    #menu_header{
        box-shadow: 1px 1px 5px rgb(0 0 0 / 5%);
        font-size: 11px;
        margin-bottom: 15px;
        position: fixed;
        width: calc(100% - 270px);
        background-color: #ffffff;
		z-index: 100;
    }
    
</style>

<div class="container-fluid" id="menu_header">
    
    <div class="row align-items-center" >
        <div class="col-md-12" align="left">
            <i class="bx bx-align-justify" style="font-size: 26px; color: #000000; padding: 15px;" id="sidebarCollapse" ></i>

            <table style="width: fit-content; float: right;">
                <tr>
                    <td width="50" align="center" style="border-left: 1px solid #f5f5f5;">
                        <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos">
                            <i class="bx bx-user" style="color: #12 1212; font-size: 25px;"></i>
                        </a>
                    </td>
                    <td width="50" align="center" style="border-left: 1px solid #f5f5f5;">
                        <a href="<?php echo $url; ?>/app/controllers/close_sesion.php">
                            <i class="bx bx-log-out" style="color: #f44336; font-size: 25px;"></i>
                        </a>
                    </td>
                    <td width="70" style="padding: 6px; background-color: #f5f5f5;" align="center">
                        <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos">
                            <div class="min_foto_perfil"></div>
                        </a>
                    </td>
                    <td style="font-size: 14px; line-height: 16px; padding: 6px 20px; background-color: #f5f5f5; color: #3a3a3a;" align="center">
                        <b><?php echo $user_log['nombre']." ".$user_log['apellidos']; ?></b><br>
                        <div style="font-size: 11px;"><?php echo $user_log['cargo']; ?><br></div>
                    </td>
                    
                </tr>
            </table>
            
        </div>
    </div>
    
</div>

<div class="container-fluid" style="height: 90px">
</div>