<?php

namespace paolodinotte\Tool\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    /**
     * 
     * @param string $host SMTP
     * @param string $username SMTP
     * @param string $password SMTP
     * @param int $port SMTP
     * @param string $senderMail
     * @param string $senderName
     * @param array $recipients
     * @param string $subject
     * @param bool $isHtml
     * @param string $body
     * 
     * 
     * @return bool true if emails are correctly sent
     *
     */
    public static function sendEmail(string $host, string $username, string $password, int $port, string $senderMail, string $senderName, array $recipients, string $subject, bool $isHtml, string $body): bool
    {
        $mail = new PHPMailer(true);
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $port;

        $mail->setFrom($senderMail, $senderName);

        foreach ($recipients as $email)
            $mail->AddAddress($email);

        $mail->isHTML($isHtml);
        $mail->Subject = $subject;
        $mail->Body = $body;

        try {
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    /**
     * Utility method to check SMPT credentials
     * 
     * @param array $emailConfiguration composed by SMPT values ['host', 'username', 'password', 'port']
     * 
     * 
     * @return bool true if SMPT credentials are correct
     *
     */
    public static function validateSmtpConfiguration(array $emailConfiguration): bool
    {
        $mail = new PHPMailer(true);
        $mail->SMTPAuth = true;
        $mail->Username = $emailConfiguration['username'];
        $mail->Password = $emailConfiguration['password'];
        $mail->Host = $emailConfiguration['host'];
        $mail->Port = $emailConfiguration['port'];

        try {
            return $mail->SmtpConnect();
        } catch (Exception $error) {
            return false;
        }
    }
}
