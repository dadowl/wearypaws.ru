<?php
    session_start();
    include('modules/bd.php');
	include('modules/minetoweb.php');

    if (isset($_GET['login'])) {$login = $_GET['login']; if ($login == '') { $login = "";} }
    if (isset($_GET['email'])) {$email = $_GET['email']; if ($email == '') { $email = "";} }
    if (isset($_GET['ref'])) {$ref = $_GET['ref']; if ($ref == '') { $ref = ""; } }
    if (isset($_GET['gender'])){
	    if ($_GET['gender'] == "man" ){
	        $gender0 = " checked "; 
	        $gender1 = "";  
	    }
	    if ($_GET['gender'] == "girl"){ 
	    	$gender0 = ""; 
	        $gender1 = " checked ";
	    } 
	} else {
		$gender0 = " checked "; 
		$gender1 = "  ";	
	}

	if ((empty($_SESSION['login']) or empty($_SESSION['id'])) and $ref != "")
	{	
		$reftoform = "value='".$ref."'";
	} else {
		$reftoform = "";
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta name="lolkekcheburek" content="Неко жив" />
		<meta name="lolkekcheburek2" content="SpaceCraft в моем сердце" />
		<?php include("modules/headers.html"); ?>
		<meta name="yandex-verification" content="08a88d034498c010" />
		<title> Главная | Weary Paws </title>
		<link href="css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="css/serverbar.css" type="text/css">

		<script src="https://www.google.com/recaptcha/api.js" async defer></script>	
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script type='text/javascript' src='js/serverbar.js'></script>
		<script>
			$( function() {
			$( "#tabs" ).tabs();
			} );
		</script>
	</head>
	<body>
			<div id="head">
				<a href="https://wearypaws.ru/"><img src="images/logo.png" /></a> 
			</div>
		<div id="container2">
		<div id="container">
			<div id="start">
				<h3><span>КАК НАЧАТЬ ИГРАТЬ?</span></h3>
				<br />
				<div id='tablecont'>
					<div class='row'>
						<div class='headrow'>
							<img src="images/1.png" /> <span>Скачай наш лаунчер</span>
						</div>
						<div class='subrow'>
							Игра на наших сервера подразумевает использование модифицированного клиента. Без лаунчера тебе не обойтись!
							<?php
							    if (!empty($_SESSION['login']) or !empty($_SESSION['id']))
							    {
							   		echo "<center><a href='http://launch.wearypaws.ru:9274/Launcher.exe' target='_blank' download>Скачать EXE-версию(Windows)</a><br />"; 
							   		echo "<a href='http://launch.wearypaws.ru:9274/Launcher.jar' target='_blank' download>Скачать JAR-версию(для всех ОС)</a></center>";     
							   	}
							?>
						</div>
					</div>
					<div class='row'>
						<div class='headrow'>
							<img src="images/2.png" /> <span>Зарегистрируйся</span>
						</div>
						<div class='subrow'>
							Выбери себе хороший ник, придумай надежный пароль, а также установи скин! 
							<br>Мы принимаем даже HD скины!
							<br>А если желаешь выделиться, то купи подписку на плащ!
						</div>
					</div>
					<div class='row'>
						<div class='headrow'>
							<img src="images/3.png" /> <span>Кайфуй от игры</span>
						</div>
						<div class='subrow'>
							Используя только что придуманные логин и пароль войди в лаунчер.
							<br>Выбери комфортый сервер и играй!
							<br>Не забудь ознакомиться с <a href="https://vk.com/topic-179787209_39912044">правилами</a> сервера, чтобы избежать бана
						</div>
					</div>
				</div>
			</div>
			<div id="about">
				<h3><span>О НАС</span></h3>
				<br />
				<div class="ctable" style="margin-bottom:250px;">
					<div class="col1" style="text-align: justify;">
						Игровой проект Weary Paws - это проект над которым работает команда опытных и профессиональных разработчиков и целая история, взявшая свое начало с маленького сервера в игре Minecraft PE. Это новое начало и продолжение истории.
						<br />Мы проанализировали ошибки большинства проектов, которые за это время потеряли большинство своей аудитории и желаем показать Вам, на что мы способны. 
						<br />На нашем проекте запланировано создание новых плагинов и режимов, а также, мы разработали новый подход к маркетинговой части проекта и работы с аудиторией в целом.
						<br />Наши сервера наполнят твою жизнь приятными воспоминаниями, здесь ты сможешь завести настоящих друзей.
					</div>
					<div class="col2" style="border-left:0px; margin-top:88px;">
						<script type="text/javascript">
							/* Запускаем анимацию изображения */
							window.onload = function () { ProgressBarManager('progressbar_meter',true).Live() }
						</script>
						<div id="serversonline">
							<?php include_once('modules/info.php'); ?>
							<?php echo ShowServer("play.wearypaws.ru",25510,320,"Vanilla Paws",rand(0,3)); ?>
							<?php echo ShowServer("mc.sharkyt.ru",25565,320,"Мини-игры",0); ?>
							<?php echo ShowServer("mc.sharkyt.ru",25565,320,"Weary Mods",0); ?>
						</div>
					</div>
				</div>
			</div>
			<div id="joinin">
				<?php
				    if (empty($_SESSION['login']) or empty($_SESSION['id']))
				    {
				   		include('modules/loginregform.php'); 
				   		//echo "<br /><br /><h3>Еще чуточку и можно будет регистрироваться</h3><br />";   
				   	}
				    else
				    {
					    echo "<h3><span>ПРОФИЛЬ</span></h3><br />";
					    include('modules/lkshort.php'); 
				    }
				?>
			<div id="footer">
				<?php include("modules/footer.php"); ?>
			</div>
			</div>
		</div>
		</div>
	</body>
</html>