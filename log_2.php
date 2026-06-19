<?php
    header('X-Powered-By: Valentina 2021');
    $_SESSION['token'] = md5(uniqid(mt_rand(), true));

    define('DURACION_SESION','14400'); //4 horas
    ini_set("session.cookie_lifetime",DURACION_SESION);
    ini_set("session.gc_maxlifetime",DURACION_SESION); 
    session_cache_expire(DURACION_SESION);

	session_start();

	include("app/models/connect.php");
	if( $_POST["user"] != "" &&  $_POST["password"] != "" ){     
        $user = addslashes($_POST["user"]);
        $pass = addslashes($_POST["password"]);

		$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
        WHERE correo = '".$user."' AND password = '".$pass."' AND estado = 1 ");
		if($query->num_rows > 0){
			$data = mysqli_fetch_array($query);
			$_SESSION['id_user'] = $data["id"];
			
			if($data["cambiar_pass"] == 0){
				echo '<script> window.location = "'.$url.'/?pg=cambiar_password"; </script>';
			}
			else{
				echo '<script> window.location = "'.$url.'"; </script>';
			}
			
            
		}
		else{
			$respuesta = '
			<div class="alert alert-danger">
			  <strong>Algo va mal!</strong> Credenciales Inválidas .
			</div>
			';
		}
	}  
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Hr Suite Viva - Nuevatel">
    <meta name="generator" content="Hr Suite 2022">
    <title>Somos AT - Innovando Juntos</title>
    <link rel="icon" href="<?php echo $url; ?>/icono.png">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo $url; ?>/css/bootstrap.css">

    <style>
        @font-face {
            font-family: Nunito-Regular;
            src: url(<?php echo $url; ?>/fonts/Nunito-Regular.ttf);
        }
        @font-face {
            font-family: Nunito-Black;
            src: url(<?php echo $url; ?>/fonts/Nunito-Black.ttf);
        }
		
		@font-face {
            font-family: Montserrat-Light;
            src: url(<?php echo $url; ?>/fonts/Montserrat-Light.ttf);
        }
        
        html,
        body {
          height: 100%;
        }
  
        body {
          display: flex;
          align-items: center;
          padding-top: 40px;
          padding-bottom: 40px;
          background-image: url(<?php echo $url; ?>/img/FOTO_PARA_PORTADA.jpeg);
          background-repeat: no-repeat;
          font-family: Nunito-Regular;
        }

        .form-signin {
          width: 100%;
          max-width: 330px;
          margin: auto;
        }

        .form-signin .checkbox {
          font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
          z-index: 2;
        }

        .form-signin input[type="email"] {
          margin-bottom: -1px;
          border-bottom-right-radius: 0;
          border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
          margin-bottom: 10px;
          border-top-left-radius: 0;
          border-top-right-radius: 0;
        }
        
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
		
		
    </style>

  </head>
    
<body class="text-center">
    
    <div class="container">
    
        <div class="row">
            <div class="col-md-12">
                <main class="form-signin">
                    <?php echo $respuesta; ?>

                    <form method="post" action="">

                        <div style="background: #ffffffa8; border-radius: 15px; padding: 10px 30px; margin-bottom: 15px; ">
                            <img src="<?php echo $url; ?>/img/LOGO_DE_AT1.png" style="width: 140px; margin-bottom: 15px">
                            
                            <input type="hidden" name="csrf" value="<?php echo $_SESSION['token']; ?>">
                            <img class="mb-4" src="img/logo-viva.png" alt="" width="150" style="margin-top: 20px;" >
                            <h4>Iniciar sesión</h4>

                            <div class="form-floating">
                              <input type="email" class="form-control" id="floatingInput" name="user" placeholder="name@example.com" required>
                              <label for="floatingInput">Correo corporativo</label>
                            </div>
                            <div class="form-floating">
                              <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                              <label for="floatingPassword">Contraseña</label>
                            </div>

                            <div class="checkbox mb-3">
                              <label>
                                <input type="checkbox" value="remember-me"> Recordarme
                              </label>
                            </div>
                        </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit" style="border-radius: 30px; border: 0px; background-color: #00b49f">
                        Ingresar
                    </button>
						
					<div align="center" style="padding: 20px 10px;">
						<a href="<?php echo $url; ?>/recuperar.php" style="color: #ffffff; text-decoration: none;">
							¿Olvido su contraseña?<br>puede recuperarla aquí.
						</a>
					</div>

					<a href="log_sso.php">
					<button class="w-100 btn btn-lg btn-primary" type="button" style="border-radius: 30px; border: 0px; background-color: #00b49f; margin-top: 0px">
                        office 365
                    </button>
					</a>
						
					<p class="mt-5 mb-3 text-muted">Hr Suite 2022</p>

					<div style="margin-top: 20px;">
                        <img src="<?php echo $url; ?>/img/logo_hr_suite.png" style="width: 50px">
					</div>

                    </form>
                </main>
            </div>
            
           
        </div>
    </div>

  </body>
</html>

<script>
 
function Ver_Pass(elem){
    
    if( $("#password").attr("type") == 'password'){
        $("#password").attr("type", "text");
    }
    else{
        $("#password").attr("type", "password");
    }  
}
</script>























