<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/../../static/vendor/autoload.php";

class Mailer
{
    protected PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = EMAIL_HOST;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = EMAIL_CORREO;
        $this->mail->Password = EMAIL_CONTRASENA;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        //$this->mail->SMTPSecure = 'tls';
        $this->mail->Port = EMAIL_PORT;
        $this->mail->setFrom(EMAIL_CORREO, EMAIL_FROM_NAME);
        $this->mail->isHTML(true);
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';
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

    public function enviarCorreo($to, string $subject, string $template, array $data = []): void
    {
        try {
            $body = $this->renderPlantilla($template, $data);

            $tos = (array) $to;
            foreach ($tos as $recipient) {
                $this->mail->addAddress($recipient);
            }

            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            $logopath = __DIR__ . "/../../static/assets/img/logo/logo.png";
            $this->mail->addEmbeddedImage(
                $logopath,          // ruta al archivo
                'logo_cid',         // Content ID (debe ser único)
                'logo.png'          // nombre de archivo
            );

            $this->mail->send();
        } catch (Exception $e) {
            throw new Exception("Error al enviar correo: " . $e->getMessage());
        }
    }
}