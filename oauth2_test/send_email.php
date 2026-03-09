<?php
require 'vendor/autoload.php';
require 'autoload.php'; // para OAuth2 clases
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/OAuthTokenProvider.php';
require 'phpmailer/src/OAuth.php';

require 'phpmailer/src/Exception.php';

require 'config/constantes.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

 
$userEmail = EMAIL_CORREO;
$clientId = CLIENT_ID;
$clientSecret = CLIENT_SECRET;
$refreshToken = REFRESH_TOKEN;
$emailFrom = EMAIL_CORREO;
$emailTo = 'sscauraga@elorrieta-errekamari.com';


try {
   $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;

    // Configurar autenticación OAuth2
    $mail->AuthType = 'XOAUTH2';

    $provider = new Google([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]);

    $mail->setOAuth(
        new OAuth([
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $userEmail,
        ])
    );

    $mail->setFrom($userEmail, 'App Hoja de Pedidos');
    $mail->addAddress($emailTo);
    $mail->Subject = 'Correo con OAuth2';
    $mail->Body    = 'Este es un mensaje de prueba con OAuth2.';

    //debug
    //$mail->SMTPDebug = 3; 
    //$mail->Debugoutput = 'html';

    $mail->send();
    echo "Correo enviado exitosamente.";
} catch (Exception $e) {
    echo "Error al enviar correo: {$mail->ErrorInfo}";
}