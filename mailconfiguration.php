<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'labourlinklanka@gmail.com';
$mail->Password = 'lyjuolzvwpgtsiuk';
$mail->SMTPSecure = 'ssl';

$mail->Port = 465;
$mail->setFrom('labourlinklanka@gmail.com',"Labour Link");



?>