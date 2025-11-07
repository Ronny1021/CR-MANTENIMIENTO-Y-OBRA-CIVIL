<?php
declare(strict_types=1);

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class PHPMailerService
{
    private array $config;
    private bool $debug;

    public function __construct(array $config, bool $debug = false)
    {
        $this->config = $config;
        $this->debug = $debug;
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $htmlBody
     * @param string|null $textBody
     * @param array $options ['from'=>['address','name'], 'cc'=>[], 'bcc'=>[], 'attachments'=>[['path','name']]]
     * @return array{success:bool, message:string}
     */
    public function enviarCorreo(
        string $to,
        string $subject,
        string $htmlBody,
        ?string $textBody = null,
        array $options = []
    ): array {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $this->config['host'] ?? 'smtp.example.com';
            $mail->SMTPAuth = $this->config['smtp_auth'] ?? true;
            $mail->Username = $this->config['username'] ?? '';
            $mail->Password = $this->config['password'] ?? '';
            $mail->CharSet = $this->config['charset'] ?? 'UTF-8';

            $port = (int)($this->config['port'] ?? 587);
            $mail->Port = $port;
            if ($port === 465) {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = $this->config['encryption'] ?? PHPMailer::ENCRYPTION_STARTTLS;
            }

            if (!empty($this->config['smtp_options']) && is_array($this->config['smtp_options'])) {
                $mail->SMTPOptions = $this->config['smtp_options'];
            }

            $mail->SMTPDebug = $this->debug ? 2 : 0;

            $from = $options['from'] ?? [$this->config['from_address'] ?? $this->config['username'] ?? '', $this->config['from_name'] ?? ''];
            $mail->setFrom((string)$from[0], (string)($from[1] ?? ''));

            $mail->addAddress($to);
            foreach ($options['cc'] ?? [] as $cc) { $mail->addCC($cc); }
            foreach ($options['bcc'] ?? [] as $bcc) { $mail->addBCC($bcc); }

            foreach ($options['attachments'] ?? [] as $att) {
                if (is_array($att)) {
                    $mail->addAttachment($att[0], $att[1] ?? '');
                } else {
                    $mail->addAttachment($att);
                }
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $textBody ?? strip_tags($htmlBody);

            $mail->send();

            return ['success' => true, 'message' => 'Correo enviado correctamente'];
        } catch (Exception $e) {
            $internal = $mail->ErrorInfo ?: $e->getMessage();
            error_log('[Mailer] ' . $internal);
            return ['success' => false, 'message' => 'No se pudo enviar el correo.'];
        }
    }
}