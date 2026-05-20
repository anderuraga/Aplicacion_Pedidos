<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

require __DIR__ . "/../../static/vendor/autoload.php";
//require __DIR__ . '/../../autoload.php';
//require  __DIR__ . '/../../vendor/autoload.php';

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/OAuthTokenProvider.php';
require 'phpmailer/src/OAuth.php';
require 'phpmailer/src/Exception.php';


class Mailer
{
    protected PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = EMAIL_HOST;
        $this->mail->Port = EMAIL_PORT;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->AuthType = 'XOAUTH2';
        
        $provider = new Google([
                'clientId' => CLIENT_ID,
                'clientSecret' => CLIENT_SECRET,
            ]);

        $this->mail->setOAuth(
            new OAuth([
                'provider' => $provider,
                'clientId' => CLIENT_ID,
                'clientSecret' => CLIENT_SECRET,
                'refreshToken' => REFRESH_TOKEN,
                'userName' => EMAIL_CORREO,
            ])
        );


        // config basica            
        $this->mail->Username = EMAIL_CORREO;         
        $this->mail->setFrom(EMAIL_CORREO, EMAIL_FROM_NAME);
        $this->mail->isHTML(true);
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';

         // debug   
        //$this->mail->SMTPDebug = 3; 
        //$this->mail->Debugoutput = 'html';

    }

    protected function renderPlantilla(string $templateName, array $data): string
    {
        $path = __DIR__ . "/../views/email/$templateName.php";
        if (!file_exists($path)) {
            throw new Exception("Plantilla no encontrada: $templateName");
        }
        $html = file_get_contents($path);
        foreach ($data as $key => $value) {
            $html = str_replace("{{{$key}}}", htmlspecialchars((string) $value), $html);
        }
        return $html;
    }

    public function enviarCorreo(
        $to,
        string $subject,
        string $template,
        array $data = [],
        array $cc = null,
        array $attachments = null,
        $replyTo = null
    ): void {
        try {
            $body = $this->renderPlantilla($template, $data);

            $tos = (array) $to;
            foreach ($tos as $recipient) {
                $this->mail->addAddress($recipient);
            }

            if ($cc !== null) {
                foreach ($cc as $ccAddress) {
                    $this->mail->addCC($ccAddress);
                }
            }

            if ($replyTo !== null) {
                foreach ($replyTo as $replyAddress) {
                    $this->mail->addReplyTo($replyAddress);
                }
            }

            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            $logopath = __DIR__ . "/../../static/assets/img/logo/logo.png";
            $this->mail->addEmbeddedImage(
                $logopath,          // ruta al archivo
                'logo_cid',         // Content ID (debe ser único)
                'logo.png'          // nombre de archivo
            );

            if ($attachments !== null) {
                foreach ($attachments as $key => $value) {
                    $filePath = $value;
                    $this->mail->addAttachment($filePath);

                }
            }

            $this->mail->send();
        } catch (Exception $e) {
            throw new Exception("Error al enviar correo: " . $e->getMessage());
        }
    }
}