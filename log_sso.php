
<?php
$appid ="399f09b9-9399-482a-872b-315d7c32ef15";
$tennantid="19685a3e-7dde-400f-bbf3-c8cdd7e1c96e";
$secret ="19afae61-887c-46b6-8de9-f6613cb5949d";
$login_url="https://login.microsoftonline.com/".$tennantid."/oauth2/v2.0/authorize";

session_start();
$_SESSION['state']=session_id();

$mensaje_sesion = "";
if(isset ($_SESSION['msatg'])){
	$mensaje_sesion = $_SESSION["uname"];
	
    //echo "<h2>Authenticated ".$_SESSION["uname"]."</h2><br>";
    //echo '<p><a href="?action=logout">Log Out </a></p>';
} //end if session
else{
     //'<p> <a href="?action=login">Log In </a>  </p>';
}

if($_GET['action']=='login'){
    $params = array ('client_id' => $appid,
    'redirect_uri' => 'https://somosat.hr-suite.app/test_log.php',
    'response_type' => token,
    'scope' => 'https://graph.microsoft.com/User.Read',
    'state' => $_SESSION['state']);
    header('Location: '.$login_url.'?'.http_build_query ($params));
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
	<meta http-equiv="Content-Security-Policy" content="default-src 'self' fontawesome.com *.fontawesome.com unpkg.com 'unsafe-inline' 'unsafe-eval'    ">
	  
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
          background-image: url(<?php echo $url; ?>/img/JORNADA_INTEGRACIÓN.jpg);
          background-repeat: no-repeat;
          font-family: Nunito-Regular;
          background-size: cover;
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

                        <div style="background: #ffffff52; border-radius: 15px; padding: 10px 30px; margin-bottom: 15px; ">
                            <img src="<?php echo $url; ?>/img/LOGO_DE_AT1.png" style="width: 140px; margin-bottom: 15px">
                            
                            <input type="hidden" name="csrf" value="<?php echo $_SESSION['token']; ?>">
                            <h5>Ingreso</h5>
							
							<div style="padding: 10px">
								<?php 
								if(isset ($_SESSION['msatg'])){ 
									?>
									Ingresar con:<br>
									<b><?php echo $mensaje_sesion; ?></b>
								<?php } ?>
							</div>




					<?php 
                    echo '<a href="?action=login">';
                    ?>
					<button class="w-100 btn btn-lg btn-primary" type="button" style="border-radius: 30px; border: 0px; background-color: #00b49f8f; margin-top: 0px">
                        Ingresar con Office 365
                    </button>
					</a>

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
