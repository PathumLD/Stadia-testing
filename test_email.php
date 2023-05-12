<?php


require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();
$mail->isSMTP();

$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";

$mail->Port = "25";
$mail->Username = "stadia.system@gmail.com";
$mail->Password = "ooxiphelmlrqyktf";
$mail->Subject = "Test email using PHPMailer";

$mail->setFrom('stadia.system@gmail.com');
$mail->isHTML(true);
$mail->Body = "Hello user,\n\nYour Stadia account has been created with the following credentials:\n\nUsername:\nPassword:\n\nPlease log in to the Stadia website using these credentials and change your password as soon as possible.\n\nRegards,\nThe Stadia Team";

$mail->addAddress('fiyaza.fb@gmail.com');

if ($mail->send()) {
  echo "Email Sent..!";
} else {
  echo "Message could not be sent. Mailer Error: " .
    $mail->ErrorInfo;
}

$mail->smtpClose();
