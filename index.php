<?php
session_start();
header('X-Powered-By: HR Suite 2023');
header("Set-Cookie: key=value; path=/; domain=somosat.hr-suite.app; HttpOnly; SameSite=Strict");
header("X-Frame-Options: DENY");
$_SESSION['token'] = md5(uniqid(mt_rand(), true));

include("app/models/connect.php");

//Agregamos selección de correo para ingresar a index

$user = $_POST["user"];
if($_SESSION["token_crf"] == $_POST["csrf"] ){
	$consultarcorreo = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE correo = '$user'");
	$correo = mysqli_fetch_array($consultarcorreo);
	$email = $correo["correo"];
	$id = $correo["id"];

	if($email!=''){
		$fch = date("Y-m_d");
		$hra = date("H:i:s");
		$_SESSION['id_user'] = $id;
		mysqli_query($connect_valentina,"INSERT INTO Logs (id_empleado, fecha, hora ) 
		VALUES 
		( '".$id."', '".$fch."', '".$hra."' )  ");
	}
}	

//VALIDACION DE SESION
if($_SESSION['id_user'] == ""){
    header('Location: log.php' );
}
else{
    require("app/controllers/Routes.php");
    $ClassRoutes = new Routes();
    $vista = $ClassRoutes->route( $_GET["pg"] );
    
    include("app/models/connect.php");
    include("app/models/library.php");
    require("app/models/Users.php");
    
    $ahora = date("Y-m-d");
    $id_empresa = 1;
    
    $ClassUsers = new Users();
    $user_log = $ClassUsers->user( $_SESSION['id_user'], $connect_valentina );
	
    $dtEmpleado = $ClassUsers->user( $_SESSION['id_user'], $connect_valentina );
	$dtEmpleado['id_empresa'] = 1;
	
	if($user_log["role"] != 1){
		$_SESSION['role_plataforma'] = $user_log["role"];
	}
    
    if(!$_SESSION['role_plataforma'] || $_SESSION['role_plataforma'] == 0 ){
        $_SESSION['role_plataforma'] = $user_log["role"];
    }

    $txt_role = "";
    foreach($Array_Role as $role){
        if($role[0] == $_SESSION['role_plataforma']){ $txt_role = $role[1]; }
    }
    
    $qryLic = mysqli_query($connect_valentina,"SELECT * FROM Licencias_Empresas WHERE id_empresa = 1 AND fecha_inicia <= '".$ahora."' AND fecha_termina >= '".$ahora."'  ");
    $dtLic = mysqli_fetch_array($qryLic);
        
    //SI EL AÑO YA FUÉ SELECCIONADO SE CARGA EL AÑO DE LA LICENCIA
    if($_SESSION['anio'] == ""){ 
        if( $qryLic->num_rows > 0){
            $_SESSION['anio'] = $dtLic['anio']; 
        }
    }
        
    //CUANDO VIENE UN CICLO
    if( $_POST["ciclo_select"] != "" ){
        $_SESSION['ciclo'] = $_POST["ciclo_select"];
    }
        
    //CUANDO VIENE UN AÑO
    if( $_POST["anio_select"] != "" ){
        $_SESSION['anio'] = $_POST["anio_select"];
    }  
}

$_SESSION['id_empresa'] = 1;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	

	
	<meta http-equiv="Content-Security-Policy" content="default-src 'self' fontawesome.com *.fontawesome.com *.youtube.com unpkg.com *.plot.ly *.cloudflare.com *.googletagmanager.com *.google-analytics.com 'unsafe-inline' 'unsafe-eval'    ">
	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Somos AT - Innovando Juntos</title>
    <link rel="icon" href="<?php echo $url; ?>/icono.png">

    <link rel="stylesheet" href="<?php echo $url; ?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/css/style_001.css">

    <!-- Font Awesome JS -->
    <script defer src="<?php echo $url; ?>/js/solid.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" crossorigin="anonymous">
    
    <script src="<?php echo $url; ?>/js/jquery-3.3.1.js"></script>
    <script src="<?php echo $url; ?>/js/popper.min.js"></script>
    <script src="<?php echo $url; ?>/js/bootstrap.js"></script>
    <script src="<?php echo $url; ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
    
    <script src="<?php echo $url; ?>/slider/js/swiper.js"></script>
	<link href="<?php echo $url; ?>/slider/css/swiper.css" rel="stylesheet" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QNZNG9PFJ6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-QNZNG9PFJ6');
    </script>

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
        .card{
            background-color: #fcfcff;
        }
        
        .info{
            color: #2196f3; 
            font-size: 20px;
        }
        
        p{
            color: #000;
        }
        
        .btn-primary{
            background-color: #00407b;
            border-color: #00407b;
        }
        
        .btn-success {
            color: #ffffff;
            background-color: #00b49f;
            border-color: #00b49f;
        }
		
		.form-control{
			border-radius: 4px;
			border: 0;
			border-bottom: 1px solid #cccccc;
			background-color: #fafaff;
			border-left: 4px solid #23da4a;
		}
		
		.nav-link.active{
			background-color: #00295e !important;
    		color: #23da4a !important;
		}
		
		.nav-tabs{
			border-bottom: 0 !important;
		}
		
		.btn-block{
			width: 100%;
		}
        
    </style>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>

</head>

<body>
    <noscript>
    <div class="alert alert-success" role="alert">
        Para utilizar las funcionalidades completas de este sitio es necesario tener
        JavaScript habilitado. Aquí están las <a href="https://www.enable-javascript.com/es/">
        instrucciones para habilitar JavaScript en tu navegador web</a>.
    </div>
	</noscript>

    <?php include("views/layouts/modal.php"); ?>
    
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <?php include("views/layouts/lateral.php"); ?>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <?php include("views/layouts/menu.php"); ?>
            <div class="container-fluid">
            <?php include($vista); ?>
            </div>
        </div>
    </div>

    <div id="xscript">
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('#menu_header').toggleClass('active_menu_header');
                
                
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>
</body>

</html>