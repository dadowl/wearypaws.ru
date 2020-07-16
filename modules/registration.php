<?php
    if (isset($_POST['login'])) { $login = trim(htmlspecialchars(stripslashes($_POST['login']))); if ($login == '') { unset($login);} } 
    if (isset($_POST['password'])) { $password=trim(htmlspecialchars(stripslashes($_POST['password']))); if ($password =='') { unset($password);} }
    if (isset($_POST['email'])) { $email = trim(htmlspecialchars(stripslashes($_POST['email']))); if ($email == '') { unset($email);} }
    if (isset($_POST['referall'])) { $referall = trim(htmlspecialchars(stripslashes($_POST['referall']))); if ($referall == '') { $referall = "0";} }
    if (($_POST['gender'] != "man") && ($_POST['gender'] != "girl")) 
        {$gender = 0; 
        } else {
        if ($_POST['gender'] == "man" )
            $gender = 0;  
        if ($_POST['gender'] == "girl") 
            $gender = 1;
    }
    //заносим введенный пользователем логин в переменную, если она пустая, то уничтожаем переменную
 if (empty($login) or empty($password) or empty($email)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    {
        exit ("<html><head><script type='text/javascript'> alert('Вы ввели не всю информацию!');</script><meta    http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>");
    }

    if(!preg_match('/^[a-zA-Z0-9_]*$/',$login)){
        exit("<html><head><script type='text/javascript'> alert('Ваш логин указан неверно!'); </script><meta http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("<html><head><script type='text/javascript'> alert('Ваш E-Mail указан неверно!'); </script><meta http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>");
    }

 // подключаемся к базе
    include ("../modules/bd.php");
    include ("../modules/mail.php");
 // проверка на существование пользователя с таким же логином
    $result = mysql_query("SELECT id FROM gamers WHERE login='$login'",$db);
    $myrow = mysql_fetch_array($result);
    if (!empty($myrow['id'])) {
        exit("<html><head><script type='text/javascript'> alert('Извините, введённый вами логин уже зарегистрирован. Введите другой логин.'); </script><meta http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>");
    }
    $result2 = mysql_query("SELECT id FROM gamers WHERE email='$email'",$db);
    $myrow2 = mysql_fetch_array($result2);
    if (!empty($myrow2['id'])) {
        exit("<html><head><script type='text/javascript'> alert('Извините, введённый вами E-Mail уже зарегистрирован. Введите другой E-Mail.'); </script><meta http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>");
    }

    function uuidFromString($string) {
        $val = md5($string, true);
        $byte = array_values(unpack('C16', $val));
        $tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
        $tMi = ($byte[4] << 8) | $byte[5];
        $tHi = ($byte[6] << 8) | $byte[7];
        $csLo = $byte[9];
        $csHi = $byte[8] & 0x3f | (1 << 7);
        if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
            $tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8) | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
            $tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
            $tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
        }
        $tHi &= 0x0fff;
        $tHi |= (3 << 12);
        $uuid = sprintf(
            '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $tLo, $tMi, $tHi, $csHi, $csLo,
            $byte[10], $byte[11], $byte[12], $byte[13], $byte[14], $byte[15]
        );
        return $uuid;
    }
    function uuidConvert($string)
    {
        $string = uuidFromString("OfflinePlayer:".$string);
        return $string;
    }
    $uuidToBase = uuidConvert($login);

    if ($gender == "0"){
        $toCopy = "../mine/users/skin/def_man.png";
    } else {
        $toCopy = "../mine/users/skin/def_girl.png";
    }
    $skin = "0";
    $newFile = "../mine/users/skin/".$login.".png";

    // Участок кода с капчем отключен, потому что на локалхосте не работает, но его можно раскомментить для получаения полной работоспособности сайта.
    //
    /*$recaptcha = $_POST['g-recaptcha-response'];
    if(!empty($recaptcha)) {
        $recaptcha = $_REQUEST['g-recaptcha-response'];
        $secret = 'XXX';
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret ."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];
     
        //Инициализация и настройка запроса
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        //Выполняем запрос и получается ответ от сервера гугл
        $curlData = curl_exec($curl);
     
        curl_close($curl); 
        //Ответ приходит в виде json строки, декодируем ее
        $curlData = json_decode($curlData, true);*/
        

        $curlData['success'] = true;
        //Смотрим на результат
        if($curlData['success']) {
            if (!copy($toCopy, $newFile)) {
                exit ("<html><head><script type='text/javascript'> alert('Регистрация завершилась ошибкой. Код 2. Обязательно сообщите администратору!'); </script><meta http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>");
            }
            $password    = md5($password);//шифруем пароль          
            $password    = strrev($password);//реверс          
            $password    = "8Ppj#e|HmH?Y".$password."Xg#Rm}62o~Kz";
            $ip=getenv("REMOTE_ADDR");
            $result3 = mysql_query ("INSERT INTO gamers (login,password,email,uuid,referall,gender,ip,regtime) VALUES('$login','$password','$email','$uuidToBase','$referall','$gender','$ip',NOW())", $db);
            // Проверяем, есть ли ошибки
            if ($result3 == TRUE)
            {
                $body    = "Здравствуйте! Спасибо за регистрацию на <a href='http://wearypaws.ru'>WearyPaws.ru</a><br />Ваш логин: ".$login."<br />С уважением,<br />Администрация WearyPaws.ru";//содержание сообщение
                $mail->msgHTML($body);
                $mail->Subject = "Регистрация на WearyPaws.ru";
                $mail->addAddress($email);
                $mail->send();
                echo "<html><head><script type='text/javascript'> alert('Вы успешно зарегистрированы!');</script><meta http-equiv='Refresh' content='0;    URL=../'></head></html>";
            } else {
                unlink($newFile);
                echo "<html><head><script type='text/javascript'> alert('Регистрация завершилась ошибкой. Код 1. Обязательно сообщите администратору!'); </script><meta http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>";
            }
        } else {
            //Капча не пройдена
            echo "<html><head><script type='text/javascript'> alert('Регистрация завершилась ошибкой. Капча не пройдена!'); </script><meta http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>";
        }
   /* }
    else {
        //Капча не введена
        echo "<html><head><script type='text/javascript'> alert('Регистрация завершилась ошибкой. Капча не введена!'); </script><meta http-equiv='Refresh' content='0;    URL=../?login=".$_POST['login']."&email=".$_POST['email']."&ref=".$_POST['referall']."&gender=".$_POST['gender']."#tabs-2'></head></html>";
    }*/
?>