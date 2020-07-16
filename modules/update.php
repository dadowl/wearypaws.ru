<?php
session_start();
include ("../modules/bd.php");
if (!empty($_SESSION['login']) and !empty($_SESSION['password'])){
  //если    существует логин и пароль в сессиях, то проверяем, действительны ли они
  $login = $_SESSION['login'];
  $password = $_SESSION['password'];
  $result2 = mysql_query("SELECT id,cloakDostyp FROM gamers WHERE login='$login' AND password='$password'",$db); 
  $myrow2 = mysql_fetch_array($result2); 
  if (empty($myrow2['id']))
     {
     //Если не    действительны, то закрываем доступ
      exit("<html><head><script type='text/javascript'> alert('Вход на эту страницу разрешен только зарегистрированным пользователям!');</script><meta http-equiv='Refresh' content='0;    URL=../'></head></html>");
     }
} else {
  //Проверяем,    зарегистрирован ли вошедший
  exit("<html><head><script type='text/javascript'> alert('Вход на эту страницу разрешен только зарегистрированным пользователям!');</script><meta http-equiv='Refresh' content='0;    URL=../'></head></html>"); 
}

$id = $_SESSION['id'];//идентификатор пользователя тоже нужен 
$max_size = 2*1024*1024;
$skinPath = '../mine/users/skin/'.$login.'.png';
$cloakPath = '../mine/users/cloak/'.$login.'.png';

if    (isset($_FILES['uploadAva']['name'])){
	if (empty($_FILES['uploadAva']['name']))
	{
  	exit("<html><head><script type='text/javascript'> alert('Изображение не выбрано!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>");
	}
	else 
	{
  	$tempPath =    '../mine/users/temp/';
    $fullPath =    '../mine/users/foto/';
  		
  	if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['uploadAva']['name']))
  	{             
  		  
    	$filename    = $_FILES['uploadAva']['name'];
    	$source    = $_FILES['uploadAva']['tmp_name'];        
    	$target    = $tempPath . $filename;
    	move_uploaded_file($source, $target);//загрузка оригинала в папку $tempPath 
    	if(preg_match('/[.](GIF)|(gif)$/',    $filename)) {
    	 $im    = imagecreatefromgif($tempPath.$filename) ; 
    	}
    	if(preg_match('/[.](PNG)|(png)$/', $filename)) {
    	 $im =    imagecreatefrompng($tempPath.$filename) ;
    	}
    	if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',    $filename)) {
    	 $im =    imagecreatefromjpeg($tempPath.$filename); 
    	}

    	//СОЗДАНИЕ    КВАДРАТНОГО ИЗОБРАЖЕНИЯ И ЕГО ПОСЛЕДУЮЩЕЕ СЖАТИЕ ВЗЯТО С САЙТА www.codenet.ru
    	//    Создание квадрата 190x190
    	//    dest - результирующее изображение 
    	//    w - ширина изображения 
    	//    ratio - коэффициент пропорциональности 
    	$w = 190;  // квадратная    90x90. Можно поставить и другой размер.
    	//    создаём исходное изображение на основе 
    	//    исходного файла и определяем его размеры 
    	$w_src = imagesx($im); //вычисляем ширину
    	$h_src = imagesy($im); //вычисляем высоту изображения
    	//    создаём пустую квадратную картинку 
    	// важно именно truecolor!, иначе    будем иметь 8-битный результат 
    	$dest = imagecreatetruecolor($w,$w); 
    	if ($w_src>$h_src) //    вырезаем квадратную серединку по x, если фото горизонтальное 
    	 imagecopyresampled($dest, $im, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2),0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 
    	// вырезаем квадратную верхушку по    y, 
    	// если фото вертикальное (хотя    можно тоже серединку) 
    	if ($w_src<$h_src) 
    	 imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,min($w_src,$h_src),    min($w_src,$h_src)); // квадратная картинка масштабируется без вырезок 
    	if ($w_src==$h_src) 
    	 imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 

    	imagejpeg($dest, $fullPath.$login.".jpg");//сохраняем изображение формата jpg в нужную папку
      $avatar =    $login.".jpg";//заносим в переменную путь до аватара.

    	$delfull = $tempPath.$filename; 
    	unlink ($delfull);//удаляем оригинал загруженного изображения, он нам    больше не нужен. Задачей было - получить миниатюру.
  	}
  	else 
  	{
  	 exit("<html><head><script type='text/javascript'> alert('Изображение должно быть формата jpg, gif или png!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>");
  	}
	}
	$result4 = mysql_query("UPDATE gamers SET foto='$avatar' WHERE login='$login'",$db);//обновляем аватар в базе 

	if ($result4=='TRUE') {//если верно, то отправляем на личную страничку
	echo "<html><head><script type='text/javascript'> alert('Фотография успешно загружена!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>";}
} 
if    (isset($_FILES['uploadSkin']['name'])){
  if (empty($_FILES['uploadSkin']['name']))
  {
    exit("<html><head><script type='text/javascript'> alert('Изображение не выбрано!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>");
  }
  else 
  {
    if ($_FILES['uploadSkin']['size'] < $max_size) {
      if ($_FILES ['uploadSkin']['type'] == 'image/png') {
        $imgsize = getimagesize($_FILES['uploadSkin']['tmp_name']);
        if(  $imgsize['0'] == 64 && $imgsize['1'] == 64 
          || $imgsize['0'] == 128 && $imgsize['1'] == 128 
          || $imgsize['0'] == 256 && $imgsize['1'] == 256  
          || $imgsize['0'] == 512 && $imgsize['1'] == 512 
          || $imgsize['0'] == 1024 && $imgsize['1'] == 1024
          || $imgsize['0'] == 64 && $imgsize['1'] == 32  
          || $imgsize['0'] == 128 && $imgsize['1'] == 64 
          || $imgsize['0'] == 256 && $imgsize['1'] == 128
          || $imgsize['0'] == 512 && $imgsize['1'] == 256 
          || $imgsize['0'] == 1024 && $imgsize['1'] == 512) {
          if(is_uploaded_file($_FILES['uploadSkin']['tmp_name'])) {
            if(move_uploaded_file($_FILES['uploadSkin']['tmp_name'], $skinPath)) {
              if((mysql_query("UPDATE gamers SET skin='1' WHERE login='$login'",$db)) == TRUE)
                $mess = "Ваш скин успешно загружен!";
            } else $mess = 'Ошибка перемещения файла по заданному пути! Обратитесь к администратору.';
          } else $mess = "Ошибка загрузки файла!.";
        } else  $mess = "Ошибка! Загруженное изображение не соответствует необходимым размерам 64x32 или 64x64. Для HD скинов - 128x64, 128x128, 256x128, 256x256, 512x256, 512x512, 1024x512, 1024x1024.";
    } else {
      exit("<html><head><script type='text/javascript'> alert('Изображение должно быть в формате PNG!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>");
    }
  } else {
    exit("<html><head><script type='text/javascript'> alert('Файл не должен превышать 2Mb!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>");
  }
  }
  echo "<html><head><script type='text/javascript'> alert('".$mess."');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>";
}

if    (isset($_FILES['uploadCloak']['name'])){
 if (empty($_FILES['uploadCloak']['name']))
  {
    exit("<html><head><script type='text/javascript'> alert('Изображение не выбрано!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>");
  }
  else 
  {
    if ($myrow2['cloakDostyp'] == "1"){
      if ($_FILES['uploadCloak']['size'] < $max_size) {
        if ($_FILES ['uploadCloak']['type'] == 'image/png') {
          $imgsize = getimagesize($_FILES['uploadCloak']['tmp_name']);
          if($imgsize['0'] == 64 && $imgsize['1'] == 32 || $imgsize['0'] == 22 && $imgsize['1'] == 17 || $imgsize['0'] == 512 && $imgsize['1'] == 256) {
            if(is_uploaded_file($_FILES['uploadCloak']['tmp_name'])) {
              if(move_uploaded_file($_FILES['uploadCloak']['tmp_name'], $cloakPath)) {
                if((mysql_query("UPDATE gamers SET cloak='1' WHERE login='$login'",$db)) == TRUE)
                  $mess = "Ваш плащ успешно загружен!";
              } else $mess = 'Ошибка перемещения файла по заданному пути! Обратитесь к администратору.';
            } else $mess = "Ошибка загрузки файла!.";
          } else  $mess = "Файл должен быть размером 64х32 или 22x17! Для HD плащей 512x256.";
        } else {
          exit("<html><head><script type='text/javascript'> alert('Изображение должно быть в формате PNG!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>");
        }
      } else {
        exit("<html><head><script type='text/javascript'> alert('Файл не должен превышать 2Mb!');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>");
      }
    } else $mess = "У вас не куплена подписка для установки плащей!";
  }
  echo "<html><head><script type='text/javascript'> alert('".$mess."');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>";
}

if(isset($_POST['delcloak'])) {
    if(unlink($cloakPath)) {
      if((mysql_query("UPDATE gamers SET cloak='0' WHERE login='$login'",$db)) == TRUE)
        $mess = "Ваш плащ успешно удален!";
  } else $mess = "Произошла ошибка удаления <b>плаща</b>!";
  echo "<html><head><script type='text/javascript'> alert('".$mess."');</script><meta http-equiv='Refresh' content='0;    URL=../lk.php?id=".$id."'></head></html>";
}
?>