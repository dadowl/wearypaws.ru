<?php
session_start();//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
if (isset($_POST['login'])) { $login = trim(htmlspecialchars(stripslashes($_POST['login']))); if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['password'])) { $password=trim(htmlspecialchars(stripslashes($_POST['password']))); if ($password =='') { unset($password);} }
//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{
    exit ("<html><head><script type='text/javascript'> alert('Вы ввели не всю информацию, вернитесь назад и заполните все поля!');</script><meta    http-equiv='Refresh' content='0;    URL=../'></head></html>");
}
include ("../modules/bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

// минипроверка на подбор паролей

$ip=getenv("HTTP_X_FORWARDED_FOR");
if (empty($ip) || $ip=='unknown') {    
    $ip=getenv("REMOTE_ADDR"); 
}//извлекаем ip           
mysql_query ("DELETE FROM loginfail WHERE UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 900");//удаляем ip-адреса ошибавшихся при входе пользователей через 15 минут.           
$result = mysql_query("SELECT col FROM loginfail WHERE ip='$ip'",$db);// извлекаем из базы количество неудачных попыток входа за    последние 15 у пользователя с данным ip 
$myrow = mysql_fetch_array($result);

if ($myrow['col'] > 2) {
//если ошибок больше двух, т.е три, то выдаем сообщение.
    exit("<html><head><script type='text/javascript'> alert('Вы набрали логин или пароль неверно 3 раз. Подождите 15 минут до следующей попытки.');</script><meta    http-equiv='Refresh' content='0;    URL=../'></head></html>");
}          
$password    = md5($password);//шифруем пароль          
$password    = strrev($password);// для надежности добавим реверс          
$password    = "8Ppj#e|HmH?Y".$password."Xg#Rm}62o~Kz";

$result = mysql_query("SELECT * FROM gamers WHERE login='$login' AND password='$password'",$db); //извлекаем из базы все данные о пользователе с    введенным логином и паролем
$myrow    = mysql_fetch_array($result);
if (empty($myrow['id']))
{         
    $select = mysql_query ("SELECT ip FROM loginfail WHERE    ip='$ip'");
    $tmp = mysql_fetch_row ($select);
    if ($ip == $tmp[0]) {//проверяем, есть ли пользователь в таблице "loginfail" 
        $result52 = mysql_query("SELECT col FROM loginfail WHERE    ip='$ip'",$db);
        $myrow52 = mysql_fetch_array($result52);          
        $col = $myrow52[0] + 1;//прибавляем    еще одну попытку неудачного входа 
        mysql_query ("UPDATE loginfail SET col=$col,date=NOW() WHERE    ip='$ip'");
    } else {
        mysql_query ("INSERT INTO loginfail (ip,date,col) VALUES ('$ip',NOW(),'1')");
    //если за последние 15 минут ошибок не было, то вставляем    новую запись в таблицу "loginfail"
    }          

    exit ("<html><head><script type='text/javascript'> alert('Извините, введённый вами логин или пароль неверный.');</script><meta    http-equiv='Refresh' content='0;    URL=../'></head></html>");
} else {          
    //если пароли    совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
    $_SESSION['password']=$myrow['password']; 
    $_SESSION['login']=$myrow['login']; 

    $_SESSION['id']=$myrow['id'];//эти    данные очень часто используются, вот их и будет "носить с собой"    вошедший пользователь

    //Далее мы запоминаем данные в куки, для последующего входа.
    //ВНИМАНИЕ!!! ДЕЛАЙТЕ ЭТО НА ВАШЕ УСМОТРЕНИЕ, ТАК КАК ДАННЫЕ ХРАНЯТСЯ    В КУКАХ БЕЗ ШИФРОВКИ

    setcookie("login",    $_POST["login"], time()+9999999);
    setcookie("password",    $_POST["password"], time()+9999999);
}                  
echo "<html><head><meta http-equiv='Refresh' content='0; URL=../'></head></html>";//перенаправляем пользователя на главную страничку, там    ему и сообщим об удачном входе          
?>
