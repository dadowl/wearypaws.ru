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

if    (isset($_POST['email'])) { $email = trim(htmlspecialchars(stripslashes($_POST['email']))); if ($email == '') { unset($email);} } 
if    (isset($_POST['pass'])) { $pass = trim(htmlspecialchars(stripslashes($_POST['pass']))); if ($pass == '') { unset($pass);} } 
if    (isset($_POST['login'])) { $login = trim(htmlspecialchars(stripslashes($_POST['login']))); if ($login == '') {    unset($login);} }

if    (isset($_POST['kod'])) { $kod = trim(htmlspecialchars(stripslashes($_POST['kod']))); if ($kod == '') {    unset($kod);} }
if    (isset($_POST['question'])) { $question = trim(htmlspecialchars(stripslashes($_POST['question']))); if ($question == '') {    unset($question);} }
if    (isset($_POST['answer'])) { $answer = trim(htmlspecialchars(stripslashes($_POST['answer']))); if ($answer == '') {    unset($answer);} }

if    (isset($_GET['kod'])) { $kod = $_GET['kod']; if ($kod == '') { unset($kod);}    }

$kodToSend = substr(md5(date('YmdHis')),    2, 8);
     
$pass    = "8Ppj#e|HmH?Y".strrev(md5($pass))."Xg#Rm}62o~Kz";

if    (isset($email) and isset($pass) and isset($login)) {//если существуют необходимые переменные  
  $result    = mysql_query("SELECT id FROM gamers WHERE email='$email' AND login='$login' AND password='$pass'",$db);
  $myrow    = mysql_fetch_array($result);
  if    (empty($myrow['id']) or $myrow['id']=='') {
    exit ("<html><head><script type='text/javascript'> alert('Вы неверно указали данные!');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>");
  }
  $body = "Здравствуйте, ".$login."! Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a> и к вашей учетной записи было запрошено подключение системы 'Вопрос Ответ'.<br />Для ее включения введите код на странице: <b>".$kodToSend."</b><br />Или просто перейдите по ссылке <a href='https://wearypaws.ru/newQA.php?kod=".$kodToSend."'>https://wearypaws.ru/newQA.php?kod=".$kodToSend."</a><br />Если вы понятия не имеете о чем речь, то просто проигнорируйте это письмо.";
   $mail->msgHTML($body);
   $mail->Subject = "Подключение Вопрос-Ответ";
   $mail->addAddress($email);
   $mail->send();
  mysql_query("UPDATE gamers SET tempConfirmCod='$kodToSend' WHERE login='$login' AND email='$email' AND password='$pass'",$db);//такой ли у пользователя е-мейл 
  unset($email);
}
if    (isset($kod) and isset($question) and isset($answer)) {
   $result2    = mysql_query("SELECT login,email,onoffansw FROM gamers WHERE tempConfirmCod='$kod'",$db);
   $myrow2    = mysql_fetch_array($result2);
   $login = $myrow2['login']; 
   $email = $myrow2['email']; 
   if($myrow2['onoffansw'] == "0"){
     if ($result2 == TRUE){  
       if ((mysql_query("UPDATE gamers SET onoffansw='1',question='$question', answer='$answer' WHERE login='$login' AND email='$email'",$db)) == TRUE) {
          mysql_query("UPDATE gamers SET tempConfirmCod='' WHERE login='$login'",$db);
          $body = "Здравствуйте, ".$login."! <br />Ваш адрес был использован при регистрации на сайте игрового проекта <a href='https://Wearypaws.ru'>Wearypaws.ru</a>. <br />К вашему аккаунту была подключена система 'Вопрос-Ответ'.<br />Ваш вопрос: ".$question." <br />Ваш ответ: ".$answer."<br />Приятной вам игры на нашем сервере!";
             $mail->msgHTML($body);
             $mail->Subject = "Подключена система 'Вопрос-Ответ'";
             $mail->addAddress($myrow2['email']);
             $mail->send();
          echo "<html><head><script type='text/javascript'> alert('Система включена!');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>";
      }
     } else {
        echo "<script type='text/javascript'> alert('Коды не совпадают!');</script>";
     }
   } else {
      mysql_query("UPDATE gamers SET tempConfirmCod='' WHERE login='$login'",$db);
      echo "<html><head><script type='text/javascript'> alert('Упс! Cистема уже у тебя подключена, ничего не выйдет)');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>";
   }
}
?>
<!DOCTYPE HTML>
<html>
   <head>
   <?php include("modules/headers.html"); ?>
      <title> Вопрос-Ответ | Weary Paws </title>
      <link href="/css/style.css" rel="stylesheet">
   </head>
   <body>
      <div id="head">
         <a href="https://wearypaws.ru/"><img src="/images/logo.png" /></a> 
      </div>
      <div id="container2">
      <div id="container">
         <div class='newPages'>
            <h3><span>Настройка "Вопрос-Ответ"</span></h3><br />
            На почту, привязанную к Вашему аккаунту было выслано письмо с кодом подтверждения, введите его и данные ниже.
            <br />
            <form action="#" method="post">
               Код подтверждения:<input type="text" name="kod" value="<?php echo $kod; ?>" required><br>
               Вопрос: <select name='question' required>
                <option value='Имя вашего первого питомца'>Имя вашего первого питомца?</option>
                <option value='Ваша любимая игра'>Ваша любимая игра?</option>
                <option value='Ваш любимый ютубер'>Ваш любимый ютубер?</option>
               </select><br>
               Ответ: <input type="text"    name="answer" required><br>
               <input type="submit"    name="submit" value="Отправить">
            </form>
         <div id="footer">
            <?php include("modules/footer.php"); ?>
         </div>
      </div>
      </div>
   </body>
</html>