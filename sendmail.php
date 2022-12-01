<?php
require_once 'mailconfiguration.php';

$mail->addAddress('ravinduwegiriya@gmail.com');
$mail->isHTML(true);
$mail->Subject = 'Test Email';
//Add external HTML File as email body
$mail->Body = file_get_contents('email.html');

if ($mail->send()) {
    echo 'Email sent';
} else {
    echo 'Email not sent';
}

?>