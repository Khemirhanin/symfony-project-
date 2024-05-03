<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twig\Environment;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class MailerService
{
    private $mailer;
    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    public function sendMail($name, $userEmail, $subject, $description): void
    {

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host= 'smtp.gmail.com';
        $mail->SMTPAuth= true;
        $mail->Username= 'benameureya953@gmail.com';
        $mail->Password='hiwc mjmq wjos asja';
        $mail->SMTPSecure='tls';
        $mail->Port= 587;
        $mail->setFrom($userEmail,$name);
        $mail->addAddress("benameureya953@gmail.com");
        $mail->isHTML(true);
        $mail->Subject= $subject.", Received from: <".$userEmail.">\r\n";
        $email_template = "
    <h2> This email is sent from ".$name."</h2>\r\n
    <p>Email: ".$userEmail."</p>\r\n
    <p>Subject: ".$subject."</p>\r\n
    <p>Message: ".$description."</p>\r\n
    ";

        $mail->Body= $email_template;
        $mail->send();
    }
}