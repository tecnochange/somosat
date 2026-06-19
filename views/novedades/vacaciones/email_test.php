<script>
    alert("a");
</script>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

// Instantiation and passing `true` enables exceptions
echo $mail = new PHPMailer(true);

try {
    //Server settings
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = 2;                       // Enable verbose debug output
    $mail->isSMTP();                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';       // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                   // Enable SMTP authentication
    $mail->Username   = 'estilo.contigo@estiloingenieria.com';   // SMTP username
    $mail->Password   = 'TH-EST-1980+';         // SMTP password
    $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                    // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    //Recipients
    $mail->setFrom('estilo.contigo@estiloingenieria.com', 'Estilo Contigo - Solicitud Aprobada');
    $mail->AddAddress('anfaliz@gmail.com');// Add a recipient
         
    // Content
    $mail->isHTML(true); // Set email format to HTML
    
    $mensaje = '
        <div align="center">
            <table cellpadding="0" cellspacing="0" width="700" style="font-family:Arial, Helvetica, sans-serif" bgcolor="#fbfbfb">
                    <tr>
                        <td>
                            <img src="https://estilocontigo.hr-suite.app/img/logo_estilo_web.png" width="160">
                        </td>
                    </tr>
    
                    <tr>
                        <td align="left" style="padding:10px" colspan="2">
                        
                            Apreciado colaborador(a)<b>

                    </tr>
    
                    <tr >
                        <td align="center" colspan="2" style="padding:10px">
                            Este correo es informativo, por favor no responder.
                        </td>
                    </tr>
            </table>
        </div>
    ';
    

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "<script> alert('Message could not be sent. Mailer Error: {'.$mail->ErrorInfo.'})</script>";
}
 

?>