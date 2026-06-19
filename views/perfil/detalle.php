<?php
//EDITAR O CREAR REGISTROS
    if( $_POST["nombre"] != "" && $_POST["apellidos"] != "" ){
        
        mysqli_query($connect_valentina,"UPDATE Empleados SET 
            nombre = '".$_POST["nombre"]."', 
            apellidos = '".$_POST["apellidos"]."', 
            correo = '".$_POST["correo"]."', 
            celular = '".$_POST["celular"]."' 
            WHERE id = '".$_POST["id_registro"]."' 
        ");

        if($_FILES["foto_perfil"]["name"]){
            $archivo = Cargar_Foto_Perfil( $_FILES["foto_perfil"] );
            mysqli_query($connect,"UPDATE Empleados SET foto = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            echo '<script> window.location = "'.$url_gestion.'?pg=perfil/detalle"; </script>';
        }
            
        $respuesta = '
            <div class="alert alert-outline-success" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button"> <span aria-hidden="true">×</span></button>
                Los datos han sido actualizados
            </div>
        ';
    }
?>



<div class="container-fluid">
    
    <div class="row view_page">
        <div class="col-md-12">
            <h2>Mi Cuenta</h2>
        </div>
   
        <!-- DATOS CUENTA BOTONES -->
        <div class="col-md-3">
            <?php include("views/perfil/form_perfil.php"); ?>
        </div>
        
        <!-- AREA DE TRABAJO -->
        <div class="col-md-9">
            
            <div class="card custom-card" style="margin-bottom: 30px">

                <div class="card-body">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                    <table width="100%" style="border-bottom: 1px solid #212131; margin-bottom: 20px;">
                        <tr>
                            <td style="width: 110px; padding-bottom: 15px;">
                                <div class="min_foto_menu"></div>
                            </td>
                            <td style="padding-bottom: 15px;">
                                Foto de perfil<br>
                                Puede cargar archivos jpg ó png. peso máximo 1 mega.<br>
                                <div style="margin-top: 6px;">
                                    <input type="file" name="foto_perfil" accept="image/*"  style="display: block; opacity: 0; margin-bottom: -30px;">
                                    <button class="btn button border btn-sm"><b>Upload</b></button>
                                </div>
                            </td>
                        </tr>
                    </table>
                    
                    <?php echo $respuesta; ?>
                    
                    
                    <div class="row">
                        
                        
                        
                        <input type="hidden" value="<?php echo $_SESSION['id_user']; ?>" name="id_registro">
                        
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" required value="<?php echo $user_log["nombre"]; ?>" readonly >
                        </div>
                        
                        <div class="col-md-6">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" required value="<?php echo $user_log["apellidos"]; ?>" readonly>
                        </div>
                        
                        <div class="col-md-6">
                            <label>Correo</label>
                            <input type="text" class="form-control" name="correo" required value="<?php echo $user_log["correo"]; ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label>Celular</label>
                            <input type="text" class="form-control" name="celular" required value="<?php echo $user_log["celular"]; ?>">
                        </div>
                        
                        <div class="col-md-12" align="right">
                            <button type="submit" class="btn btn-primary">Guardar</button>    
                        </div>
                        
                    </div>
                    </form>
                    
                    
                    
                    <div align="center">
                        
                        <h5></h5>
                    </div>
                    
                </div>

            </div>
            
        </div>

    </div>

</div>



<script>
$( document ).ready(function() {    
	$("#bt_perfil").prepend( '<span class="shape1"></span>' );
    $("#bt_perfil").addClass( "bt_select" );
    $("#ico_perfil").addClass( "base_icons_menu" );
});
</script>

