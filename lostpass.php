<?php
if    (isset($_POST['login'])) { $login = trim(htmlspecialchars(stripslashes($_POST['login']))); if ($login == '') { unset($login);}    } 
if    (isset($_POST['email'])) { $email = trim(htmlspecialchars(stripslashes($_POST['email']))); if ($email == '') { unset($email);} } 
if    (isset($_POST['kod'])) { $kod = trim(htmlspecialchars(stripslashes($_POST['kod']))); if ($kod == '') {    unset($kod);} }
if    (isset($_POST['newPass'])) { $newPass = trim(htmlspecialchars(stripslashes($_POST['newPass']))); if ($newPass == '') {    unset($newPass);} }
if    (isset($_GET['kod'])) { $kod = $_GET['kod']; if ($kod == '') { unset($kod);}    }

include ("modules/bd.php");
include('modules/mail.php');
$kodToSend = substr(md5(date('YmdHis')),    2, 8);

if    (isset($login) and isset($email)) {//если существуют необходимые переменные  
   $result    = mysql_query("SELECT id FROM gamers WHERE login='$login' AND email='$email'",$db);//такой ли у пользователя е-мейл 
   $myrow    = mysql_fetch_array($result);
   if    (empty($myrow['id']) or $myrow['id']=='') {
            //если активированного пользователя с таким логином и е-mail    адресом нет
            exit ("<html><head><script type='text/javascript'> alert('Пользователя с таким e-mail адресом не обнаружено в нашей базе!');</script><meta    http-equiv='Refresh' content='0;    URL=/#tabs-3'></head></html>");
            }
   //если пользователь с таким логином и е-мейлом найден,    то необходимо сгенерировать для него случайный код, обновить его в базе и    отправить на е-мейл
   //извлекаем из шифра 8 символов начиная со второго

   $body = "Здравствуйте, ".$login."! Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a> и к вашей учетной записи было запрошено восстановление пароля.<br />Для изменения пароля вашей учетной записи введите код на странице восстановления: <b>".$kodToSend."</b><br />Или просто перейдите по ссылке <a href='https://wearypaws.ru/lostpass.php?kod=".$kodToSend."'>https://wearypaws.ru/lostpass.php?kod=".$kodToSend."</a><br />Если вы понятия не имеете о чем речь, то просто проигнорируйте это письмо.";//текст сообщения
   $mail->msgHTML($body);
   $mail->Subject = "Восстановление пароля";
   $mail->addAddress($email);
   $mail->send();
   unset($email);
   mysql_query("UPDATE gamers SET tempConfirmCod='$kodToSend' WHERE login='$login'",$db);//такой ли у пользователя е-мейл 
}
if    (isset($kod) and isset($newPass)) {
   $result2    = mysql_query("SELECT login,email FROM gamers WHERE tempConfirmCod='$kod'",$db);
   $myrow2    = mysql_fetch_array($result2);
   if ($result2 == TRUE){
     $login = $myrow2['login'];
     $email = $myrow2['email'];    
      $newPass    = md5($newPass);//шифруем пароль          
      $newPass    = strrev($newPass);//реверс          
      $newPass    = "8Ppj#e|HmH?Y".$newPass."Xg#Rm}62o~Kz";
      if ((mysql_query("UPDATE gamers SET password='$newPass' WHERE login='$login'",$db)) == TRUE) {//если верно, то обновляем его в сессии
        mysql_query("UPDATE gamers SET tempConfirmCod='' WHERE login='$login'",$db);
        $body = "Здравствуйте, ".$login."! <br />Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a>. <br />Ваш пароль был изменен.<br />Если вы не отправляли запрос на изменение пароля, то незамедлительно восстановите его на <a href='https://wearypaws.ru/#tabs-3'>нашем сайте. </a><br />Приятной вам игры на нашем сервере!";
           $mail->msgHTML($body);
           $mail->Subject = "Ваш пароль был изменен";
           $mail->addAddress($email);
           $mail->send();
        echo "<html><head><script type='text/javascript'> alert('Пароль успешно изменен!');</script><meta    http-equiv='Refresh' content='0;    URL=/'></head></html>";
    }
   } else {
      echo "<script type='text/javascript'> alert('Коды не совпадают!');</script>";
   }
}
?>
<!DOCTYPE HTML>
<html>
   <head>
   <?php include("modules/headers.html"); ?>
      <title> Восстановление пароля | Weary Paws </title>
      <link href="/css/style.css" rel="stylesheet">
   </head>
   <body>
      <div id="head">
         <a href="https://wearypaws.ru/"><img src="/images/logo.png" /></a> 
      </div>
      <div id="container2">
      <div id="container">
         <div class='newPages'>
            <h3><span>Восстановление пароля</span></h3><br />
            На почту, привязанную к Вашему аккаунту было выслано письмо с кодом подтверждения, введите его и новый пароль ниже.
            <br />
            <form action="#" method="post">
               Код подтверждения:<input type="text" name="kod" value="<?php echo $kod; ?>" required><br>
               Новый пароль: <input type="password"    name="newPass" pattern="(?=.*[A-ZА-Я])(?=.*[0-9])(?=.*[a-zа-я]).{8,}" minlength="8" required><br>
               <input type="submit"    name="submit" value="Отправить">
            </form>
         <div id="footer">
            <?php include("modules/footer.php"); ?>
         </div>
      </div>
      </div>
   </body>
</html>