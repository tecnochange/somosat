<?php
    $respuesta = '';

    //EDITAR O CREAR REGISTROS
    if( $_POST["password"] != "" && $_POST["nuevo_password"] != "" ){
        
        $queryPw = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION['id_user_valentina']."' AND password = '".$_POST["password"]."' ");
        if($queryPw->num_rows > 0){
            mysqli_query($connect_valentina,"UPDATE Empleados SET 
                password = '".$_POST["nuevo_password"]."' 
                WHERE id = '".$_SESSION['id_user_valentina']."' 
            ");

            $respuesta = '
                <div class="alert alert-success" role="alert">
                  La contraseña ha sido actualizado con éxito.
                </div>
            ';
            
        }
        else{
            $respuesta = '
                <div class="alert alert-danger" role="alert">
                  Lo sentimos. la contraseña actual no coinciede con nuestros registros.
                </div>
            ';
        }
    }
?>

<div class="container-fluid">
    
    <div class="row view_page">
        <div class="col-md-12">
            <h2>Mi Perfil</h2>
            <nav aria-label="breadcrumb" >
                <ol class="breadcrumb miga">
                    <li class="breadcrumb-item"><a href="?pg=home">Escritorio</a></li>
                    <li class="breadcrumb-item" aria-current="page">Perfil</li>
                </ol>
            </nav>
        </div>
   
        <!-- DATOS CUENTA BOTONES -->
        <div class="col-md-3">
            <?php include("views/perfil/form_perfil.php"); ?>

        </div>
        
        <!-- AREA DE TRABAJO -->
        <div class="col-md-9">
            
            <div class="card custom-card" style="margin-bottom: 30px">

                <div class="card-body">
                    
                    <table width="100%" style="border-bottom: 1px solid #212131; margin-bottom: 20px;">
                        <tr>
                            <td>
                                <h2>Cambiar Contraseña</h2>
                                A continuación podrá modificar la contraseña actual por una nueva.<br><br>
                            </td>
                        </tr>
                    </table>
                    
                    
                    
                    <?php echo $respuesta; ?>
                    
                    <form action="" method="post">
                    <div class="row">

                        <input type="hidden" value="<?php echo $_SESSION['id_user_valentina']; ?>" name="id_registro">
                        
                        <div class="col-md-6">
                            <label>Contraseña Anterior</label>
                            <input type="text" class="form-control" name="password" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label>Nueva contraseña</label>
                            <input type="text" class="form-control" name="nuevo_password" required >
                        </div>
                        
                        <div class="col-md-12" align="right">
                            <button type="submit" class="btn btn-primary">Cambiar</button>    
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

