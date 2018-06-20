<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer();
    }

    public function setSMTP() {
        $this->mail->isSMTP();
        $this->mail->Host = getenv('SMTP_HOST');
        $this->mail->SMTPAuth = getenv('SMTP_AUTH');
        $this->mail->Username = getenv('SMTP_USERNAME');
        $this->mail->Password = getenv('SMTP_PASSWORD');
        $this->mail->SMTPSecure = getenv('SMTP_SECURE');
        $this->mail->Port = getenv('SMTP_PORT');
        return $this;
    }

    public function from($emailFrom, $nameFrom = '') {
        $this->mail->setFrom($emailFrom, $nameFrom);
        return $this;
    }

    public function to($emailTo, $nameTo = '') {
        $this->mail->addAddress($emailTo, $nameTo);
        return $this;
    }
    
    public function replyTo($replyToEmail, $replyToName = '') {
        $this->mail->addReplyTo($replyToEmail, $replyToName);
        return $this;
    }

    public function cc($cc) {
        $this->mail->addCC($cc);
        return $this;
    }

    public function bcc($bcc) {
        $this->mail->addBCC($bcc);
        return $this;
    }

    public function subject($subject) {
        $this->mail->Subject = $subject;
        return $this;
    }

    public function body($body) {
        $this->mail->Body = $body;
        return $this;
    }

    public function altBody($altBody) {
        $this->mail->Alt = $altBody;
        return $this;
    }

    public function setHTML() {
        $this->mail->isHTML(true);
        return $this;
    }

    public function send() {
        $this->mail->send();
    }
}