<?php
    session_start();
    include('modules/bd.php');
    include('modules/minetoweb.php');
     if (isset($_GET['id'])) {$id =trim(htmlspecialchars(stripslashes($_GET['id']))); } //id "хозяина" странички 
            else
            { exit("Вы зашли на    страницу без параметра!");} //если не    указали id, то выдаем ошибку
            if (!preg_match("|^[\d]+$|", $id))    {
            exit("<p>Неверный    формат запроса! Проверьте URL</p>");//если id не число, то выдаем    ошибку
            }
	if (!empty($_SESSION['login']) and    !empty($_SESSION['password']))
            {
            //если    существует логин и пароль в сессиях, то проверяем, действительны ли они
            $login = $_SESSION['login'];
            $password = $_SESSION['password'];
            $result2 = mysql_query("SELECT id FROM    gamers WHERE login='$login' AND password='$password'",$db); 
            $myrow2 = mysql_fetch_array($result2); 
            if (empty($myrow2['id']))

               {
               //Если не действительны 

                exit("<html><head><script type='text/javascript'> alert('Вход на эту страницу разрешен только зарегистрированным пользователям!');</script><meta    http-equiv='Refresh' content='0;    URL=/'></head></html>");
               }
            }
            else {
            //Проверяем,    зарегистрирован ли вошедший
            exit("<html><head><script type='text/javascript'> alert('Вход на эту страницу разрешен только зарегистрированным пользователям!');</script><meta    http-equiv='Refresh' content='0;    URL=/'></head></html>"); }
            $result = mysql_query("SELECT * FROM gamers WHERE id='$id'",$db); 
            $myrow =    mysql_fetch_array($result);//Извлекаем все данные    пользователя с данным id
	if (empty($myrow['login'])) {    exit("<html><head><script type='text/javascript'> alert('Пользователя не существует! Возможно он был удален.');</script><meta    http-equiv='Refresh' content='0;    URL=/lk.php?id=".$_SESSION['id']."'></head></html>");}
    
	$yesimg = "<img src='/images/yes.png' class='checkImg'";
	$noimg = "<img src='/images/no.png' class='checkImg'";

	$fotodir  = "/mine/users/foto/".$myrow['login'].".jpg";
    if (!file_exists($_SERVER['DOCUMENT_ROOT'].$fotodir)){
    	$fotodir = "/mine/users/foto/def/def_".rand(1, 16).".png";
    }
    $skindir = "/mine/users/skin/".$myrow['login'].".png";
    if ($myrow['skin'] == "0"){
    	//if ($myrow['gender'] == "0"){$skindir = "/mine/users/skin/def_man.png";} 
    	//	else {$skindir = "/mine/users/skin/def_girl.png";}
    	$skin = $noimg."title = 'Не установлен, используется стандартный' >"; 	
    } else {
    	$skin = $yesimg."title = 'Установлен' >";
    }
    if ($myrow['cloakDostyp'] == "0"){
    	$capeimg = $noimg."title = 'Подписка не куплена' >";
    	$cap = "";
    	$capclass = "";
    } else {
    	if ($myrow['cloakDostyp'] == "1"){
		    $capeInfo = "<p id='cloaksub' style='padding-left:10px;'>Подписка куплена ".date( 'd.m.Y', strtotime($myrow['cloakDate'])).". Истекает - ".date( 'd.m.Y', strtotime($myrow['cloakStop']))."</p>";
		    $cap = "openclose('cloaksub');";
		    $capclass = "class = 'moreinfo' "; 
		    $capeimg = $yesimg."title = 'Подписка куплена, можно установить плащ' >";
		    if ($myrow['cloak'] == "0"){
				$cloakdir = "";
		    } else {
		    	$cloakdir = "/mine/users/cloak/".$myrow['login'].".png";
		    }
    	}
	}
    if ($myrow['gender'] == "0"){
    	$gender = "мужской";
    } else {
    	$gender = "женский";
    }
    if($myrow['onoffansw'] == "0"){
    	$answ = $noimg."title = 'Система Вопрос-Ответ не включена, включите ее, чтобы защитить свой аккаунт' >";
    } else {
    	$answ = $yesimg."title = 'Система Вопрос-Ответ включена' >";
    }
    if($myrow['referall'] == "0" ){
    	$ref = "";
    } else {
    	$ref = "<p><span>Рефералл: </span>".$myrow['referall']."</p>"; 
    }
    if($myrow['vanillaDostyp'] == "0"){
    	//$vanilla = $noimg."title = 'Подписка не куплена' >";
    	$vanilla = $yesimg."title = 'Подписка куплена, можно играть на Vanilla сервере' >";
    	$van = "";
    	$vanclass = "";
    } else {
    	$vanilla = $yesimg."title = 'Подписка куплена, можно играть на Vanilla сервере' >";
    	$van = "openclose('vanillasub');";
    	$vanclass = "class = 'moreinfo' "; 
		$vanillaInfo = "<p id='vanillasub' style='padding-left:10px;'>Подписка куплена ".date( 'd.m.Y', strtotime($myrow['vanillaDate'])).". Истекает - ".date( 'd.m.Y', strtotime($myrow['vanillaStop']))."</p>";
    }
    $uuid = $myrow['uuid'];
    $pexsend = mysql_query("SELECT parent FROM permissions_inheritance WHERE child = '$uuid'",$db_pex);
	$pexres = mysql_fetch_assoc($pexsend);
	if (empty($pexres['parent'])){
		$pexsh = 'default';
	} else {
		$pexsh = $pexres['parent'];
	}
	$pexsend2 = mysql_query("SELECT value FROM permissions WHERE name = '$pexsh' AND permission = 'prefix'",$db_pex);
	$pextolk = mysql_fetch_assoc($pexsend2);

	$pextolk = MineToWeb($pextolk['value']);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php include("modules/headers.html"); ?>
		<title> Страница <?php echo $myrow['login']; ?> | Weary Paws </title>
		<link href="css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="css/serverbar.css" type="text/css">

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/three.js/95/three.min.js"></script>
		<script src="/js/skinview3d.js"></script>
	</head>
	<body>
		<div id="head">
			<a href='<?php echo "https://wearypaws.ru/lk.php?id=".$_SESSION['id']; ?>'><img src="images/logo.png" /></a> 
		</div>
		<div id="container2">
		<div id="container">
			<div id="lk">
				<h3><span>ЛИЧНЫЙ КАБИНЕТ ИГРОКА <?php echo $myrow['login']; ?></span></h3><br />
				<div id="lkleft">
					<div id="lkcont">
						<img src="<?php echo $fotodir; ?>" id="lkfullimg"/><br />
						<!--<b style="font-size: 17px;">Твой скин:</b>-->
						<div id="skin_container"></div>
						<script>
							skinViewer = new skinview3d.SkinViewer({
								domElement: document.getElementById("skin_container"),
								slim: false,
								width: 200,
								height: 300,
								skinUrl: "<?php echo $skindir; ?>",
								capeUrl : "<?php echo $cloakdir; ?>"

							});

							skinViewer.animation = new skinview3d.CompositeAnimation();
							control = skinview3d.createOrbitControls(skinViewer);
							skinViewer.animation.add(skinview3d.WalkingAnimation);
							control.tipidor(); //Тут нужна ошибка, потому что иначе оно не будет работать, если есть предположения почему, то пишите http://vk.com/fayence

							// disable the 'right click to play/pause' feature
							// control.enableAnimationControl = false;

							rotate = skinViewer.animation.add(skinview3d.RotatingAnimation);
							rotate.speed = 4;

							// add an animation
							walk = skinViewer.animation.add(skinview3d.WalkAnimation);

							// set its speed and some others
							walk.speed = 1.5;
							// walk.paused = true;
						</script>
					</div>
				</div>
				<div id="lkright">
					<h4>Информация об аккаунте</h4>
					<p><span>Пол: </span><?php echo $gender; ?></p>
					<?php if ($myrow['login'] == $login) { printf("<p><span>Баланс: </span>".$myrow['money']." руб.</p>");} ?>
					<p><span>Группа: </span><?php echo $pextolk; ?></p>
					<p><span>Скин: </span><?php echo $skin; ?></p>
					<p <? echo $capclass; ?> onClick="<? echo $cap; ?>"><span>Плащ: </span><?php echo $capeimg; ?></p>
					<?php echo $capeInfo; ?>
					<?php if ($myrow['login'] == $login) { printf("<p><span>Вопрос-ответ: </span>$answ</p>");} ?>
					<?php echo $ref; ?>
					<p <? echo $vanclass; ?> onClick="<? echo $van; ?>"><span>Доступ на ваниллу: </span><?php echo $vanilla; ?></p>
					<?php echo $vanillaInfo; ?>
					<script type="text/javascript">
						function openclose(id){
						    display = document.getElementById(id).style.display;

						    if(display=='none'){
						       document.getElementById(id).style.display='block';
						    }else{
						       document.getElementById(id).style.display='none';
						    }
						}
					</script>
				</div>
				<?php if ($myrow['login'] == $login) { 
				printf(' 
				<div id="lkrr">
					<h4>Настройки аккаунта</h4>
					<p><a href="javascript://" onclick="showModal(1);">Сменить пароль</a></p>
					<p><a href="javascript://" onclick="showModal(2);">Сменить адрес почты</a></p>
					<br />
					<p><a href="javascript://" onclick="showModal(3);">Установить аватарку</a></p>
					<p><a href="javascript://" onclick="showModal(4);">Установить скин</a></p>');
					if ($myrow['cloakDostyp'] == 1) { echo '<p><a href="javascript://" onclick="showModal(5);">Установить плащ</a></p>';}
					printf('
					<br /><br />
					<span>Безопасность аккаунта:</span>
					<p><a href="javascript://" onclick="showModal(6);">Настройка системы "Вопрос-Ответ"</a></p>
					<br /><br />
					<p><a href="/logout.php">Выйти из аккаунта</a></p>
				</div>
				');} else { echo ""; } ?>
			</div>
			<div id="footer">
				<?php include("modules/footer.php"); ?>
			</div>
		</div>
		</div>
		<div id="modals">
			<?php include('modules/lkmodals.php'); ?>
		</div>
	</body>
</html>