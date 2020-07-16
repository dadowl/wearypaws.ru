<?php
session_start();
include ("modules/bd.php");
include('modules/mail.php');
if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
  //если    существует логин и пароль в сессиях, то проверяем, действительны ли они
  $login = $_SESSION['login'];
  $password = $_SESSION['password'];
  $result2 = mysql_query("SELECT id FROM gamers WHERE login='$login' AND password='$password'",$db); 
  $myrow2 = mysql_fetch_array($result2); 
  if (empty($myrow2['id']))
     {
     //Если не    действительны, то закрываем доступ
      exit("<html><head><script type='text/javascript'> alert('Вход на эту страницу разрешен только зарегистрированным пользователям!');</script><meta    http-equiv='Refresh' content='0;    URL=/'></head></html>");
     }
}
else {
  //Проверяем,    зарегистрирован ли вошедший
  exit("<html><head><script type='text/javascript'> alert('Вход на эту страницу разрешен только зарегистрированным пользователям!');</script><meta    http-equiv='Refresh' content='0;    URL=/'></head></html>"); 
}

if    (isset($_POST['answ'])) { $answ = trim(htmlspecialchars(stripslashes($_POST['answ']))); if ($answ == '') { unset($answ);}    } 
if    (isset($_POST['email'])) { $email = trim(htmlspecialchars(stripslashes($_POST['email']))); if ($email == '') { unset($email);} } 
if    (isset($_POST['email2'])) { $email2 = trim(htmlspecialchars(stripslashes($_POST['email2']))); if ($email2 == '') { unset($email2);} } 
if    (isset($_POST['login2'])) { $login2 = trim(htmlspecialchars(stripslashes($_POST['login2']))); if ($login2 == '') { unset($login2);} } 

if    (isset($_POST['kod'])) { $kod = trim(htmlspecialchars(stripslashes($_POST['kod']))); if ($kod == '') {    unset($kod);} }
if    (isset($_POST['newPass'])) { $newPass = trim(htmlspecialchars(stripslashes($_POST['newPass']))); if ($newPass == '') {    unset($newPass);} }
if    (isset($_GET['kod'])) { $kod = $_GET['kod']; if ($kod == '') { unset($kod);}    }

$kodToSend = substr(md5(date('YmdHis')),    2, 8);

if    (isset($answ) and isset($email)) {//если существуют необходимые переменные  
  $result    = mysql_query("SELECT id,login FROM gamers WHERE email='$email' AND answer='$answ'",$db);//такой ли у пользователя е-мейл 
  $myrow    = mysql_fetch_array($result);
  if    (empty($myrow['id']) or $myrow['id']=='') {
  //если активированного пользователя с таким логином и е-mail    адресом нет
    exit ("<html><head><script type='text/javascript'> alert('Вы неверно указали данные!');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>");
  }
  $login = $myrow['login']; 
  $body = "Здравствуйте, ".$login."! Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a> и к вашей учетной записи было запрошено изменение пароля.<br />Для изменения пароля вашей учетной записи введите код на странице изменения: <b>".$kodToSend."</b><br />Или просто перейдите по ссылке <a href='https://wearypaws.ru/newPass.php?kod=".$kodToSend."'>https://wearypaws.ru/newPass.php?kod=".$kodToSend."</a><br />Если вы понятия не имеете о чем речь, то просто проигнорируйте это письмо.";////текст сообщения
   $mail->msgHTML($body);
   $mail->Subject = "Запрос на изменение пароля";
   $mail->addAddress($email);
   $mail->send();
  mysql_query("UPDATE gamers SET tempConfirmCod='$kodToSend' WHERE login='$login' AND email='$email'",$db);//такой ли у пользователя е-мейл 
  unset($email);
}
if    (isset($login2) and isset($email2)) {//если существуют необходимые переменные  
$result    = mysql_query("SELECT id FROM gamers WHERE login='$login2' AND email='$email2'",$db);//такой ли у пользователя е-мейл 
$myrow    = mysql_fetch_array($result);
if    (empty($myrow['id']) or $myrow['id']=='') {
//если активированного пользователя с таким логином и е-mail    адресом нет
  exit ("<html><head><script type='text/javascript'> alert('Вы неверно ответили на вопрос!');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>");
}
$body = "Здравствуйте, ".$login2."! Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a> и к вашей учетной записи было запрошено изменение пароля.<br />Для изменения пароля вашей учетной записи введите код на странице изменения: <b>".$kodToSend."</b><br />Или просто перейдите по ссылке <a href='https://wearypaws.ru/newPass.php?kod=".$kodToSend."'>https://wearypaws.ru/newPass.php?kod=".$kodToSend."</a><br />Если вы понятия не имеете о чем речь, то просто проигнорируйте это письмо.";////текст сообщения
   $mail->msgHTML($body);
   $mail->Subject = "Запрос на изменение пароля";
   $mail->addAddress($email);
   $mail->send();
mysql_query("UPDATE gamers SET tempConfirmCod='$kodToSend' WHERE login='$login2' AND email='$email2'",$db);//такой ли у пользователя е-мейл 
unset($email2);
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
        $_SESSION['password'] = $newPass;
        mysql_query("UPDATE gamers SET tempConfirmCod='' WHERE login='$login'",$db);
        $body = "Здравствуйте, ".$login."! <br />Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a>. <br />Ваш пароль был изменен.<br />Если вы не отправляли запрос на изменение пароля, то незамедлительно восстановите его на <a href='https://wearypaws.ru/#tabs-3'>нашем сайте. </a><br />Приятной вам игры на нашем сервере!";
           $mail->msgHTML($body);
           $mail->Subject = "Ваш пароль был изменен";
           $mail->addAddress($email);
           $mail->send();
        echo "<html><head><script type='text/javascript'> alert('Пароль успешно изменен!');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>";
      if (isset($_COOKIE['password'])) {
        setcookie("password",$_POST['newPass'],    time()+9999999);//Обновляем пароль в куках, если они есть 
      } 
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
      <title> Изменение пароля | Weary Paws </title>
      <link href="/css/style.css" rel="stylesheet">
   </head>
   <body>
      <div id="head">
         <a href="https://wearypaws.ru/"><img src="/images/logo.png" /></a> 
      </div>
      <div id="container2">
      <div id="container">
         <div class='newPages'>
            <h3><span>Изменение пароля</span></h3><br />
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