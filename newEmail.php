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
if    (isset($_POST['pass'])) { $pass = trim(htmlspecialchars(stripslashes($_POST['pass']))); if ($pass == '') { unset($pass);} } 

if    (isset($_POST['email2'])) { $email2 = trim(htmlspecialchars(stripslashes($_POST['email2']))); if ($email2 == '') { unset($email2);} } 
if    (isset($_POST['pass2'])) { $pass2 = trim(htmlspecialchars(stripslashes($_POST['pass2']))); if ($pass2 == '') { unset($pass2);} } 
if    (isset($_POST['login2'])) { $login2 = trim(htmlspecialchars(stripslashes($_POST['login2']))); if ($login2 == '') { unset($login2);} } 

if    (isset($_POST['kod'])) { $kod = trim(htmlspecialchars(stripslashes($_POST['kod']))); if ($kod == '') {    unset($kod);} }
if    (isset($_POST['newEmail'])) { $newEmail = trim(htmlspecialchars(stripslashes($_POST['newEmail']))); if ($newEmail == '') {    unset($newEmail);} }

if    (isset($_GET['kod'])) { $kod = $_GET['kod']; if ($kod == '') { unset($kod);}    }

$kodToSend = substr(md5(date('YmdHis')),    2, 8);
     
$pass    = "8Ppj#e|HmH?Y".strrev(md5($pass))."Xg#Rm}62o~Kz";
$pass2    = "8Ppj#e|HmH?Y".strrev(md5($pass2))."Xg#Rm}62o~Kz";

if    (isset($answ) and isset($email) and isset($pass)) {//если существуют необходимые переменные  
  $result    = mysql_query("SELECT id,login FROM gamers WHERE email='$email' AND answer='$answ' AND password='$pass'",$db);
  $myrow    = mysql_fetch_array($result);
  if    (empty($myrow['id']) or $myrow['id']=='') {
    exit ("<html><head><script type='text/javascript'> alert('Вы неверно указали данные!');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>");
  }
  $login = $myrow['login']; 
  $body = "Здравствуйте, ".$login."! Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a> и к вашей учетной записи было запрошено изменение почты.<br />Для изменения почты вашей учетной записи введите код на странице изменения: <b>".$kodToSend."</b><br />Или просто перейдите по ссылке <a href='https://wearypaws.ru/newEmail.php?kod=".$kodToSend."'>https://wearypaws.ru/newEmail.php?kod=".$kodToSend."</a><br />Если вы понятия не имеете о чем речь, то просто проигнорируйте это письмо.";
   $mail->msgHTML($body);
   $mail->Subject = "Запрос на изменение почты";
   $mail->addAddress($email);
   $mail->send();
  mysql_query("UPDATE gamers SET tempConfirmCod='$kodToSend' WHERE login='$login' AND email='$email' AND password='$pass'",$db);//такой ли у пользователя е-мейл 
  unset($email);
}
if    (isset($login2) and isset($email2) and isset($pass2)) {//если существуют необходимые переменные  
  $result    = mysql_query("SELECT id FROM gamers WHERE login='$login2' AND email='$email2' AND password='$pass2'",$db);//такой ли у пользователя е-мейл 
  $myrow    = mysql_fetch_array($result);
  if    (empty($myrow['id']) or $myrow['id']=='') {
    exit ("<html><head><script type='text/javascript'> alert('Вы неверно указали данные!');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>");
  }
  $body = "Здравствуйте, ".$login."! Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a> и к вашей учетной записи было запрошено изменение почты.<br />Для изменения почты вашей учетной записи введите код на странице изменения: <b>".$kodToSend."</b><br />Или просто перейдите по ссылке <a href='https://wearypaws.ru/newEmail.php?kod=".$kodToSend."'>https://wearypaws.ru/newEmail.php?kod=".$kodToSend."</a><br />Если вы понятия не имеете о чем речь, то просто проигнорируйте это письмо.";
   $mail->msgHTML($body);
   $mail->Subject = "Запрос на изменение почты";
   $mail->addAddress($email);
   $mail->send();
  mysql_query("UPDATE gamers SET tempConfirmCod='$kodToSend' WHERE login='$login2' AND email='$email2' AND password='$pass2'",$db);//такой ли у пользователя е-мейл 
  unset($email2);
}
if    (isset($kod) and isset($newEmail)) {
   $result2    = mysql_query("SELECT login,email FROM gamers WHERE tempConfirmCod='$kod'",$db);
   $myrow2    = mysql_fetch_array($result2);
   if ($result2 == TRUE){
    $result8 = mysql_query("SELECT id FROM gamers WHERE email='$newEmail'",$db);
    $myrow8 = mysql_fetch_array($result8);
    if (!empty($myrow8['id'])) {
        exit("<html><head><script type='text/javascript'> alert('Извините, введённый вами E-Mail уже зарегистрирован. Введите другой E-Mail.'); </script><meta http-equiv='Refresh' content='0;    URL=/newEmail.php?kod=".$kod."'></head></html>");
    }
     $login = $myrow2['login'];
     $oldEmail = $myrow2['email'];    
     if ((mysql_query("UPDATE gamers SET email='$newEmail' WHERE login='$login'",$db)) == TRUE) {//если верно, то обновляем его в сессии
        mysql_query("UPDATE gamers SET tempConfirmCod='' WHERE login='$login'",$db);
        $body = "Здравствуйте, ".$login."! <br />Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a>. <br />Ваша почта была изменена с ".$oldEmail." на ".$newEmail.".<br />Приятной вам игры на нашем сервере!";
           $mail->msgHTML($body);
           $mail->Subject = "Ваша почта была изменена";
           $mail->addAddress($newEmail);
           $mail->send();
        echo "<html><head><script type='text/javascript'> alert('Почта успешно изменена!');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>";
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
      <title> Изменение почты | Weary Paws </title>
      <link href="/css/style.css" rel="stylesheet">
   </head>
   <body>
      <div id="head">
         <a href="https://wearypaws.ru/"><img src="/images/logo.png" /></a> 
      </div>
      <div id="container2">
      <div id="container">
         <div class='newPages'>
            <h3><span>Изменение почты</span></h3><br />
            На почту, привязанную к Вашему аккаунту было выслано письмо с кодом подтверждения, введите его и новую почту ниже.
            <br />
            <form action="#" method="post">
               Код подтверждения:<input type="text" name="kod" value="<?php echo $kod; ?>" required><br>
               Новая почта: <input type="email"    name="newEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required><br>
               <input type="submit"    name="submit" value="Отправить">
            </form>
         <div id="footer">
            <?php include("modules/footer.php"); ?>
         </div>
      </div>
      </div>
   </body>
</html>