<?php

require_once 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->CharSet = 'UTF-8';

// Настройки SMTP
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPDebug = 0;

$mail->Host = 'ssl://smtp.yandex.ru';
$mail->Port = 465;
$mail->Username = 'xxx';
$mail->Password = 'xxx';

// От кого
$mail->setFrom('no_reply@wearypaws.ru', 'Weary Paws');        

?>